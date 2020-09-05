<?php

namespace frontend\modules\sta\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sta\models\StaEventosdet;

/**
 * StaEventosSearch represents the model behind the search form of `frontend\modules\sta\models\StaEventos`.
 */
class StaEventosdetSearch extends StaEventosdet
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
          // [['id', 'talleres_id'], 'integer'],
            [['codalu', 'nombres', 'correo', 'celulares','asistio','libre'], 'safe'],
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
    public function searchByEvento($id_evento,$params)
    {
        $query = StaEventosdet::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        
        // grid filtering conditions
        $query->andFilterWhere([
            'eventos_id' => $id_evento,
            //'talleres_id' => $this->talleres_id,
        ]);

        $query->andFilterWhere(['like', 'nombres', $this->nombres])
            ->andFilterWhere(['like', 'codalu', $this->codalu])
            ->andFilterWhere(['like', 'celulares', $this->celulares])
                 ->andFilterWhere(['asistio'=>$this->asistio])
                ->andFilterWhere(['libre'=>$this->libre])
            ->andFilterWhere(['like', 'correo', $this->correo]);

        return $dataProvider;
    }
    
    public function searchByPrograma($id_programa,$params)
    {
        $query = StaEventosdet::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        
        // grid filtering conditions
        $query->andFilterWhere([
            'talleres_id' => $id_programa,
            //'talleres_id' => $this->talleres_id,
        ]);

        $query->andFilterWhere(['like', 'nombres', $this->nombres])
            ->andFilterWhere(['like', 'codalu', $this->codalu])
            ->andFilterWhere(['like', 'celulares', $this->celulares])
                 ->andFilterWhere(['asistio'=>$this->asistio])
                ->andFilterWhere(['libre'=>$this->libre])
            ->andFilterWhere(['like', 'correo', $this->correo]);

        return $dataProvider;
    }
    
    
    
}
