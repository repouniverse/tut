<?php
 use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\modules\sigi\helpers\comboHelper;
use common\helpers\timeHelper;
use common\helpers\h;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;

use yii\grid\GridView;
use yii\widgets\Pjax;
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

      <?php Pjax::begin(['id'=>'grilla_cargospor']); ?>
    <?php echo GridView::widget([
        'dataProvider' =>$dataProviderCuentasPor,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => $searchModel,
        'columns' => [
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                'buttons' => [
                    'update' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'Update'),                            
                        ];
                        if(!$model->colector->isBudget())
                        return Html::a('<span class="btn btn-info btn-sm glyphicon glyphicon-pencil"></span>', $url, $options/*$options*/);
                         },
                          'view' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'View'),                            
                        ];
                        return Html::a('<span class="btn btn-warning btn-sm glyphicon glyphicon-search"></span>', $url, $options/*$options*/);
                         },
                                              
                        
                        'delete' => function ($url,$model) {
                             $options = [
                            'data-confirm' => Yii::t('sigi.labels', 'Esta seguro de eliminar este ítem?'),
                            'title' => Yii::t('base.verbs', 'Borrar'),                            
                        ];
			   $url = \yii\helpers\Url::toRoute($this->context->id.'/deletemodel-for-ajax');
                            if(!$model->colector->isBudget())  
                           return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                            }
                         
                    ]
                ],
           ['class' => 'frontend\modules\report\components\columnGridReport',
                   'attribute'=>'report_id'],
           // 'id',
              /*['attribute'=>'edificio_id',
                  'filter'=> frontend\modules\sigi\helpers\comboHelper::getCboEdificios(),
                  'value'=>'edificio.codigo'
                  ],*/
           /* ['attribute'=>'codocu',
                  'filter'=> frontend\modules\sigi\helpers\comboHelper::getCboDocuments(),
                  'value'=>'documento.desdocu'
                  ],*/
                            
           /*  ['attribute'=>'colector_id',
                  //'filter'=> frontend\modules\sigi\helpers\comboHelper::getCboColectores($model->edificio_id),
                  'value'=>'colector.cargo.descargo'
                  ],  */             
           // 'codocu',
            'descripcion',
           // 'fedoc',
                            
            //'mes',
            //'anio',
            //'detalle:ntext',
            //'fevenc',
            'monto',
            //'igv',
            //'codestado',

          
        ],
    ]); ?>
          
       <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
            'idGrilla'=>'grilla_cargospor',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?> 
        
          
    <?php Pjax::end(); ?>
</div>       
      
    
</div>
<?php
 $url= Url::to(['/sigi/cuentaspor/create-as-child','id'=>$model->id,'gridName'=>'grilla_cargospor','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Insertar '), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Elemento'),'id'=>'btn_apoderado', 'class' => 'botonAbre btn btn-success']); 
?> 
