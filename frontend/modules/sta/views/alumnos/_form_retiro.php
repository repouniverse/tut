<?Php
use yii\widgets\ActiveForm;
USE yii\helpers\Html;
use common\widgets\selectwidget\selectWidget;
 use kartik\date\DatePicker;
 use common\widgets\comboajaxwidget\comboAjaxWidget;
//use common\helpers\ComboHelper;
use common\helpers\h;
use yii\widgets\Pjax;
use yii\helpers\Url;
?>
    <?php $form = ActiveForm::begin([
        'id'=>'formualrio',
        'enableAjaxValidation'=>true
        ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton(Yii::t('sta.labels', 'Guardar'), ['class' => 'btn btn-success']) ?>
            
                <?= (!$model->isNewRecord)?common\widgets\auditwidget\auditWidget::widget(['model'=>$model]):'';?>
             

            </div>
        </div>
    </div>
     
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">  
   <?php 
   echo $form->field($model, 'codalu')->textInput(['disabled'=>true]);
  
   ?>
</div> 
         <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">  
   <?php 
   echo $form->field($model, 'codalu')->textInput(['disabled'=>true,'value'=>$model->alumno->fullName()]);
  
   ?>
    </div>   
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
    
 <?php 
 
  echo $form->field($model, 'estado')->
            dropDownList($model::comboDataField('estado'),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                       'disabled'=>($model->isNewRecord or $model->isBlocked())?'disabled':null,
                      ]
                    );   
 
 ?>
 </div> 

 
   
 
  
 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">    
 <?= $form->field($model, 'motivo')->
            dropDownList($model::comboDataField('motivo'),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                    // 'class'=>'probandoSelect2',
                    //'disabled'=>($model->isNewRecord)?'disabled':null,
                        ]
                    ) ?>
 </div> 
 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
      <?= $form->field($model, 'fecha')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                       'format' => h::getFormatShowDate(),
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2010:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control']
                            ]) ?>

 </div>

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?PHP 
         //Pjax::begin(['id'=>'mensajepjax']);
         
        ?>
      <div id="advertencia_tipo" class="alert alert-info"></div>
      <?PHP 
        /// Pjax::end();
         
        ?>
   </div>
 


     
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?PHP 
         echo $form->field($model, 'detalle')->textarea();
         
        ?>
   </div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
    <?= \common\widgets\imagewidget\ImageWidget::widget([
        'name'=>'imagenrep',
        'isImage'=>false,  
        'model'=>$model,
        'extensions'=>['pdf','doc','docx','png','jpg'],
            ]); ?>
   </div> 
    <?php ActiveForm::end(); ?>
<?=(!$model->isNewRecord)? \nemmo\attachments\components\AttachmentsTable::widget([
	'model' => $model,
	//'showDeleteButton' => false, // Optional. Default value is true
]):''?>
 <?php echo comboAjaxWidget::widget([  
            'id_combo'=>'staretiros-motivo',
            'tipo'=>'get',
            'evento'=>'change',
      'isHtml'=>true,
            'idGrilla'=>'advertencia_tipo',
            'ruta'=>Url::to(['/sta/alumnos/ajax-adv-retiro','id'=>$model->id]),          
           //'posicion'=> \yii\web\View::POS_END           
        ]); 
  ?>   