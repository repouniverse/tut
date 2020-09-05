<?php
 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\sta\helpers\comboHelper;


?>
<h4><?=yii::t('sta.labels','Asignar Psicólogo') ?></h4>
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
     
     
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?= 
            $form->field($model, 'codtra')->
            dropDownList(comboHelper::getCboTutoresByProg($model->talleres->id,[$model->codtra]) ,
                    ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )->label(yii::t('sta.labels','Psicólogo destino'))  ?>
          </div>
         
          
         
    
            
           
    
          
         
          
  <?php ActiveForm::end(); ?>
  
 </div>
   

   
