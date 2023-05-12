<?

namespace Lib\File;

use Exception;

class File
{


    static function storePublic($fileName, $toPath = ""): string|bool
    {
        $doc_root = $_SERVER["DOCUMENT_ROOT"];
        $directory = str_replace('"\"', '/', $doc_root) . '/storage/' . constant('MC_SYMBOL') . "/" . $toPath;


        if (!isset($_FILES[$fileName])) {
            throw new Exception("File Name Not In Uploaded Files", 422);
        }
        if (!is_file($_FILES[$fileName]['tmp_name'])) {
            throw new Exception("File Name Is Not A File", 422);
        }

        $name = basename($_FILES[$fileName]["name"]);
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $finalPath = $directory . "/$name";
        if (move_uploaded_file($_FILES[$fileName]["tmp_name"], $finalPath)) {
            return '/storage/' . constant('MC_SYMBOL') . "/" . $toPath ."/$name";
        }
        return  false;
    }


    /* 
        if the file not exists nothing happens
    */
    static function delete($path)
    {
        $doc_root = $_SERVER["DOCUMENT_ROOT"];
        $directory = str_replace('"\"', '/', $doc_root) . $path;
        if (!file_exists($directory)) {
            return false;
        }
        return unlink($directory);
    }


    /* 
        the file should be deleted
        otherwise Exception will be thrown
    */
    static function forceDelete($path)
    {
        $doc_root = $_SERVER["DOCUMENT_ROOT"];
        $directory = str_replace('"\"', '/', $doc_root) . $path;
        if (!file_exists($directory )) {
            throw new Exception("File Not Exists", 422);
        }
        return unlink($directory);
    }
}
