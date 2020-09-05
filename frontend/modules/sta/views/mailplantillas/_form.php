<?php
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\sta\helpers\comboHelper;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\PlantillaCorreos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plantilla-correos-form">
    <br>
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('base.names', 'Save'), ['class' => 'btn btn-success']) ?>
            

            </div>
        </div>
    </div>
      <div class="box-body">
  
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <?= ComboDep::widget([
               'model'=>$model,               
               'form'=>$form,
               'data'=> comboHelper::getCboFacultades(),
               'campo'=>'codfac',
               'idcombodep'=>'plantillacorreos-programa_id',
               /* 'source'=>[ //fuente de donde se sacarn lso datos 
                    /*Si quiere colocar los datos directamente 
                     * para llenar el combo aqui , hagalo coloque la matriz de los datos
                     * aqui:  'id1'=>'valor1', 
                     *        'id2'=>'valor2,
                     *         'id3'=>'valor3,
                     *        ...
                     * En otro caso 
                     * de la BD mediante un modelo  
                     */
                        /*Docbotellas::className()=>[ //NOmbre del modelo fuente de datos
                                        'campoclave'=>'id' , //columna clave del modelo ; se almacena en el value del option del select 
                                        'camporef'=>'descripcion',//columna a mostrar 
                                        'campofiltro'=>'codenvio'/* //cpolumna 
                                         * columna que sirve como criterio para filtrar los datos 
                                         * si no quiere filtrar nada colocwue : false | '' | null
                                         *
                        
                         ]*/
                   'source'=>[\frontend\modules\sta\models\Talleres::className()=>
                                [
                                  'campoclave'=>'id' , //columna clave del modelo ; se almacena en el value del option del select 
                                        'camporef'=>'descripcion',//columna a mostrar 
                                        'campofiltro'=>'codfac'  
                                ]
                                ],
                            ]
               
               
        )  ?>
 </div>
 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'disparador')->
            dropDownList($model::comboDataField('disparador'),
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                     //'disabled'=>(($model->cargamasiva_id)>0)?'disabled':false,
                       ]
      ) ?>

 </div>
          
 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

 </div>  
 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'programa_id')->
            dropDownList(($model->isNewRecord)?[]:[comboHelper::getCboProgramasByFac($model->codfac)],
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                     //'disabled'=>(($model->cargamasiva_id)>0)?'disabled':false,
                       ]
      ) ?>

 </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'masivo')->checkbox() ?>

 </div>
          <p class="text-orange"> <?=yii::t('base.labels','Datos del mensaje')?></p>
     <hr style="border: 1px dashed #4CAF50;">     
          
 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'copiato')->textInput(['maxlength' => true]) ?>

 </div> 
  
  
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'remitente')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?PHP
     //echo $form->field($model, 'sugerencias')->textarea();
     echo $form->field($model, 'cuerpo')->widget(\dosamigos\ckeditor\CKEditor::className(), [
        'options' => ['rows' => 20],
         'clientOptions'=>['language'=>'es',
             //'disableNativeSpellChecker' => false,
             //scayt_sLang=
             ],
        //'preset' => 'basic'
         //'language'=>'es',
        ]);
      ?>

 </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalles')->textarea(['rows' => 6]) ?>

 </div>
     
    <?php ActiveForm::end(); ?>

</div>
    </div>
