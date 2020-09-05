<?php
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
if(isset($idcita)){
    $datos= \frontend\modules\sta\models\StaDocuAlu::prepareArrayToGraphStatic($idcita);
}elseif(isset($model)){
  $datos= $model->prepareArrayToGraph();  
}else{
    return "NO ha especificado ni el idcdita ni el model";
}
  
  //HighchartsAsset::register($this)->withScripts(['/modules/exporting','/modules/offline-exporting','/modules/export-data']);
    $grafico=Highcharts::widget([
    'id'=>'grafiquito',
   'options' => [
       'chart'=>['type'=>'bar',
           'width'=>700 ],
      'title' => ['text' => 'Niveles en cada uno de los indicadores'],
      'xAxis' => [
          'labels'=>[ 
                                'style'=>[
                                        'fontSize'=>'9px'
                                    ]
                         ],
         //'categories' => $indicadores,
          'categories' => $datos['labels'],
      ],
      'yAxis' => [
          
         'title' => ['text' => 'Percentil']
      ],
      'legend'=>['reversed'=>true],
      'plotOptions'=>[
                 'series'=>[
                    'stacking'=>'normal',
                     'showInLegend'=>false, 
                     
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
       'credits'=>true,
      'series' => [
          ['name' => '','dataLabels'=>['enabled'=>false]  ,'pointWidth'=>15,'groupPadding'=>1,'boderRadius'=>15,'boderColor'=>'#aaaaaa','color'=>'#dddddd', 'data' => $datos['series1']],
         
          ['name' => '', 'pointWidth'=>15,'groupPadding'=>1,'boderRadius'=>15,'boderColor'=>'#f93087','color'=>'#f93087', 'data' => $datos['series2']],
          
          
      ]
   ]
]);
     ECHO $grafico;

?>