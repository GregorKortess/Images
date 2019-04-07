<?php

namespace frontend\components;

use phpDocumentor\Reflection\File;
use yii\web\UploadedFile;

interface StorageInterface
{
    public function saveUploadedFile(UploadedFile $file);

    public function getFile(string $filename);
}