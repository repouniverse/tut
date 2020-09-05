<?php
    use kartik\export\ExportMenu;
    use frontend\modules\sta\models\VwStaResultadosSearch;
      use frontend\modules\sta\models\VwStaExamenesSearch;
    use frontend\modules\sta\staModule;
    use common\helpers\h;
    ?> 
<div class="box box-body">
    <h4><?=yii::t('sta.labels','Listado de Alumnos en Riesgo')?></h4>
    <div class="alert alert-light bg-warning">
 Provee un listado general de los alumnos en riesgo acádemico,
 limitado según los accesos a cada facultad.
</div>
<?php
ini_set("pcre.backtrack_limit", "5000000");
 $dataProvider = (New \frontend\modules\sta\models\VwAluriesgoSearch)->search(Yii::$app->request->queryParams);

     $gridColumns = [
    'codalu',     
    'ap',
    'am',
    'nombres',
    'celulares',
    'correo',     
    'codfac',
    'codperiodo',
    'correo',
    'desfac',
    'descar',
    'codcur',
    'status'
    ];
     
     echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
     'filename'=>yii::t('sta.labels','Resultados'),
     'exportConfig'=>[
          ExportMenu::FORMAT_PDF => false,
         ExportMenu::FORMAT_EXCEL=>[
             'filename'=>'Exportacion'
               ],
         ExportMenu::FORMAT_EXCEL_X=>[
             'filename'=>'Exportacion'
               ]
         ],
     'batchSize'=>100,
    'columns' => $gridColumns,
    'dropdownOptions' => [
        'label' => yii::t('sta.labels','Exportar'),
        'class' => 'btn btn-success'
    ]
]);

?>
    <br><br><br><br>
<?php if(staModule::levelAccess()==staModule::LEVEL_ACCESS_PROFILE_ALTO){   ?>
<h4><?=yii::t('sta.labels','Resultados Alumnos Evaluados')?></h4>
<div class="alert alert-light bg-warning">
 Provee un listado de los resultados de alumnos en riesgo acádemico,
 limitado según los accesos a cada facultad y según tu perfil de usuario.
</div>
<?php
 $dataProvider = (New VwStaResultadosSearch())->search(Yii::$app->request->queryParams);

     $gridColumns = [
    'codfac',
    'aptutor',
    'amtutor',
    'nombrestutor',
    'codperiodo',
    'descripcion',
    'status',
    'codalu','ap','am','nombres',
    'codcar','numerocita','fechaprog',
    'codtest','puntaje_total','indicador_id',
    'percentil','categoria','nemonico','nombre'
    ];
     $tipo=h::user()->profile->tipo;
    // var_dump($tipo,[staModule::PROFILE_AUTORIDAD,staModule::PROFILE_PSICOLOGO],in_array($tipo,[staModule::PROFILE_AUTORIDAD,staModule::PROFILE_PSICOLOGO]));die();
    //die();
     if(in_array($tipo,[staModule::PROFILE_AUTORIDAD,staModule::PROFILE_PSICOLOGO])){
        $config=[
         ExportMenu::FORMAT_PDF => false,
         ExportMenu::FORMAT_EXCEL=>[
             'filename'=>'Exportacion'
               ],
         ExportMenu::FORMAT_EXCEL_X=>[
             'filename'=>'Exportacion'
               ]
         ];
    }else{
      $config=[]; 
      $gridColumns=[];
        $dataProvider= (New VwStaResultadosSearch())->searchNada();

    }
   //  var_dump($config);die();
     echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
     'filename'=>yii::t('sta.labels','Resultados'),
     'exportConfig'=>$config,
     'batchSize'=>100,
    'columns' => $gridColumns,
    'dropdownOptions' => [
        'label' => yii::t('sta.labels','Exportar'),
        'class' => 'btn btn-success'
    ]
]);
}
?>
    
    <br><br><br><br>
<?php if(staModule::levelAccess()==staModule::LEVEL_ACCESS_PROFILE_ALTO){   ?>
<h4><?=yii::t('sta.labels','Exámenes tomados')?></h4>
<div class="alert alert-light bg-warning">
 Provee un listado de los exámenes con el detalle de las respuestas  de alumnos en riesgo acádemico,
 limitado según los accesos a cada facultad y según tu perfil de usuario.
</div>
<?php
 $dataProvider = (New VwStaExamenesSearch())->search(Yii::$app->request->queryParams);

     $gridColumns = [
    'codalu',
    'ap',
    'am',
    'nombres',
    'codbateria',
    'codfac',
    'descripcion',
    'codtest',
    'item',
    'pregunta',
    'appsico',
    'codigotra',
         'codperiodo',
    
         'puntaje',
         'valor',
         'grupo'
    ];
     $tipo=h::user()->profile->tipo;
    // var_dump($tipo,[staModule::PROFILE_AUTORIDAD,staModule::PROFILE_PSICOLOGO],in_array($tipo,[staModule::PROFILE_AUTORIDAD,staModule::PROFILE_PSICOLOGO]));die();
    //die();
     if(in_array($tipo,[staModule::PROFILE_AUTORIDAD,staModule::PROFILE_PSICOLOGO])){
        $config=[
         ExportMenu::FORMAT_PDF => false,
         ExportMenu::FORMAT_EXCEL=>[
             'filename'=>'Exportacion'
               ],
         ExportMenu::FORMAT_EXCEL_X=>[
             'filename'=>'Exportacion'
               ]
         ];
    }else{
      $config=[]; 
      $gridColumns=[];
        $dataProvider= (New VwStaResultadosSearch())->searchNada();

    }
   //  var_dump($config);die();
     echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
     'filename'=>yii::t('sta.labels','Resultados'),
     'exportConfig'=>$config,
     'batchSize'=>20,
    'columns' => $gridColumns,
    'dropdownOptions' => [
        'label' => yii::t('sta.labels','Exportar'),
        'class' => 'btn btn-success'
    ]
]);
}
?>

</div>