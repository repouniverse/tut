<?php
namespace frontend\modules\sta\models;
use yii\data\ActiveDataProvider;
use yii\base\Model;
/**
 * This is the ActiveQuery class for [[StaVwCitas]].
 *
 * @see StaVwCitas
 */
class StaDocuAluSearch extends StaDocuAlu
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           [[
             'codocu',
         'talleresdet_id',              
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
   
    
     public function searchByTalleresdet($id)
    {
        $query = StaDocuAlu::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

         $query->Where(['talleresdet_id'=> $id]);
        return $dataProvider;
    }
    
}