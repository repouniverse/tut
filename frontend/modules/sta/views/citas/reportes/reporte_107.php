<?php
use yii\helpers\Html;
use yii\helpers\Url;
//use miloschuman\highcharts\Highcharts;
//use miloschuman\highcharts\HighchartsAsset;
  // $query= frontend\modules\sta\models\StaResultados::find()->where(['examen_id'=>$examenesId]);
if($rutaimagen==''){
   echo Html::img(Url::base().'/img/logo_cabecera.png');
   }
?>
<div class="titulo">PLAN DE TUTORÍA PSICOLÓGICA INDIVIDUALIZADA (PTI)</div>
<div class="subtitulo">I DATOS GENERALES</div>
<div class="afiliacion">
<table >
    <TR >
        <TD width="100%" >
            <div >
                <table >
                 <TR style="border-top:solid;border-bottom:solid;border-color:#CCC; border-width: 1px;">
                    <TD style="padding: 7px;">Nombres y apellidos : </TD>
                    <TD style="padding: 7px;"><?=$alumno->fullName()?></TD>
                </TR>
                
                <TR style="border-bottom:solid;border-color:#CCC; border-width: 1px;">
                    <TD style="padding: 7px;">Código :</TD>
                    <TD style="padding: 7px;"><?=$alumno->codalu?></TD>
                </TR>
                 <TR style="border-bottom:solid;border-color:#CCC; border-width: 1px;">
                    <TD style="padding: 7px;">Facultad :</TD>
                    <TD style="padding: 7px;"><?=$alumno->facultad->desfac?></TD>
                </TR>
                  <TR style="border-bottom:solid;border-color:#CCC; border-width: 1px;">
                   <TD style="padding: 7px;">Especialidad :</TD>
                    <TD style="padding: 7px;"><?=$alumno->carrera->descar?></TD> 
                </TR>
                 <TR style="border-bottom:solid;border-color:#CCC; border-width: 1px;">
                   <TD style="padding: 7px;">Psicólogo Responsable :</TD>
                    <TD style="padding: 7px;"><?=$model->talleresdet->trabajador->fullName()?></TD> 
                </TR>
            </TABLE>
            </DIV>
        </TD>
        <TD width="10%">
          
        </TD>
    </TR>
    
</table>
</div>

<div class="subtitulo">II INDICADORES PSICOLÓGICOS HALLADOS</div>

<div class="afiliacion">
 <?php
  
 ?>
<diV id='migrafico' style="display:none;">
 <?php
  //HighchartsAsset::register($this)->withScripts(['/modules/exporting','/modules/offline-exporting','/modules/export-data']);
if($rutaimagen==''){
    echo $this->render('makeGraficos',['model'=>$model]);
    
  $string2="var chart = $('#grafiquito').highcharts();
   
var opts = chart.options;        // retrieving current options of the chart
opts = $.extend(true, {}, opts); // making a copy of the options for further modification
delete opts.chart.renderTo;      // removing the possible circular reference

/* Here we can modify the options to make the printed chart appear */
/* different from the screen one                                   */

var strOpts = JSON.stringify(opts);
//alert(strOpts);
$.post(
    'http://export.highcharts.com/',
    {
        content: 'options',
        options: strOpts ,
         type:    'image/svg+xml',
        width:   '1000px',
        scale:   '1',
        constr:  'Chart',
        async:   true
    },
    function(data){
        var imgUrl = 'http://export.highcharts.com/' + data;
        $('#miimagen').html('<img src=' +imgUrl+ '>');
        /* Here you can send the image url to your server  */
        /* to make a PDF of it.                            */
        /* The url should be valid for at least 30 seconds */
    }
);";

$this->registerJs($string2, \yii\web\View::POS_READY);  
}
    ?>
  </diV> 
    <div id='miimagen' style="width: 600px;" >
       <?PHP 
       IF(strlen($rutaimagen)>0){
           echo Html::img($rutaimagen);
       } 
       ?>
    </div>
</diV>


<div class="subtitulo">III CONCLUSIONES</div>
<div class="afiliacion">
   <?=$model->getAttributeLabel('indi_altos') ?>
</div>
<div class="afiliacion italica">
   <?=$model->indi_altos ?>  
</div>
<div class="afiliacion">
   <?php echo $model->getAttributeLabel('adecuado_nivel'); ?>
</div>
<div class="afiliacion italica">
   <?=$model->adecuado_nivel?>  
</div>
<div class="afiliacion">
   <?=$model->getAttributeLabel('indi_riesgo') ?>
</div>
<div class="afiliacion italica">
   <?=$model->indi_riesgo ?>  
</div>
<div class="subtitulo">IV METAS DE TUTORÍA</div>
<div class="afiliacion">
   <?=$model->getAttributeLabel('metas_aux') ?>
</div>
<div class="afiliacion italica">
   <?=$model->metas_aux?>  
</div>

<div class="subtitulo">Atentamente:  TUTORÍA PSICÓLOGICA <?=$model->facultad->desfac ?></div>


<br>
<br>