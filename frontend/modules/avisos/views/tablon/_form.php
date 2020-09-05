<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use common\helpers\h;
/* @var $this yii\web\View */
/* @var $model frontend\modules\avisos\models\AvisosTablon */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="avisos-tablon-form">
    <br>
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('base.names', 'Save'), ['class' => 'btn btn-success']) ?>
            

            </div>
        </div>
    </div>
      <div class="box-body">
    
 
 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <?php 
      
         echo $form->field($model, 'finicio')->widget(
        DateTimePicker::classname(), [
         'name' => 'finicio',
            'language' => h::app()->language,
            'options' => ['placeholder' =>yii::t('sta.labels', '--Seleccione un valor--')],
    //'convertFormat' => true,
                'pluginOptions' => [
                'format' => h::getFormatShowDateTime(),
                //'startDate' => '01-Mar-2014 12:00 AM',
                'todayHighlight' => true
                                ]
                    ]);  
     
       
                ?>
  </div> 
   <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <?php 
      
         echo $form->field($model, 'ftermino')->widget(
        DateTimePicker::classname(), [
         'name' => 'ftermino',
            'language' => h::app()->language,
            'options' => ['placeholder' =>yii::t('sta.labels', '--Seleccione un valor--')],
    //'convertFormat' => true,
                'pluginOptions' => [
                'format' => h::getFormatShowDateTime(),
                //'startDate' => '01-Mar-2014 12:00 AM',
                'todayHighlight' => true
                                ]
                    ]);  
     
       
                ?>
  </div> 
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?php echo $form->field($model, 'texto')->widget(\rikcage\sceditor\SCEditor::className(), [
        'options' => ['rows' => 10],
        'clientOptions' => [
            'toolbar'=>'bold,italic,underline,left,center,right,justify,font,size,color|cut,copy,paste,table,image,link,unlinkemail,youtube,print,maximize',
            'plugins' => 'bbcode',
            'locale'=>'es'
        ]
    ]); ?> 

 </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'texto_interno')->textarea(['rows' => 6]) ?>

 </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'esevento')->checkbox() ?>

 </div>
  
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'periodo')->textInput() ?>

 </div>
  
     
    <?php ActiveForm::end(); ?>

</div>
    </div>
