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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sta_docu_alu}}';
    }
public function behaviors()
            {
	return [
		
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
    public function rules()
    {
        return [
            [['talleresdet_id'], 'integer'],
            [['codocu'], 'required'],
            [['detalle'], 'string'],
            [['cita_id'], 'safe'],
            [['codfac','indi_altos','indi_riesgo1','obs_entrev','cuenta_buen','adecuado_nivel','indi_riesgo','metas','sugerencias'], 'safe'],
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
            'codocu' => Yii::t('app', 'Codocu'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'detalle' => Yii::t('app', 'Detalle'),
            'codestado' => Yii::t('app', 'Estado'),
            'indi_altos' => Yii::t('sta.labels', 'El estudiante de pregrado en condición de riesgo académico de la Universidad Nacional de Ingeniería, muestra indicadores altos para un buen desempeño académico tales como:'),
             'indi_riesgo1' => Yii::t('sta.labels', 'Sin embargo se observa  indicadores de riesgo, lo que significa que posee bajos niveles de :'),
       'obs_entrev' => Yii::t('sta.labels', 'Observaciones durante la entrevista:'),
            'cuenta_buen' => Yii::t('sta.labels', 'Teniendo en cuenta los hallazgos durante la entrevista y en la evaluación psicológica se concluye que el estudiante cuenta con buen:'),
            'adecuado_nivel' => Yii::t('sta.labels', 'Así tambien presenta adecuado nivel en:'),
            'indi_riesgo' => Yii::t('sta.labels', 'Por otro lado presenta indicadores de riesgo como:'),
            'metas' => Yii::t('sta.labels', 'El presente plan describe las metas de tutoría psicológica que se llevarán acabo con el referido(a) alumno(a), a partir de los resultados de la evaluación inicial de tutoría psicológica en el semestre 2020-I , la misma que brinda los siguientes indicadores prioritariamente:'),
               'sugerencias' => Yii::t('sta.labels', 'Se sugiere trabajar los siguientes indicadores de riesgo :'),
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
    

    /**
     * {@inheritdoc}
     * @return StaDocuAluQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StaDocuAluQuery(get_called_class());
    }
}
