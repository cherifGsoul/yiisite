<?php

class MediaController extends Controller {

    public function actionIndex() {
        $this->render('index');
        
    }

    public function actionCreate() {
        $files = CUploadedFile::getInstanceByName('media');
        if (isset($files) && count($files) > 0) {
            foreach ($files as $file => $media) {
                echo $media->name . '<br\>';
                if ($media->saveAs(Yii::getPathOfAlias('site') . 'common/uploads/' . $media->name)) {
                    $this->render('index');
                }else
                    echo 'failed';
            }
        }
        $this->render('index');
    }

    // Uncomment the following methods and override them if needed
    /*
      public function filters()
      {
      // return the filter configuration for this controller, e.g.:
      return array(
      'inlineFilterName',
      array(
      'class'=>'path.to.FilterClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }

      public function actions()
      {
      // return external action classes, e.g.:
      return array(
      'action1'=>'path.to.ActionClass',
      'action2'=>array(
      'class'=>'path.to.AnotherActionClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }
     */
}