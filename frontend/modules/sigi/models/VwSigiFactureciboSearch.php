<?php

namespace frontend\modules\sigi\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sigi\models\VwSigiFacturecibo;

/**
 * SigiUnidadesSearch represents the model behind the search form of `frontend\modules\sigi\models\SigiUnidades`.
 */
class VwSigiFactureciboSearch extends VwSigiFacturecibo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
       /* @property int $id
 * @property int $cuentaspor_id
 * @property int $edificio_id
 * @property int $unidad_id
 * @property int $colector_id
 * @property int $grupo_id
 * @property string $monto
 * @property string $igv
 * @property string $grupounidad agrupa  todos los objetos: cochera, depositos  en el mismo departamento  
 * @property string $grupofacturacion Agrupa el documento del recibo, ojo lo hace por departametno o apoderado, MUY IMPORTANTES 
 * @property int $facturacion_id
 * @property int $mes
 * @property string $anio
 * @property int $identidad
 * @property string $fecha
 * @property string $descripcion
 * @property string $detalles
 * @property string $nombreedificio
 * @property string $codigo
 * @property string $direccion
 * @property string $numero
 * @property string $nombre
 * @property string $area
 * @property string $participacion
 * @property string $descargo
 * @property string $codcargo
 * @property string $codgrupo
 * @property string $desgrupo
 * @property string $numerodepa
 * @property string $nombredepa
 * @property string $areadepa
 * @property string $participaciondepa*/
        
        return 
            [/*['nombre','codgrupo','direccion','codigo',
              'nombreedificio','descripcion','fecha','anio','mes',                
                'grupounidad','grupofacturacion', 'numero', 'numerodepa',
                'monto','area','cuentaspor_id', 'edificio_id', 'unidad_id', 'colector_id', 'grupo_id'
                ], 'safe'*/
           
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($idfacturacion,$params)
    {
        $query = VwSigiFacturecibo::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>['pageSize'=>1500],
        ]);

        $this->load($params);

       

        // grid filtering conditions
        $query->andFilterWhere([
            'facturacion_id' => $idfacturacion,
            'edificio_id' => $this->edificio_id,
        ]);

        $query->andFilterWhere(['like', 'anio', $this->anio])
            ->andFilterWhere(['like', 'mes', $this->mes])
            ->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'numero', $this->numero]);

        return $dataProvider;
    }
     
}
