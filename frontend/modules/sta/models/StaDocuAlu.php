<?php

namespace frontend\modules\sta\models;
use common\models\masters\Documentos;
use common\behaviors\FileBehavior;
use common\behaviors\AccessDownloadBehavior;
use frontend\modules\access\models\modelSensibleAccess;
use Yii;

/**
 * This is the model class for table "{{%sta_docu_alu}}".
 *
 * @property int $id
 * @property int $talleresdet_id
 * @property string $codocu
 * @property string $descripcion
 * @property string $detalle
 *
 * @property StaTalleresdet $talleresdet
 */
class StaDocuAlu extends modelSensibleAccess
{
   const SCE_CAMBIO_IMPRESO='crea_basica';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sta_docu_alu}}';
    }
    
 public $_dataToGraph=[];

 
 
    
public function behaviors()
            {
	return [
		'auditoriaBehavior' => [
			'class' => '\common\behaviors\AuditBehavior' ,
                               ],
		'fileBehavior' => [
			'class' => FileBehavior::className()
		],
            
            'AccessDownloadBehavior' => [
			'class' => AccessDownloadBehavior::className()
		]
		
                ];
            }
    /**
     * {@inheritdoc}
     */
  public $dateorTimeFields=[
        'ultimamod'=>self::_FDATETIME,        
    ];
 public $booleanFields=['impreso'];
 public $sensibleFields=['indi_altos','cuenta_buen',
     'indi_riesgo','sugerencias','cita_id','conclu_acad','metas_acad',
     'recom_tutor_acad',
     'adecuado_nivel'];
    public function rules()
    {
        return [
            [['talleresdet_id'], 'integer'],
            [['codocu'], 'required'],
            [['detalle'], 'string'],
            [['cita_id','impreso','ultimamod'], 'safe'],
            [['codfac','indi_altos','indi_riesgo1','obs_entrev','cuenta_buen','adecuado_nivel','indi_riesgo','metas','sugerencias','indi_encont','conclu_acad','metas_acad','recom_tutor_acad','metas_aux','status'], 'safe'],
            [['codocu'], 'string', 'max' => 3],
            [['descripcion'], 'string', 'max' => 30],
            [['talleresdet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Talleresdet::className(), 'targetAttribute' => ['talleresdet_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'talleresdet_id' => Yii::t('app', 'Talleresdet ID'),
            'codocu' => Yii::t('app', 'Código'),
            'cita_id' => Yii::t('app', 'Cita'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'detalle' => Yii::t('app', 'Detalle'),
            'codestado' => Yii::t('app', 'Estado'),
            'indi_altos' => Yii::t('sta.labels', 'Teniendo en cuenta los hallazgos en la evaluación psicológica se concluye que el alumno presenta alto nivel en:'),
             'indi_riesgo1' => Yii::t('sta.labels', 'Sin embargo se observa  indicadores de riesgo, lo que significa que posee bajos niveles de :'),
            'obs_entrev' => Yii::t('sta.labels', 'Observaciones durante la entrevista:'),
            'cuenta_buen' => Yii::t('sta.labels', 'Teniendo en cuenta los hallazgos en la evaluación psicológica se concluye que:'),
            'adecuado_nivel' => Yii::t('sta.labels', 'Así tambien presenta adecuado nivel en:'),
            'indi_riesgo' => Yii::t('sta.labels', 'Por otro lado presenta indicadores de riesgo como:'),
            'metas' => Yii::t('sta.labels', 'El presente plan describe las metas de tutoría psicológica que se llevarán acabo con el referido(a) alumno(a), a partir de los resultados de la evaluación inicial de tutoría psicológica en el semestre 2020-I , la misma que brinda los siguientes indicadores prioritariamente:'),
            'metas_aux' => Yii::t('sta.labels', 'El presente plan describe las metas de tutoría psicológica que se llevarán acabo con el referido(a) alumno(a), a partir de los resultados de la evaluación inicial de tutoría psicológica en el semestre 2020-I , la misma que brinda los siguientes indicadores prioritariamente:'),
            
            'sugerencias' => Yii::t('sta.labels', 'Se sugiere trabajar los siguientes indicadores de riesgo :'),
            'indi_encont' => Yii::t('sta.labels', 'El estudiante de pregrado en condición de riesgo académico de la Universidad Nacional de Ingeniería, durante la entrevista muestra:'),
            'conclu_acad' => Yii::t('sta.labels', 'Conclusiones de la evaluación:'),
            'metas_acad' => Yii::t('sta.labels', 'La tutoría psicológica propone, a partir de los resultados encontrados,desarrollar los indicadores siguientes :'),
            'recom_tutor_acad' => Yii::t('sta.labels', 'Recomendaciones para el tutor académico:'),
            ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTalleresdet()
    {
        return $this->hasOne(Talleresdet::className(), ['id' => 'talleresdet_id']);
    }
    public function getDocumento()
    {
        return $this->hasOne(Documentos::className(), ['codocu' => 'codocu']);
    }
    public function getCita()
    {
        return $this->hasOne(Citas::className(), ['id' => 'cita_id']);
    }
public function getFacultad()
    {
        return $this->hasOne(Facultades::className(), ['codfac' => 'codfac']);
    }
    /**
     * {@inheritdoc}
     * @return StaDocuAluQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StaDocuAluQuery(get_called_class());
    }
    
    public function getDataToGraph(){
      if(count($this->_dataToGraph)==0){
           $cita=Citas::findOne($this->cita_id);
        if(!is_null($cita)){
            $examenesId=$cita->examenesId();
             $query= \frontend\modules\sta\models\StaResultados::find()->where(['examen_id'=>$examenesId]);
             $datos=$query->select(['puntaje_total','percentil','categoria','b.nombre','b.nemonico','b.nombre'])->join('INNER JOIN','{{%sta_testindicadores}} b','indicador_id=b.id')->orderBy('b.ordenabs ASC')->asArray()->all();
            $indicadores= array_column($datos, 'nombre');
            $categorias= array_column($datos, 'categoria');
                $alabels=[];
            foreach($indicadores as $key=>$valor){
                $alabels[]=$valor.'-('.$categorias[$key].')';
                }
                    $percentil= array_column($datos, 'percentil');
                    $percentil=array_map('intval', $percentil);
            $this->_dataToGraph=['x'=> $alabels,'y'=>$percentil];
            return $this->_dataToGraph;
           }else{
             return [];  
           }
         
      }else{
          return $this->_dataToGraph;
      }
        
     
    }
    
    public function  dataGraph(){
       
                   
            
        $plantilla=[
            'content'=>'options',
            'options'=>'{"colors":["#7cb5ec","#434348","#90ed7d","#f7a35c","#8085e9","#f15c80","#e4d354","#2b908f","#f45b5b","#91e8e1"],"symbols":["circle","diamond","square","triangle","triangle-down"],'
            . '"lang":{"loading":"Loading...","months":'
            . '["January","February","March","April","May","June","July","August","September","October","November","December"],"shortMonths":["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],'
            . '"weekdays":["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],'
            . '"decimalPoint":".","numericSymbols":["k","M","G","T","P","E"],'
            . '"resetZoom":"Reset zoom","resetZoomTitle":"Reset zoom level 1:1",'
            . '"thousandsSep":" "},"global":{},"time":{"timezoneOffset":0,'
            . '"useUTC":true},"chart":{"styledMode":false,"borderRadius":0,'
            . '"colorCount":10,"defaultSeriesType":"line","ignoreHiddenSeries":true,'
            . '"spacing":[10,10,15,10],"resetZoomButton":{"theme":{"zIndex":6},'
            . '"position":{"align":"right","x":-10,"y":10}},"width":700,'
            . '"height":null,"borderColor":"#335cad","backgroundColor":"#ffffff",'
            . '"plotBorderColor":"#cccccc","type":"bar"},'
            . '"title":{"style":{"color":"#333333","fontSize":"18px",'
            . '"fill":"#333333","width":"636px"},"text":"Indicadores",'
            . '"align":"center","margin":15,"widthAdjust":-44},'
            . '"subtitle":{"style":{"color":"#666666","fill":"#666666",'
            . '"width":"636px"},"text":"","align":"center","widthAdjust":-44},'
            . '"caption":{"style":{"color":"#666666","fill":"#666666","width":"680px"},'
            . '"margin":15,"text":"","align":"left","verticalAlign":"bottom"},'
            . '"plotOptions":{"line":{"lineWidth":2,"allowPointSelect":false,'
            . '"showCheckbox":false,"animation":{"duration":1000},"events":{},'
            . '"marker":{"lineWidth":0,"lineColor":"#ffffff","enabledThreshold":2,'
            . '"radius":4,"states":{"normal":{"animation":true},'
            . '"hover":{"animation":{"duration":50},"enabled":true,"radiusPlus":2,'
            . '"lineWidthPlus":1},"select":{"fillColor":"#cccccc","lineColor":"#000000","lineWidth":2}}},'
            . '"point":{"events":{}},"dataLabels":{"align":"center","padding":5,'
            . '"style":{"fontSize":"11px","fontWeight":"bold","color":"contrast",'
            . '"textOutline":"1px contrast"},"verticalAlign":"bottom","x":0,"y":0},'
            . '"cropThreshold":300,"opacity":1,"pointRange":0,"softThreshold":true,'
            . '"states":{"normal":{"animation":true},"hover":{"animation":{"duration":50},'
            . '"lineWidthPlus":1,"marker":{},"halo":{"size":10,"opacity":0.25}},'
            . '"select":{"animation":{"duration":0}},"inactive":{"animation":{"duration":50},'
            . '"opacity":0.2}},"stickyTracking":true,"turboThreshold":1000,"findNearestPointBy":"x"},'
            . '"area":{"lineWidth":2,"allowPointSelect":false,"showCheckbox":false,'
            . '"animation":{"duration":1000},"events":{},"marker":{"lineWidth":0,'
            . '"lineColor":"#ffffff","enabledThreshold":2,"radius":4,'
            . '"states":{"normal":{"animation":true},"hover":{"animation":{"duration":50},"enabled":true,"radiusPlus":2,"lineWidthPlus":1},'
            . '"select":{"fillColor":"#cccccc","lineColor":"#000000","lineWidth":2}}},'
            . '"point":{"events":{}},"dataLabels":{"align":"center","padding":5,"style":{"fontSize":"11px","fontWeight":"bold","color":"contrast","textOutline":"1px contrast"},'
            . '"verticalAlign":"bottom","x":0,"y":0},'
            . '"cropThreshold":300,"opacity":1,"pointRange":0,"softThreshold":false,'
            . '"states":{"normal":{"animation":true},"hover":{"animation":{"duration":50},'
            . '"lineWidthPlus":1,"marker":{},"halo":{"size":10,"opacity":0.25}},'
            . '"select":{"animation":{"duration":0}},"inactive":{"animation":{"duration":50},'
            . '"opacity":0.2}},"stickyTracking":true,"turboThreshold":1000,'
            . '"findNearestPointBy":"x","threshold":0},"spline":{"lineWidth":2,"allowPointSelect":false,"showCheckbox":false,'
            . '"animation":{"duration":1000},"events":{},"marker":{"lineWidth":0,"lineColor":"#ffffff","enabledThreshold":2,"radius":4,"states":{"normal":{"animation":true},"hover":{"animation":{"duration":50},"enabled":true,"radiusPlus":2,"lineWidthPlus":1},"select":{"fillColor":"#cccccc","lineColor":"#000000","lineWidth":2}}},"point":{"events":{}},"dataLabels":{"align":"center","padding":5,"style":{"fontSize":"11px","fontWeight":"bold","color":"contrast","textOutline":"1px contrast"},"verticalAlign":"bottom","x":0,"y":0},"cropThreshold":300,"opacity":1,"pointRange":0,"softThreshold":true,"states":{"normal":{"animation":true},"hover":{"animation":{"duration":50},"lineWidthPlus":1,'
            . '"marker":{},"halo":{"size":10,"opacity":0.25}},"select":{"animation":{"duration":0}},"inactive":{"animation":{"duration":50},"opacity":0.2}},"stickyTracking":true,"turboThreshold":1000,"findNearestPointBy":"x"},"areaspline":{"lineWidth":2,"allowPointSelect":false,"showCheckbox":false,"animation":{"duration":1000},"events":{},"marker":{"lineWidth":0,"lineColor":"#ffffff","enabledThreshold":2,"radius":4,"states":{"normal":{"animation":true},"hover":{"animation":{"duration":50},"enabled":true,"radiusPlus":2,"lineWidthPlus":1},"select":{"fillColor":"#cccccc","lineColor":"#000000","lineWidth":2}}},"point":{"events":{}},"dataLabels":{"align":"center","padding":5,'
            . '"style":{"fontSize":"11px","fontWeight":"bold","color":"contrast","textOutline":"1px contrast"},"verticalAlign":"bottom","x":0,"y":0},"cropThreshold":300,"opacity":1,'
            . '"pointRange":0,"softThreshold":false,"states":{"normal":{"animation":true},"hover":{"animation":{"duration":50},"lineWidthPlus":1,"marker":{},"halo":{"size":10,"opacity":0.25}},"select":{"animation":{"duration":0}},"inactive":{"animation":{"duration":50},"opacity":0.2}},"stickyTracking":true,"turboThreshold":1000,"findNearestPointBy":"x","threshold":0},"column":{"lineWidth":2,"allowPointSelect":false,"showCheckbox":false,"animation":{"duration":1000},"events":{},"marker":null,"point":{"events":{}},"dataLabels":{"align":null,"padding":5,"style":{"fontSize":"11px","fontWeight":"bold","color":"contrast","textOutline":"1px contrast"},"verticalAlign":null,"x":0,"y":null},'
            . '"cropThreshold":50,"opacity":1,"pointRange":null,"softThreshold":false,"states":{"normal":{"animation":true},"hover":{"animation":{"duration":50},"lineWidthPlus":1,"marker":{},"halo":false,"brightness":0.1},"select":{"animation":{"duration":0},"color":"#cccccc","borderColor":"#000000"},"inactive":{"animation":{"duration":50},"opacity":0.2}},"stickyTracking":false,"turboThreshold":1000,"findNearestPointBy":"x","borderRadius":0,"crisp":true,"groupPadding":0.2,"pointPadding":0.1,"minPointLength":0,"startFromThreshold":true,"threshold":0,"borderColor":"#ffffff"},"bar":{"lineWidth":2,"allowPointSelect":false,"showCheckbox":false,"animation":{"duration":1000},"events":{},"marker":null,"point":{"events":{}},"dataLabels":{"align":null,"padding":5,'
            . '"style":{"fontSize":"11px","fontWeight":"bold","color":"contrast","textOutline":"1px contrast"},"verticalAlign":null,"x":0,"y":null,"enabled":true,"crop":false,"overflow":"none"},"cropThreshold":50,"opacity":1,"pointRange":null,"softThreshold":false,"states":{"normal":{"animation":true},"hover":{"animation":{"duration":50},"lineWidthPlus":1,"marker":{},"halo":false,"brightness":0.1},"select":{"animation":{"duration":0},"color":"#cccccc","borderColor":"#000000"},"inactive":{"animation":{"duration":50},"opacity":0.2}},"stickyTracking":false,"turboThreshold":1000,"findNearestPointBy":"x","borderRadius":0,"crisp":true,"groupPadding":0.2,"pointPadding":0.1,"minPointLength":0,"startFromThreshold":true,'
            . '"tooltip":{},"threshold":0,"borderColor":"#ffffff"},"scatter":{"lineWidth":0,"allowPointSelect":false,"showCheckbox":false,"animation":{"duration":1000},"events":{},"marker":{"lineWidth":0,"lineColor":"#ffffff","enabledThreshold":2,"radius":4,"states":{"normal":{"animation":true},"hover":{"animation":{"duration":50},"enabled":true,"radiusPlus":2,"lineWidthPlus":1},"select":{"fillColor":"#cccccc","lineColor":"#000000","lineWidth":2}},"enabled":true},"point":{"events":{}},"dataLabels":{"align":"center","padding":5,"style":{"fontSize":"11px","fontWeight":"bold","color":"contrast","textOutline":"1px contrast"},"verticalAlign":"bottom","x":0,"y":0},"cropThreshold":300,"opacity":1,"pointRange":0,'
            . '"softThreshold":true,"states":{"normal":{"animation":true},"hover":{"animation":{"duration":50},"lineWidthPlus":1,"marker":{},"halo":{"size":10,"opacity":0.25}},"select":{"animation":{"duration":0}},"inactive":{"animation":{"duration":50},"opacity":0.2}},"stickyTracking":true,"turboThreshold":1000,"findNearestPointBy":"xy","jitter":{"x":0,"y":0}},"pie":{"allowPointSelect":false,"showCheckbox":false,"animation":{"duration":1000},"events":{},"marker":null,"point":{"events":{}},"dataLabels":{"align":"center","padding":5,"style":{"fontSize":"11px","fontWeight":"bold","color":"contrast","textOutline":"1px contrast"},"verticalAlign":"bottom","x":0,"y":0,"allowOverlap":true,"connectorPadding":5,'
                 . '"distance":30,"enabled":true,"softConnector":true,"connectorShape":"fixedOffset","crookDistance":"70%"},"cropThreshold":300,"opacity":1,"pointRange":0,"softThreshold":true,"states":{"normal":{"animation":true},"hover":{"animation":{"duration":50},"lineWidthPlus":1,"marker":{},"halo":{"size":10,"opacity":0.25},"brightness":0.1},"select":{"animation":{"duration":0}},"inactive":{"animation":{"duration":50},"opacity":0.2}},"stickyTracking":false,"turboThreshold":1000,"findNearestPointBy":"x","center":[null,null],"clip":false,"colorByPoint":true,"ignoreHiddenPoint":true,"inactiveOtherPoints":true,"legendType":"point","size":null,"showInLegend":false,"slicedOffset":10,"borderColor":"#ffffff",'
                 . '"borderWidth":1},"series":{"stacking":"normal","showInLegend":false,"tooltip":{}}},"labels":{"style":{"position":"absolute","color":"#333333"}},"legend":{"enabled":true,"align":"center","alignColumns":true,"layout":"horizontal","borderColor":"#999999","borderRadius":0,"navigation":{"activeColor":"#003399","inactiveColor":"#cccccc"},"itemStyle":{"color":"#333333","cursor":"pointer","fontSize":"12px","fontWeight":"bold","textOverflow":"ellipsis"},"itemHoverStyle":{"color":"#000000"},"itemHiddenStyle":{"color":"#cccccc"},"shadow":false,"itemCheckboxStyle":{"position":"absolute","width":"13px","height":"13px"},"squareSymbol":true,"symbolPadding":5,"verticalAlign":"bottom","x":0,"y":0,'
                 . '"title":{"style":{"fontWeight":"bold"}},"reversed":true},"loading":{"labelStyle":{"fontWeight":"bold","position":"relative","top":"45%"},"style":{"position":"absolute","backgroundColor":"#ffffff","opacity":0.5,"textAlign":"center"}},"tooltip":{"enabled":true,"animation":true,"borderRadius":3,"dateTimeLabelFormats":{"millisecond":"%A, %b %e, %H:%M:%S.%L","second":"%A, %b %e, %H:%M:%S","minute":"%A, %b %e, %H:%M","hour":"%A, %b %e, %H:%M","day":"%A, %b %e, %Y","week":"Week from %A, %b %e, %Y","month":"%B %Y","year":"%Y"},"footerFormat":"","padding":8,"snap":10,"headerFormat":"<span style=\"font-size: 10px\">{point.key}</span><br/>","pointFormat":"<span style=\"color:{point.color}\">●</span> '
                 . '{series.name}: <b>{point.y}</b><br/>","backgroundColor":"rgba(247,247,247,0.85)","borderWidth":1,"shadow":true,"style":{"color":"#333333","cursor":"default","fontSize":"12px","pointerEvents":"none","whiteSpace":"nowrap"}},"credits":true,"xAxis":[{"categories":["AUTOEFICACIA ACADÉMICA-(PROMEDIO)","PROCASTINACIÓN ACADÉMICA-(PROMEDIO)","ANSIEDAD FRENTE A EXAMEN-(BAJO)","VÍNCULOS PSICOSOCIALES-(ALTO)","ACEPTACIÓN Y CONTROL-(ALTO)","PROYECTOS-(ALTO)","AUTONOMÍA-(ALTO)","AUTOCONCEPTO SOCIAL-(ALTO)","ADAPTACIÓN FAMILIAR-(PROMEDIO)","COHESIÓN FAMILIAR-(PROMEDIO)","CAPACIDAD RESOLUTIVA-(ALTO)","EXPECTATIVA DE ÉXITO-(PROMEDIO)","AUTOCONCEPTO ACADÉMICO-(PROMEDIO)","AFRONTAMIENTO AL PROBLEMA-(ALTO)","AUTOESTIMA-(PROMEDIO)"],'
                 . '"index":0,"isX":true}],"yAxis":[{"title":{"text":"Percentil"},"index":0}],"series":[{"name":"","pointWidth":15,"groupPadding":1,"boderRadius":15,"boderColor":"#f78ad2","color":"#f93087","data":[70,30,10,90,90,90,70,90,50,60,90,50,50,70,40]}]}',
          'type'=>'image/svg+xml' ,
            'width'=>'700px',
            'scale'=> 1,
        'constr'=> 'Chart',
           'async'=> true
          ];
        $valores=$this->dataToGraph;
    $options=\yii\helpers\Json::decode($plantilla['options']);
   $options['xAxis'][0]['categories']=$valores['x'];
     $options['series'][0]['data']=$valores['y'];     
     $plantilla['options']=\yii\helpers\Json::encode($options);
     return $plantilla;
    }
  public function hasChangedInfo(){
      $cambio=false;
      foreach($this->sensibleFields as $field){
          if($this->hasChanged($field)){
              $cambio=true;break;
          }
      }
      return $cambio;
  }
  
 public function scenarios()
    {
        $scenarios = parent::scenarios(); 
        $scenarios[self::SCE_CAMBIO_IMPRESO] = ['impreso'];
       return $scenarios;
    }
  
 public function beforeSave($insert) {
     if(!$insert){
        if($this->hasChangedInfo()){
           
            $this->impreso=false;
            $this->ultimamod=self::SwichtFormatDate(date(\common\helpers\timeHelper::formatMysqlDateTime()),'datetime',true);
        } else{
           
        }
     }
     return parent::beforeSave($insert);
 }
    
 public function changeStatusImpresion(){
     $oldScenario=$this->getScenario();
     $this->setScenario(self::SCE_CAMBIO_IMPRESO);
     $this->impreso=true;
      $this->ultimamod=self::SwichtFormatDate(date(\common\helpers\timeHelper::formatMysqlDateTime()),'datetime',true);
     $this->save();
     $this->setScenario($oldScenario);
     RETURN;
 }  
 
}
