function notificaexamen(){ 
    $.ajax(
            { 
         url: '/frontend/web/sta/citas/notifica-examen-digital',
         type: 'get',
         data:{id:3,idalu:28646},
         dataType: 'json',
         error: function(xhr, textStatus, error){ 
             var n = Noty('id'); 
             $.noty.setText(n.options.id, error);
             $.noty.setType(n.options.id, 'error'); 
         },
         success: function(json) {
             var n = Noty('id');
             if ( !(typeof json['error']==='undefined') )
             { $.noty.setText(n.options.id,' '+ json['error']);
                 $.noty.setType(n.options.id, 'error'); 
             } 
             if ( !(typeof json['warning']==='undefined' )) {
                 $.noty.setText(n.options.id,' '+ json['warning']);
                 $.noty.setType(n.options.id, 'warning'); } 
             if ( !(typeof json['success']==='undefined' )) {
                 $.noty.setText(n.options.id,' '+ json['success']);
                 $.noty.setType(n.options.id, 'success'); } 
         } }
             ); }