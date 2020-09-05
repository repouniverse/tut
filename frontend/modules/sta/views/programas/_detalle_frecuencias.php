 <?php
 use yii\helpers\Url;
 use yii\helpers\Html;
$url= Url::to(['convoca-alumno','id'=>$model->id,'gridName'=>'convocatorias_'.$model->id,'idModal'=>'buscarvalor']);
echo  Html::a('<span class="btn btn-success btn-sm fa fa-phone"></span>', $url, ['class'=>'botonAbre']);  
?>