<?php

namespace frontend\modules\sta\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sta\models\VwStaExamenes;

/**
 * FacultadesSearch represents the model behind the search form of `frontend\modules\sta\models\Facultades`.
 */
class VwStaExamenesSearch extends VwStaExamenes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           [['codfac','codalu','codperiodo','codbateria','codtest'], 'safe'],
     
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
        $query = VwStaExamenes::find();

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
        $query->andFilterWhere(['codfac'=>$this->codfac])->
            andFilterWhere(['codalu'=>$this->codalu])
              ->andFilterWhere(['codigotra'=>$this->codigotra])
                  ->andFilterWhere(['codtest'=>$this->codtest])
                 ->andFilterWhere(['codperiodo'=>$this->codperiodo])
                 ->andFilterWhere(['codbateria'=>$this->codbateria])
                 ;
          //  ->andFilterWhere(['like', 'codperiodo', $this->codperiodo]);

        return $dataProvider;
    }
    
     public function searchByExamenId($idexamen)
    {
        $query = VwStaExamenes::find();
 $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->andWhere(['examenes_id'=> $idexamen]);
         return $dataProvider;
    }
    public function searchByExamenCode($idcita,$codexamen)
    {
        $query = VwStaExamenes::findFree();
 $dataProvider = new ActiveDataProvider([
            'query' => $query,
      'pagination' => [ 'pageSize' =>100]
        ]);

        $query->andWhere(['citas_id'=>$idcita,'codtest'=> $codexamen]);
         return $dataProvider;
    }
}
