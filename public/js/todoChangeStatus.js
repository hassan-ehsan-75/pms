 $(document).ready(function(){
    $('#status-options').hide();
    var temp;
    var todo_id=0;
    $('.todo-status').css({
      'cursor':'pointer',
    });
    $('#status-options').css({
      'cursor':'pointer',
    });

    $('.todo-status').on('click','small',function(){
      
      temp=$(this).parent();
      console.log(temp);
      todo_id=$(this).parent().children(':input').val();
      

      $("#status-options").css({
        'position':'absolute',
            'left':$(this).offset().left -250,
            'top': $(this).offset().top + $(this).height()-45,
             
    });

    $('#status-options').toggle('slow/400/fast'); 
});
    $('#status-options').children('option').click(function(){

       
      $('#status-options').hide('slow/400');
      var status=$(this).text();
      var url='http://dev101.nasable.com/changeToDoStatus'+'?todo_id='+todo_id+'&status='+status;
      $.get(url,function(data)
      {
        if(data.message=="updated")
          {
            console.log(status);
            if (status == "NOT_STARTED")
              temp.html(
                    '<small class="label label-danger">'+
                    '<i class="fa fa-ban" aria-hidden="true"></i>'+status+'</small>'+
                    '<input type="hidden" name="todo_id" value="'+todo_id+'" >');

                  else if (status == "ONGOING")
                    temp.html('<small class="label label-success">'+
                      '<i class="fa fa-spinner" aria-hidden="true"></i>'+status+'</small>'+
                      '<input type="hidden" name="todo_id" value="'+todo_id+'" >');
                  else if (status == "POSTPONED")
                    temp.html('<small class="label label-warning">'+
                  '<i class="fa fa-pause" aria-hidden="true"></i>'+status+'</small>'+
                  '<input type="hidden" name="todo_id" value="'+todo_id+'" >');
                  else if (status == "DONE")
                    temp.html('<small class="label label-success">'+
                  '<i class="fa fa-check" aria-hidden="true"></i>'+status+'</small>'+
                  '<input type="hidden" name="todo_id" value="'+todo_id+'" >');
          }
      });
    });

    });