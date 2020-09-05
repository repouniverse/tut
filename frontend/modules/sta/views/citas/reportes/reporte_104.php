<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\h;
USE frontend\modules\sta\staModule;
$tipo=h::user()->profile->tipo;

echo Html::img(Url::base().'/img/logo_cabecera.png');

?>
<div class="titulo">REPORTE TUTORÍA PSICOLÓGICA POR SESIÓN</div>
<div class="subtitulo">I DATOS GENERALES</div>
<div class="afiliacion">
<table>
    <TR>
        <TD width="80%">
            <TABLE>
                <TR>
                    <TD>Nombres y apellidos : </TD>
                    <TD><?=$alumno->fullName()?></TD>
                </TR>
                
                <TR>
                    <TD>Código :</TD>
                    <TD><?=$alumno->codalu?></TD>
                </TR>
                <TR>
                    <TD>Facultad :</TD>
                    <TD><?=$alumno->facultad->desfac?></TD>
                </TR>
                <TR>
                   <TD>Especialidad :</TD>
                    <TD><?=$alumno->carrera->descar?></TD> 
                </TR>
               
            </TABLE>
        </TD>
        <TD width="20%">
           </TD>
    </TR>
    
</table>
</div>

 
    <?php foreach($citas as $cita) { 
        
        /*RESLVEINDO LAS VISIVILIDADES DE LOS CAMPOS*/
if(!$cita->isVisibleField('detalles_secre', $tipo)){
  $cita->detalles_secre="<br>Estos datos no están disponibles para su rol de usuario<br>";
}
if(!$cita->isVisibleField('detalles_tareas_pend', $tipo)){
  $cita->detalles_tareas_pend="<br>Estos datos no están disponibles para su rol de usuario<br>";
}        
if(!$cita->isVisibleField('detalles_indicadores', $tipo)){
  $cita->detalles_indicadores="<br>Estos datos no están disponibles para su rol de usuario<br>";
} 
if(!$cita->isVisibleField('detalles', $tipo)){
  $cita->detalles="<br>Estos datos no están disponibles para su rol de usuario<br>";
} 
        
        ?>
    <div class="afiliacion">
        <div class="subtitulo"><?php echo $cita->flujo->proceso   ?></div>
    <table style='width:650px;'>
    <tr class="borderx">
        <td class="gris-claro" width="30%">Número de Sesión</td>
        <td class="gris-claro" width="25%">Fecha</td>
        <td class="gris-claro" width="45%">Responsable</td>
    </tr>
    <tr class="borderx">
        <td class="borderx"><?=$cita->numero?></td>
        <td class="borderx"><?=substr($cita->fechaprog,0,10)?></td>
        <td class="borderx"><?=$cita->psicologo->fullName()?></td>
    </tr>
    <tr class="borderx">
        <td   class="texto-center" colspan="3">Actividades Realizadas</td>
        
    </tr>
    <tr class="borderx">
        <td colspan="3" class="borderx italica"  ><?=!empty($cita->detalles)?$cita->detalles:"<br><br>"?></td>
        
    </tr>
    <tr class="borderx">
        <td colspan="3" class="texto-center"  >Indicador Trabajado</td>
        
    </tr>
    <tr class="borderx">
       <td colspan="3" class="borderx italica">
                <?=(!empty($cita->detalles_indicadores))?$cita->detalles_indicadores:"<br><br>"?>
           <?php foreach($cita->indicadores as $indicador){?>
           <?php  echo "<b>".$indicador->indicador->nombre."</b><br>".$indicador->detalles?>
           <?php } ?>
       </td> 
    </tr>
     <tr class="borderx">
        <td colspan="3" class="texto-center"  >Datos relevantes</td>
        
    </tr>
    <tr class="borderx">
       <td colspan="3" class="borderx italica"><?=$cita->detalles_secre?></td> 
    </tr>
    
    <tr class="borderx">
        <td class="gris-claro" width="20%">Observaciones</td>
        <td class="borderx italica" colspan="2" width="80%"><?=$cita->detalles_tareas_pend?></td>
        
    </tr>
    
    <tr class="borderx">
        <td width="20%" class="borderx">Firma del psicólogo:</td>
        <td colspan="2" width="80%" class="borderx"><br><br><br></td>
        
    </tr>
    </table>
    </div>
<br><br>
    <?php } ?>

