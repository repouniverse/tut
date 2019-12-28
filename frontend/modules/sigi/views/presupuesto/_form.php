<?php
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use frontend\modules\sigi\models\VwSigiColectores;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use frontend\modules\sigi\helpers\comboHelper;
use common\helpers\timeHelper;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiBasePresupuesto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sigi-base-presupuesto-form">
  
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField',
        'enableAjaxValidation'=>true
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton(Yii::t('sigi.labels', 'Grabar'), ['class' => 'btn btn-success']) ?>
            

            </div>
        </div>
    </div>
      <div class="box-body">
   <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>

 </div> 

    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
        <?php if($model->isNewRecord){ ?>
    <?= ComboDep::widget([
               'model'=>$model,               
               'form'=>$form,
               'data'=> comboHelper::getCboEdificios(),
               'campo'=>'edificio_id',
               'idcombodep'=>'sigibasepresupuesto-cargosgrupoedificio_id',
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
                   'source'=>[\frontend\modules\sigi\models\VwSigiColectores::className()=>
                                [
                                  'campoclave'=>'idgrupo' , //columna clave del modelo ; se almacena en el value del option del select 
                                        'camporef'=>'descripciongrupo',//columna a mostrar 
                                        'campofiltro'=>'idedificio'  
                                ]
                                ],
                            ]
               
               
        )  ?>
         <?php } else{ ?> 
<?php echo $form->field($model, 'edificio_id')->
        textInput([
            'value' => $model->edificio->nombre,
            'disabled'=>true
            ]) ?>

     <?php 
    }
      ?> 
        
 </div>  
          
          <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
    <?php if($model->isNewRecord){ ?>
    <?= ComboDep::widget([
               'model'=>$model,               
               'form'=>$form,
               'data'=>[],
               'campo'=>'cargosgrupoedificio_id',
               'idcombodep'=>'sigibasepresupuesto-cargosedificio_id',
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
                   'source'=>[\frontend\modules\sigi\models\VwSigiColectores::className()=>
                                [
                                  'campoclave'=>'idcolector' , //columna clave del modelo ; se almacena en el value del option del select 
                                        'camporef'=>'descargo',//columna a mostrar 
                                        'campofiltro'=>'idgrupo'  
                                ]
                                ],
                            ]
               
               
        )  ?>
    <?php } else{ ?> 
<?php echo $form->field($model, 'cargosgrupoedificio_id')->
        textInput([
            'value' => $model->cargosGrupoEdificioFirme->descripcion,
            'disabled'=>true
            ]) ?>

     <?php 
    }
      ?>        
              
          </div>      
    <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">

 <?php if($model->isNewRecord){ ?>
          <?= 
            $form->field($model, 'cargosedificio_id')->
            dropDownList([] ,
                    ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'input-group',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>
 <?php } else{ ?> 
<?php echo $form->field($model, 'cargosgrupoedificio_id')->
        textInput([
            'value' => $model->grupoConcepto->cargo->descargo,
            'disabled'=>true
            ]) ?>

     <?php 
    }
      ?> 
        
   
      </div>  

 
  
  
   <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

 </div>
 
   <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= 
            $form->field($model, 'ejercicio')->
            dropDownList(timeHelper::cboAnnos() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>
</div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'mensual')->textInput(['maxlength' => true]) ?>

 </div>
  
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'restringir')->checkbox([]) ?>

 </div>
           <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'activo')->checkbox([]) ?>

 </div>
 
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalles')->textarea(['rows' => 6]) ?>

 </div>
           
    <?php ActiveForm::end(); ?>

</div>
    </div>
