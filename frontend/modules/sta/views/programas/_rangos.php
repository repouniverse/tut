<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;
use kartik\widgets\TimePicker;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="borereuccess">
   
    <?php $form = ActiveForm::begin(['id'=>'form-rango',
        'fieldClass'=>'\common\components\MyActiveField']); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
            <?php 
            if($model->isNewRecord){
                $url=\yii\helpers\Url::to(['/sta/programas/crear-rango','id'=>$idTaller]);
            }else{
                $url=\yii\helpers\Url::to(['/sta/programas/edit-rango','id'=>$id]);
            }
            echo \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'form-rango',
                      'url'=> $url,
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
            </div>
        </div>
    </div>
      <div class="box-body">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?PHP
      if($model->isNewRecord){
           echo $form->field($model, 'dia')->
            dropDownList(common\helpers\timeHelper::daysOfWeek() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )->label(yii::t('sta.labels','Día')) ;
      }else{
          echo $form->field($model, 'nombredia')->textInput(['disabled'=>true]);
      }
     
      ?>
  </div>   
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <?PHP
     echo $form->field($model, 'hinicio')->widget(TimePicker::classname(), [
         'pluginOptions'=>[
             'showSeconds'=>false,
             'showMeridian'=>false
             ]
     ]);
      ?>
  </div>
  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <?PHP
     echo $form->field($model, 'hfin')->widget(TimePicker::classname(), [
         'pluginOptions'=>[
             'showSeconds'=>false,
             'showMeridian'=>false
             ]
     ]);
      ?>
  </div>
 <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
      <?= $form->field($model, 'activo')->checkbox([]) ?>

  </div>
  <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
      <?= $form->field($model, 'skipferiado')->checkbox([]) ?>

  </div>
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?= 
            $form->field($model, 'codtra')->
            dropDownList(\frontend\modules\sta\helpers\comboHelper::getCboTutoresByProg($model->talleres->id) ,
                    ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )->label(yii::t('sta.labels','Psicólogo Programado'))  ?>
          </div>
 </div>
    <?php ActiveForm::end(); ?>

</div>
    </div>
