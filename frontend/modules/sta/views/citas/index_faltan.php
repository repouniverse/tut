<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use frontend\modules\sta\models\Citas;
//use yii\grid\GridView;
use yii\widgets\Pjax;
    use kartik\export\ExportMenu;
    use common\widgets\spinnerWidget\spinnerWidget;
    ECHO spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\sta\models\CitasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('sta.labels', 'Citas con Pruebas inconclusas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="citas-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
  
    <?php  
     Pjax::begin(['id'=>'listado_citas']); 
    echo $this->render('_search_faltan', ['model' => $searchModel]); ?>
         <hr/>
    
    <?php
    $gridColumns=[
            
         
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
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
               'attribute' => 'codalu',
                    'group'=>TRUE,
                    ],  
                   [
               'attribute' => 'ap',
                    'group'=>TRUE,
                    ], 
                     [
               'attribute' => 'am',
                    'group'=>TRUE,
                    ], 
                    [  'attribute' => 'nombres',
                    'group'=>TRUE,
                    ],
       
           [  'attribute' => 'correo',
                    'group'=>TRUE,
                    ],
             [  'attribute' => 'celulares',
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
    
    <?=Html::beginForm(['controller/bulk'],'post');?>
    <?= GridView::widget([
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
              $('.progress').html( html );
             // alert($('.progress').html());
            // alert($('.progress-bar-danger').attr('aria-valuenow'));
             var porcentaje=$('.progress-bar-danger').attr('aria-valuenow');
             if(porcentaje >= 100){
             $('#btn-conf-examen').removeAttr('disabled');
               
             }

                        }
                   
                       
                        });




        })";
       
  // echo  \yii\helpers\Html::script($stringJs);
   $this->registerJs($cadenaJs);
   // $this->getView()->registerJs($stringJs2);
         

?>     