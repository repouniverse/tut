<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;

?>

 <div class="box-body">
    
    <?php $form = ActiveForm::begin(['id'=>'form-convojgjgcatoria',
        'fieldClass'=>'\common\components\MyActiveField']); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
            <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'form-convojgjgcatoria',
                      'url'=> \yii\helpers\Url::to(['/sta/programas/edita-docu','id'=>$id]),
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
            </div>
        </div>
    </div>
     
          <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
              <?=Html::img($modeldet->alumno->urlImage,['width'=>100,'height'=>140])?>
          </div>   
          <div class="col-lg-8 col-md-9 col-sm-6 col-xs-12">
              <?=$form->field($modeldet, 'nombres')->textInput(['disabled'=>true,'value'=>$modeldet->alumno->fullName()])?>
          </div> 
     <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= 
            $form->field($model, 'codestado')->
            dropDownList($model->comboDataField('codestado') ,
                    ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>
        </div>
     
    <div class="col-lg-8 col-md-9 col-sm-6 col-xs-12">
      <?PHP
     echo $form->field($model, 'descripcion')->textInput();
      ?>
  </div>

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?PHP
     echo $form->field($model, 'detalle')->textarea();
      ?>
  </div>
          
  <?php ActiveForm::end(); ?>
  
 </div>
   

   
