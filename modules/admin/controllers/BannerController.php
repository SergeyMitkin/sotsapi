<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 20.09.2019
 * Time: 0:05
 */

namespace app\modules\admin\controllers;

use app\models\FileUpload;
use app\modules\admin\models\Banner;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\UploadedFile;

class BannerController extends Controller
{
    public function actionIndex(){
        //получаем массив с именами файлов
        $images = Banner::searchImages();
        $dataProvider = new ArrayDataProvider([
            'models' => $images,
        ]);
        $modelFileUpload = new FileUpload();
        $fileName = $this->findModel($images);

        if(\Yii::$app->request->isPost){
            $modelFileUpload->file = UploadedFile::getInstance($modelFileUpload, 'file');
            $modelFileUpload->uploadFile();
            $modelFileUpload->insertToJson($fileName);
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'modelFileUpload' => $modelFileUpload,
            'images' => $images,
        ]);
    }

    public function actionOne($images){
        //создаём страницу для вывода полного изображения одного изображения
        return $this->render('picture_item',[
            'images' => $this->findModel($images),
        ]);
    }

    public function actionDelete($images)
    {
        $fileName = $this->findModel($images);
        $path = 'img/banner/' . $fileName;
        $pathSmall = 'img/banner/small/' . $fileName;

        $modelFileUpload = new FileUpload();
        $modelFileUpload->deleteFile($path, $pathSmall);
        $modelFileUpload->deleteFromJson($fileName);

        return $this->redirect(['index']);
    }

    protected function findModel($images)
    {
        //функция поиска модели для управления файлами. Возможно лишняя.
        if (($model = Banner::findOne($images)) !== null) {
            return $images;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}