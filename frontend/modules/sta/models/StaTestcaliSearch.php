<?php

namespace frontend\modules\sta\models;
use yii\data\ActiveDataProvider;
use frontend\modules\sta\models\StaTestcali;
//use common\models\masters\Trabajadores;
use yii\base\Model;
/**
 * This is the ActiveQuery class for [[StaVwCitas]].
 *
 * @see StaVwCitas
 */
class StaTestcaliSearch extends StaTestcali
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


    public function searchByTest($codtest)
    {
        $query = StaTestcali::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>false,
        ]);

         $query->Where(['codtest'=> $codtest]);
        return $dataProvider;
    }
    
    public function searchByTestSimple($codtest)
    {
        $query = StaTestcali::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>false,
            //'header'=>false,
        ]);

         $query->Where(['codtest'=> $codtest]);
        return $dataProvider;
    }
    
}
