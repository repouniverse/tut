<?php

namespace frontend\modules\avisos\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\avisos\models\AvisosTablon;

/**
 * AvisosTablonSearch represents the model behind the search form of `frontend\modules\avisos\models\AvisosTablon`.
 */
class AvisosTablonSearch extends AvisosTablon
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'periodo', 'user_admin'], 'integer'],
            [['finicio', 'ftermino', 'texto', 'texto_interno', 'esevento', 'activo'], 'safe'],
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
        $query = AvisosTablon::find();

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
            'id' => $this->id,
            'user_id' => $this->user_id,
            'periodo' => $this->periodo,
            'user_admin' => $this->user_admin,
        ]);

        $query->andFilterWhere(['like', 'finicio', $this->finicio])
            ->andFilterWhere(['like', 'ftermino', $this->ftermino])
            ->andFilterWhere(['like', 'texto', $this->texto])
            ->andFilterWhere(['like', 'texto_interno', $this->texto_interno])
            ->andFilterWhere(['like', 'esevento', $this->esevento])
            ->andFilterWhere(['like', 'activo', $this->activo]);

        return $dataProvider;
    }
    
    public static function searchCurrents(){
        $query = AvisosTablon::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
         $query->andWhere(['<','finicio',self::CarbonNow()->format(\common\helpers\timeHelper::formatMysqlDateTime())])
                 ->andWhere(['>','ftermino',self::CarbonNow()->format(\common\helpers\timeHelper::formatMysqlDateTime())]);
         return $dataProvider;
    }
}
