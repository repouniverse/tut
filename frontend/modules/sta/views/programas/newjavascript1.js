 "$(\"div[id='grid_docu'] [family='pinke']\").on( 'click', function() { 
    var resulta;
   var identi=this.id;
  
 var promesa1= $.ajax({
          url : this.title,
          type : 'GET', 
          data : {}, 
          dataType: 'json', 
          success : function(json) {
                            resulta1=json['success'];
                                                  
                     }, //fin funcion success ajax 1
                    error : function(xhr,errmsg,err) {
                     console.log(xhr.status + ': ' + xhr.responseText);
                            } //fin de funcion  error ajax 1
        });//fin de ajax 1
  
 var promesa2=promesa1.then(function(){    
         $.ajax({
      url : 'http://export.highcharts.com/',
      type : 'POST', 
     data : resulta1, 
     success : function(data) {
      resulta2=data; 
               },
             error : function(xhr,errmsg,err) {
             console.log(xhr.status + ': ' + xhr.responseText);                                                                                }
           }); 
       });
       
    promesa2.then(function(){
 $.ajax({
            url : '".\yii\helpers\Url::to(['citas/report-inf-psicologico','id'=>0])."',
            type : 'GET',
            data :  {urlimagen: resulta2,identidad:identi},
            success: function(data2){
            $.pjax.reload({container: '#grid_docu',timeout:3000});
                 console.log(data2); // Debería imprimir {ajax2: true}
                        },
               error : function(xhr,errmsg,err) {
                         console.log(xhr.status + ': ' + xhr.responseText);
                      }
                 });
    });
  
  
  
  
  
  var resulta;
   var identi=this.id;
  
 var promesa1= $.ajax({
          url : this.title,
          type : 'GET', 
          data : {}, 
          dataType: 'json', 
          success : function(json) {
                            resulta1=json['success'];
                                                  
                     }, //fin funcion success ajax 1
                    error : function(xhr,errmsg,err) {
                     console.log(xhr.status + ': ' + xhr.responseText);
                            } //fin de funcion  error ajax 1
        });//fin de ajax 1
  
 var promesa2=promesa1.then(function(){    
         $.ajax({
      url : 'http://export.highcharts.com/',
      type : 'POST', 
     data : resulta1, 
     success : function(data) {
      resulta2=data; 
               },
             error : function(xhr,errmsg,err) {
             console.log(xhr.status + ': ' + xhr.responseText);                                                                                }
           }); 
       });
       
    promesa2.then(function(){
 $.ajax({
            url : '".\yii\helpers\Url::to(['citas/report-inf-psicologico','id'=>0])."',
            type : 'GET',
            data :  {urlimagen: resulta2,identidad:identi},
            success: function(data2){
            $.pjax.reload({container: '#grid_docu',timeout:3000});
                 console.log(data2); // Debería imprimir {ajax2: true}
                        },
               error : function(xhr,errmsg,err) {
                         console.log(xhr.status + ': ' + xhr.responseText);
                      }
                 });
    });
  
  
  
  
  
  
  
  
  
  
  $.ajax({
          url : this.title,
          type : 'GET', 
          data : {}, 
          dataType: 'json', 
          success : function(json) {
                            resulta1=json['success'];
                                                 $.ajax({
                                                    url : 'http://export.highcharts.com/',
                                                     type : 'POST', 
                                                     data : resulta1, 
                                                        success : function(data) {
                                                            resulta2=data;
                                                                            $.ajax({
                                                                                url : '".\yii\helpers\Url::to(['citas/report-inf-psicologico','id'=>0])."',
                                                                                type : 'GET',
                                                                                data :  {urlimagen: resulta2,identidad:identi},
                                                                                 success: function(data2){
                                                                                  $.pjax.reload({container: '#grid_docu',timeout:3000});
                                                                                    console.log(data2); // Debería imprimir {ajax2: true}
                                                                                      },
                                                                                error : function(xhr,errmsg,err) {
                                                                                console.log(xhr.status + ': ' + xhr.responseText);
                                                                                        }
                                                                                });
              
                                                                },

                                                            error : function(xhr,errmsg,err) {
                                                            console.log(xhr.status + ': ' + xhr.responseText);
                                                                                }
                                                        });     
                     }, //fin funcion success ajax 1
                    error : function(xhr,errmsg,err) {
                     console.log(xhr.status + ': ' + xhr.responseText);
                            } //fin de funcion  error ajax 1
        });//fin de ajax 1


    
});
