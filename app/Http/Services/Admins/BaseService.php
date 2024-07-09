<?php

namespace App\Http\Services\Admins;

use App\Repositories\ConfigBonusesRepository;
use App\Repositories\ItemRepository;
use Illuminate\Support\Facades\Storage;
use Exception;

class BaseService
{
    /**
     * Construct
     */
    public function __construct()
    {
    }

    /**
     * FileName
     *
     * @param [type] $fileName
     * @return void
     */

    public function fileName($checkFile)
    {
        $typeFile = config('constant.type_file');

        $extension = strrev(substr(strrev($checkFile), 0, strpos(strrev($checkFile), '.')));

        switch ($extension) {
            case $typeFile[1]:
                $fileName = time() . '-' .$this->generateRandomString().'.'.$typeFile[1];
                break;
            case $typeFile[2]:
                $fileName = time() . '-' .$this->generateRandomString().'.'.$typeFile[2];
                break;
            default:
            throw new Exception(" Uploaded images must be png jpg!");
        }

        return $fileName;
    }

    /**
     * Check Folder
     *
     * @param [type] $path
     * @return void
     */

    protected function checkFolder($path)
    {
        $pathFolder = public_path("$path/");
        if (!file_exists($pathFolder)) {
            Storage::makeDirectory($pathFolder, 0755, true);
        }
        return $pathFolder;
    }

     /**
     * Generate auto number
     *
     * @return void
     */
    function generateRandomString()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 10; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}