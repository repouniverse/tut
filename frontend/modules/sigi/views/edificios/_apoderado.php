<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use common\widgets\selectwidget\selectWidget;
use common\helpers\h;
 use kartik\date\DatePicker;
 use frontend\modules\sigi\models\Edificios;
 ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
?>

<div class="box box-success">
  <div class="box-body">
    
    <?php $form = ActiveForm::begin([
        'id'=>'myformulario'/*,'enableAjaxValidation'=>true*/
    ]); ?>
      <div class="box-header">
          
        <div class="col-md-12">
            <div class="form-group no-margin">
          <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'myformulario',
                      'url'=> \yii\helpers\Url::to(['/sigi/'.$this->context->id.'/'.(($model->isNewRecord)?'agrega':'edita').'-apoderado','id'=>$id]),
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
         
                  

            </div>
        </div>
    </div>
     
  
 

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codpro',
         'ordenCampo'=>1,
         'addCampos'=>[2],
        'inputOptions'=>[/*'enableAjaxValidation'=>true*/],
        ]);  ?>

 </div> 
 
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?=Html::label(yii::t('sigi.labels','Edificio'),'desedi23',['class'=>'control-label'])?>
     <?=Html::textInput( 'desedi23',Edificios::findOne($id)->nombre, ['id'=>'desedi23','disabled'=>true,'class'=>'form-group form-control'] )?>

  </div>
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($model, 'tienejunta')->checkbox() ?>

 </div>
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($model, 'facturaigv')->checkbox() ?>

 </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($model, 'emisordefault')->checkbox() ?>

 </div>
 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($model, 'cobranzaindividual')->checkbox() ?>

 </div>
 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($model, 'facturindividual')->checkbox() ?>

 </div>
    <?php ActiveForm::end(); ?>

</div>
  </div>  
