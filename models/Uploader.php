<?php
namespace app\models;

use yii\web\UploadedFile;

class Uploader
{
    /**
     * @var UploadedFile[]
     */
    public $images;
    public $uploadedFiles = [];
    public $uploadErrors = [];


    public function rules()
    {
        return [
                'extensions' => ['png', 'jpg', 'jpeg', 'gif', 'webp'],
                'maxFiles' => 10,
            ];
    }

    public function validateFile($fileData = null)
    {
        $rules = $this->rules();
        $files = Files::instance();

        $mimeType = $files->getFileMimeType($fileData['tmp_name']);
        foreach ($rules['extensions'] as $ext)
        {
            if ( stristr($mimeType, $ext) )
                return true;
        }

        return false;
    }

    /**
     * @param string $id
     * @param string $fieldName
     * @param string $path
     * @return array|bool
     * @throws \Exception
     */
    public function upload( $id = '', string $fieldName='', string $path='' )
    {
        if ( !$fieldName )
            $fieldName = 'images';
        if ( !$path )
            $path = _rootDIR_ . '/web/Stockimages/';

        $files = Files::instance();
        $hua = $files->makeHUA($fieldName);

        $oneAtLeast = false;

        foreach ( $hua as $fileData )
        {
            if ( !$this->validateFile($fileData) )
            {
                $this->uploadErrors[] = $fileData['name'];
                continue;
            }

            $info = new \SplFileInfo($fileData['name']);
            $extension = mb_strtolower( pathinfo($info->getFilename(), PATHINFO_EXTENSION) );

            $newFileName = $id . "_" . randomStringChars(12,'en','symbols').time() . '.' . $extension;
            $uploadPath = $path . $newFileName;

            if ( $files->upload($fileData['tmp_name'], $uploadPath) )
            {
                $this->uploadedFiles[] = $newFileName;
                $oneAtLeast = true; // Хотя бы одна загрузка!
            } else {
                $this->uploadErrors[] = $fileData['name'];
            }
        }

        return $oneAtLeast;
    }
}