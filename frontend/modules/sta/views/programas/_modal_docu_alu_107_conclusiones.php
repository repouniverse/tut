  
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?PHP
     //echo $form->field($model, 'indi_altos')->textarea();
     echo $form->field($model, 'indi_altos')->widget(\dosamigos\ckeditor\CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
        ]);
      ?>
  </div>   
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?PHP
    //echo $form->field($model, 'adecuado_nivel')->textarea();
    echo $form->field($model, 'adecuado_nivel')->widget(\dosamigos\ckeditor\CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
        ]);
      ?>
  </div>  
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?PHP
     //echo $form->field($model, 'indi_riesgo')->textarea();
     echo $form->field($model, 'indi_riesgo')->widget(\dosamigos\ckeditor\CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
        ]);
      ?>
  </div> 




   
