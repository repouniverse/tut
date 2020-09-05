<?php
 use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
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
        'id'=>'myformulario',/*,'enableAjaxValidation'=>true*/
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      
      <div class="box-body">
          <div class="col-md-12">
            <div class="form-group no-margin">
          <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'myformulario',
                      'url'=> \yii\helpers\Url::to(['/sigi/'.$this->context->id.'/crea-lecturas','id'=>$id]),
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
         
                  

            </div>
        </div>
          
          
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'flectura')->widget(DatePicker::class, [
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
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'mes')->textInput(['value'=>$mes,'disabled'=>true]) ?>
 </div>
  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'anio')->textInput(['value'=>$anio,'disabled'=>true]) ?>
 </div>
<?php ActiveForm::end(); ?>
</div>       
    
    
</div>
