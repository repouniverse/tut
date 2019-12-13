<?php

namespace frontend\modules\sta\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sta\models\StaConvocatoriaQuery;

/**
 * TalleresSearch represents the model behind the search form of `frontend\modules\sta\models\Talleres`.
 */
class StaConvocatoriaSearch extends StaConvocatoria
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            
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
    public function searchByDetalle($id)
    {
        $query = StaConvocatoria::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //$this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

       
        $query->andWhere(['talleresdet_id'=>$id]);

        return $dataProvider;
    }
    
     
}
