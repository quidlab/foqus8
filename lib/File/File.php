<?

namespace Lib\File;

use Exception;

class File
{


    static function storePublic($fileName, $toPath = ""): string|bool
    {
        $doc_root = $_SERVER["DOCUMENT_ROOT"];
        $storagePath = str_replace('"\"', '/', $doc_root) . '/storage/';


        if (!isset($_FILES[$fileName])) {
            throw new Exception("File Name Not In Uploaded Files", 422);
        }
        if (!is_file($_FILES[$fileName]['tmp_name'])) {
            throw new Exception("File Name Is Not A File", 422);
        }

        $name = basename($_FILES[$fileName]["name"]);
        $finalPath = $storagePath . "$toPath/$name";
        if (move_uploaded_file($_FILES[$fileName]["tmp_name"], $finalPath)) {
            return "storage/$toPath/$name";
        }
        return  false;
    }
}
