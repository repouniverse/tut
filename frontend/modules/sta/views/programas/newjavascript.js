
$('div[id="grid_docu"] [family="pinke"]').on( 'click', function() { 
    var resulta;
     var promise = $.ajax({
          url : 'http://export.highcharts.com/',
          type : 'POST', 
          data : {dato:1}, 
          success : function(data) {

              resulta=data;

            },

          error : function(xhr,errmsg,err) {
            console.log(xhr.status + ': ' + xhr.responseText);
          }
        });
        
    promise.then(function(){
            //
                    $.ajax({
                url : 'case.itekron.com/valor',
                type : 'GET',
                data :  {urlimagen: resulta},
                success: function(data2){
                  console.log(data2); // Debería imprimir {ajax2: true}
                },
                error : function(xhr,errmsg,err) {
                  console.log(xhr.status + ': ' + xhr.responseText);
                }
              });
        //
        });    
    
    
    
});


