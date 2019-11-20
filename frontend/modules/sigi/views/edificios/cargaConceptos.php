<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use common\helpers\ComboHelper;
use common\widgets\selectwidget\selectWidget;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\Edificios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="edificios-form">
   <div class="box box-success">
    <?php $form = ActiveForm::begin([
    //'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton('<span class="fa fa-save"></span>'.'  '.Yii::t('sigi.labels', 'Guardar'), ['class' => 'btn btn-success']) ?>
            

            </div>
        </div>
    </div>
      <div class="box-body">
    
 
 <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codtra',
         'ordenCampo'=>2,
         'addCampos'=>[3,4],
        'options'=>['disabled'=>true],
        ]);  ?>

 </div> 
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($model, 'nombre')->textInput(['disabled' => true,'maxlength' => true]) ?>

 </div>
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($model, 'proyectista')->textInput(['disabled' => true,'maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
     <?= $form->field($model, 'direccion')->textInput(['disabled' => true,'maxlength' => true]) ?>
 </div>        
          
  
 
  

  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'npisos')->textInput(['disabled' => true]) ?>

 </div>
 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">         
          <?= 
            $form->field($model, 'codcen')->
            dropDownList(comboHelper::getCboCentros() ,
                    ['disabled' => true, 'prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>
</div>
    <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
     <?= Html::label(yii::t('base.names','Area'),'45545rret',['class' => 'control-label']) ?>
           
            <?=  Html::textInput('45545rret',  $model->area(),['disabled'=>true,'class' => 'form-control form-group']) ?>
          
 </div>    
  
     
    <?php ActiveForm::end(); ?>

    <?php echo $this->render('cargaConceptos_detalle', [
            'model'=>$model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
             'id'=>$id,
        ]);  ?>      
          
          
          
          
</div>
    </div>
    </div>