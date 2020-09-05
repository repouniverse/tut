
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?PHP
     //echo $form->field($model, 'cuenta_buen')->textarea();
      ?>
       
       <?php /* echo $form->field($model, 'cuenta_buen')->widget(\rikcage\sceditor\SCEditor::className(), [
        'options' => ['rows' => 10],
        'clientOptions' => [
            'toolbar'=>'bold,italic,underline,left,center,right,justify,font,size,color|cut,copy,paste,table,image,link,unlinkemail,youtube,print,maximize',
            'plugins' => 'bbcode',
            'locale'=>'es'
        ]
    ]);*/
       /*echo $form->field($model, 'indi_altos')->widget(\franciscomaya\sceditor\SCEditor::className(), [
        'options' => ['rows' => 12],
        'clientOptions' => [
            'toolbar'=>'bold,italic,underline,left,center,right,justify,font,size,color|cut,copy,paste|table,image,link,unlink|email,youtube,date,time|print,maximize',
            'plugins' => 'bbcode',
            'locale'=>'es'
        ]
    ]) */
      echo $form->field($model, 'cuenta_buen')->widget(\dosamigos\ckeditor\CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
        ]);
       ?> 
  </div>   
    
     
  
    
     
     
     

   

   

   

   
