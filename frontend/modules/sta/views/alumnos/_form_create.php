<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\selectwidget\selectWidget;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use common\helpers\ComboHelper;
use frontend\modules\sta\helpers\comboHelper as cbohelper;
use common\helpers\h;
 use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Alumnos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alumnos-form">
    <br>
    <?php $form = ActiveForm::begin( [
'enableAjaxValidation'=>true,
    'fieldClass'=>'\common\components\MyActiveField']); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton(Yii::t('sta.labels', 'Guardar'), ['class' => 'btn btn-success']) ?>
            

            </div>
        </div>
    </div>
      <div class="box-body">
       
  
          
       
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
                   <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'ap')->textInput(['maxlength' => true]) ?>

                  </div>

                     <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
                       <?= $form->field($model, 'am')->textInput(['maxlength' => true]) ?>

                     </div>
                                <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
                           <?= $form->field($model, 'nombres')->textInput(['maxlength' => true]) ?>

                              </div>
                            
              </div>
               <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <img src="<?=$model->getUrlImage()?>" class="img-thumbnail">
                  
              </div>
          </div>       
          
          
          
          
          
          <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                           <?php  //h::settings()->invalidateCache();  ?>
                       <?= $form->field($model, 'fecna')->widget(DatePicker::class, [
                             'language' => h::app()->language,
                           // 'readonly'=>true,
                          // 'inline'=>true,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                  'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>"-99:+0",
                               ],
                           
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control']
                            ]) ?>
                           </div>
          
          
          
          
          
 
          
            
  
          
          
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codalu')->textInput(['maxlength' => true]) ?>

 </div>
      
                  
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
    <?= ComboDep::widget([
               'model'=>$model,               
               'form'=>$form,
               'data'=> cbohelper::getCboFacultades(),
               'campo'=>'codfac',
               'idcombodep'=>'alumnos-codcar',
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
                   'source'=>[\frontend\modules\sta\models\Carreras::className()=>
                                [
                                  'campoclave'=>'codcar' , //columna clave del modelo ; se almacena en el value del option del select 
                                        'camporef'=>'descar',//columna a mostrar 
                                        'campofiltro'=>'codfac'  
                                ]
                                ],
                            ]
               
               
        )  ?>
 </div>  
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
 <?= $form->field($model, 'codcar')->
            dropDownList([],
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div>        
              
          
          
          
          
          
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'dni')->textInput(['maxlength' => true]) ?>

 </div>
   <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'correo')->textInput(['maxlength' => true]) ?>

 </div>
          
  <div class="col-lg-3 col-md-12 col-sm-6 col-xs-12">
     <?= $form->field($model, 'domicilio')->textInput(['maxlength' => true]) ?>

 </div>

   
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
    <?= ComboDep::widget([
               'model'=>$model,               
               'form'=>$form,
               'data'=> ComboHelper::getCboDepartamentos(),
               'campo'=>'codep',
               'idcombodep'=>'alumnos-codprov',
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
                   'source'=>[\common\models\masters\Ubigeos::className()=>
                                [
                                  'campoclave'=>'codprov' , //columna clave del modelo ; se almacena en el value del option del select 
                                        'camporef'=>'provincia',//columna a mostrar 
                                        'campofiltro'=>'coddepa'  
                                ]
                                ],
                            ]
               
               
        )  ?>
 </div>       
          
          
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
    <?= ComboDep::widget([
               'model'=>$model,               
               'form'=>$form,
               'data'=> ($model->isNewRecord)?[]:ComboHelper::getCboProvincias($model->codep),
               'campo'=>'codprov',
               'idcombodep'=>'alumnos-codist',
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
                   'source'=>[\common\models\masters\Ubigeos::className()=>
                                [
                                  'campoclave'=>'coddist' , //columna clave del modelo ; se almacena en el value del option del select 
                                        'camporef'=>'distrito',//columna a mostrar 
                                        'campofiltro'=>'codprov'  
                                ]
                                ],
                            ]
               
               
        )  ?>
 </div> 
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'codist')->
            dropDownList(($model->isNewRecord)?[]:ComboHelper::getCboDistritos($model->codprov),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div>        
          
          
          
          
  
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'sexo')->
            dropDownList(ComboHelper::getCboSex(),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div>  
  <div class="col-lg-3 col-md-12 col-sm-6 col-xs-12">
     <?= $form->field($model, 'celulares')->textInput(['maxlength' => true]) ?>

 </div>         
     <div class="col-lg-3 col-md-12 col-sm-6 col-xs-12">
     <?= $form->field($model, 'fijos')->textInput(['maxlength' => true]) ?>

 </div> 
    <?php ActiveForm::end(); ?>

</div>
    </div>
