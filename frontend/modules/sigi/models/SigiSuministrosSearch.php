<?php

namespace frontend\modules\sigi\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sigi\models\SigiSuministros;

/**
 * EdificiosSearch represents the model behind the search form of `\frontend\modules\sigi\models\Edificios`.
 */
class SigiSuministrosSearch extends SigiSuministros
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['id', 'edificio_id','cargo_id','grupo_id'], 'integer'],
            [['unidad_id','edificio_id','codsuministro','tipo','numerocliente','codpro'], 'safe'],
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
    public function searchByUnidad($idunidad)
    {
        $query = SigiSuministros::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

       /* $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
       /* $query->andFilterWhere([
            'edificio_id' => $this->edificio_id,
            'cargo_id' => $this->cargo_id,
            'tasamora' => $this->tasamora,
            'grupo_id' => $this->grupo_id,
             'regular' => $this->regular,
            'montofijo' => $this->montofijo,
            'frecuencia' => $this->frecuencia,
            'tipomedidor' => $this->frecuencia,
        ]);*/
$query->andFilterWhere([
            'unidad_id' => $idunidad
                    ]);
        return $dataProvider;
    }
    
    public function searchByEdificio($id)
    {
        $query = SigiSuministros::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

       
$query->andFilterWhere([
            'edificio_id' => $id
                    ]);
        return $dataProvider;
    }
    
    public function search($params){
         $query = SigiSuministros::find();
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
        $query->andFilterWhere(['edificio_id' => $this->edificio_id])->
            andFilterWhere(['unidad_id' => $this->unidad_id])->
          andFilterWhere(['tipo' => $this->tipo])->
                 andFilterWhere(['like','codpro', $this->codpro])->
              andFilterWhere(['like','codsuministro', $this->codsuministro])->   
             andFilterWhere(['codum' => $this->codum]);
            
        
        return $dataProvider;
    }
    
    
   
}