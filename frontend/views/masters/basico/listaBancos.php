<?php
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SociedadesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('base.names', 'Bancos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sociedades-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(['id'=>'gridBancos']); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('base.actions', 'Crear Banco'), ['crear-banco'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
       // 'id'=>'gridBancos',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           
            'codbanco',
            'nombre',
            
            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{update}{view}{delete}',
                'buttons'=>[
                    'update'=>function($url,$model){
                        $url=\yii\helpers\Url::toRoute(['editar-banco','id'=>$model->id]);
                        return \yii\helpers\Html::a(
                                '<span class="btn btn-success glyphicon glyphicon-pencil"></span>',
                                $url,
                                ['data-pjax'=>'0']
                                );
                     },
                     'view'=>function($url,$model){
                        $url=\yii\helpers\Url::toRoute(['ver-banco','id'=>$model->id]);
                        return \yii\helpers\Html::a(
                                '<span class="btn btn-success glyphicon glyphicon-search"></span>',
                                $url,
                                ['data-pjax'=>'0']
                                );
                     },
                             'delete' => function ($url,$model) {
			    $url = \yii\helpers\Url::to('deletemodel-for-ajax');
                             return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                            }
                   ]
                ],
        ],
    ]); ?>
    <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgridBancos',
            'idGrilla'=>'gridBancos',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
    
    <?php Pjax::end(); ?>
</div>


