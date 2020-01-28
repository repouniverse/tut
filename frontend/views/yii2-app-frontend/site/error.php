<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="box box-body">
<section class="content">

    <div class="error-page">
        <h2 class="headline text-info"><i class="fa fa-warning text-yellow"></i></h2>

        <div class="error-content">
            <h4><?php ?></h4>

            <p>
            <h4><?= nl2br(Html::encode($message)) ?></h4>
           
            <?php if($exception->statusCode=='403'){
                ?>
            <p>
                No tiene permitido acceder a esta dirección; consulte con el administrador
                de la aplicación, o solicite los privilegios que correpsondan. Puedes  <a href='<?= Yii::$app->homeUrl ?>'>Volver al inicio</a> 
            </p>
            <?php  } elseif($exception->statusCode=='404'){
               ?>
            <p>
               La dirección a la que intenta acceder no existe o no tiene los parámetros correctos,
                Revise el enlace original o los parámetros de la Url . Puedes  <a href='<?= Yii::$app->homeUrl ?>'>Volver al inicio</a> 
            </p>
            <?php } elseif($exception->statusCode=='500'){?>
            <p>
               Ha ocurrido un error interno en el servidor, un correo con la informaación
               a sido enciado al administrador. Puedes  <a href='<?= Yii::$app->homeUrl ?>'>Volver al inicio</a> 
            </p>
            <?php 
          
            }else{
              ?>
            <p>
               Ha ocurrido un error Desconocido  <a href='<?= Yii::$app->homeUrl ?>'>Volver al inicio</a> 
            </p>
            <?php   
            }
 ?>

            

            
        </div>
    </div>
    <br>
    <br><br>
    <br>
    <br>
    <br>
    <br>
    <br><br>
    <br>
    <br>
    <br>
</section>
</div>