<?php
 use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\sigi\helpers\comboHelper;
use common\helpers\timeHelper;
use common\helpers\h;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiFacturacion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sigi-facturacion-form">

    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('sigi.labels', 'Grabar'), ['class' => 'btn btn-success']) ?>
            

            </div>
        </div>
    </div>
      <div class="box-body">

  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <?php echo $form->field($model, 'edificio_id')->
            dropDownList(comboHelper::getCboEdificios(),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>

 </div>
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?php echo $form->field($model, 'mes')->
            dropDownList(timeHelper::cboMeses(),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div>
  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?php echo $form->field($model, 'ejercicio')->
            dropDownList(timeHelper::cboAnnos(),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div>
  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'fecha')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control']
                            ]) ?>
 </div>
  
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalles')->textarea(['rows' => 6]) ?>

 </div>
     
    <?php ActiveForm::end(); ?>

</div>
    </div>
