 
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?PHP
    
      //echo $form->field($model, 'recom_tutor_acad')->textarea();
      echo $form->field($model, 'recom_tutor_acad')->widget(\dosamigos\ckeditor\CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
        ]);
      ?>
  </div>
 
  
    
     
     
     

   

   

   

   