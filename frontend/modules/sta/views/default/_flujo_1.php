<?php
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
//print_r($indiAvances);die();
//var_dump($indiAvances['informes'],$indiAvances['ntotales']);
ECHO Highcharts::widget([
    //'id'=>'grafiquito',
   'options' => [
       'chart'=>['type'=>'column'],
       'title'=>['text'=>'Evaluación inicial'],
       //'subtitle'=>['text'=>'Avance de primera etapa'],
        'xAxis'=>[
            'categories'=>$indiAvances['facultades'],
            'crosshair'=>true,
            ],
       'yAxis'=>[
            'min'=>0,
            'title'=>[ 'text'=>'Num Alumnos'],
           'max'=>300, 
           'min'=>0, 
            ],
        
   'plotOptions'=>[
        'column'=>[
            'pointPadding'=>0.2,
            'borderWidth'=>0
        ]
    ],
   
    'tooltip'=>[
        'headerFormat'=>'<span style="font-size:10px">{point.key}</span><table>',
        'pointFormat'=>'<tr><td style="color:{series.color};padding:0">{series.name}: </td>'.'<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
        'footerFormat'=>'</table>',
        'shared'=>true,
        'useHTML'=>true
            ],
    'plotOptions'=>[
        'column'=>[
            'pointPadding'=>0.1,
            'borderWidth'=>0
        ]
    ],
    'credits'=>false,
    'series'=> [
        [
          'name'=>'Núm Alumnos Evaluados',
          'data'=> $indiAvances['examenes'],
            'dataLabels'=>['enabled'=>true],
           'color'=>'#12d4f3',
        ],
        [
          'name'=>'Núm Alumnos con 3 Informes',
          'data'=>$indiAvances['informes'],
            'dataLabels'=>['enabled'=>true],
             'color'=>'#f7d350',
        ],
        
        [
          'name'=>'Núm Alumnos Totales',
          'data'=>$indiAvances['ntotales'],
            'dataLabels'=>['enabled'=>true],
          'color'=>'#de59d4'
        ],
        
       
        ]
]]);
