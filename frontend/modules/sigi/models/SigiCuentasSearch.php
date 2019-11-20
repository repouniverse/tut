<?php

namespace frontend\modules\sigi\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sigi\models\SigiCuentas;

/**
 * SigiCargosSearch represents the model behind the search form of `frontend\modules\sigi\models\SigiCargos`.
 */
class SigiCuentasSearch extends SigiCuentas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [[], 'safe'],
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
    public function searchByEdificio($edificio_id)
    {
        $query = SigiCuentas::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->where([
            'edificio_id' => $edificio_id,
           // 'npisos' => $this->npisos,
        ]);
        // grid filtering conditions
        
        return $dataProvider;
    }
}
