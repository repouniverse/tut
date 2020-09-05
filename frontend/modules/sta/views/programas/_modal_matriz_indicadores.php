<?php use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
//use frontend\modules\sta\models\StaVwCitas;

?>

<br>
<div class="box box-body success">
    <a href="_modal_grafico.php"></a>
    
   
<?php
use common\helpers\h;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
?>
    <h4><?=$model->alumno->fullName()?></h4>
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
<?php 
$avance=$model->ITutoriasAvance();
//var_dump($model->Iasistencias());die();
 HighchartsAsset::register($this)->withScripts(['highcharts-more']);
ECHO Highcharts::widget([
     'id'=>'my-chart-id',
    'options'=>[
       'credits'=>false,
        'chart'=>[
            'width'=>200,
            'type'=>'gauge',
        'plotBorderWidth'=> 0,
        'plotBackgroundColor'=>[
            'color'=>'#333',
           /* 'linearGradient'=>[ 'x1'=> 0, 'y1'=> 0, 'x2'=> 0, 'y2'=> 1 ],
            'stops'=>[
                [0, '#FFF4C6'],
                [0.3, '#FFFFFF'],
                [1, '#FFF4C6']
            ]*/
        ],
        'plotBackgroundImage'=>null,
        'height'=> 200
        ],
           'title'=>[
        'text'=>yii::t('sta.labels','Avance tutorías'),
            ],
        
         'pane'=>[[
                'startAngle'=>-40,
                'endAngle'=> 40,
                'background'=>null,
                'center'=>['50%', '100%'],
                    'size'=>200
                     ], /*[
                    'startAngle'=>-45,
                    'endAngle'=>45,
                    'background'=>null,
                    'center'=>['75%', '145%'],
                    'size'=> 300
                ]*/],
                   'exporting'=>[
                  'enabled'=>false
                      ],

                   'tooltip'=>[
                    'enabled'=>false
                  ],
        
         'yAxis'=>[
              [
                     'min'=>0,
                    'max'=>$avance['max']+0,
                    'minorTickPosition'=>'outside',
                    'tickPosition'=>'outside',
                        'labels'=>[
                                'rotation'=>'auto',
                                 'distance'=>20
                                ],
                 'plotBands'=> [
                      [
                                'from'=>0,
                                'to'=>$avance['medio']+0,
                                'color'=>'#ffc5cc',
                                'innerRadius'=>'100%',
                                'outerRadius'=>'105%'
                                ],
                     [
                                'from'=>$avance['medio']+0,
                                'to'=>$avance['bueno']+0,
                                'color'=>'#fbe7c9',
                                'innerRadius'=>'100%',
                                'outerRadius'=>'105%'
                                ],
                     [
                                'from'=>$avance['bueno']+0,
                                'to'=>$avance['max']+0,
                                'color'=>'#c7f5a8',
                                'innerRadius'=>'100%',
                                'outerRadius'=>'105%'
                                ]
                     ],
                        'pane'=>0,
                            'title'=>[
                                     'text'=>'<br/><span style="font-size:8px">TUTORÍA</span>',
                                     'y'=>0
                                    ]
                            
             ],/*[
        'min'=> -20,
        'max'=> 6,
        'minorTickPosition'=> 'outside',
        'tickPosition'=>  'outside',
        'labels'=>  [
            'rotation'=>  'auto',
            'distance'=>  20
        ],
        'plotBands'=>  [[
            'from'=>  0,
            'to'=>  6,
            'color'=>  '#C02316',
            'innerRadius'=>  '100%',
            'outerRadius'=>  '105%'
        ]],
        'pane'=>  1,
        'title'=>  [
            'text'=>  'VU<br/><span style="font-size:8px">Channel B</span>',
            'y'=>  -40
        ]
    ]
       */ 
             
             ],
 'plotOptions'=>[
        'gauge'=> [
            'dataLabels'=>[
                'enabled'=> false
            ],
            'dial'=> [
                'radius'=> '90%'
            ]
        ]
    ],
             
    'series'=>[
               [
                'name'=> 'Channel A',
                'data'=> [$avance['valor']],
                'yAxis'=> 0
                ], /*[
                    'name'=> 'Channel B',
                    'data'=> [-10],
                    'yAxis'=> 1
                ], */
            ] 
         

    ]
]);





?>

<?php $this->registerJs("
   var chart = $('#my-chart-id').highcharts(); 
   var series=chart.series;
    var left =series[0].points[0];
     var original=left.y;
    setInterval(function () {
        if (series) { // the chart may be destroyed
           
               
               var inc = Math.floor(Math.random() *15);
                var esp = Math.floor(Math.random() *10);
                 if(esp % 2 == 0){
                  signo=-1;
                 }else{
                  signo=1;
                 }
                
           
            
            leftVal =original + inc*signo;
             
            //rightVal = right.y + inc ;
           
            left.update(leftVal, false);
            //right.update(rightVal, false);
            chart.redraw();
        }
    }, 200);

",\yii\web\View::POS_READY);  
  ?>
</div>
    
   <div class="col-lg- col-md-4 col-sm-6 col-xs-12">
                     <div class="">
                <table class="table no-margin">
                  <thead>
                  <tr >
                      <th colspan="2"><p class="text-green"><span class="fa fa-clock-o"></span> Métricas de Alumno</p></th> 
                    
                  </tr>
                  <tr>
                      <th><img src="<?=$model->alumno->getUrlImage()?>" width="100" height="120" >
                 </th> 
                      <th>Valor</th> 
                    
                  </tr>
                  </thead>
                  <tbody>
                      
                  
              <tr> 
                  <td>
                      Reprogramaciones
                  </td>
                    <td>
                        <span class="label label-warning"><?=$model->nReprogramaciones()?></span>
                   </td>
              </tr>
              <tr> 
                  <td>
                      Period.  / Period.Prom. (días)
                  </td>
                    <td>
                        <span class="label label-success"><?=$model->frecuencia().'  /  '.$model->talleres->periodo?></span>
                   </td>
              </tr> 
          
                  
                  </tbody>
                </table>
              </div>
  </div>
   
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
   <?php 
 HighchartsAsset::register($this)->withScripts(['highcharts-more']);
ECHO Highcharts::widget([
     'id'=>'my-chart-id2',
    'options'=>[
       'credits'=>false,
        'chart'=>[
            'width'=>200,
            'type'=>'gauge',
        'plotBorderWidth'=> 0,
        'plotBackgroundColor'=>[
            'color'=>'#333',
           /* 'linearGradient'=>[ 'x1'=> 0, 'y1'=> 0, 'x2'=> 0, 'y2'=> 1 ],
            'stops'=>[
                [0, '#FFF4C6'],
                [0.3, '#FFFFFF'],
                [1, '#FFF4C6']
            ]*/
        ],
        'plotBackgroundImage'=>null,
        'height'=> 200
        ],
           'title'=>[
        'text'=>yii::t('sta.labels','Fac asist %'),
            ],
        
         'pane'=>[[
                'startAngle'=>-40,
                'endAngle'=> 40,
                'background'=>null,
                'center'=>['50%', '100%'],
                    'size'=>200
                     ], /*[
                    'startAngle'=>-45,
                    'endAngle'=>45,
                    'background'=>null,
                    'center'=>['75%', '145%'],
                    'size'=> 300
                ]*/],
                   'exporting'=>[
                  'enabled'=>false
                      ],

                   'tooltip'=>[
                    'enabled'=>false
                  ],
        
         'yAxis'=>[
              [
                     'min'=>0,
                    'max'=>100,
                    'minorTickPosition'=>'outside',
                    'tickPosition'=>'outside',
                        'labels'=>[
                                'rotation'=>'auto',
                                 'distance'=>20
                                ],
                 'plotBands'=> [
                      [
                                'from'=>0,
                                'to'=>70,
                                'color'=>'#ffc5cc',
                                'innerRadius'=>'100%',
                                'outerRadius'=>'105%'
                                ],
                     [
                                'from'=>70,
                                'to'=>90,
                                'color'=>'#fbe7c9',
                                'innerRadius'=>'100%',
                                'outerRadius'=>'105%'
                                ],
                     [
                                'from'=>90,
                                'to'=>100,
                                'color'=>'#c7f5a8',
                                'innerRadius'=>'100%',
                                'outerRadius'=>'105%'
                                ]
                     ],
                        'pane'=>0,
                            'title'=>[
                                     'text'=>'<br/><span style="font-size:8px">ASIST</span>',
                                     'y'=>0
                                    ]
                            
             ],/*[
        'min'=> -20,
        'max'=> 6,
        'minorTickPosition'=> 'outside',
        'tickPosition'=>  'outside',
        'labels'=>  [
            'rotation'=>  'auto',
            'distance'=>  20
        ],
        'plotBands'=>  [[
            'from'=>  0,
            'to'=>  6,
            'color'=>  '#C02316',
            'innerRadius'=>  '100%',
            'outerRadius'=>  '105%'
        ]],
        'pane'=>  1,
        'title'=>  [
            'text'=>  'VU<br/><span style="font-size:8px">Channel B</span>',
            'y'=>  -40
        ]
    ]
       */ 
             
             ],
 'plotOptions'=>[
        'gauge'=> [
            'dataLabels'=>[
                'enabled'=> false
            ],
            'dial'=> [
                'radius'=> '90%'
            ]
        ]
    ],
             
    'series'=>[
               [
                'name'=> 'Channel A',
                'data'=> [(INTEGER)$model->Iasistencias()+0],
                'yAxis'=> 0
                ], /*[
                    'name'=> 'Channel B',
                    'data'=> [-10],
                    'yAxis'=> 1
                ], */
            ] 
         

    ]
]);





?>

<?php $this->registerJs("
   var chart = $('#my-chart-id2').highcharts(); 
   var series=chart.series;
    var left =series[0].points[0];
     var original=left.y;
    setInterval(function () {
        if (series) { // the chart may be destroyed
           
               
               var inc = Math.floor(Math.random() *10);
                var esp = Math.floor(Math.random() *10);
                 if(esp % 2 == 0){
                  signo=-1;
                 }else{
                  signo=1;
                 }
                
           
            
            leftVal =original + inc*signo;
             
            //rightVal = right.y + inc ;
           
            left.update(leftVal, false);
            //right.update(rightVal, false);
            chart.redraw();
        }
    }, 200);

",\yii\web\View::POS_READY);  
  ?> 
</div> 
      
    
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">  
    
    
 <p class="text-green"><b><span class="fa fa-list-ul"></span><?='      '.yii::t('sta.labels','Indicadores trabajados')?></p></b>
   
    
<?php 

$matriz=$model->indicadoresMatriz();
if(count($matriz)>0){
    $columns=array_keys($matriz[0]);
    $columnas=[];
    foreach($columns as $clave=>$valor){
        if($valor=='PRIO'){
            $columnas['PRIO']=['attribute'=>'PRIO',
                    'format'=>'raw',
                  'value'=>function($model){
                        return $model['PRIO'].'  '.(($model['PRIO']=='A')?'<i style="color:#fa614c;font-size:16px;"><span class="fa fa-circle"></span></i>':'');
                     }];
            
          }
          elseif($clave>=6){
            $columnas[$clave]=['attribute'=>$valor,
                    'format'=>'raw',
                  'value'=>function($model)use($valor){
                        if($model[$valor]=='X'){
                            return '<i style="color:#37dd31;font-size:16px;"><span class="fa fa-circle"></span></i>';
                        }else{
                            return '';
                        }
                        
                     }];  
          }else{
              $columnas[$clave]=['attribute'=>$valor,
                    'format'=>'raw',
                  'value'=>function($model)use($valor){
                        return $model[$valor];
                     }];  
          }
          
           }
    
    /*$columns['nombre']=['attribute'=>'nombre',
                  'value'=>function($model){
                        return $model['nombre'];
                     }
                     ];
    $columns['PRIO']=['attribute'=>'PRIO',
                    'format'=>'raw',
                  'value'=>function($model){
                        return $model['PRIO'].'<span class="fa fa-list-ul"></span>';
                     }
                     ];*/
    ?>
<div style="overflow:auto;">
<?php
$tipo=h::user()->profile->tipo;
if($tipo== \frontend\modules\sta\staModule::PROFILE_PSICOLOGO OR 
   $tipo== \frontend\modules\sta\staModule::PROFILE_AUTORIDAD     ){
     echo GridView::widget([
        'dataProvider' =>new \yii\data\ArrayDataProvider([
            'allModels'=>$matriz ,
        ]
                ),
         'summary' => '',
         'emptyCell'=>'',
         'tableOptions'=>['class'=>'table no-margin'],
       // 'filterModel' => $searchModel,
        'columns' =>$columnas, 
    ]); 
   }
?>
</div> 
    <?php 
}
   
?>
 
<br>

</diV>

</diV>