<?php
 use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;
use kartik\widgets\TimePicker;
use common\widgets\selectwidget\selectWidget;
?>
<h4><?=yii::t('sta.labels','Transferir alumnos') ?></h4>
 <div class="box-body">
    
    <?php $form = ActiveForm::begin(['id'=>'form-pico',
       // 'fieldClass'=>'\common\components\MyActiveField'
        ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
       <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'form-pico',
                      'url'=> \yii\helpers\Url::to(['/sta/programas/cambio-psicologo-alumno','id'=>$id]),
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
            </div>
        </div>
    </div>
     <div class="col-lg-12 col-md-6 col-sm-6 col-xs-6">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <?=$form->field($model, 'id')->textInput(['disabled'=>true,'value'=>$model->alumno->fullname()])->label(yii::t('sta.labels','Alumno'))?>
          </div> 
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <?=$form->field($model, 'id')->textInput(['disabled'=>true,'value'=>$model->trabajador->fullname()])->label(yii::t('sta.labels','Psicólo Original'))?>
          </div> 
         
     </div>
     <div class="col-lg-12 col-md-6 col-sm-6 col-xs-6">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?= 
            $form->field($model, 'codtra')->
            dropDownList(\frontend\modules\sta\helpers\comboHelper::getCboTutoresByProg($model->talleres->id,[$model->codtra]) ,
                    ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )->label(yii::t('sta.labels','Psicólogo destino'))  ?>
          </div>
         
          
         
     </div>
            
           
    
          
         
          
  <?php ActiveForm::end(); ?>
  
 </div>
   

   
