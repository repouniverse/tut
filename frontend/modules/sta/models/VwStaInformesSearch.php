<?php

namespace frontend\modules\sta\models;
use yii\data\ActiveDataProvider;

//use common\models\masters\Trabajadores;
use yii\base\Model;
/**
 * This is the ActiveQuery class for [[StaVwCitas]].
 *
 * @see StaVwCitas
 */
class VwStaInformesSearch extends VwStaInformes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [ 
           [[
            'aptutor' ,'codtra',
            'amtutor' ,
            'nombrestutor',
            'proceso',
            'codalu',
            'ap' ,
            'am',
            'nombres',
            'codcar',
            'correo',
            'id',
            'codocu',
            'codfac',
            'descripcion',
            'status',
            'impreso',
            'ultimamod',
            'numerocita',
            'fechaprog',
            'flujo_id',
            'desdocu',      
           ], 'safe'],
     
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
     public function search($params)
    {
        $query = VwStaInformes::except();
 $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>[
                'pageSize'=>20,
                
            ]
        ]);
 $this->load($params);
 if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['codfac'=> $this->codfac])
            ->andFilterWhere(['codalu'=> $this->codalu])
       ->andFilterWhere(['codperiodo'=>$this->codperiodo])
         ->andFilterWhere(['flujo_id'=> $this->flujo_id])
        ->andFilterWhere(['like','aptutor', $this->aptutor])
        ->andFilterWhere(['like','ap', $this->ap])
        ->andFilterWhere(['like','am', $this->am])
      ->andFilterWhere(['like','numerocita', $this->numerocita])
                 ->andFilterWhere(['codtra'=> $this->codtra])
      ->andFilterWhere(['codocu'=> $this->codocu]);
          //  ->andFilterWhere(['like', 'codperiodo', $this->codperiodo]);

        return $dataProvider;
    }
  
}
