<?php
use yii\helpers\Html;
use yii\helpers\Url;
//use kartik\grid\GridView;
use frontend\modules\sta\models\Citas;
use yii\grid\GridView;
use yii\widgets\Pjax;
    use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\sta\models\CitasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
  use common\widgets\spinnerWidget\spinnerWidget;

    ECHO spinnerWidget::widget();
$this->title = Yii::t('sta.labels', 'Examenes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="citas-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
    <?php Pjax::begin(['id'=>'listado_resultados','timeout'=>false]); ?>
    <?php  echo $this->render('_search_examenes', ['model' => $searchModel]); ?>
         <hr/>
    
    <?php
    $gridColumns=[
       [
                    'class' => 'yii\grid\CheckboxColumn',
                     'checkboxOptions' => function($model) {
                    return ['value' => $model->codalu];
                     }
                ],
           
               [
               'attribute' => 'codfac',
                   
                    ], 
                'codbateria',
                'codtest',
                'descripcion',
                'item',
                   [
               'attribute' => 'codalu',
                   
                    ],       
                
                             
         
                [
               'attribute' => 'pregunta',
                   'value'=>function($model){
                    return substr($model->pregunta,0,40);
                   }
                    ],  
                   [
               'attribute' => 'puntaje',
                    
                    ], 
                     [
               'attribute' => 'valor',
                   
                    ], 
                  
        ];
    echo Html::beginForm(['/finder/addmaletin'],'post',['id'=>'miform']);
   //echo  Html::submitButton('<span class="fa fa-briefcase"></span>   '.Yii::t('sta.labels', ''), ['class' => 'btn btn-success']);
 echo \common\widgets\handbagwidget\handBagWidget::widget([
       'idForm'=>'miform', 'idGrilla'=>'mi_maletin'
              ]);
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
        'dataProvider' => $dataProvider,
         //'summary' => '',
         'tableOptions'=>['class'=>'table no-margin'],
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