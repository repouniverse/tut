<?php

namespace frontend\modules\sigi\models;

use Yii;

/**
 * This is the model class for table "{{%sigi_lecturas}}".
 *
 * @property int $id
 * @property int $suministro_id
 * @property int $unidad_id
 * @property string $codepa
 * @property string $mes
 * @property string $flectura
 * @property string $hlectura
 * @property string $lectura
 * @property string $lecturaant
 * @property string $delta
 *
 * @property SigiSuministros $suministro
 */
class SigiLecturasTemp extends SigiLecturas
{
    
   
      public function rules()
    {
        return [
            ];
    }
 public function scenarios()
    {
        $scenarios = parent::scenarios(); 
        return $scenarios;
    }
    public static function tableName()
    {
        return '{{%sigi_temp_lecturas}}';
    }

}
