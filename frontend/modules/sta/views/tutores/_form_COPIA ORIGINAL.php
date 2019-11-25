<?php
use kriss\calendarSchedule\CalendarScheduleWidget;
use yii\web\JsExpression;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="borereuccess">   
    
     
      <div class="box-body">
        
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        
                 <?=Html::label(yii::t('sta.labels','Tutor'),'trabajadores_caja',['class'=>'control-label']) ?> 
                <?=Html::textInput('mytexto',$model->trabajador->fullName(),['id' =>'trabajadores_caja','class'=>'form-group form-control']) ?>

            </div>
   <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
              
<?php


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
    
    'draggableEvents' => [
        'items' => [
            ['name' => 'Lunes', 'color' => '#286090'],
            ['name' => 'Martes', 'color' => '#f0ad4e'],
            ['name' => 'Miercoles', 'color' => '#286090'],
            ['name' => 'Jueves', 'color' => '#f0ad4e'],
            ['name' => 'Viernes', 'color' => '#286090'],
            ['name' => 'Sabado', 'color' => '#f0ad4e'],
            
        ],
        'removeCallback' => new JsExpression($jsRemoveCallback)
    ],
    'createEvents' => [
        'colors' => ['#286090', '#5cb85c', '#5bc0de', '#f0ad4e', '#d9534f'],
        'createCallback' => new JsExpression($jsCreateCallback)
    ],
    'fullCalendarOptions' => [
        
       /*  'validRange'=>[
                'start'=>'2019-11-05',
                'end'=>'2019-11-19'
                ],*/
        //'formatDate'=>'dd/mm/yyyy',
         'locale'=>'es',   
        'events' => [
            ['title' => 'evento 1', 'start' => date('Y-m-d 10:00:00'), 'end' => date('Y-m-d 20:00:00'), 'color' => '#286090'],
            ['title' => 'evento 2', 'start' => date('Y-m-10 10:00:00'), 'allDay' => true, 'color' => '#5bc0de'],
        ],
        'eventReceive' => new JsExpression('function(event, delta, revertFunc) {
                    alert(event.title + " was received on " + event.start.format("YYYY-MM-DD HH:mm:ss"));
                    
 var fechainicio=event.start.format("YYYY-MM-DD HH:mm:ss");
        $.ajax({ 
                    method:"get",    
                    url: "'.\yii\helpers\Url::toRoute('/sta/programas/make-cita-by-student').'",
                    delay: 250,
                        data: {id:'.$model->id.', fecha:fechainicio,codalu:event.title  },
             error:  function(xhr, textStatus, error){               
                            revertFunc();
                                }, 
              success: function(json) {  
                        var n = Noty("id");
                       if ( !(typeof json["error"]==="undefined") ) {
                       revertFunc();
                   $.noty.setText(n.options.id,"<span class=\'glyphicon glyphicon-trash\'></span>      "+ json["error"]);
                              $.noty.setType(n.options.id, "error"); 
                              }
                         if ( !(typeof json["success"]==="undefined") ) {
                                        $.noty.setText(n.options.id, json["success"]);
                             $.noty.setType(n.options.id, "success");
                              } 
                               if ( !(typeof json["success"]==="undefined") ) {
                                        $.noty.setText(n.options.id, json["warning"]);
                             $.noty.setType(n.options.id, "warning");
                              } 
                              
                      
                        },
   cache: true
  })









if (!confirm("Are you sure about this change?")) {
                             revertFunc(); }
                                    }'),
        'eventDrop' => new JsExpression(
                'function(event, delta, revertFunc) {
                    alert(event.title + " was dropped on " + event.start.format());
                    if (!confirm("Are you sure about this change?")) {
                             revertFunc(); }
                                    }'),
        'eventResize' => new JsExpression('function(event, delta, revertFunc) {
                    alert(event.title + " SE MOVIO A     INICIO->" + event.start.format("YYYY-MM-DD H:m:s")+ "   FIN  -> "+event.end.format("YYYY-MM-DD HH:mm:ss") );
                    if (!confirm("Are you sure about this change?")) {
                    

                             revertFunc(); }}'),
        'eventClick' => new JsExpression('function(event) {alert("hiciste clik  en "+event.title)}'),
    ]
]);


?>
    </div>   
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
      <?php  $gridColumns = [
[  'attribute' => 'ap',
],
[  'attribute' => 'nombres', 
],         
[
                'attribute'=>'codalu',
                'format'=>'html',
                'value' => function ($model, $key, $index, $column) {
                    $options=['id'=>$model->codalu,
                              'class'=>'class_link_ajax'
                               ];
                    return Html::a($model->codalu, '#', $options);
                        },
],
];
   ?>
        <?php 
        Pjax::begin(['id'=>'sumilla']);
        echo GridView::widget([
             'id' => 'kv-grid-demo',
        'dataProvider' => $dataProvider,
         //'summary' => '',
        // 'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => $searchAlumnos,
        'columns' => $gridColumns,
           //  'pjax' => true, // pjax is set to always true for this demo
            //'toggleDataContainer' => ['class' => 'btn-group mr-2'],
           /* 'panel' => [
        'type' => GridView::TYPE_WARNING,
        //'heading' => $heading,
    ],*/
    
    ]);
        Pjax::end();
        ?>
        
     </div>         
</div>
    </div>
<a href="<?=\yii\helpers\Url::toRoute("prueba-modal") ?>" class="btn btn-success botonAbre">picha aqui</a>