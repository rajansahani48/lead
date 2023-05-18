<?php
namespace App\services;

class CsvUpload
{
    public function save($file)
    {
        $filename = $file->getClientOriginalName();
        $file->move($this->storedLocation($filename), $filename);
        $leads = [];
        if (($open = fopen($this->fileLocation($filename), "r")) !== FALSE) {
            while (($data = fgetcsv($open, 200, ",")) !== FALSE) {
                $leads[] = $data;
            }
            fclose($open);
        }
        return $leads;
    }
    public function deleteFile($filename)
    {

        if (\File::exists($this->fileLocation($filename)))
            \File::delete($this->fileLocation($filename));

    }
    public function fileLocation($filename)
    {
        return storage_path("file/$filename");
    }

    public function storedLocation($filename)
    {
        return storage_path("file");
    }

}
?>
