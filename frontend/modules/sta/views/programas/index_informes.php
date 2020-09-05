<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
//use frontend\modules\sta\models\Citas;
//use yii\grid\GridView;
use yii\widgets\Pjax;
    use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\sta\models\CitasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
  use common\widgets\spinnerWidget\spinnerWidget;

    ECHO spinnerWidget::widget();
$this->title = Yii::t('sta.labels', 'Informes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="citas-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
    <?php Pjax::begin(['id'=>'listado_resultados','timeout'=>false]); ?>
    <?php  echo $this->render('_search_informes', ['model' => $searchModel]); ?>
         <hr/>
    
    <?php
    $gridColumns=[
         [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{grafico}',
               'buttons' => [                 
                        'grafico' => function ($url,$model) {
			   $url = \yii\helpers\Url::to(['/sta/citas/data-to-graph','id'=>$model->id]);
                              
                              return \yii\helpers\Html::a('<span class="btn fa fa-cogs"></span>','javascript:void();', ['id'=>$model->id,'title'=>$url,'family'=>'pinke']);
                              
                             }
                    ]
                ],
         [
                    'class' => 'yii\grid\CheckboxColumn',
                     'checkboxOptions' => function($model) {
                    return ['value' => $model->id];
                     }
                ],
          [
               'attribute' => 'codalu',
                    'format'=>'raw',
                    'value' => function ($model) {
                        $url=Url::to(['trata-alumno','id'=>$model->idtalleresdet]);
                        return Html::a($model->codalu, $url,['target'=>'_blank','data-pjax'=>'0']);
                        //return ($model->impreso)?'<span style="color:#60a917;font-weight:600;">SI</span>':'NO';
                    // return Html::checkbox('impreso[]', $model->impreso, [ 'disabled' => true]);

                       },
              
                    ],  
            [
               'attribute' => 'ultimamod',
                   
                    ],  
                   [
               'attribute' => 'aptutor',
                    'group'=>TRUE,
                    ], 
                     [
               'attribute' => 'codocu',
                
                    ],
                     
                    [
    'attribute' => 'impreso',
    'header'=>'pdf',
    'format' => 'raw',
    'value' => function ($model) {
                        return ($model->impreso)?'<span style="color:#60a917;font-weight:600;">SI</span>':'NO';
        return Html::checkbox('impreso[]', $model->impreso, [ 'disabled' => true]);

             },

          ],
                    
                     [
               'attribute' => 'desdocu',
                 'group'=>TRUE,
                  'value'=>function($model){
                    return substr($model->desdocu,0,10);
                     }
                    
                    ],      
                   [  'attribute' => 'ap',
                    'group'=>TRUE,
                    ],       
                  [  'attribute' => 'nombres',
                    'group'=>TRUE,
                    ],        
                        
         [ 'attribute' => 'numerocita',
             'group'=>TRUE,
             ],
                    
               [
               'attribute' => 'codfac',
                    'group'=>TRUE,
                    ],  
                   [
               'attribute' => 'codperiodo',
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
   //echo  Html::submitButton('<span class="fa fa-briefcase"></span>   '.Yii::t('sta.labels', ''), ['class' => 'btn btn-success']);
 echo \common\widgets\handbagwidget\handBagWidget::widget([
       'idForm'=>'miform', 'idGrilla'=>'mi_maletin','preserve'=>true
              ]);
 
    echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
     'filename'=>'Informes',
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
   <?php $url=Url::to(['zipear-informes']); ?>
   <?=Html::a('<span class="fa fa-file-archive" ></span>'.'  '.yii::t('sta.labels','Descargar Maletín'),$url,['data-pjax'=>'0','class'=>"btn btn-danger"])?>
 <hr>
    
    
    <div style='overflow:auto;'>
   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
         //'summary' => '',
         'tableOptions'=>['class'=>'table'],
        //'filterModel' => $searchModel,
        'columns' => $gridColumns,
    ]); ?>
        
        <div class="btn-group">
            
        </div>   
    <?= Html::endForm();?> 
    <?PHP 
     $this->registerJs("$(\"div[id='listado_resultados'] [family='pinke']\").on( 'click', function() { 
        var resulta;
   var identi=this.id;
  
 var promesa1= $.ajax({
          url : this.title,
          type : 'GET', 
          data : {}, 
          dataType: 'json', 
          success : function(json) {
                            resulta1=json['success'];
                                                  
                     }, //fin funcion success ajax 1
                    error : function(xhr,errmsg,err) {
                     console.log(xhr.status + ': ' + xhr.responseText);
                            } //fin de funcion  error ajax 1
        });//fin de ajax 1
  
 var promesa2=promesa1.then(function(){    
         $.ajax({
      url : 'http://export.highcharts.com/',
      type : 'POST', 
     data : resulta1, 
     success : function(data) {
      resulta2=data; 
               },
             error : function(xhr,errmsg,err) {
             console.log(xhr.status + ': ' + xhr.responseText);                                                                                }
           }); 
       });
       
    promesa2.then(function(){
 $.ajax({
            url : '".\yii\helpers\Url::to(['citas/report-inf-psicologico','id'=>0])."',
            type : 'GET',
            data :  {urlimagen: resulta2,identidad:identi},
            success: function(data2){
            $.pjax.reload({container: '#listado_resultados',timeout:false});
                 console.log(data2); // Debería imprimir {ajax2: true}
                        },
               error : function(xhr,errmsg,err) {
                         console.log(xhr.status + ': ' + xhr.responseText);
                      }
                 });
    });
    
});

", \yii\web\View::POS_READY);
    ?>     
        
        
        
    <?php Pjax::end(); ?>
</div>
    </div>
</div>
    </div>
  
  <?php /* $this->registerJs("jQuery(document).ready(function($) {
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
    });",\yii\web\View::POS_END); */ 
  ?>     