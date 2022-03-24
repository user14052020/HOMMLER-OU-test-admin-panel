<?php

namespace app\models;
use yii\db\ActiveRecord;
use yii\base\Model;
use yii\web\UploadedFile;

class Product extends ActiveRecord {
	public $imageFile;
	public function attributeLabels(){
		return [
			'imageFile' => 'Изображение',
			'image' => 'Изображение',
		    'sku' => 'SKU',
		    'name' => 'Название',
		    'count' => 'Кол-во на складе',
		    'type' => 'Тип товара'
		];
	}

	public function rules(){
		return [
			[['sku', 'name', 'count', 'type'],'required'],
			 [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg']

		];
	}

	public function upload(){
		if($this->validate()){
			$imageFilePath = '../web/img/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
			$this->imageFile->saveAs($imageFilePath);
			$this->image = $imageFilePath;
			return true;
		}else{
			return false;
		}
	}
    
    public static function find()
    {
        return new ProductQuery(get_called_class());
    } 
}




?>