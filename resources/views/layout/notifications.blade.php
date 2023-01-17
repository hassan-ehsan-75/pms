<li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" >
                 <i class="fa fa-bell-o"></i>
              <span class="label label-warning"> {{$count}} </span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">you have {{$count}}  unread events</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                
  @foreach ($events as $event)

  <li @if (!empty(App\UserEvent::where('event_id',$event->id)->where('user_id',auth()->id())->first()))
                        class="list-group-item-info" 
                      @endif><!-- start message -->
                    <a href="{{url($event->link_id)}}"
                      
                      >

                      <div class="pull-left">
                    
		    <img src="{{ asset($event->user->getAttachment()) }}" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                           {{$event->user->full_name }}
                        <small><i class="fa fa-clock-o"></i> {{$event->created_at->diffForHumans()}}</small>
                      </h4>
                      <p>
has {{$event->type}} a {{$event->content_type}} <b> {{strip_tags(html_entity_decode($event->title))}}</b>
</p>
                    <input type="hidden" id="event_id" value="{{$event->id}}">
                    </a>
                  </li>
                  <!-- end message -->

                  @endforeach
                </ul>
              </li>
                 <li class="footer"><a href="{{ route('event.index') }}">View all</a>
                  <li class="footer"><a href="{{ route('event.allAsRead') }}">mark all as read</a>
                 </li>
            </ul>
          </li>

          <script>

            $(document).ready(function(){
              console.log('jquery works!!');
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
          </script>
