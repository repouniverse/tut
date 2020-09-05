<?php

use yii\helpers\Html;
use yii\helpers\Url;
//use kartik\grid\GridView;
use frontend\modules\sta\models\Citas;
use yii\grid\GridView;
use yii\widgets\Pjax;
    use kartik\export\ExportMenu;
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\sta\models\CitasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('sta.labels', 'Resumen Asistencias');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="citas-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
   
    <?php  echo $this->render('_search_asistencias', ['model' => $searchModel]); ?>
         <hr/>
    
    <?php
    $gridColumns=[
            
         
         /*[
                'class' => 'yii\grid\ActionColumn',
                'template' => '',
                'buttons' => [
                    'update' => function($url, $model) {
                     
                          $url= \yii\helpers\Url::toRoute(['update','id'=>$model->id]);
                        $options = [
                            'data-pjax'=>'0',
                            'target'=>'_blank',
                            'title' => Yii::t('base.verbs', 'Editar'),                            
                        ];
                        return Html::a('<span class="btn btn-danger btn-sm glyphicon glyphicon-pencil"></span>', $url, $options);
                      
                        
                     }
                        ,
                          'view' => function($url, $model) {  
                             $url= \yii\helpers\Url::toRoute(['view','id'=>$model->id]);
                       
                              $options = [
                            'data-pjax'=>'0',
                            'target'=>'_blank',
                            'title' => Yii::t('base.verbs', 'Ver'),                            
                        ];
                        return Html::a('<span class="btn btn-warning btn-sm glyphicon glyphicon-search"></span>', $url, $options);
                      
                        
                        
                        },
                         
                    ]
                ],*/
                
         [ 'attribute' => 'codalu',
             'format'=>'raw',
             'value'=>function($model){
                  $url=\yii\helpers\Url::to(['/sta/programas/trata-alumno','id'=>$model->tallerdet_id]);
                return \yii\helpers\Html::a($model->codalu,$url,['target'=>'_blank','data-pjax'=>'0']);        
             }
             ],
        [ 'attribute' => 'nombres',
             ],
            // 'alumno.celulares', 
             // 'alumno.correo', 
           [ 'attribute' => 'codperiodo',
             ],
       [
           'attribute' => 'codfac',
          // 'visible' =>false,
           ],
           [
           'attribute' => 'codtra',
          // 'visible' =>false,
           ],
      
         [ 'attribute' => 'codcar',
             ],
            [ 
             'attribute' => 'n_informe'
             ],
             [ 
              'attribute' => 'c_1',
               'format'=>'raw',
              'value'=>function($model){
                if($model->c_1==''){
                    return ''; 
                }else{
                    if(substr($model->c_1,0,1)=='@'){
                        $cola="<i style='color:red'>".substr($model->c_1,1,5)."<b>*<b></i>";
                    }else{
                       $cola=substr($model->c_1,0,5); 
                    }
                     $url=\yii\helpers\Url::to(['/sta/citas/update','id'=>$model->obtenerCitaId(1)]);
                return \yii\helpers\Html::a($cola,$url,['target'=>'_blank','data-pjax'=>'0']);        
             
                }
                         
             }
             ],
               [ 
              'attribute' => 'c_2',
                    'format'=>'raw',
                   'value'=>function($model){
                if($model->c_2==''){
                    return ''; 
                }else{
                     $url=\yii\helpers\Url::to(['/sta/citas/update','id'=>$model->obtenerCitaId(2)]);
                return \yii\helpers\Html::a(substr($model->c_2,0,5),$url,['target'=>'_blank','data-pjax'=>'0']);        
                       }
                                     }
             ],
                  [ 
              'attribute' => 'c_3',
                      'value'=>function($model){
                 return substr($model->c_3,0,5);         
                 }
             ],
                  [ 
              'attribute' => 'c_4',
                      'value'=>function($model){
                 return substr($model->c_4,0,5);         
                 }
             ],
             [ 
              'attribute' => 'c_5',
                      'value'=>function($model){
                 return substr($model->c_5,0,5);         
                 }
             ],                    
            [ 
              'attribute' => 'c_6',
                      'value'=>function($model){
                 return substr($model->c_6,0,5);         
                 }
             ], 
            [ 
              'attribute' => 'c_7',
                      'value'=>function($model){
                 return substr($model->c_7,0,5);         
                 }
             ], 
              [ 
              'attribute' => 'c_8',
                      'value'=>function($model){
                 return substr($model->c_8,0,5);         
                 }
             ], 
                      [ 
              'attribute' => 'c_9',
                      'value'=>function($model){
                 return substr($model->c_9,0,5);         
                 }
             ], 
              [ 
              'attribute' => 'c_10',
                      'value'=>function($model){
                 return substr($model->c_10,0,5);         
                 }
             ], 
                     [ 
              'attribute' => 'c_11',
                      'value'=>function($model){
                 return substr($model->c_11,0,5);         
                 }
             ], 
                [ 
              'attribute' => 'c_12',
                      'value'=>function($model){
                 return substr($model->c_12,0,5);         
                 }
             ], 
                     [ 
              'attribute' => 'c_37',
                      'value'=>function($model){
                 return substr($model->c_37,0,5);         
                 }
             ],       
               [ 
              'attribute' => 'c_38',
                      'value'=>function($model){
                 return substr($model->c_38,0,5);         
                 }
             ],
               [ 
              'attribute' => 'c_39',
                      'value'=>function($model){
                 return substr($model->c_39,0,5);         
                 }
             ],        
                 
              [ 
              'attribute' => 'c_15',
                      'value'=>function($model){
                 return substr($model->c_15,0,12);         
                 }
             ],  
             [ 
              'attribute' => 'c_16',
                      'value'=>function($model){
                 return substr($model->c_16,0,12);         
                 }
             ],
             [ 
              'attribute' => 'c_17',
                      'value'=>function($model){
                 return substr($model->c_17,0,12);         
                 }
             ],
            [ 
              'attribute' => 'c_18',
                      'value'=>function($model){
                 return substr($model->c_18,0,12);         
                 }
             ],
                     
            [ 
              'attribute' => 'c_19',
                      'value'=>function($model){
                 return substr($model->c_19,0,12);         
                 }
             ], 
                 [ 
              'attribute' => 'c_20',
                      'value'=>function($model){
                 return substr($model->c_20,0,12);         
                 }
             ],  
                     
               [ 
              'attribute' => 'c_30',
                      'value'=>function($model){
                 return substr($model->c_30,0,12);         
                 }
             ],     
                      [ 
              'attribute' => 'c_31',
                      'value'=>function($model){
                 return substr($model->c_31,0,12);         
                 }
             ],  
                      [ 
              'attribute' => 'c_32',
                      'value'=>function($model){
                 return substr($model->c_32,0,12);         
                 }
             ],     
                      [ 
              'attribute' => 'c_33',
                      'value'=>function($model){
                 return substr($model->c_33,0,12);         
                 }
             ], 
                      [ 
              'attribute' => 'c_34',
                      'value'=>function($model){
                 return substr($model->c_34,0,12);         
                 }
             ],   
                      [ 
              'attribute' => 'c_35',
                      'value'=>function($model){
                 return substr($model->c_35,0,12);         
                 }
             ],   
                     
              [ 
              'attribute' => 'c_36',
                      'value'=>function($model){
                 return substr($model->c_36,0,12);         
                 }
             ], 
              [ 
              'attribute' => 'c_40',
                      'value'=>function($model){
                 return substr($model->c_40,0,12);         
                 }
             ],           
             [ 
              'attribute' => 'c_41',
                      'value'=>function($model){
                 return substr($model->c_41,0,12);         
                 }
             ], 
                     [ 
              'attribute' => 'c_42',
                      'value'=>function($model){
                 return substr($model->c_42,0,12);         
                 }
             ], 
                     [ 
              'attribute' => 'c_43',
                      'value'=>function($model){
                 return substr($model->c_43,0,12);         
                 }
             ], 
                [ 
              'attribute' => 'c_44',
                      'value'=>function($model){
                 return substr($model->c_44,0,12);         
                 }
             ],      
                     
                     [ 
              'attribute' => 'nveces',
                      
             ],
          [ 
              'attribute' => 'tmarzo',
                      'value'=>function($model){
                 return substr($model->tmarzo,0,5);         
                 }
             ],
                     [ 
              'attribute' => 'tabril',
                      'value'=>function($model){
                 return substr($model->tabril,0,5);         
                 }
             ],
                     [ 
              'attribute' => 'tmayo',
                      'value'=>function($model){
                 return substr($model->tmayo,0,5);         
                 }
             ],
                       [ 
              'attribute' => 'tjunio',
                      'value'=>function($model){
                 return substr($model->tjunio,0,5);         
                 }
             ],
                     [ 
              'attribute' => 'tjulio',
                      'value'=>function($model){
                 return substr($model->tjulio,0,5);         
                 }
             ],
                     
               [ 
              'attribute' => 'tagosto',
                      'value'=>function($model){
                 return substr($model->tagosto,0,5);         
                 }
             ],
                      [ 
              'attribute' => 'tsetiembre',
                      'value'=>function($model){
                 return substr($model->tsetiembre,0,5);         
                 }
             ],
            
                     
             [ 
              'attribute' => 'n_tutorias',
                 'header'=>'Solo Tutorías Indiv'
                          
                
             ],
             [ 
              'attribute' => 'n_talleres',
                 'header'=>'Solo Tutorías grup'
                          
                
             ],
           [ 
              'attribute' => 'c_21',
                 'header'=>'Total'
                          
                
             ],
           
        ];
    
    echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
     'filename'=>'Hoja de asistencia',
     'exportConfig'=>[
         ExportMenu::FORMAT_EXCEL=>[
             'filename'=>'Exportacion'
               ],
         ExportMenu::FORMAT_EXCEL_X=>[
             'filename'=>'Exportacion'
               ]
         ],
    'columns' => $gridColumns,
    'dropdownOptions' => [
        'label' => yii::t('sta.labels','Exportar'),
        'class' => 'btn btn-success'
    ]
]) ?>
 
 

         
 <hr>
    
    
    <div style='overflow:auto;'>
    <?php Pjax::begin(['id'=>'listado_asistencias', 'timeout'=>false]); ?>
   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
         //'summary' => '',
         'tableOptions'=>['class'=>'table no-margin'],
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
    ]); ?>
        
        <div class="btn-group">
            
        </div> 
   </div> 
 
 
  
                
        
        
    <?php    $this->registerJs("
         
$('#boton_parte_asistencia').on( 'click', function(){    
  $.ajax({ 
  
   method:'post',    
      url: '".\yii\helpers\Url::toRoute('/sta/citas/asistencias')."',
   delay: 250,
 data: {},
             error:  function(xhr, textStatus, error){               
                            var n = Noty('id');                      
                              $.noty.setText(n.options.id, error);
                              $.noty.setType(n.options.id, 'error');       
                                }, 
              success: function(json) {  
                        var n = Noty('id');
                       if ( !(typeof json['error']==='undefined') ) {
                                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['error']);
                              $.noty.setType(n.options.id, 'error'); 
                              }
                         if ( !(typeof json['success']==='undefined') ) {
                                        $.noty.setText(n.options.id, json['success']);
                             $.noty.setType(n.options.id, 'success');
                              } 
                               if ( !(typeof json['warning']==='undefined') ) {
                                        $.noty.setText(n.options.id, json['warning']);
                             $.noty.setType(n.options.id, 'warning');
                              } 
                              $.pjax.defaults.timeout = false;  
                        $.pjax.reload({container: '#listado_asistencias'});
                        },
   cache: true
  })
 }
 
);",\yii\web\View::POS_END);  
  ?>
    <?php Pjax::end(); ?>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <b><p class="text-green"><?='             '.yii::t('sta.labels','Asistencias totales')?></p></b>
      <?php 
       $cuantos=frontend\modules\sta\models\StaResumenasistencias::find()
              ->select(['count(codalu) as nalufac','codfac'])
             ->groupBy(['codfac'])->orderBy('codfac')->asArray()->all();
      $cuan=array_combine(array_column($cuantos,'codfac'),array_column($cuantos,'nalufac'));
      
       $datos=frontend\modules\sta\models\StaResumenasistencias::find()
              ->select(['count(c_21) as nalumnos','c_21','codfac'])
             ->groupBy(['c_21','codfac'])->orderBy([
    'codfac' => SORT_ASC,
    'c_21' => SORT_ASC,
])->asArray()->all();
      
      echo GridView::widget([
        'dataProvider' => New \yii\data\ArrayDataProvider([
        'allModels'=>$datos
            
            ]),
         'summary' => '',
         'tableOptions'=>['class'=>'table no-margin'],
        //'filterModel' => $searchModel,
        'columns' => [
            
            ['attribute'=>'# Asistencias',
                'value'=>function($model) {
                                 return $model['c_21'];
                                 }
                ],
             ['attribute'=>'Alumnos',
                'value'=>function($model) {
                                 return $model['nalumnos'];
                                 }
                ],
           
            ['attribute'=>'Porcentaje',
                'value'=>function($model) use ($cuan){
                                if($cuan[$model['codfac']]==0) return 0;
                                return round($model['nalumnos']*100/$cuan[$model['codfac']],2).' %';;
                                 }
                ], 'codfac',
                    ],
    ]); ?>
               
</div>     
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <b><p class="text-green"><?='             '.yii::t('sta.labels','Asistencias depuradas')?></p></b>
      <?php 
      $cuantos=frontend\modules\sta\models\StaResumenasistencias::find()
              ->select(['count(codalu) as nalufac','codfac'])->andWhere(['>','c_21',0])
             ->groupBy(['codfac'])->orderBy('codfac')->asArray()->all();
      $cuan=array_combine(array_column($cuantos,'codfac'),array_column($cuantos,'nalufac'));
      
       $datos=frontend\modules\sta\models\StaResumenasistencias::find()
              ->select(['count(c_21) as nalumnos','c_21','codfac'])->andWhere(['>','c_21',0])->
             groupBy(['c_21','codfac'])->orderBy([
    'codfac' => SORT_ASC,
    'c_21' => SORT_ASC,
])->asArray()->all();
      
      echo  GridView::widget([
        'dataProvider' => New \yii\data\ArrayDataProvider([
        'allModels'=> $datos
            
            ]),
         //'summary' => '',
         'tableOptions'=>['class'=>'table no-margin'],
         'summary'=>'',
        //'filterModel' => $searchModel,
        'columns' => [
            
            ['attribute'=>'# Asistencias',
                'value'=>function($model) {
                                 return $model['c_21'];
                                 }
                ],
             ['attribute'=>'Alumnos',
                'value'=>function($model) {
                                 return $model['nalumnos'];
                                 }
                ],
           
            ['attribute'=>'Porcentaje',
                'value'=>function($model) use ($cuan){
                                if($cuan[$model['codfac']]==0) return 0;
                                return round($model['nalumnos']*100/$cuan[$model['codfac']],2).' %';
                                 }
                ], 'codfac',
                    ],
    ]); ?>       
</div>   
    </div>
</div>
    </div>
  
   