<?php
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;       
use common\helpers\FileHelper;      
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\selectwidget\selectWidget;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Test */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-success">
    <br>
    <?php $form = ActiveForm::begin(['fieldClass'=>'\common\components\MyActiveField']); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton(Yii::t('sta.labels', 'Grabar'), ['class' => 'btn btn-success']) ?>
          <?php if(!$model->isNewRecord){ ?>
           <?= frontend\modules\report\widgets\linkReportWidget\linkReportWidget::widget(['model'=>$model])?>
          <?php } ?>
            </div>
        </div>
    </div>
      <div class="box-body">
          <div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= \common\widgets\imagewidget\ImageWidget::widget(['name'=>'imagenrep','isImage'=>false,'model'=>$model,'extensions'=> FileHelper::extDocs()]); ?>
   </div>   
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'reporte_id',
         'ordenCampo'=>10,
         'addCampos'=>[12],
        ]);  ?>

 </div>        
          
 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codtest')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'opcional')->checkBox([]) ?>

 </div>
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'version')->textInput(['maxlength' => true]) ?>

 </div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
     <?= $form->field($model, 'orden')->textInput(['maxlength' => true]) ?>

 </div>
 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">   
   <?= $form->field($model, 'codbateria')->
            dropDownList(\frontend\modules\sta\helpers\comboHelper::baterias(),
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                     
                       ]
                    ) ?>
 </div>  
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalles')->textArea(['rows' => 3]) ?>              
</div>        
    <?php ActiveForm::end(); ?>
     
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <?php 
                    if(!$model->isNewRecord){
                        echo $this->render('_tabs',['model'=>$model,
                        ]);
                    }else{
                        ?>
         
                    <?php
                        }
   
                    ?>      
              </div>       
        
              
          
             </div>
          
    

</div>
    </div>
