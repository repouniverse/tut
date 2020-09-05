<?php 
use frontend\modules\sta\models\Talleresdet;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use common\components\CalendarScheduleWidget;
?>
<div class="box box-body">
    <h4>BIENVENIDO AL PANEL DE ASISTENCIA - <?=$codfac?></h4>
     <?php
    //if(ModAvisos::hasAvisosActuales() && h::userId()==51){
       echo $this->render('_avisos');
   // }
    ?>
    <div class="col-md-4">
            <!-- Info Boxes Style 2 -->
            <?=Html::a("<div class='info-box mb-3 bg-yellow'>
              <span class='info-box-icon'><i class='fa fa-calendar-check-o'></i></span>

              <div class='info-box-content'>
                <span class='info-box-text'>Ir a programa</span>
                
              </div>
             
            </div>",Url::to(['/sta/programas']))?>
            <!-- /.info-box -->
            <?=Html::a("<div class='info-box mb-3 bg-purple-active'>
              <span class='info-box-icon'><i class='fa fa-users'></i></span>

              <div class='info-box-content'>
                <span class='info-box-text'>Resumen de facultad</span>
                <span class='info-box-number'></span>
              </div>
              <!-- /.info-box-content -->
            </div>",Url::to(['/sta/default/resumen-facultad','codfac'=>$codfac]))?>
           
    
    
    
</div>
    
     <div class="col-md-4">
                  <p class="text-center text-info">
                    <?=yii::t('sta.labels','Metas Cumplimieto de Citas')?>
                  </p>

                  <div class="progress-group">
                      <span class="text-info"><span class="fa fa-users"></span><?='  '.yii::t('sta.labels','Alumnos sin ubicar')?></span>
                    <span class="progress-number"><b><?=round($kpiContacto[Talleresdet::CONTACTO_SIN_RESPUESTA]*$nalumnos/100,0)?></b>/<?=$nalumnos?></span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-red" style="width: <?=$kpiContacto[Talleresdet::CONTACTO_SIN_RESPUESTA]?>%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="text-info"><span class="fa fa-users"></span><?='  '.yii::t('sta.labels','Alumnos Contactados')?></span>
                    <span class="progress-number"><b><?=round($kpiContacto[Talleresdet::CONTACTO_CON_RESPUESTA]*$nalumnos/100,0)?></b>/<?=$nalumnos?></span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-warning" style="width: <?=$kpiContacto[Talleresdet::CONTACTO_CON_RESPUESTA]?>%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="text-info"><span class="fa fa-users"></span><?='  '.yii::t('sta.labels','Alumnos con Asistencia')?></span>
                    <span class="progress-number"><b><?=round($kpiContacto[Talleresdet::CONTACTO_CON_CITA]*$nalumnos/100,0)?></b>/<?=$nalumnos?></span>

                    <div class="progress sm">
                        <div class="progress-bar progress-bar-green" style="width: <?=$kpiContacto[Talleresdet::CONTACTO_CON_CITA]?>%"></div>
                    </div>
                  </div>
           
                  <!-- /.progress-group -->
    </div>
    
    
    
    


    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
       <h4><?= yii::t('sta.labels','Citas programadas en general')?></h4>
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
                
    ]
]);?>
 </div>  

</div>