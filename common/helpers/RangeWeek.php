<?php
/*
 * Esta clase para ahorrar tiempo
 * Evitando escribir Yii::$app->
 */
namespace common\helpers;
use common\helpers\RangeDates;
use common\helpers\RangeDay;
use yii;


class RangeWeek extends RangeDay{
    
 public $carbonesDias=[];
   
  public function __construct(\Carbon\Carbon $carbon) {
      //$this->day=$carbon->dayOfWeek;
      $dates=[$carbon->copy()->startOfWeek(),$carbon->copy()->endOfWeek()];
      $this->setDates($dates);
      /*$this->carbonesDias[]=$this->initialDate;
      $this->carbonesDias[]=$this->initialDate->copy()->addDay(1);
      $this->carbonesDias[]=$this->initialDate->copy()->addDay(2);
      $this->carbonesDias[]=$this->initialDate->copy()->addDay(3);
      $this->carbonesDias[]=$this->initialDate->copy()->addDay(4);
      $this->carbonesDias[]=$this->initialDate->copy()->addDay(5);
      $this->carbonesDias[]=$this->initialDate->copy()->addDay(6);
      foreach($this->carbonesDias as $carbonDia){
          if(!is_null($carbonDia))
           $this->insertRange(New RangeDay($carbonDia));
      }*/
     parent::__construct($carbon);
     
  }
  
 
  
  
}
   
   
   
   

   


  
   
