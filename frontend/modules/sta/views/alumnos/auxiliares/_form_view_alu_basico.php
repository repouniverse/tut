<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;
?>
     <?php $form = ActiveForm::begin(); ?>
      

        <?php //print_r($model->attributes);var_dump($model->facultad); die(); ?>

  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= Html::label(yii::t('base.names','Facultad'),'45545rret',['class' => 'control-label']) ?>
           <?php if( $model->hasProperty('facultad')){ ?>
            <?=  Html::input('text', 'namefacu', $model->facultad->desfac,['disabled'=>'disabled','class' => 'form-control']) ?>
           <?php } else { ?>
            <?=  Html::input('text', 'namefacu', $model->desfac,['disabled'=>'disabled','class' => 'form-control']) ?>
           <?php }  ?>
 </div>
  
   <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= Html::label(yii::t('base.names','Carrera'),'4u5545rret',['class' => 'control-label']) ?>
     <?php if( $model->hasProperty('carrera')){ ?>
            <?=  Html::input('text', 'namefacxu', $model->carrera->descar,['disabled'=>'disabled','class' => 'form-control']) ?>
           <?php } else { ?>
            <?=  Html::input('text', 'namefacxu', $model->descar,['disabled'=>'disabled','class' => 'form-control']) ?>
           <?php }  ?>
 </div>
   
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <?php if( $model->hasProperty('fullName')){ ?>
       <?= $form->field($model, 'nombres')->textInput(['value' =>$model->fullName(),'disabled' => 'disabled']) ?>
         <?php }else{ ?>
         <?= $form->field($model, 'nombres')->textInput(['value' =>$model->ap.'-'.$model->am.'-'.$model->nombres,'disabled' => 'disabled']) ?>
           <?php }  ?>
   </div>
   <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
       
                  <img src="<?=$model->getUrlImage()?>" width="160" height="180" class="img-thumbnail">
   </div>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
 <?php 
            
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
          if($this->context->action->id='trata-alumno'){
           $avance=$modelTallerdet->ITutoriasAvance();
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
            'tooltip'=>'Este es un indicador de progerso en las tutorías',
            
        'plotBackgroundImage'=>null,
        'height'=> 200
        ],
           'title'=>[
        'text'=>yii::t('sta.labels','#Tutorías'),
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
           
               
               var inc = Math.floor(Math.random() *2);
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
  
          }
      ?>
  </div>
 <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
 <?php  //h::settings()->invalidateCache();  ?>
 <?= $form->field($model, 'codalu')->textInput(['disabled' => 'disabled'])?>
 <?php 
 // ECHO  \yii\helpers\Html::a('<span class="btn btn-danger btn-sm glyphicon glyphicon-pencil"></span>', \Yii\Helpers\Url::to(['/sta/alumnos/update','id'=>$model->id]),['target'=>'_blank']);
 echo \yii\helpers\Html::a('<span class="btn btn-danger btn-lg glyphicon glyphicon-scale"></span>'.'  '.yii::t('sta.labels','Ver métricas'),\yii\helpers\Url::to(['modal-matriz-indicadores','id'=>$modelTallerdet->id]),['class'=>'botonAbre btn btn-warning']);  ?>
 </div>
  <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
     <?= $form->field($model, 'dni')->textInput(['disabled' => 'disabled']) ?>

 </div>
 <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">    
 <?= $form->field($model, 'celulares')->textInput(['disabled' => 'disabled']) ?>
 </div>        
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">    
 <?= \yii\helpers\Html::a('<span class="btn btn-danger btn-sm glyphicon glyphicon-pencil"></span>', \Yii\Helpers\Url::to(['/sta/alumnos/update','id'=>$model->id]),['target'=>'_blank']) ?>
 <?php ECHO ($model->hasProperty('codperiodo'))?\yii\helpers\Html::a('<span class="btn btn-success btn-sm glyphicon glyphicon-folder-open"></span>', \Yii\Helpers\Url::to(['/sta/alumnos/ver-detalles','id'=>$model->idalumno,'codperiodo'=>$model->codperiodo]),['target'=>'_blank']):'' ?>
 
 </div>       
           
              
   <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">   
 <?= $form->field($model, 'correo')->textInput(['disabled' => 'disabled']) ?>
 </div>  

 <?php if( $model->hasProperty('domicilio')){ ?>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'domicilio')->textInput(['disabled' => 'disabled']) ?>

 </div>
 <?php } ?>  
  
     
               
          
  
     
    <?php ActiveForm::end(); ?>

     
          
          

