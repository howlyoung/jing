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

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $path = 'uploads/' . $this->getName($this->imageFile->baseName) . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($path);
            return $path;
        } else {
            return false;
        }
    }

    protected function getName($name) {
        return md5($name);
    }
}