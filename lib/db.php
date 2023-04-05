<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
function parse_azure_connection_string($conn_str)
{

    // Initialize array.
    $conn_array = array();

    // Split connection string on semicolons. Results in array of "parts".
    $parts = explode(";", $conn_str);

    // Loop through array of parts. (Each part is a string.)
    foreach ($parts as $part) {

        // Separate each string on equals sign. Results in array of 2 items.
        $temp = explode("=", $part);

        // Make items key=>value pairs in returned array.
        $conn_array[$temp[0]] = $temp[1];
    }

    return $conn_array;
}

// ** SQL Azure settings - Automatically read from env variables ** //
// added by mostafa 
if (getenv('SQLCONNSTR_conn')) {
    $conn1 = parse_azure_connection_string(getenv('SQLCONNSTR_conn'));
}else{
    $conn1['Initial Catalog'] = "foqus3";
    $conn1['User ID'] = "foqus3";
    $conn1['Password'] = "Foqus123#*";
    $conn1['Server'] = "tcp:foqus3.database.windows.net,1433";
}

/** The name of the database for WordPress */
define('DB_NAME', $conn1['Initial Catalog']);

/** Azure database username */
define('DB_USER', $conn1['User ID']);

/** Azure database password */
define('DB_PASSWORD', $conn1['Password']);

/** Azure hostname */
define('DB_HOST', $conn1['Server']);

//$url = 'http://www.example.com';


$url = '';
foreach (getallheaders() as $name => $value) {
    if ($name == 'X-Forwarded-Host') {
        $url = $value;
    }
}
//$db=array_shift((explode('.', $_SERVER['X-Forwarded-Host'])));
$urlexplode = explode('.', $url);
//$db=array_shift((explode('.', $url))); 
$dbname = array_shift($urlexplode);

$dbname = "foqus3"; // remove ,added by mostafa


//echo($conn1);
//$dbname="FoQus8";
$dbhost = DB_HOST;
$dbuser = DB_USER;
$dbpassword = DB_PASSWORD;
class SQLSRV_DataBase
{
    public $dbuser; // added by mostafa
    public $dbpassword; // added by mostafa
    public $dbname; // added by mostafa
    public $dbhost; // added by mostafa
    public $dbport; // added by mostafa
    public $is_connected; // added by mostafa  
    public $db; // added by mostafa  
    public function __construct($dbuser, $dbpassword, $dbname, $dbhost, $dbport = 1433, $build_schema = false)
    {
        $this->dbuser       = $dbuser;
        $this->dbpassword   = $dbpassword;
        $this->dbname       = $dbname;
        $this->dbhost       = $dbhost;
        $this->dbport       = $dbport;

        $this->is_connected = $this->db_connect();
    }

    public function db_connect()
    {
        //$serverName = "tcp:" . $this->dbhost . ", " . $this->dbport;
        $serverName = $this->dbhost;
        $connectionOptions = array(
            "Database" => $this->dbname,
            "UID"      => $this->dbuser,
            "PWD"      => $this->dbpassword,
            "MultipleActiveResultSets" => true, "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0, "CharacterSet"  => 'UTF-8'
        );

        // Create the connection resource
        $this->db = sqlsrv_connect($serverName, $connectionOptions);


        // If the connection fails we get a false value and build our error log
        if (false === $this->db) {
            /*
			 * We don't use log_error() here as the values passed from a failed connection
			 * are not compatible with the errors passed from a failed query
			 */
            //$error = sqlsrv_errors();
            //$this->error[] = $error;
            //error_log( 'Database failure: ' . print_r($error, true) );
            error_log('Database failure: ');
            return false;
        }
        sqlsrv_configure('WarningsReturnAsErrors', true);

        return true;
    }


    /**
     * @param string $query A query where each parameter is equal to question mark (?)
     * @param array $params one demension array of query parameters. Each element is matched to query parameters by sequence
     * @param string $DB A database name where query is executed
     * @return bool|array|null array of query result (row by row)
     * @example
     * $query = "SELECT * FROM DB.dbo.table1 WHERE id = ? AND description = ? AND date = ?";
     * $params = array(1, "some descr", "2022-01-01");
     */

    public function Select(string $query, array $params = array()): bool|array|null
    {
        $result = FALSE;
        try {
            $arr = null;
            if (!$this->is_connected) {
                $this->is_connected = $this->db_connect();

                // If we couldn't reconnect we break out early
                if (!$this->is_connected) {
                    return false;
                }
            }
            $result = sqlsrv_query($this->db, $query, $params);

            if ($result === FALSE)
                throw new Exception(print_r(sqlsrv_errors(), true));

            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
                $arr[] = $row;

            return $arr;
        } catch (Exception $e) {
            error_log("Select DB Exception in " . __FILE__);
            error_log(print_r($e, true));
            return false;
        } finally {
            if ($result !== FALSE)
                sqlsrv_free_stmt($result);
            //  if($conn !== FALSE)
            //    sqlsrv_close($conn);
        }
    }


    /**
     * @param string $query A query where each parameter is equal to question mark (?)
     * @param array $params one demension array of query parameters. Each element is matched to query parameters by sequence
     * @param string $DB A database name where query is executed
     * @return bool|int Affected rows or false in case of exception or  no rows affected
     */
    public function Run($query, $params = array()): bool|int
    {
        $result = FALSE;
        //$conn = FALSE;
        if (!$this->is_connected) {
            $this->is_connected = $this->db_connect();

            // If we couldn't reconnect we break out early
            if (!$this->is_connected) {
                return false;
            }
        }
        try {


            //$conn = self::OpenConnection();
            $result = sqlsrv_query($this->db, $query, $params);

            if ($result === FALSE)
                throw new Exception(print_r(sqlsrv_errors(), true));

            $rowsAffected = sqlsrv_rows_affected($result);

            if ($rowsAffected === FALSE)
                throw new Exception(print_r(sqlsrv_errors(), true));
            elseif ($rowsAffected == -1 || $rowsAffected == 0)
                throw new Exception("Error $rowsAffected rows affected");

            return $rowsAffected;
        } catch (Exception $e) {
            error_log("Run DB Exception in " . __FILE__);
            error_log(print_r($e, true));
            return false;
        } finally {
            if ($result !== FALSE)
                sqlsrv_free_stmt($result);
            // if($conn !== FALSE)
            //     sqlsrv_close($conn);
        }
    }

    public function InsertAndGetPK($query, $params = array()): bool|int
    {
        $query = $query . 'SELECT @@IDENTITY as id;';
        $result = FALSE;
        //$conn = FALSE;
        if (!$this->is_connected) {
            $this->is_connected = $this->db_connect();

            // If we couldn't reconnect we break out early
            if (!$this->is_connected) {
                return false;
            }
        }
        try {


            //$conn = self::OpenConnection();
            $result = sqlsrv_query($this->db, $query, $params);

            if ($result === FALSE)
                throw new Exception(print_r(sqlsrv_errors(), true));

            $rowsAffected = sqlsrv_rows_affected($result);
            sqlsrv_next_result($result);
            //sqlsrv_fetch_array($result); 
            //echo sqlsrv_get_field($result, 0);

            if ($rowsAffected === FALSE)
                throw new Exception(print_r(sqlsrv_errors(), true));
            elseif ($rowsAffected == -1 || $rowsAffected == 0)
                throw new Exception("Error $rowsAffected rows affected");
            $pk = sqlsrv_fetch_array($result);
            return $pk[0];
        } catch (Exception $e) {
            error_log("Run DB Exception in " . __FILE__);
            error_log(print_r($e, true));
            return false;
        } finally {
            if ($result !== FALSE)
                sqlsrv_free_stmt($result);
            // if($conn !== FALSE)
            //     sqlsrv_close($conn);
        }
    }
}
//for testing only
//$dbname='trial1';
$FoQusdatabase = new SQLSRV_DataBase($dbuser, $dbpassword, $dbname, $dbhost, $dbport = 1433, $build_schema = false);
$FoQusdatabase->db_connect();

if (!$FoQusdatabase->is_connected) { // added by mostafa
    echo "Connection Faild";
    die( print_r( sqlsrv_errors(), true)); // TODO => return exhiption
}

