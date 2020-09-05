<?php
use yii\helpers\Html;
use yii\helpers\Url;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
use frontend\modules\sta\models\StaDocuAlu;
?>


 <?php
   /*$expresion=new yii\db\Expression("100-percentil as complemento");  
    $datos=$query->select(['puntaje_total','percentil',$expresion,'categoria','b.nombre','b.nemonico','b.invertido'])->join('INNER JOIN','{{%sta_testindicadores}} b','indicador_id=b.id')->orderBy('b.ordenabs ASC')->asArray()->all();
   $indicadores= array_column($datos, 'nombre');
    $categorias= array_column($datos, 'categoria');
   $inversiones= array_column($datos, 'invertido');
    $percentiles= array_column($datos, 'percentil');
   $complemento= array_column($datos, 'complemento');
   $alabels=[];
   foreach($indicadores as $key=>$valor){
       $alabels[]=$valor.'-('.$categorias[$key].')';
       
       if($inversiones[$key]=='1'){
         $temppercentil=$percentiles[$key];
          $percentiles[$key]= $complemento[$key]; 
           $complemento[$key]= $temppercentil; 
       }
   }
    $percentiles=array_map('intval', $percentiles);
    $complemento= array_map('intval', $complemento);*/
$datos= StaDocuAlu::findOne(2361)->prepareArrayToGraph();

 ?>

 <?php
 
  $grafico=Highcharts::widget([
    'id'=>'grafiquito',
   'options' => [
       'chart'=>['type'=>'bar',
           'width'=>700 ],
      'title' => ['text' => 'Niveles en cada uno de los indicadores'],
      'xAxis' => [
          
         'categories' => ['INDI 1','INDI 2'],
          //'categories' => $datos['labels'],
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
          ['name' => '','dataLabels'=>['enabled'=>false]  ,'pointWidth'=>15,'groupPadding'=>1,'boderRadius'=>15,'boderColor'=>'#aaaaaa','color'=>'#dddddd', 'data' => [20,35]],
         
          ['name' => '', 'pointWidth'=>15,'groupPadding'=>1,'boderRadius'=>15,'boderColor'=>'#aa1054','color'=>'#cc3087', 'data' => [['y'=>80,'color'=>'green'],['y'=>65,'color'=>'green']]],
          
          
      ]
   ]
]);
     ECHO $grafico;
   

    ?>
  