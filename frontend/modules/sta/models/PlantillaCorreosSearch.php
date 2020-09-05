<?php

namespace frontend\modules\sta\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sta\models\PlantillaCorreos;

/**
 * PlantillaCorreosSearch represents the model behind the search form of `frontend\modules\sta\models\PlantillaCorreos`.
 */
class PlantillaCorreosSearch extends PlantillaCorreos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'programa_id'], 'integer'],
            [['codfac', 'masivo', 'descripcion', 'disparador', 'titulo', 'cuerpo', 'detalles'], 'safe'],
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
    public function search($params)
    {
        $query = PlantillaCorreos::find();

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
            'id' => $this->id,
            'programa_id' => $this->programa_id,
        ]);

        $query->andFilterWhere(['codfac'=> $this->codfac])
            ->andFilterWhere(['like', 'masivo', $this->masivo])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'disparador', $this->disparador])
            ->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'cuerpo', $this->cuerpo])
            ->andFilterWhere(['like', 'detalles', $this->detalles]);

        return $dataProvider;
    }
}
