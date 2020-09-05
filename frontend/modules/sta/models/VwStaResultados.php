<?php

namespace frontend\modules\sta\models;

use Yii;

/**
 * This is the model class for table "{{%vw_sta_resultados}}".
 *
 * @property string $aptutor
 * @property string $amtutor
 * @property string $nombrestutor
 * @property string $codperiodo
 * @property string $descripcion
 * @property string $numero
 * @property string $codalu
 * @property string $ap
 * @property string $am
 * @property string $nombres
 * @property string $codcar
 * @property string $numerocita
 * @property string $fechaprog
 * @property string $codtest
 * @property int $puntaje_total
 * @property int $indicador_id
 * @property int $percentil
 * @property string $categoria
 * @property string $interpretacion
 * @property string $nemonico
 * @property string $nombre
 */
class VwStaResultados extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%vw_sta_resultados}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['aptutor', 'amtutor', 'nombrestutor', 'descripcion', 'numero', 'codalu', 'codtest', 'indicador_id', 'nombre'], 'required'],
            [['puntaje_total', 'indicador_id', 'percentil'], 'integer'],
            [['interpretacion'], 'string'],
             [['codfac'], 'safe'],
            [['aptutor', 'amtutor', 'nombrestutor', 'descripcion', 'ap', 'am', 'nombres'], 'string', 'max' => 40],
            [['codperiodo', 'codcar'], 'string', 'max' => 6],
            [['numero', 'numerocita', 'codtest'], 'string', 'max' => 8],
            [['codalu'], 'string', 'max' => 14],
            [['fechaprog'], 'string', 'max' => 19],
            [['categoria'], 'string', 'max' => 10],
            [['nemonico'], 'string', 'max' => 20],
            [['nombre'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'aptutor' => Yii::t('sta.labels', 'Aptutor'),
            'amtutor' => Yii::t('sta.labels', 'Amtutor'),
            'nombrestutor' => Yii::t('sta.labels', 'Nombrestutor'),
            'codperiodo' => Yii::t('sta.labels', 'Codperiodo'),
            'descripcion' => Yii::t('sta.labels', 'Descripcion'),
            'numero' => Yii::t('sta.labels', 'Numero'),
            'codalu' => Yii::t('sta.labels', 'Codalu'),
            'ap' => Yii::t('sta.labels', 'Ap'),
            'am' => Yii::t('sta.labels', 'Am'),
            'nombres' => Yii::t('sta.labels', 'Nombres'),
            'codcar' => Yii::t('sta.labels', 'Codcar'),
            'numerocita' => Yii::t('sta.labels', 'Numerocita'),
            'fechaprog' => Yii::t('sta.labels', 'Fechaprog'),
            'codtest' => Yii::t('sta.labels', 'Codtest'),
            'puntaje_total' => Yii::t('sta.labels', 'Puntaje Total'),
            'indicador_id' => Yii::t('sta.labels', 'Indicador ID'),
            'percentil' => Yii::t('sta.labels', 'Percentil'),
            'categoria' => Yii::t('sta.labels', 'Categoria'),
            'interpretacion' => Yii::t('sta.labels', 'Interpretacion'),
            'nemonico' => Yii::t('sta.labels', 'Nemonico'),
            'nombre' => Yii::t('sta.labels', 'Nombre'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return VwStaResultadosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VwStaResultadosQuery(get_called_class());
    }
}
