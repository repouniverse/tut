<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\modules\sta\models\StaGrupoflujo;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
$this->title = Yii::t('sta.labels', 'Panel de control Coordinación');
//$this->params['breadcrumbs'][] = ['label' => Yii::t('sta.labels', 'Panel Coord'), 'url' => ['/sta/default/panel-coord']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('sta.labels', 'Panel')];

?>
<?php
 
    $ntotalPeriodo= \frontend\modules\sta\models\VwAlutaller::find()->completeFacultades()->andWhere(['codperiodo'=>$codperiodo])->count();
   //var_dump(\frontend\modules\sta\models\VwAlutaller::find()->completeFacultades()->andWhere(['codperiodo'=>$codperiodo])->createCommand()->getRawSql());die();
    //$ntotalFacultad= \frontend\modules\sta\models\VwAlutaller::find()->andWhere(['codfac'=>$codfac,'codperiodo'=>$codperiodo])->count();
   // $nPorPiscologo=\frontend\modules\sta\models\VwAlutaller::find()->andWhere(['codfac'=>$codfac,'codperiodo'=>$codperiodo,'codtra'=>$codtra])->count();
    //$porcAvancePsico=StaGrupoflujo::porcTotal($codperiodo,$codfac,$codtra)*100;
?>

    <h4><i class="fa fa-edit"></i><?= Html::encode($this->title) ?></h4>

    
    
    <div class="box box-success">
 <br>
  <?php 
            $url=Url::to(['/avisos/tablon/create']);
            echo Html::a('<p class="text-green"><span class="fa fa-volume-up"></span>'.yii::t('sta.labels','Colocar anuncio').'</p>',$url, ['class'=>""]);
            ?>
            
         
    <br>
     <div class="row">
       <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $ntotalPeriodo ?></h3>

              <p>Alumnos en riesgo</p>
            </div>
            <div class="icon">
                <span style="color:white;opacity:0.5;"><i class="fa fa-users"></i></span>
            </div>
            <?php 
            $url=Url::to(['cantidades-en-riesgo']);
            echo Html::a(yii::t('sta.labels','Detalles').'<i class="fa fa-arrow-circle-right"></i>',$url, ['class'=>"botonAbre small-box-footer"]);
            ?>
            
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
                <h3><?= frontend\modules\sta\components\Indicadores::cantidadesExamenes()?><sup style="font-size: 20px"></sup></h3>

              <p>Exámenes rendidos</p>
            </div>
            <div class="icon">
              <span style="color:white;opacity:0.5;"><i class="fa fa-pencil-alt"></i></span>
            </div>
            <?php 
            $url=Url::to(['examenes']);
            echo Html::a(yii::t('sta.labels','Detalles').'<i class="fa fa-arrow-circle-right"></i>',$url, ['class'=>"botonAbre small-box-footer"]);
            ?> </div>
        </div>
        <!-- ./col -->
         <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
                <h3><?php 
                $aten=frontend\modules\sta\components\Indicadores::cantidadAtenciones($codperiodo);
                echo $aten[0]['total'];
                ?></h3>

              <p>Atenciones efectuadas</p>
            </div>
            <div class="icon">
              <i class="fa fa-calendar-check-o"></i>
            </div>
            <?php 
            $url=Url::to(['atenciones']);
            echo Html::a(yii::t('sta.labels','Detalles').'<i class="fa fa-arrow-circle-right"></i>',$url, ['class'=>"botonAbre small-box-footer"]);
            ?> 
          </div>
        </div>
       
      </div> 
    
   
</div>
<?php 
echo $this->render('coord_psico',['psicologos'=>$psicologos,'codperiodo'=>$codperiodo]); 
?>


    
