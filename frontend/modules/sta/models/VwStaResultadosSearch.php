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
class VwStaResultadosSearch extends VwStaResultados
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           [[
           'codbateria', 'codfac','codalu','codperiodo','categoria','indicador_id','flujo_id','talleresdet_id'    
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
        $query = VwStaResultados::find();
 $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>[
                'pageSize'=>100,
                
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
                 ->andFilterWhere(['talleresdet_id'=> $this->talleresdet_id])
       ->andFilterWhere(['codperiodo'=>$this->codperiodo])
         ->andFilterWhere(['categoria'=> $this->categoria])
                ->andFilterWhere(['flujo_id'=> $this->flujo_id])
        ->andFilterWhere(['indicador_id'=> $this->indicador_id]);
          //  ->andFilterWhere(['like', 'codperiodo', $this->codperiodo]);

        return $dataProvider;
    }
   public function searchNada()
    {
        $query = VwStaResultados::find()->where(['<',1,0]);
return new ActiveDataProvider([
            'query' => $query,
            'pagination'=>[
                'pageSize'=>100,
                
            ]
        ]);
 
    }
}
