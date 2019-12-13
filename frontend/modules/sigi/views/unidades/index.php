<?php
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\sigi\models\SigiUnidadesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('sigi.labels', 'Unidades');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sigi-unidades-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
    <?php Pjax::begin(); ?>
        
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        
    <p>
        <?= Html::a('<span class="fa fa-couch"></span>'.'    '.Yii::t('sigi.labels', 'Crear unidad'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div style='overflow:auto;'>
    <?php echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'dropdownOptions' => [
        'label' => yii::t('sta.labels','Exportar'),
        'class' => 'btn btn-success'
    ]
]) . "<hr>\n".GridView::widget([
        'dataProvider' => $dataProvider,
        // 'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'filterModel' => $searchModel,
        'columns' => [
            
         
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                
          ],
          [
                'attribute'=>'edificio',
                'filter'=>frontend\modules\sigi\helpers\comboHelper::getCboEdificios(),
                'value' => function($model) { 
                        //var_dump($model);die();
                        return $model->edificio->nombre ;
                         },
                 'group'=>true,   
            ],
           ['attribute'=>'tipo',
                                 'value'=>'tipo.desunidad',
                                 //'filter'=>comboHelper::getCboEdificios(),
             'group'=>true,
                            
              ],
         [
             'attribute'=>'numero',
             'format'=>'raw',
             'value'=>function($model){
                   
                      return   '<i style="color:#ff2211;font-size:14px">    '.$model->numero.'</i>' ;
                
             
                       
             }
         ],
         [
             'attribute'=>'parent_id',
             'format'=>'raw',
            
             'value'=>function($model){
                   if($model->parent_id>0){
                      return   '<i style="color:#08882f;font-size:14px">    '.$model->padre->numero.'     <span class="fa fa-child"></span></i>' ;
                    
                   }
                    return '';
                
                 
             },
                
         ],
         
         

           
           
            [
                'attribute'=>'participacion',
                'value' => function($model) { 
                        //var_dump($model);die();
                         $participacion=$model->participacion(true);
                        if(empty($participacion) or $participacion==0)
                         return '--';
                        return round($model->participacion(true),2).'  %';
                         },
            ],
            
            'nombre',
              
             
            ]
            //'participacion',
            //'parent_id',
            //'detalles:ntext',
            //'estreno',

          
        
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
</div>
    </div>
       