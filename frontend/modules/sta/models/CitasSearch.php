<?php

namespace frontend\modules\sta\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sta\models\Citas;

/**
 * CitasSearch represents the model behind the search form of `frontend\modules\sta\models\Citas`.
 */
class CitasSearch extends Citas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'talleresdet_id', 'talleres_id', 'duracion'], 'integer'],
            [['fechaprog', 'codtra', 'finicio', 'ftermino', 'fingreso', 'detalles', 'codaula'], 'safe'],
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
        $query = Citas::find();

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
            'talleresdet_id' => $this->talleresdet_id,
            'talleres_id' => $this->talleres_id,
            'duracion' => $this->duracion,
        ]);

        $query->andFilterWhere(['like', 'fechaprog', $this->fechaprog])
            ->andFilterWhere(['like', 'codtra', $this->codtra])
            ->andFilterWhere(['like', 'finicio', $this->finicio])
            ->andFilterWhere(['like', 'ftermino', $this->ftermino])
            ->andFilterWhere(['like', 'fingreso', $this->fingreso])
            ->andFilterWhere(['like', 'detalles', $this->detalles])
            ->andFilterWhere(['like', 'codaula', $this->codaula]);

        return $dataProvider;
    }
}
