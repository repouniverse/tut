<?php
use yii\helpers\Html;
use yii\helpers\Url;

//$query= frontend\modules\sta\models\StaResultados::find()->where(['examen_id'=>$examenesId]);

   if($rutaimagen==''){
   echo Html::img(Url::base().'/img/logo_cabecera.png');
   }
?>
<br>
<div class="titulo">INFORME DEL PERFIL PSICOLÓGICO (IPP)</div>
<div class="subtitulo">I DATOS GENERALES</div>
<div class="afiliacion">
<table >
    <TR >
        <TD width="90%" >
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
        <TD width="5%">
          
        </TD>
    </TR>
    
</table>
</div>

<br>
<div class="subtitulo">II INDICADORES PSICOLÓGICOS HALLADOS</div>


<div class="afiliacion">
 <?php
   /*$expresion=new yii\db\Expression("100-percentil as complemento");  
    $datos=$query->select(['puntaje_total','percentil',$expresion,'categoria','b.nombre','b.nemonico','b.invertido'])->join('INNER JOIN','{{%sta_testindicadores}} b','indicador_id=b.id')->orderBy('b.ordenabs ASC')->asArray()->all();
   $indicadores= array_column($datos, 'nombre');
    $categorias= array_column($datos, 'categoria');
   $inversiones= array_column($datos, 'invertido');
    $percentiles= array_column($datos, 'percentil');
   $complemento= array_column($datos, 'complemento');
   $alabels=[];
   foreach($indicadores as $key=>$valor){
       $alabels[]=$valor.'-('.$categorias[$key].')';
       
       if($inversiones[$key]=='1'){
         $temppercentil=$percentiles[$key];
          $percentiles[$key]= $complemento[$key]; 
           $complemento[$key]= $temppercentil; 
       }
   }
    $percentiles=array_map('intval', $percentiles);
    $complemento= array_map('intval', $complemento);*/


 ?>
<diV id='migrafico' style="display:none;">
 <?php
 if($rutaimagen==''){     
   echo $this->render('makeGraficos',['model'=>$model]);
 ?>
 <?php
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
   <?php  ?>
    <div id='miimagen' style="width: 700px;" >
       <?PHP 
       IF(strlen($rutaimagen)>0){
           echo Html::img($rutaimagen);
       } 
       ?>
    </div>
     
</diV>

<div class="subtitulo">III CONCLUSIONES DEL PERFIL PSICOLÓGICO</div>
<div class="afiliacion">
   <?php /*$model->getAttributeLabel('conclu_acad')*/ ?>
</div>
<div class="afiliacion italica">
   <?=$model->conclu_acad ?>  
</div>

<div class="subtitulo">IV METAS DE TUTORÍA PISCOLÓGICA</div>
<div class="afiliacion">
   <?=$model->getAttributeLabel('metas_acad') ?>
</div>
<div class="afiliacion italica">
   <?=$model->metas_acad ?>  
</div>

<div class="subtitulo">V RECOMENDACIONES PARA EL TUTOR ACADÉMICO</div>
<div class="afiliacion">
   <?php /*echo $model->getAttributeLabel('recom_tutor_acad')*/ ?>
</div>
<div class="afiliacion italica">
   <?=$model->recom_tutor_acad ?>  
</div>

<div class="subtitulo"></div>
<div class="afiliacion">
    <br>
</div>
<div class="subtitulo">Atentamente:  TUTORÍA PSICÓLOGICA <?=$model->facultad->desfac ?></div>

<br>
<br>