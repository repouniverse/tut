  <div class="col-xs-12 col-md-8">
      <?=$form->field($useredificio,"[$i]id")->
 hiddenInput()->label(false) ?>
      
<?=$form->field($useredificio,"[$i]activa")->
 checkBox(['label'=> \yii\helpers\StringHelper::mb_ucwords(
         strtolower($useredificio->edificio->nombre))]
         ) ?>
 
</div>
