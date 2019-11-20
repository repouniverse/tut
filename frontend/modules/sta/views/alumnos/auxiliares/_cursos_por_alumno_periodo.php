<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
?>

<div class="label label-success"><?=$codperiodo?></div>
    <?php Pjax::begin(); ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => $searchModel,
        'columns' => [
            'codcar',
            //'codfac',
            'codcur',
            'curso.nomcur',
           // 'materia.nomcur',
            'nveces'
        ],
    ]); ?>
    <?php Pjax::end(); ?> 
