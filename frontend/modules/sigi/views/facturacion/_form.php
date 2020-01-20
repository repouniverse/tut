<?php
 use kartik\date\DatePicker;
use kartik\export\ExportMenu;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\modules\sigi\helpers\comboHelper;
use common\helpers\timeHelper;
use common\helpers\h;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use kartik\grid\GridView;
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
           <?=Html::button('<span class="fa fa-book-reader"></span>   '.Yii::t('sta.labels', 'Facturar'), ['id'=>'boton_facturacion','class' => 'btn btn-warning'])?>    
        <?=Html::button('<span class="fa fa-book-reader"></span>   '.Yii::t('sta.labels', 'Resetear'), ['id'=>'boton_resetear','class' => 'btn btn-warning'])?>    
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
  <?php echo Html::a('reporte', Url::to(['/report/make/multi-report','id'=>2,'idsToReport'=> \yii\helpers\Json::encode($model->idsToFacturacion())]), $options); ?>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalles')->textarea(['rows' => 6]) ?>

 </div>
     
    <?php ActiveForm::end(); ?>
          
       <?php if(!$model->isNewRecord) {?>
      <?php Pjax::begin(['id'=>'grilla_cargospor']); ?>
    <?=ExportMenu::widget([
    'dataProvider' => $dataProviderCuentasPor,
    'columns' => $gridColumns,
    'dropdownOptions' => [
        'label' => yii::t('sta.labels','Exportar'),
        'class' => 'btn btn-success'
    ]
]) . "<br><hr>\n".GridView::widget([
        'dataProvider' =>$dataProviderCuentasPor,
         'summary' => '',
         'showPageSummary' => true,
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => $searchModel,
        'columns' => [
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}{generate}',
                'buttons' => [
                     'update' => function($url, $model) {  
                       $url= Url::to(['/sigi/cuentaspor/edita-cobranza','id'=>$model->id,'gridName'=>'grilla_cargospor','idModal'=>'buscarvalor']);
                         $options = [
                           'class'=>'botonAbre',
                            //'title' => Yii::t('sta.labels', 'Editar'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            //'data-method' => 'get',
                            'data-pjax' => '0',
                             //'target'=>'_blank'
                        ];
                        //return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => ' btn btn-sm btn-success']);
                        if(!$model->colector->isBudget())
                         return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>',$url,$options);
                     
                        
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
                            },
                            
                           /* 'generate' => function ($url,$model) {
                             $options = [
                            'data-confirm' => Yii::t('sigi.labels', 'Esta seguro de generar lecturas?'),
                            'title' => Yii::t('base.verbs', 'Generar'),                            
                        ];
			   $url = \yii\helpers\Url::toRoute([$this->context->id.'/crear-lecturas','id'=>$model->id]);
                            $colector=$model->colector;
                           if(!$colector->isBudget() && $colector->isMedidor() && $colector->isMassive())  
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-th-list"></span>', '#', ['title'=>$url,'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))])]);
                            },*/
                       'generate' => function($url, $model) {  
                       $url= Url::to(['/sigi/cuentaspor/crea-lecturas','id'=>$model->id,'gridName'=>'grilla_cargospor','idModal'=>'buscarvalor']);
                         $options = [
                           'class'=>'botonAbre',
                            //'title' => Yii::t('sta.labels', 'Editar'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            //'data-method' => 'get',
                            'data-pjax' => '0',
                             //'target'=>'_blank'
                        ];
                         $colector=$model->colector;
                        //return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => ' btn btn-sm btn-success']);
                        if(!$colector->isBudget() && $colector->isMedidor() && $colector->isMassive())  
                         return Html::a('<span class="btn btn-success glyphicon glyphicon-th-list"></span>',$url,$options);
                     
                        
                        },    
                            
                         
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
            'colector.cargo.descargo',
            'descripcion',
           // 'colector.id',
          
           // 'fedoc',
                            
            //'mes',
            //'anio',
            //'detalle:ntext',
            //'fevenc',
            ['attribute'=>'monto',
                            'format' => ['decimal', 2],
                            'pageSummary' => true,
                            ]    ,
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
       <?php }?>  
    
</div>
<?php
 $url= Url::to(['/sigi/cuentaspor/create-as-child','id'=>$model->id,'gridName'=>'grilla_cargospor','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Cobranza masiva'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Elemento'),'id'=>'btn_apoderado', 'class' => 'botonAbre btn btn-success']); 
?> 
<?php
 $url= Url::to(['/sigi/cuentaspor/create-as-child-interno','id'=>$model->id,'gridName'=>'grilla_cargospor','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Cobranza Individual'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Elemento'),'id'=>'btn_apoderado', 'class' => 'botonAbre btn btn-success']); 
?> 


 <?php 
  $string="$('#boton_facturacion').on( 'click', function(){      
       $.ajax({
              url: '".Url::to(['/sigi/facturacion/facturacion-mes','id'=>$model->id])."', 
              type: 'get',
              data:{},
              dataType: 'json', 
              error:  function(xhr, textStatus, error){               
                            var n = Noty('id');                      
                              $.noty.setText(n.options.id, error);
                              $.noty.setType(n.options.id, 'error');       
                                }, 
              success: function(json) {
              var n = Noty('id');
                      
                       if ( !(typeof json['error']==='undefined') ) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['error']);
                              $.noty.setType(n.options.id, 'error');  
                          }    

                             if ( !(typeof json['warning']==='undefined' )) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['warning']);
                              $.noty.setType(n.options.id, 'warning');  
                             } 
                          if ( !(typeof json['success']==='undefined' )) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['success']);
                              $.noty.setType(n.options.id, 'success');  
                             }      
                   
                        }
                        });


             })";
  
  $this->registerJs($string, \yii\web\View::POS_END);
?>

 <?php 
  $string="$('#boton_resetear').on( 'click', function(){      
       $.ajax({
              url: '".Url::to(['/sigi/facturacion/reset-facturacion-mes','id'=>$model->id])."', 
              type: 'get',
              data:{},
              dataType: 'json', 
              error:  function(xhr, textStatus, error){               
                            var n = Noty('id');                      
                              $.noty.setText(n.options.id, error);
                              $.noty.setType(n.options.id, 'error');       
                                }, 
              success: function(json) {
              var n = Noty('id');
                      
                       if ( !(typeof json['error']==='undefined') ) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['error']);
                              $.noty.setType(n.options.id, 'error');  
                          }    

                             if ( !(typeof json['warning']==='undefined' )) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['warning']);
                              $.noty.setType(n.options.id, 'warning');  
                             } 
                          if ( !(typeof json['success']==='undefined' )) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['success']);
                              $.noty.setType(n.options.id, 'success');  
                             }      
                   
                        }
                        });


             })";
  
  $this->registerJs($string, \yii\web\View::POS_END);
?>