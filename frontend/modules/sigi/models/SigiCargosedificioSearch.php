<?php

namespace frontend\modules\sigi\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sigi\models\SigiCargosedificio;

/**
 * EdificiosSearch represents the model behind the search form of `\frontend\modules\sigi\models\Edificios`.
 */
class SigiCargosedificioSearch extends SigiCargosedificio
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'edificio_id','cargo_id','grupo_id'], 'integer'],
            [['edificio_id','cargo_id','grupo_id','regular', 'montofijo', 'frecuencia', 'tipomedida'], 'safe'],
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
        $query = SigiCargosedificio::find();

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
        $query->andFilterWhere([
            'edificio_id' => $this->edificio_id,
            'cargo_id' => $this->cargo_id,
            'tasamora' => $this->tasamora,
            'grupo_id' => $this->grupo_id,
             'regular' => $this->regular,
            'montofijo' => $this->montofijo,
            'frecuencia' => $this->frecuencia,
            'tipomedidor' => $this->frecuencia,
        ]);

        return $dataProvider;
    }
  
     public function searchByGrupo($idgrupo)
    {
        $query = SigiCargosedificio::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

       
        // grid filtering conditions
        $query->andFilterWhere([
            'grupo_id' => $idgrupo
        ]);

        return $dataProvider;
    }
    
}