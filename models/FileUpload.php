<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 19.09.2019
 * Time: 23:48
 */

namespace app\models;

use yii\base\Model;
use yii\helpers\Json;
use yii\imagine\Image;

class FileUpload extends Model
{
    //модель загрузки
    /**
     * @var UploadedFile
     */
    public $file;

    public function rules()
    {
        return [
            [['file'], 'file']
        ];
    }

    public function uploadFile(){
        //загрузка изображения и его превью в папку small
        $fileName = $this->file->baseName . '.' . $this->file->extension;
        $path = '@imgUploads/banner/' . $fileName;
        $this->file->saveAs(\Yii::getAlias($path));
        Image::thumbnail($path, 200, 100)
        ->save(\Yii::getAlias('@imgUploads/banner/small/' . $fileName));
        return $fileName;
    }

    public function deleteFile($path, $pathSmall){
        $delete = unlink ($path);
        $deleteSmall = unlink ($pathSmall);
    }

    public function deleteFromJson($fileName){
        //удаление url изображения из json-файла

        $jsonContent = file_get_contents('mocks/banner.json');
        $jsonContentSmall = file_get_contents('mocks/banner-small.json');
        $needle = '{"url":"' . $fileName . '"}';
        $replace = '';
        $doubleComma = ',,';
        $comma = ",";

        $changeJson = str_replace($needle, $replace, $jsonContent);
        if (substr($changeJson,-3, 1) == $comma){
            $changeJson = str_replace(',]}', ']}', $changeJson);
        };
        $changeJson2 = str_replace($doubleComma, $comma, $changeJson);
        file_put_contents('mocks/banner.json', $changeJson2);

        $changeJsonSmall = str_replace($needle, $replace, $jsonContentSmall);
        if (substr($changeJsonSmall,-3, 1) == $comma){
            $changeJsonSmall = str_replace(',]}', ']}', $changeJsonSmall);
        };
        $changeJson2Small = str_replace($doubleComma, $comma, $changeJsonSmall);
        file_put_contents('mocks/banner-small.json', $changeJson2Small);
    }

    public function insertToJson($fileName){
        // добавление url изображения в json-файл

        $jsonContent = file_get_contents('mocks/banner.json');
        $decode = Json::decode($jsonContent);
        $needle = array('url'=> $fileName);

        $jsonContentSmall = file_get_contents('mocks/banner-small.json');
        $decodeSmall = Json::decode($jsonContentSmall);
        $needleSmall = array('url'=> $fileName);

        if(array_search($needle, $decode['contents']) == false) {
            $decode['contents'][] = array('url' => $fileName);
            $encode = Json::encode($decode);
            file_put_contents('mocks/banner.json', $encode);
        }

        if(array_search($needleSmall, $decodeSmall['contents']) == false) {
            $decodeSmall['contents'][] = array('url' => $fileName);
            $encodeSmall = Json::encode($decodeSmall);
            file_put_contents('mocks/banner-small.json', $encodeSmall);
        }
    }
}