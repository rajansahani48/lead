<?php
namespace App\services;

class CsvUpload
{
    public function save($file)
    {
        $filename = $file->getClientOriginalName();
        $file->move($this->fileLocation(), $filename);
        $leads = [];
        if (($open = fopen($this->fileLocation($filename), "r")) !== FALSE) {
            while (($data = fgetcsv($open, 200, ",")) !== FALSE) {
                $leads[] = $data;
            }
            fclose($open);
        }
        if (\File::exists($this->fileLocation($filename)))
            \File::delete($this->fileLocation($filename));
        return $leads;
    }
    public function fileLocation($filename=null)
    {
        return storage_path("file/$filename");
    }
}
?>
