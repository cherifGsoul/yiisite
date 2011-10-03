<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model
 *
 * @author CHERIF
 */
abstract class BModel extends CActiveRecord {
    
    protected function beforeSave() {
        if ($this->isNewRecord){
            $this->create_time=$this->update_time=new CDbExpression('NOW()');
            $this->user_id=$this->update_user_id=Yii::app()->user->id;
        }else{
            $this->update_time=new CDbExpression('NOW()');
            $this->update_user_id=Yii::app()->user->id;
        }
        return parent::beforeSave();
    }
}

?>
