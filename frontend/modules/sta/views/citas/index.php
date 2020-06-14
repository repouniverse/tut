<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use frontend\modules\sta\models\Citas;
//use yii\grid\GridView;
use yii\widgets\Pjax;
    use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\sta\models\CitasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
  use common\widgets\spinnerWidget\spinnerWidget;
    ECHO spinnerWidget::widget();
$this->title = Yii::t('sta.labels', 'Citas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="citas-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
    <?php Pjax::begin(['id'=>'listado_citas','timeout'=>false]); ?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
         <hr/>
    
    <?php
    $gridColumns=[
            
         
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{view}',
                'buttons' => [
                    'update' => function($url, $model) {
                     if(strtotime($model->swichtDate('fechaprog',false))==0){
                         return '';   
                     }else{
                          $url= \yii\helpers\Url::toRoute(['update','id'=>$model->id]);
                        $options = [
                            'data-pjax'=>'0',
                            'target'=>'_blank',
                            'title' => Yii::t('base.verbs', 'Editar'),                            
                        ];
                        return Html::a('<span class="btn btn-danger btn-sm glyphicon glyphicon-pencil"></span>', $url, $options/*$options*/);
                      
                        
                     }
                        },
                          'view' => function($url, $model) {  
                             $url= \yii\helpers\Url::toRoute(['view','id'=>$model->id]);
                       if(strtotime($model->swichtDate('fechaprog',false))==0){
                                 return ''; 
                        }else{
                              $options = [
                            'data-pjax'=>'0',
                            'target'=>'_blank',
                            'title' => Yii::t('base.verbs', 'Ver'),                            
                        ];
                        return Html::a('<span class="btn btn-warning btn-sm glyphicon glyphicon-search"></span>', $url, $options/*$options*/);
                      
                        
                              
                         }
                        },
                         
                    ]
                ],
                [
                    'class' => 'yii\grid\CheckboxColumn',
                     'checkboxOptions' => function($model) {
                    return ['value' => $model->id];
                     }
                ],
         [ 'attribute' => 'numerocita',
             'format'=>'raw',
             'value'=>function($model){
                 return '<span style="font-size:14px; color:#ad5eb7; font-weight:700;">'.$model->numerocita.'</span>';           
             }
             ],
                      [
               'attribute' => 'fechaprog',
                 'value'=>function($model){
                 return SUBSTR($model->fechaprog,0,16);           
                         }
                    ], 
               [
               'attribute' => 'codfac',
                    'group'=>TRUE,
                    ],  
                   [
               'attribute' => 'codperiodo',
                    'group'=>TRUE,
                    ],       
                
                                [
    'attribute' => 'asistio',
    'format' => 'raw',
    'value' => function ($model) {
       if($model->asistio){
           return '<i style="color:#5bb75b;"><span class="fa fa-check-square">1</span></i>';
       }else{
          return '';//<i style="color:#ff7b7b;"><span class="fa fa-times-circle">0</span></i>'; 
       }
             },

          ],     
         
                [
               'attribute' => 'codalu',
                    'group'=>TRUE,
                    ],  
                   [
               'attribute' => 'ap',
                    'group'=>TRUE,
                    ], 
                    
         [  'attribute' => 'aptutor',
                    'group'=>TRUE,
                    ],
          [  'attribute' => 'proceso',
                    'group'=>TRUE,
                    ],
           /* 'id',
            'talleres_id',
            'talleresdet_id',*/
           
            
            //'codperiodo',
                       
            //'finicio',
            //'ftermino',
            //'fingreso',
            //'detalles:ntext',
            //'codaula',
            //'duracion',

          
        ];
             
   echo Html::beginForm(['/finder/addmaletin'],'post',['id'=>'miform']);
   echo  Html::submitButton('<span class="fa fa-briefcase"></span>   '.Yii::t('sta.labels', ''), ['class' => 'btn btn-success']);
  
    echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
     'filename'=>'Citas',
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
   
      <?= GridView::widget([
        'id'=>'mygrilla',
        'dataProvider' => $dataProvider,
         //'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => $searchModel,
        'columns' => $gridColumns,
    ]); ?>
        
        <div class="btn-group">
            
        </div>   
    <?= Html::endForm();?> 
    <?php Pjax::end(); ?>
</div>
    </div>
</div>
    </div>
  <?PHP
$divPjax='listado_citas';
$clase=str_replace('\\','_',Citas::className());
$family='holas';
$url=Url::to(['/finder/addmaletin']);
$cadenaJs="
 $('div[id=\"".$divPjax."\"] [type=checkbox]').on( 'click', function() { 
     identidad=this.value;
     var keys = $('#mygrilla').yiiGridView('getSelectedRows');
     alert(keys);
//alert(this.checked);
//var mycadena = this.name;
//var myarr = mycadena.split('_');
//var myidentidad=myarr[2];
 $.ajax({
              url: '".$url."',
              type: 'post',
              data:{identidad:identidad,checked:this.checked,clase:'".$clase."'} ,
              dataType: 'html',
               error:  function(xhr, textStatus, error){               
                            var n = Noty('id');                      
                              $.noty.setText(n.options.id, error);
                              $.noty.setType(n.options.id, 'error');       
                                }, 
              
               success: function(html) {
              
                        }
                   
                       
                        });




        })";
       
  // echo  \yii\helpers\Html::script($stringJs);
   //$this->registerJs($cadenaJs);
   // $this->getView()->registerJs($stringJs2);
         

?>
<?php $this->registerJs("jQuery(document).ready(function($) {
       $('#miform').submit(function(event) {
            event.preventDefault(); // stopping submitting
            var data = $(this).serializeArray();
            var url = $(this).attr('action');
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: data,
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

                             if ( !(typeof json['warning']==='undefined' )) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['warning']);
                              $.noty.setType(n.options.id, 'warning');  
                             } 
                          if ( !(typeof json['success']==='undefined' )) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['success']);
                              $.noty.setType(n.options.id, 'success');  
                             }      
                   
                        }
                       
            });
            
        
        });
    });",\yii\web\View::POS_END);  
  ?>     