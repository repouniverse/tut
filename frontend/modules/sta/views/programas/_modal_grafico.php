<?php
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
use frontend\modules\sta\models\StaDocuAlu;
  $datos= $model->prepareArrayToGraph();
  //HighchartsAsset::register($this)->withScripts(['/modules/exporting','/modules/offline-exporting','/modules/export-data']);
    $grafico= Highcharts::widget([
    'id'=>'grafiquitoe',
   'options' => [
       'chart'=>['type'=>'bar'],
      'title' => ['text' => 'Indicadores'],
      'xAxis' => [
         //'categories' => $indicadores,
           'categories' => $datos['labels'],
      ],
      'yAxis' => [
         'title' => ['text' => 'Percentil']
      ],
      'legend'=>['reversed'=>true],
      'plotOptions'=>[
                 'series'=>[
                    'stacking'=>'normal'
                  ],
          'bar'=>[
                'dataLabels'=>[
                   'enabled'=>true,
                   'crop'=>false,
                'overflow'=>'none'
                  // 'backgroundColor'=>'#fff'
                  ]
                ],
            ], 
       'credits'=>false,
      'series' => [
         ['name' => '','dataLabels'=>['enabled'=>false]  ,'pointWidth'=>15,'groupPadding'=>1,'boderRadius'=>15,'boderColor'=>'#aaaaaa','color'=>'#dddddd', 'data' => $datos['series1']],
         
          ['name' => '', 'pointWidth'=>15,'groupPadding'=>1,'boderRadius'=>15,'boderColor'=>'#f93087','color'=>'#f93087', 'data' => $datos['series2']],
          
         
      ]
   ]
]);
     echo $grafico;

?>
