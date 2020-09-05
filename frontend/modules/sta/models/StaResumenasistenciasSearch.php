<?php

namespace frontend\modules\sta\models;
use yii\data\ActiveDataProvider;
use frontend\modules\sta\models\StaResumenasistencias;
//use common\models\masters\Trabajadores;
use yii\base\Model;
/**
 * This is the ActiveQuery class for [[StaVwCitas]].
 *
 * @see StaVwCitas
 */
class StaResumenasistenciasSearch extends StaResumenasistencias
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           [
               ['nombres','codalu','codfac','codperiodo','tmarzo','tabril','c_21','tjunio','tjulio','tagosto','tsetiembre','n_talleres','n_tutorias'],
               'safe'
               ],
     
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
        $query =  StaResumenasistencias::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        

        $query->andFilterWhere(['like', 'nombres', $this->nombres])
            ->andFilterWhere(['like', 'codalu', $this->codalu])
             //->andFilterWhere(['like', 'n_tutorias', $this->n_tutorias])
             ->andFilterWhere(['>', 'n_tutorias', $this->n_tutorias])
              ->andFilterWhere(['>', 'n_talleres', $this->n_talleres])
                ->andFilterWhere(['>', 'c_21', $this->c_21])
                  ->andFilterWhere([ 'codfac'=> $this->codfac])
            ->andFilterWhere(['codperiodo'=> $this->codperiodo])
             
                 ->andFilterWhere(['n_informe'=>$this->n_informe]);

        return $dataProvider;
    }
    
    
}
