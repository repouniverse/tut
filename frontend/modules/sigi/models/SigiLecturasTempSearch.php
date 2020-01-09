<?php

namespace frontend\modules\sigi\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sigi\models\SigiLecturastemp;

/**
 * EdificiosSearch represents the model behind the search form of `\frontend\modules\sigi\models\Edificios`.
 */
class SigiLecturasTempSearch extends SigiLecturasTemp
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['id', 'edificio_id','cargo_id','grupo_id'], 'integer'],
            [['codepa',  'lectura','flectura','suministro_id','id'], 'safe'],
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
    public function searchByCuenta($params)
    {
        $query = SigiLecturasTemp::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'suministro_id' => $this->suministro_id,
             'unidad_id' => $this->unidad_id,
            'codepa' => $this->codepa,
            'codtipo' => $this->codtipo,
            
           ]);

        return $dataProvider;
    }
   
}