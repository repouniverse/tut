<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="titulo">INFORME EVALUACIÓN PSICOLÓGICA (EVP)</div>
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
<BR>
<div class="afiliacion  parrafo-plantilla">
<table>
    <?php foreach($resultados as $resultado) {  ?>
    <tr>
        <td width='70%'><?=$resultado->indicador->nombre?></td>
        <td>Nivel: </td>
        <td><?=$resultado->categoria?></td>
    </tr>
    <tr>
        <td><?=$resultado->interpretacion?></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td width='80%'>.</td>
        <td>.</td>
        <td>.</td>
    </tr>
    <?php } ?>
</table>
</diV>

<div class="subtitulo">III CONCLUSIONES</div>
<div class="afiliacion parrafo-plantilla">
   <?=$model->getAttributeLabel('cuenta_buen') ?>
    
</div>
<div class="afiliacion italica ">
   
    <?=$model->cuenta_buen ?>  
</div>
<div class="subtitulo">IV SUGERENCIAS</div>
<div class="afiliacion  parrafo-plantilla">
   <?=$model->getAttributeLabel('sugerencias') ?>
</div>
<div class="afiliacion italica ">
   <?=$model->sugerencias ?>  
</div> 

<div class="subtitulo">Atentamente:  TUTORÍA PSICÓLOGICA <?=$model->facultad->desfac ?></div>

