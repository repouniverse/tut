<?php

namespace frontend\modules\sta\models;
use yii\data\ActiveDataProvider;
use frontend\modules\sta\models\StaTestdet;
//use common\models\masters\Trabajadores;
use yii\base\Model;
/**
 * This is the ActiveQuery class for [[StaVwCitas]].
 *
 * @see StaVwCitas
 */
class StaTestdetSearch extends StaTestdet
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           [[
                   
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = StaVwCitas::find();

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
         $query->andFilterWhere(['like', 'aptutor', $this->aptutor])
                 ->andFilterWhere(['like', 'amtutor', $this->amtutor])
            ->andFilterWhere(['like', 'nombrestutor', $this->nombrestutor])
           ->andFilterWhere(['codperiodo'=>$this->codperiodo])
                ->andFilterWhere(['codalu'=>$this->codalu])
           ->andFilterWhere(['like', 'ap', $this->ap])
      ->andFilterWhere(['like', 'am', $this->am])
            ->andFilterWhere(['like', 'nombres', $this->nombres])
          ->andFilterWhere(['codfac'=>$this->codfac])
                ->andFilterWhere(['codcar'=>$this->codcar])
                   ->andFilterWhere(['codtra'=>$this->codtra])
            ->andFilterWhere(['like', 'codaula', $this->codaula]);
         
         if(!empty($this->fechaprog) && !empty($this->fechaprog1)){
         $query->andFilterWhere([
             'between',
             'fechaprog',
             $this->openBorder('fechaprog',false),
             $this->openBorder('fechaprog1',true)
                        ]);   
        }
        
         
         
         
       // ->andWhere(['codocu'=>$this->codocu]);
        return $dataProvider;
    }
    
     public function getAlumno()
    {
        return $this->hasOne(Alumnos::className(), ['codalu' => 'codalu']);
    }
     public function getTrabajador()
    {
        return $this->hasOne(Trabajadores::className(), ['codigotra' => 'codtra']);
    }
    
     public function searchByAlumnoByPeriodo($codalu,$codperiodo)
    {
        $query = StaVwCitas::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

         $query->Where(['codalu'=> $codalu])
                 ->andWhere(['codperiodo'=>$codperiodo]);
        return $dataProvider;
    }
    public function searchByTest($codtest)
    {
        $query = StaTestdet::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

         $query->Where(['codtest'=> $codtest]);
        return $dataProvider;
    }
    
}
