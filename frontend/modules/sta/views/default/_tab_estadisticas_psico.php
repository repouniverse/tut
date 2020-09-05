<?php
use kartik\export\ExportMenu;
use yii\web\JsExpression;
use yii\helpers\Html;
use yii\helpers\Json;

use yii\helpers\Url;

use common\helpers\h;
use yii\grid\GridView;

use yii\widgets\Pjax;



/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="box box-body">   
              

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?php 
      
      $columns=[
                  [
             'attribute'=>'codalu',
             'format'=>'raw',
              'value'=>function($model){
          // var_dump($model->codalu);die();
                $url=Url::to(['/sta/programas/trata-alumno','id'=>$model->talleresdet_id]);
                $options=['data-pjax'=>'0','target'=>'_blank'];
                 return Html::a(substr($model->codalu,0,15),$url,$options);
              }
                
                ],
                  'ap',
            'nombres',
            
        ];
               
      ?>
        <?php  Pjax::begin(['id'=>'sumilla','timeout'=>false]);  ?>
         <?php echo ExportMenu::widget([
    'dataProvider' => $providerAlu,
              'filename'=>'Pacientes',
    'columns' => $columns,
    'dropdownOptions' => [
        'label' => yii::t('sta.labels','Exportar'),
        'class' => 'btn btn-success'
    ]
]) . "<hr>\n". GridView::widget([
        'dataProvider' => $providerAlu,
         'filterModel' => $searchAlumnos,
       // 'summary' => '',
         'tableOptions'=>[
             'class'=>'table table-nomargin'
             ],
             'columns' => $columns,
    ]); ?>
     <?php  Pjax::end();  ?>
    </div> 
<?PHP


?>    
</div> 
  
