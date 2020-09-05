<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\sta\models\AulasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('sta.labels', 'Antes de iniciar seleccionar Psicólogo');

?>
<div class="box box-body">

<div class="aulas-index">
    <div class="alert alert-warning"><?=yii::t('sta.labels','Se ha detectado más de un psicólogo para el día de hoy, seleccione con cuál de ellos va a trabajar')?></div>
   
 
   
    <div style='overflow:auto;'>
   
        <?php

$gridColumns = [

[
    
    'attribute' => 'codigotra',    
   
],
[
    
    'attribute' => 'nombres',   
    'format'=>'raw',
    'value'=>function($model){
     return Html::a($model->fullName(),Url::to(['sesion-select-psicologo','codtra'=>$model->codigotra]));
    }
   
],


];

    
  echo GridView::widget([
    'id' => 'kv-grid-demo',
    'dataProvider' => $dataProvider,
      'summary'=>'',
   
    'columns' => $gridColumns, // check the configuration for grid columns by clicking button above
    
]);  

?>
        
 </div>       
</div>
  
</div>
