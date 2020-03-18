<?php
namespace frontend\modules\sta\models;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sta\models\Aluriesgo;

/**
 * AlumnosController represents the model behind the search form of `frontend\modules\sta\models\Alumnos`.
 */
class AluriesgoSearch extends Aluriesgo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['entrega_id', 'programa_id','nveces','nveces15'], 'integer'],
            [['codcar', 'codcur', 'codalu','codperiodo', 'status', 'codfac'], 'safe'],
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
    public function getAlumno()
    {
        return $this->hasOne(Alumnos::className(), ['codalu'=> 'codalu']);
    }
    
    public function search($params)
    {
        $query = Aluriesgo::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination'=>['pageSize '=>10]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
       /* $query->andFilterWhere([
            'id' => $this->id,
            'profile_id' => $this->profile_id,
        ]);*/

        $query->andFilterWhere(['like', 'codcar', $this->codcar])
            ->andFilterWhere(['like', 'ap', $this->codcur])            
          ;

        return $dataProvider;
    }
    
     public function searchByIncorporado($params)
    {
        $query = Aluriesgo::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination'=>['pageSize '=>10]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
       /* $query->andFilterWhere([
            'id' => $this->id,
            'profile_id' => $this->profile_id,
        ]);*/

        $query->andFilterWhere(['status'=>'I'])
                ->andFilterWhere(['like', 'codcar', $this->codcar])
            ->andFilterWhere(['like', 'ap', $this->codcur])            
          ;

        return $dataProvider;
    }
    public function searchByPeriodoAlumno(){
        
    }
    
}
