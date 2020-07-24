<?php

namespace app\models\forms;

use app\models\Product;
use yii\web\UploadedFile;

class ProductForm extends Product
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'];
        return $rules;
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('@app/web/uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}