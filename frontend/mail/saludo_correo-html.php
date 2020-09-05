<?php
use yii\helpers\Html;
?>
<div class="password-reset">
    <img src="<?= $message->embed($img); ?>">
    
    <p>Buenas tardes <?= Html::encode($destinatario) ?>,</p>
    <p>
      La presente es para saludarle y mostrarle este correo automático
      enviado desde el sistema.
      <br>
      La imagen incrustada de arriba puede cambiarse por otra a eleccion de los 
      usuarios.
      <br>
    </p>
    <p>
     Quisiera, saber si las firmas de correo que aparecen líneas abajo
     van a quedar así o deben ser removidas.
       </p>
       <br>
       Saludos cordiales
    </p>
     
    
</div>
