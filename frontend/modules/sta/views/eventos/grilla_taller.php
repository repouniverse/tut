<?php

use kartik\editable\Editable;
use yii\helpers\Html;
use kartik\tabs\TabsX;
use yii\helpers\Url;
use common\helpers\h;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\widgets\Pjax;
 use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
  use kartik\export\ExportMenu;


?>
 <?php
  
echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
     'bordered'=>true,
    'align' => TabsX::ALIGN_LEFT,
      'encodeLabels'=>false,
    'items' => [
        [
          'label'=>'<i class="fa fa-home"></i> '.yii::t('sta.labels','Sesiones'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_sesiones',['model' => $model]),
           'active' => true,
             'options' => ['id' => 'tabid1'],
        ],
        [
          'label'=>'<i class="fa fa-users"></i> '.yii::t('sta.labels','Alumnos'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_alumnos', ['dataProvider'=>$dataProvider,'validator'=>$validator,'model'=>$model,'searchModel' => $searchModel]),
           'active' => false,
             'options' => ['id' => 'tabid2'],
        ],
       
       
    ],
]);  

 ?>




