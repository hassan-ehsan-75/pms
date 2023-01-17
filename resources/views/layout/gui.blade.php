<?php
$_PROJECT_NAME='RS4IT Inside';
$_VERSION='1.0';
$_YEAR='2017-2018';
$_COMPANY_NAME='RS4IT';
$_COMPANY_WEB='http://www.rs4it.com';


/* Default values */

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $_PROJECT_NAME;?> | <?php echo $_PAGE_TITLE;?> </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{asset('dist/css/skins/skin-blue.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/nasable.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/fullcalendar/fullcalendar.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('plugins/iCheck/flat/blue.css')}}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{asset('plugins/morris/morris.css')}}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{asset('plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">

<link rel="apple-touch-icon" sizes="180x180" href="{{asset('apple-touch-icon.png')}}">
<link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicon-32x32.png')}}">
<link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicon-16x16.png')}}">
<link rel="manifest" href="/manifest.json">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
<meta name="theme-color" content="#ffffff">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

<!-- latest jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
</script>
</head>
<body class="hold-transition  skin-blue sidebar-mini fixed">

<!-- flash messages -->



<!-- end flash messages -->

<div class="wrapper">
<header class="main-header ">
  <!-- Logo -->
  <a href="{{ route('dashboard') }}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>N</b></span>
    <!-- logo for regular state and mobile devices -->
  <span class="logo-lg"><img src="{{asset('img/nasable_logo.png')}}" style="width: 95%"/></span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
      <!-- notifications -->
        @include('layout.notifications')
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-list-alt"></i>
              <span class="label label-success">{{count(\App\ToDo::where('assigned_to',Auth::user()->id)->where('status','!=',"DONE")->get())}}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">you have {{count(\App\ToDo::where('assigned_to',Auth::user()->id)->where('status','!=',"DONE")->get())}} Not DONE TODOs</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                
                @foreach(\App\ToDo::where('assigned_to',Auth::user()->id)->where('status','!=',"DONE")->get() as $todo )
                  <li><!-- start message -->
                    <a href="{{route('todo.show',$todo->id)}}">
                      <div class="pull-left">
                        <img src="{{asset($todo->task->project->getAttachment())}}" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        {{$todo->task->project->title}}
                        <small><i></i> {{$todo->status}}</small>
                      </h4>
                      <p>
                          <?php $todo_sum=strip_tags(html_entity_decode($todo->description));
                        if (strlen($todo_sum)>40){
                            $todo_sum=substr($todo_sum,0,40).'...';
                        }
                        echo $todo_sum;

                        ?>
                      </p>
                    </a>
                  </li>
                  <!-- end message -->
                  @endforeach
                </ul>
              </li>
              <li class="footer"><a href="{{route('todo.index','user_todo')}}">See All Todos</a></li>
            </ul>
          </li>

        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<span class="hidden-xs"> {{Auth::user()->full_name}}</span>
            <img src="{{asset(Auth::user()->getAttachment())}}" class="img-circle" height="20" alt="User Image">
            {{-- expr --}}

           
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">

              <img src="{{asset(Auth::user()->getAttachment())}}" class="img-circle"  alt="User Image">
              {{-- expr --}}


              <p>
                {{Auth::user()->full_name}} - {{Auth::user()->getTitle()}}
                @if (Auth::user()->created_at!=null)
                  {{-- expr --}}

                <small>Member since {{Auth::user()->created_at->toformattedDateString()}}</small>
              @endif
              </p>
            </li>
            <!-- Menu Body -->
            <li class="user-body">
              <div class="row">
                <div class="col-xs-4 text-center">
                  <span class="badge bg-green"><a href="{{route('project.index')}}"> <i class="fa fa-tasks" aria-hidden="true"></i>
                  <span class="badge bg-green">{{count(\App\Project::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->get())}}</span></a></span>
                </div>
                <div class="col-xs-4 text-center">
                  <span class="badge bg-aqua"><a href="{{route('task.index','all')}}"> <i class="fa fa-thumb-tack" aria-hidden="true"></i>
                 <span class="badge bg-aqua"> {{count(\App\Task::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->get())}}</span> </a></span>
                </div>
                <div class="col-xs-4 text-center">
                  <span class="badge bg-yellow"><a href="{{route('discussion.index')}}"><i class="fa fa-comment" aria-hidden="true"></i>
                  <span class="badge bg-yellow">{{count(\App\Discussion::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->get())}}</span></a></span>

                </div>
              </div>
              <!-- /.row -->
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="{{route('user.profile',Auth::user()->id)}}" class="btn btn-default btn-flat">Profile</a>
              </div>
              <div class="pull-right">
                <a href="{{route('user.logout')}}" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
            </li>
          </ul>
        </li>



      </ul>
    </div>
  </nav>
</header>



  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar ">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar fixed" style="height: auto;">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset(Auth::user()->getAttachment())}}" class="img-circle" alt="User Image">


        </div>
        <div class="pull-left info">
          <a href="{{route('user.profile',Auth::user()->id)}}"><p>{{Auth::user()->full_name}}</p></a>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="{{ route('search') }}" method="post" class="sidebar-form">
        {{csrf_field()}}
        <div class="input-group">
          <input type="text" name="search_query" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class=" treeview">
          <a href="{{route('dashboard')}}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>


          <li class=" treeview">
            <a href="{{route('user.index')}}">
              <i class="fa fa-user"></i> <span>Users</span>
               <small class="label pull-right bg-blue">{{\App\User::where('id','!=',2)->count()}}</small>
            </a>
          </li>

          <li >
            <a href="{{route('project.index')}}">
              <i class="fa fa-edit"></i> <span>Projects</span>
               <small class="label pull-right bg-blue">{{\App\Project::all()->count()}}</small>
              </a>
            </li>

             <li>
          <a href="{{route('calendar')}}">
            <i class="fa fa-calendar"></i> <span>Calendar</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-red">{{\App\Task::where('priority','High')->count()}}</small>
              <small class="label pull-right bg-yellow">{{\App\Task::where('priority','Normal')->count()}}</small>
              <small class="label pull-right bg-green">{{\App\Task::where('priority','Low')->count()}}</small>
            </span>
          </a>
        </li>
                <li class=" treeview">
          <a href="{{route('title.index')}}">
            <i class="fa  fa-file-text-o "></i> <span>Titles</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
            <li>
             <a href="{{asset('wiki/')}}">
              <i class="fa fa-wikipedia-w" aria-hidden="true"></i><span>Wiki</span>
               </a>
             </li>

             @if (Auth::user()->hasPermission('Admin') || Auth::user()->hasPermission('Manger'))
               {{-- expr --}}
		
              <li class="treeview">
			  <a href="#">
			    <i class="fa fa-cog"></i>
			  <span>Admin Tools</span>
			  <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
			  </a>
			  	<ul class="treeview-menu">
				<li>
             <a href="{{route('apiToken.index')}}">
               <i class="fa fa-circle" aria-hidden="true"></i> <span>Api Tokens</span>
               </a>
             </li>
			  <li >
             <a href="{{route('job.index')}}">
               <i class="fa fa-briefcase" aria-hidden="true"></i> <span>Jobs</span>
               </a>
			   
             </li>
			 
			   <li>
            <a href="{{route('news.index')}}">
              <i class="fa fa-newspaper-o"></i> <span>News</span>
              </a>
            </li>
			
			<li>
             <a href="{{route('attachment.index')}}">
               <i class="fa fa-paperclip" aria-hidden="true"></i> <span>Attachments</span>
               </a>
             </li>
			 
			 <li>
            <a href="{{route('announcement.index')}}">
              <i class="fa  fa-bullhorn"></i> <span>Announcments</span>
              </a>
            </li>
			 
			 </ul>
            @endif

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <div class="container-fluid">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <!--h1>
        <?php echo $_PAGE_TITLE;?>
        <small><?php echo $_PAGE_SUB_TITLE; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo $_PAGE_TITLE; ?></li>
      </ol-->
       @include('layout.flash', ['some' => 'data'])
      @yield('content')
      @include('layout.errors')
    </section>
	</div>
</div>

<!-- content will go here NasAbleContent-->

<!-- /.content-wrapper -->

<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Version</b> <?php echo $_VERSION; ?>
  </div>
  <strong>Copyright &copy; <?php echo $_YEAR; ?> <a href="<?php echo $_COMPANY_WEB; ?>"><?php echo $_COMPANY_NAME; ?></a>.</strong> All rights
  reserved.
</footer>

</div>
</body>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="{{asset('plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
<!-- Morris.js charts -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{asset('plugins/morris/morris.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('plugins/sparkline/jquery.sparkline.min.js')}}"></script>
<!-- jvectormap -->
<script src="{{asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('plugins/knob/jquery.knob.js')}}"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- datepicker -->
<script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{asset('plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('plugins/fastclick/fastclick.js')}}"></script>

<!-- AdminLTE App -->
<script src="{{asset('dist/js/app.min.js')}}"></script>
<script src="{{asset('plugins/fullcalendar/fullcalendar.js')}}"></script>


<script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>

<script src="{{ asset('js/main.js') }}"></script>


</html>
