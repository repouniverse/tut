<?php
use yii\helpers\Html;
use yii\helpers\Url;

use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
?>

<?php
$meses= array_slice(array_keys($cantidades[0]),0,3);
$cantidades=array_slice(array_map('intval',array_values($cantidades[0])),0,3);
echo Highcharts::widget([
   'options' => [
      'title' => ['text' => yii::t('sta.labels','Atenciones por mes'),
           'style'=>[
                        'color'=> '#f39c12',
                        'fontWeight'=>'bold',
                        'fontSize'=>'15px'
                        ]
          ],
      
       'plotOptions'=>[
         'series'=>[
            'series'=> [
                'connectorAllowed'=>false
            ],
           ],
           ],
       'credits'=>false,
      
      'xAxis' => [
         'categories' => $meses,
      ],
     /* 'yAxis' => [
         'title' => ['text' => 'Asistencias']
      ],*/
      'series' => [
          
         ['name' => 'Cantidad de Atenciones', 
             'data' => $cantidades,
             
         ],
          
         //['name' => 'John', 'data' => [5, 7, 3]]
      ]
   ]
]);



?>
