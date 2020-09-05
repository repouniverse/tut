<?php
use common\helpers\h;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
?>


<?php 
 HighchartsAsset::register($this)->withScripts(['highcharts-more']);
ECHO Highcharts::widget([
     'id'=>'my-chart-id',
    'options'=>[
       
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
        'text'=>'% Eficiencia'
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
                                'to'=>30,
                                'color'=>'#ffc5cc',
                                'innerRadius'=>'100%',
                                'outerRadius'=>'105%'
                                ],
                     [
                                'from'=>30,
                                'to'=>60,
                                'color'=>'#fbe7c9',
                                'innerRadius'=>'100%',
                                'outerRadius'=>'105%'
                                ],
                     [
                                'from'=>60,
                                'to'=>100,
                                'color'=>'#c7f5a8',
                                'innerRadius'=>'100%',
                                'outerRadius'=>'105%'
                                ]
                     ],
                        'pane'=>0,
                            'title'=>[
                                     'text'=>'<br/><span style="font-size:8px">ANSIE</span>',
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
                'data'=> [30],
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
