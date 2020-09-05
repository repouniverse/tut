<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use frontend\modules\sigi\helpers\comboHelper;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\sigi\models\SigiBasePresupuestoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('sigi.labels', 'Partidas');
$this->params['breadcrumbs'][] = $this->title;
?>
 <div  CLASS="alert alert-info">
     <?php $medidor=New frontend\modules\sigi\models\SigiSuministros();
         $medidor->edificio_id=$model->edificio_id;
         ?>
          <?=yii::t('sigi.labels','Consumo total de agua (M3)').' : '.$medidor->consumoTotal($model->mes,$model->ejercicio,true)?>
        
         
         </DIV> 
<div class="sigi-base-presupuesto-index">
    
         
        
     <div class="box-body">
         
         
         
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'dataProvider' => $dataProviderLecturas,
         'summary' => '',
        'pjax' => true,
    'striped' => true,
    'hover' => true,
       'showPageSummary' => true,
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'filterModel' => $searchModelLecturas,
        'columns' => [
          ['attribute'=>'nombre',],
           ['attribute'=>'codsuministro',], 
             //['attribute'=>'numerocliente',],  
['attribute'=>'codum',], 
             ['attribute'=>'numero',], 
            ['attribute'=>'lecturaant',],
             ['attribute'=>'lectura',
                'format'=>'html',
                 'value'=>function($model) {                        
                        
                        $url=Url::to(['/sigi/edificios/lecturas','id'=>$model->suministro_id]);
                        return Html::a($model->lectura, $url,['target'=>'_blank']);
                         },
                 ],
             ['attribute'=>'delta',],
            ['attribute'=>'flectura',],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
</div>

       