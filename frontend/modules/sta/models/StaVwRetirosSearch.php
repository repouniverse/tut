<?php

namespace frontend\modules\sta\models;
use yii\data\ActiveDataProvider;
use common\helpers\h;
//use frontend\modules\sta\models\Alumnos;
use frontend\modules\sta\staModule;
//use common\models\masters\Trabajadores;
use yii\base\Model;
use yii;
/**
 * This is the ActiveQuery class for [[StaVwCitas]].
 *
 * @see StaVwCitas
 */
class StaVwRetirosSearch extends StaVwRetiros
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           [[
          'estado','detalle','codocu','descripcion','motivo',  
        'codperiodo',
        'codalu','codfac',
         'ap','am','nombres','codfac','codcar',
         'id','talleres_id','talleresdet_id',
           'fecha',
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
        $query = StaVwRetiros::find();
        
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
//var_dump($this->asistio);
        $this->load($params);
       //var_dump($this->asistio);die();
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }          
         $query->andFilterWhere(['like', 'ap', $this->ap])
                 ->andFilterWhere(['like', 'am', $this->am])
            ->andFilterWhere(['like', 'nombres', $this->nombres])
           ->andFilterWhere(['codperiodo'=>$this->codperiodo])
            ->andFilterWhere(['estado'=>$this->estado])
                  ->andFilterWhere(['motivo'=>$this->motivo])
           ->andFilterWhere(['codfac'=>$this->codfac])
                ->andFilterWhere(['like', 'codalu', $this->codalu])
                ->andFilterWhere(['codcar'=>$this->codcar]) ;
         //echo $query->createCommand()->getRawSql();die();
         
       // ->andWhere(['codocu'=>$this->codocu]);
        return $dataProvider;
    }
    
}
