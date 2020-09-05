<?php
 use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
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
$this->title = Yii::t('sta.labels', 'Eventos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="citas-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
    <?php Pjax::begin(['id'=>'listado_citas','timeout'=>false]); ?>
    <?php  echo $this->render('_search_eventos', ['model' => $searchModel]); ?>
         <hr/>
    
    <?php
    $gridColumns=[
            
          
         
                [
                    'class' => 'yii\grid\CheckboxColumn',
                     'checkboxOptions' => function($model) {
                    return ['value' => $model->id];
                     }
                ],
         [ 'attribute' => 'numero',
             'format'=>'raw',
             'group'=>TRUE,
             'value'=>function($model){
                    $filtro='StaEventosdetSearch[codalu]='.$model->codalu;
                 return Html::a($model->numero,Url::to(['/sta/eventos/update','id'=>$model->eventos_id,'StaEventosdetSearch[codalu]'=>$model->codalu]));
             }
             ],
         ['attribute'=>'numerocita',
          'format'=>'raw',
          'value'=>function($model){
                      $cade='';
              if(!empty($model->numerocita)) {
                  $regCita=frontend\modules\sta\models\Citas::findOne(['numero'=>$model->numerocita]);
                  if(!is_null($regCita)){
                    if($regCita->hasExamenes()){
                        if($regCita->hasPerformedTest()){
                       $cade= '<i style="color:#60a917;"><span class="fa fa-circle"></span></i>'; 
                     }else{
                        if($regCita->isTokenActive()){
                            $cade='<i style="color:orange;"><span class="fa fa-circle"></span></i>'; 
                       
                        }else{
                            
                           $cade='<i style="color:red;"><span class="fa fa-circle"></span></i>';  
                        }
                       
                     }
                    }else{
                       $cade='' ; 
                    }
                     
                  }
              } else{
                 $cade='' ;
              }     
             return $cade.Html::a($model->numerocita,Url::to(['/sta/eventos/edita-cita','id'=>$model->numerocita]),['target'=>'_blank','data-pjax'=>'0']);               
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
                [ 'attribute' => 'nombres'],
         
                                [
    'attribute' => 'asistio',
    'format' => 'raw',
    'value' => function ($model) {
       if($model->asistio){
           return '<i style="color:#5bb75b;"><span class="fa fa-check"></i>';
       }else{
          return '';//<i style="color:#ff7b7b;"><span class="fa fa-times-circle">0</span></i>'; 
       }
             },

          ],     
         
                [
               'attribute' => 'codalu',
                    'group'=>TRUE,
                    ],  
                   
          [  'attribute' => 'proceso',
                    'group'=>TRUE,
                    ],
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
        
        <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
            'idGrilla'=>'listado_citas',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
       'posicion'=>\yii\web\View::POS_END
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
        
        
        
        
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