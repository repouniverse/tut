<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\sta\helpers\comboHelper;
use frontend\modules\sta\models\StaRetiros;
use common\widgets\selectwidget\selectWidget;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\AlumnosController */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alumnos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['retiros'],
        'method' => 'get',
       // 'multiple'=>'multiple',
        'options' => [
         'data-pjax' => true
        ],
    ]); ?>
    
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <div class="form-group">
        <?= Html::submitButton("<span class='fa fa-search'></span>     ".Yii::t('sta.labels', 'buscar'), ['class' => 'btn btn-primary']) ?>
        
    </div>
     </div>
    <div id="buscador">
        
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'codcar')->
            dropDownList(comboHelper::getCboCarreras(),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div>  
        
           <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'codperiodo')->
            dropDownList(comboHelper::getCboPeriodos(),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div>
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
 <?php 
 
  echo $form->field($model, 'estado')->
            dropDownList(StaRetiros::comboDataField('estado'),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                       //'disabled'=>($model->isNewRecord)?'disabled':null,
                      ]
                    );   
 
 ?>
 </div>
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">       
   <?= $form->field($model, 'motivo')->
            dropDownList(StaRetiros::comboDataField('motivo'),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                    // 'class'=>'probandoSelect2',
                    //'disabled'=>($model->isNewRecord)?'disabled':null,
                        ]
                    ) ?>     
  </div>       
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
    <?= $form->field($model,'codalu') ?>
</div> 
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
    <?= $form->field($model, 'nombres') ?>
</div> 
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
    <?= $form->field($model, 'ap') ?>
</div> 
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">     
    <?= $form->field($model, 'am') ?>
 </div>   
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'codfac')->
            dropDownList(comboHelper::getCboFacultades(),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div>  
</div>
    
    <?php ActiveForm::end(); ?>

</div>
