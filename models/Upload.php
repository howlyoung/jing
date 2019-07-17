<?php
/**
 * Created by PhpStorm.
 * User: yanghao
 * Date: 2019/6/19
 * Time: 17:10
 */

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class Upload extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $imageFiles;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg'],
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg','maxFiles'=>9],
        ];
    }

    public function upload()
    {
        if ($this->validate('imageFile')) {
            $path = 'uploads/' . $this->getName($this->imageFile->baseName) . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($path);
            return $path;
        } else {
            return false;
        }
    }

    public function uploads() {
        $pathArr = [];
        if ($this->validate('imageFiles')) {
            foreach($this->imageFiles as $file) {
                $name = $this->getName($file->baseName);
                $path = 'uploads/' . $name . '.' . $file->extension;
                $file->saveAs($path);
                $pathArr[] = $path;
            }
        }
        return $pathArr;
    }

    protected function getName($name) {
        return md5($name);
    }
}