
            $(document).ready(function(){

              $('a').click(function(e){
                //get the vent id
                var event_id=$(this).children('#event_id').val();
                var url='{{ url('markAsRead') }}'+'?event_id='+event_id;
                //make a request to the server
                $.get(url,function(data,message)
                {
                  if(data.message=='deleted')
                    console.log('deleted successuflly');
                });
                
               
              });

            });