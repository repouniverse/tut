<?Php
use yii\widgets\ActiveForm;
USE yii\helpers\Html;
use common\widgets\selectwidget\selectWidget;
//use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
//use common\helpers\ComboHelper;
use common\helpers\h;

?>
    <?php $form = ActiveForm::begin([
        'id'=>'formualrio',
        'enableAjaxValidation'=>true
        ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton(Yii::t('sta.labels', 'Guardar'), ['class' => 'btn btn-success']) ?>
            

            </div>
        </div>
    </div>
     
            
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
 <?= $form->field($model->periodo, 'periodo')->textInput(['maxlength' => true,'disabled' => true]) ?>

</div>
 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'codfac')->
            dropDownList(\frontend\modules\sta\helpers\comboHelper::getCboFacultadesByUser(h::userId()),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div> 
   <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">  
   <?php 
   //$model->fillRelations();
   // print_r($model->_obRelations);die();
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codalu',
             'ordenCampo'=>2,
         'addCampos'=>[3,4,5],
        ]);  ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">  
   <?php 
   //$model->fillRelations();
   // print_r($model->_obRelations);die();
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codcur',
             'addCampos'=>[2],
            //'foreignskeys'=>[1,2,3],
        ]);  ?>
    </div>
 
  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
 <?= $form->field($model, 'nveces')->textInput(['maxlength' => true]) ?>

</div>
   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
 <?= $form->field($model, 'nveces15')->textInput(['maxlength' => true]) ?>

</div>    
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
    <?= \common\widgets\imagewidget\ImageWidget::widget([
        'name'=>'imagenrep',
        'isImage'=>false,  
        'model'=>$model,
        'extensions'=>['csv'],
            ]); ?>
   </div>      

    <?php ActiveForm::end(); ?>

