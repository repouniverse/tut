<?php
use common\components\CalendarScheduleWidget;
use yii\web\JsExpression;
use yii\helpers\Html;
use yii\helpers\Json;

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\helpers\h;
use yii\grid\GridView;
use kartik\date\DatePicker;
use yii\widgets\Pjax;
use frontend\modules\avisos\Module as ModAvisos;
use frontend\modules\sta\staModule;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="borereuccess">   
  <div class="box box-body">               
<?php

  IF(staModule::getCurrentPeriod()==$codperiodo){  

      ?>
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
             
              <i style="color:#8ddaf5;" ><span class="fa fa-envelope" title="<?=yii::t('sta.labels','Indica que al momento de la creación o reprogramación de una cita, enviará un correo automático al alumno. Si observa esta opción está deshabilitada póngase en contacto con el administrador')?>"</span></i>
              <div class="switch">
                    <label>
                    <input type="checkbox" <?=(h::gsetting('sta','notificacitasmail'))?'checked=""':'' ?> disabled="disabled" >
                    <span class="lever"></span> 
                    </label>
                </div>
          </div> 
      </div> 
      
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
             <b><p class="text-green"><span class="fa fa-calendar"></span><?='             '.yii::t('sta.labels','Citas prog para').'   '.$fecha?></p></b>
        
      <?php
     $urlCurrent=\yii\helpers\Url::current();
     
      echo DatePicker::widget([
     'name' => 'anniversary',
    //'type' => DatePicker::TYPE_BUTTON,
    //'value' => '23-Feb-1982',
    'pluginOptions' => [
       'format' => 'mm/dd/yyyy'
    ],
   'pluginEvents'=> [
   "changeDate" => "function(e) {"
       . "mes=(e.date.getMonth()+1)+'';"
       . " dia= e.date.getDate()+'';"       
       . "formatted = e.date.getFullYear() + '-' + mes.padStart(2, '0') + '-' + dia.padStart(2, '0') ; "
       . " "
       . "  var url = '".\yii\helpers\Url::current()."';
            
        
             if(url.search('fecha')>0){
             url=url.replace('fecha=".$fecha."','fecha='+formatted);
             }else{
               if(url.search('codfac')>0){
                 url=url+'&fecha='+formatted; 
               } else{
                 url=url+'?fecha='+formatted; 
               }
             
             }
              
             // alert(url);
           window.location=url;
          
          return false;  "
       . "}",
                  ]
      ]);    ?>
        </div>
      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
       
          <?php  
        $sesion=h::session();
          if($sesion->has('correos_'.h::userId())){
              echo \yii\helpers\Html::button('<span class="fa fa-envelope"></span>   '.Yii::t('sta.labels', 'Notificar'), ['class' => 'btn btn-success','href' => '#','id'=>'btn-mail']);
            }
         ?>
         <?php  
        $sesion=h::session();
          if($sesion->has('correos_'.h::userId())){
              $listaCorreos= array_column(array_values($sesion['correos_'.h::userId()]), 'correo');
           echo Html::a('<span class="fa fa-envelope-open" ></span>'.'  '.yii::t('sta.labels','Mensaje'),Url::toRoute(['/sta/default/mensaje-masivo','lista'=>  Json::encode($listaCorreos)    ]),['target'=>'_blank','data-pjax'=>'0','class'=>"btn btn-danger"]);
            }
         ?>
                
       </div>  
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
       
          <?php  
           if(h::user()->isMultiFacultad()){ ?>
             
            <?= \yii\helpers\Html::label(yii::t('sta.labels','Ir a otra Facultad'),'micombo',['class'=>'control-label'])?>
        
        <?= \yii\helpers\Html::dropDownList('micombofac',$codfac,\frontend\modules\sta\helpers\comboHelper::getCboFacultadesByUser(\common\helpers\h::userId()),
                    ['prompt'=>yii::t('sta.labels','--Seleccione un valor--'),
                     'class'=>'form-group form-control',
                     'id'=>'id_micombofac'
                        ]
                    )?>
                 
       
          <?PHP  } ?>
       
         
                
       </div>     
        
        
       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">   
           <br><br>
        <?php Pjax::begin(['id'=>'listado_citas','timeout'=>false]); ?>
         <?= GridView::widget([
        'dataProvider' => $provider,
        // 'summary' => '',
         'tableOptions'=>[
             'class'=>'table table-condensed table-hover table-borderless table-striped table-responsive text-nowrap'
             ],
             'columns' => [
                 
                 ['attribute'=>'aptutor',
                     'format'=>'raw',
                     'value'=>function($model){
                              return ((is_null($model->codaula))?'':'<i style="color:red;"><span class="fa fa-users"></span></i>').$model->aptutor;
                       }
                     ]
                 ,
         [
             'attribute'=>'Cita',
             'format'=>'raw',
              'value'=>function($model){
                $url=Url::to(['/sta/citas/update','id'=>$model->id]);
                $options=['data-pjax'=>'0','target'=>'_blank'];
                 return Html::a(substr($model->fechaprog,0,16),$url,$options);
              }
                
                ],                        
            'asistio',
           'codfac',
           /*[
             'attribute'=>'nombreprograma',
             'format'=>'raw',
              'value'=>function($model){
                $url=Url::to(['/sta/programas/update','id'=>$model->talleres_id]);
                $options=['data-pjax'=>'0','target'=>'_blank'];
                 return Html::a(substr($model->nombreprograma,0,15).'...',$url,$options);
              }
                
                ],*/
            [
             'attribute'=>'codalu',
             'format'=>'raw',
              'value'=>function($model){
                $url=Url::to(['/sta/programas/trata-alumno','id'=>$model->talleresdet_id]);
                $options=['data-pjax'=>'0','target'=>'_blank'];
                 return Html::a(substr($model->codalu,0,15).'...',$url,$options);
              }
                
                ],
                  'ap',
            'nombres',
            [
             'attribute'=>'Imagen',
             'format'=>'html',
              'value'=>function($model){
                 return $model->fotoAluSmall();
              }
                
                ]
        ],
    ]); ?>
            <?php Pjax::end(); ?>
     </div> 
    
          
    </div>   
      
        
            
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
       
       <br>
       <br>
       <hr style="border: 1px dashed #4CAF50;" >
       <br>
       <br>
    <b><p class="text-green"><span class="fa fa-calendar"></span><?='             '.yii::t('sta.labels','Citas programadas en general')?></p></b>
         
       
 <?PHP     
$jsRemoveCallback = <<<JS
function(title) {
  console.log('removeCallback', title);
}
JS;

$jsCreateCallback = <<<JS
function(title, color) {
  console.log('createCallback', title, color);
}
JS;
echo CalendarScheduleWidget::widget([
    'defaultEventDuration'=>'00:45',
     
    'draggableEvents' => [
        'visible'=>false,
        'items' => [],
       
    ],
    'createEvents' => [
         'visible'=>false,
        'colors' => [],
       
    ],
    'fullCalendarOptions' => [
        'minTime'=>"07:00:00",
        'maxTime'=>"21:00:00",
        'editable' => false,
       /*  'validRange'=>[
                'start'=>'2019-11-05',
                'end'=>'2019-11-19'
                ],*/
        //'formatDate'=>'dd/mm/yyyy',
         'locale'=>'es',
        
       'events' => $citasPendientes,
        'eventClick' => new JsExpression('function(event) {
          var url = "sta/citas/update?id="+event.id;
          var abso="'.\yii\helpers\Url::home(true).'";
              window.open(abso+url);
         }' ),
        
        
         'eventDrop' => new JsExpression('function(event, delta,revertFunc) {
           
      
       if (confirm("'.yii::t('sta.labels','¿Confirmar que desea hacer esta operación ?').'")) {
                  var fechainicio=event.start.format("YYYY-MM-DD HH:mm:ss");
                   var fechatermino=event.end.format("YYYY-MM-DD HH:mm:ss");
        $.ajax({ 
                    method:"get",    
                    url: "'.\yii\helpers\Url::toRoute(['/sta/citas/reprograma-cita']).'",
                    delay: 250,
                        data: {idcita:event.id, finicio:fechainicio,ftermino:fechatermino },
             error:  function(xhr, textStatus, error){               
                           var n = Noty("id");                      
                            $.noty.setText(n.options.id, "No se completó la operación,refresque la página e intente nuevamente");
                             
                              $.noty.setType(n.options.id, "error"); 
                                }, 
              success: function(json) {  
                        var n = Noty("id");
                       if ( !(typeof json["error"]==="undefined") ) {
                      //revertFunc();
                   $.noty.setText(n.options.id,"<span class=\'glyphicon glyphicon-remove-sign\'></span>      "+ json["error"]);
                              $.noty.setType(n.options.id, "error"); 
                              }
                         if ( !(typeof json["success"]==="undefined") ) {
                                        $.noty.setText(n.options.id,"<span class=\'glyphicon glyphicon-ok-sign\'></span>" + json["success"]);
                             $.noty.setType(n.options.id, "success");
                              } 
                               if ( !(typeof json["warning"]==="undefined") ) {
                                        $.noty.setText(n.options.id,"<span class=\'glyphicon glyphicon-info-sign\'></span>" +json["warning"]);
                             $.noty.setType(n.options.id, "warning");
                              } 
                              
                      
                        },
   cache: true
  })
        }else{
     // revertFunc();
      }
}'),
        
        
        
        
    ]
]);?>
 </div>  
<?PHP
  }ELSE{ ?>
    <div class="alert alert-warning"><span class="fa fa-book-reader"></span><?='    '.yii::t('sta.labels','La programación de citas sólo es posible en el periodo activo  '.staModule::getCurrentPeriod())?></div>  
 <?PHP }

?>
 
        
</div>
    </div>
<?php 

$string4="$('#btn-mail').on( 'click', function(){ 
    if (confirm('".yii::t('sta.labels','¿Confirmar que desea hacer esta operación ?')."')) {  
     
       $.ajax({
              url: '".Url::to(['/sta/default/notifica'])."', 
              type: 'get',
              data:{fecha:'". Json::encode($fecha)."'},
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
                              $.pjax.reload({container: '#botones-examenes'});
                             } 
                          if ( !(typeof json['success']==='undefined' )) {
                         
                         
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-ok\'></span>      '+ json['success']);
                             
                            $.noty.setType(n.options.id, 'success');  
                               
                             }      
                   
                        }
                        });
           }

             })";
 $this->registerJs($string4, \yii\web\View::POS_END);
?>
<?php 
 
 echo \yii\helpers\Html::script("$(function(){
       $('#id_micombofac').on('change', function () {
        //alert($(this).val());
          var url = '".\yii\helpers\Url::current()."';
             //  alert(url);
          //url=url.replace('codfac=".$codfac."','codfac='+$(this).val());
             if(url.search('codfac')>0){
             url=url.replace('codfac=".$codfac."','codfac='+$(this).val());
             }else{
             url=url+'?codfac='+$(this).val(); 
             }
              
              //alert(url);
           window.location=url;
          
          return false;
      });
    });" ); ?>