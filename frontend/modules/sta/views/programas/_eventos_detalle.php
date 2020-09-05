<?php
//use frontend\modules\sta\models\StaVwCitas;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
//use frontend\modules\sta\models\StaEventos;
//use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
?>
<h4><?=yii::t('sta.labels','Detalle de Eventos')?></h4>
   
     <div class="box box-body">
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">      
       <div class="col-lg-12 col-md-6 col-sm-6 col-xs-6">
         <?php
//HighchartsAsset::register($this)->withScripts(['highcharts']);
$totalAlumnos=$porconvocar+$enproceso+$natendidos;
if($totalAlumnos >0){
    $porcAtencion=round($natendidos*100/$totalAlumnos,1);
   
}else{
    $porcAtencion=0;
}
if($nconvocatorias >0){
    $porcAsistencias=round($nasistencias*100/$nconvocatorias,1);
   
}else{
    $porcAsistencias=0;
}
 
//  var_dump($porcAtencion);die();        
         HighchartsAsset::register($this)->withScripts(['highcharts-more']);
      
HighchartsAsset::register($this)->withScripts(['modules/solid-gauge']);

 echo Highcharts::widget([
   'options' => [
       'chart'=>[
           'type'=>'solidgauge',
           //'spacingTop'=>-115,
           'marginTop'=>-900,
            'marginBottom'=>0,
        'spacingRight'=> 0,
        //'spacingBottom'=> -5,
        'spacingLeft'=> 0,
        'plotBorderWidth'=> 0,
       // 'margin'=>[0,0,0,0]
           
           ],
      'title' => ['text' => '% Avance Evaluacion'],
       'pane'=>[
        'center'=>['50%', '85%'],
        'size'=>'80%',
        'startAngle'=>-90,
        'endAngle'=>90,
        'background'=>[
            'backgroundColor'=>'#EEE',
            'innerRadius'=>'60%',
            'outerRadius'=>'100%',
            'shape'=> 'arc'
        ]
    ], 
     'exporting'=>[
        'enabled'=>false
    ],   
       
     'tooltip'=>[
        'enabled'=> false
    ],   
     'credits' => ['enabled' => false],  
  'yAxis'=>[
       'min'=>0,
        'max'=>100,
        'title'=> [
            'text'=>'Speed'
        ],
        'stops'=>[
           [0.1, '#DF5353'], // red
            [0.5, '#DDDF0D'], // yellow
            [0.9, '#55BF3B'] // green
        ],
        'lineWidth'=>0,
        'tickWidth'=>0,
       // 'minorTickInterval'=>null,
        'tickAmount'=>2,
        'title'=>[
            'y'=>-70
        ],
        'labels'=>[
           'y'=>16 
        ]
         
    ],
   
   'plotOptions'=>[
        'solidgauge'=>[
            'dataLabels'=>[
                'y'=>5,
                'borderWidth'=>0,
                'useHTML'=> true
            ]
        ]
    ],
       
       
     

    

    'series'=>[[
        'name'=> 'Speed',
        'data'=> [$porcAtencion],
        'dataLabels'=>[
            'format'=>
                '<div style="text-align:center">'.
                '<span style="font-size:25px">{y}</span><br/>'.
                '<span style="font-size:12px;opacity:0.4">%</span>'.
                '</div>'
        ],
        'tooltip'=> [
            'valueSuffix'=>' km/h'
        ]
  ]]     
       
       
       
       
       
]   
       
     ]);
       
       


?>
      </div> 
       <div class="col-lg-12 col-md-6 col-sm-6 col-xs-6">
         <?php
//HighchartsAsset::register($this)->withScripts(['highcharts']);
//HighchartsAsset::register($this)->withScripts(['highcharts-more']);
      
//HighchartsAsset::register($this)->withScripts(['modules/solid-gauge']);

 echo Highcharts::widget([
   'options' => [
       'chart'=>[
           'type'=>'solidgauge',
           //'spacingTop'=>-115,
           'marginTop'=>-900,
            'marginBottom'=>0,
        'spacingRight'=> 0,
        //'spacingBottom'=> -5,
        'spacingLeft'=> 0,
        'plotBorderWidth'=> 0,
       // 'margin'=>[0,0,0,0]
           
           ],
      'title' => ['text' => '% Asistencia'],
       'pane'=>[
        'center'=>['50%', '85%'],
        'size'=>'80%',
        'startAngle'=>-90,
        'endAngle'=>90,
        'background'=>[
            'backgroundColor'=>'#EEE',
            'innerRadius'=>'60%',
            'outerRadius'=>'100%',
            'shape'=> 'arc'
        ]
    ], 
     'exporting'=>[
        'enabled'=>false
    ],   
       
     'tooltip'=>[
        'enabled'=> false
    ],   
     'credits' => ['enabled' => false],  
  'yAxis'=>[
       'min'=>0,
        'max'=>100,
        'title'=> [
            'text'=>'Speed'
        ],
        'stops'=>[
            [0.1, '#DF5353'], // red
            [0.5, '#DDDF0D'], // yellow
            [0.9, '#55BF3B'] // green
        ],
        'lineWidth'=>0,
        'tickWidth'=>0,
       // 'minorTickInterval'=>null,
        'tickAmount'=>2,
        'title'=>[
            'y'=>-70
        ],
        'labels'=>[
           'y'=>16 
        ]
         
    ],
   
   'plotOptions'=>[
        'solidgauge'=>[
            'dataLabels'=>[
                'y'=>5,
                'borderWidth'=>0,
                'useHTML'=> true
            ]
        ]
    ],
       
       
     

    

    'series'=>[[
        'name'=> 'Speed',
        'data'=> [$porcAsistencias],
        'dataLabels'=>[
            'format'=>
                '<div style="text-align:center">'.
                '<span style="font-size:25px">{y}</span><br/>'.
                '<span style="font-size:12px;opacity:0.4">%</span>'.
                '</div>'
        ],
        'tooltip'=> [
            'valueSuffix'=>' km/h'
        ]
  ]]     
       
       
       
       
       
]   
       
     ]);
       
       


?>
      </div> 
         
         
     <div class="col-lg-12 col-md-6 col-sm-6 col-xs-6">    
         
         
         
            <div class="info-box mb-3 bg-aqua-gradient">
              <span class="info-box-icon"><i class="fa fa-user-plus"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Alumnos atendidos</span>
                <span class="info-box-number"><?=$natendidos?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-yellow-gradient">
              <span class="info-box-icon"><i class="fa fa-user-plus"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Alumnos en espera (Evento abierto)</span>
                <span class="info-box-number"><?=$enproceso?></span>
              </div>
              <!-- /.info-box-content -->
            </div>  
        <!-- /.info-box -->
            <div class="info-box mb-3 bg-lime-active">
              <span class="info-box-icon"><i class="fa fa-user-plus"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Alumnos que deben convocarse</span>
                <span class="info-box-number"><?=$porconvocar?></span>
              </div>
              <!-- /.info-box-content -->
            </div>  
         <!-- /.info-box -->
         <div class="info-box mb-3 bg-fuchsia">
              <span class="info-box-icon"><i class="fa fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Alumnos en el programa</span>
                <span class="info-box-number"><?=$porconvocar+$enproceso+$natendidos?></span>
              </div>
              <!-- /.info-box-content -->
            </div>  
     
     </div>   
   </div>
    <?php 
      echo \yii\bootstrap\Collapse::widget([
    'items' => [
        // equivalent to the above
        [
            'label' => 'Alumnos pendientes de convocar',
            'content' => $this->render('_eventos_detalle_por_convocar',['dataProviderFaltantes'=>$dataProviderFaltantes]),
            // open its content by default
            'contentOptions' => [/*'class' => 'in'*/]
        ],
        // another group item
        [
           'label' => 'Resumen de alumnos convocados',
           'content' => $this->render('_eventos_detalle_resumen',['dataProvider'=>$dataProvider]),
           'contentOptions' => [],
            'options' => [],
        ],
        
    ]
]);
     ?>
          
         
         
         
         
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
      
         
         

        

    </div>
   
</div>
  
    