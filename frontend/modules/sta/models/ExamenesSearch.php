<?php

namespace frontend\modules\sta\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sta\models\Examenes;

/**
 * EntregasSearch represents the model behind the search form of `frontend\modules\sta\models\Entregas`.
 */
class ExamenesSearch extends Examenes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            
            [['codtest', 'cistas_id'], 'safe'],
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
    public function searchByTaller($idtaller)
    {
        $query = Examenes::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

       

        $query->Where(['citas_id'=> $idtaller])
           ;
            //->andFilterWhere(['like', 'codalu', $this->codalu]);  
        return $dataProvider;
    }
}
