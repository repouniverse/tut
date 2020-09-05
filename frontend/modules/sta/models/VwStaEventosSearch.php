<?php

namespace frontend\modules\sta\models;
use yii\base\Model;
/**
 * This is the ActiveQuery class for [[VwStaEventos]].
 *
 * @see VwStaEventos
 */
class VwStaEventosSearch extends VwStaEventos
{
    /**
     * {@inheritdoc}
     */
 
    public function rules()
    {
        return [ 
           [[
            
            'proceso',
            'codalu',
            'nombres',
            'codcar',
            'codfac',
            'codfac',
            'codperiodo',
            'status',
            'clase',
            'fechaprog','fechaprog1',
            'numero',
            'libre',
            'asistio',
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
        $query = VwStaEventos::except();
 $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination'=>[
                'pageSize'=>10,
                
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
            ->andFilterWhere(['like', 'codalu', $this->codalu])
     ->andFilterWhere(['codcar'=> $this->codcar])
       ->andFilterWhere(['codperiodo'=>$this->codperiodo])       
        ->andFilterWhere(['asistio'=> $this->asistio])
                 ->andFilterWhere(['like', 'nombres', $this->nombres])
         ->andFilterWhere(['libre'=> $this->libre]);
        
 if(!empty($this->fechaprog) && !empty($this->fechaprog1)){
         $query->andFilterWhere([
             'between',
             'fechaprog',
             $this->openBorder('fechaprog',false),
             $this->openBorder('fechaprog1',true)
                        ]);   
        }
        return $dataProvider;
    }
  
}
