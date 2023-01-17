<!DOCTYPE html>
<!--
Landing page based on Pratt: http://blacktie.co/www/pratt/
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Nasable">
    <meta name="author" content="Sergi Tur Badenas - acacha.org">

    <meta property="og:title" content="Nasable" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="Nasable" />
    <meta property="og:url" content="http://www.Nasable.org/" />
    <meta property="og:image" content="http://www.Nasable.org/img/AcachaNasable.png" />
    <meta property="og:image" content="http://www.Nasable.org/img/AcachaNasable600x600.png" />
    <meta property="og:image" content="http://www.Nasable.org/img/AcachaNasable600x314.png" />
    <meta property="og:sitename" content="www.Nasable.org" />
    <meta property="og:url" content="http://www.Nasable.org" />

    <title>Nasable</title>

    <!-- Custom styles for this template -->
    <link href="{{asset('dist/css/all-landing.css')}}" rel="stylesheet">

    <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>

</head>

<body data-spy="scroll" data-target="#navigation" data-offset="50">

<div id="app" v-cloak>
    <!-- Fixed navbar -->
    <div id="navigation" class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><b>Nasable</b></a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#home" class="smoothScroll">Nasable</a></li>
                    <li><a href="#desc" class="smoothScroll">Nasable</a></li>
                    <li><a href="#showcase" class="smoothScroll">Nasable</a></li>
                    <li><a href="#contact" class="smoothScroll">Nasable</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    
                        <li><a href="{{ url('/login-form') }}">Log in</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    
                        <li><a href="/home"></a></li>
                    
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>


    <section id="home" name="home">
        <div id="headerwrap">
            <div class="container">
                <div class="row centered">
                    <div class="col-lg-12">
                        <h1>Nasabel<b><a href="https://github.com/acacha/Nasable-laravel">Nasabel</a></b></h1>
                        <h3>A <a href="https://laravel.com/">Laravel</a> {{ trans('Nasable_lang::message.laravelpackage') }}
                            scaffolding/boilerplate {{ trans('Nasable_lang::message.to') }} <a href="https://almsaeedstudio.com/preview">Nasable</a> {{ trans('Nasable_lang::message.templatewith') }}
                            <a href="http://getbootstrap.com/">Bootstrap</a> 3.0 {{ trans('Nasable_lang::message.and') }} <a href="http://blacktie.co/www/pratt/">Pratt</a> Landing page</h3>
                        <h3><a href="{{ url('/register') }}" class="btn btn-lg btn-success">{{ trans('Nasable_lang::message.gedstarted') }}</a></h3>
                    </div>
                    <div class="col-lg-2">
                        <h5>{{ trans('Nasable_lang::message.amazing') }}</h5>
                        <p>{{ trans('Nasable_lang::message.basedNasable') }}</p>
                        <img class="hidden-xs hidden-sm hidden-md" src="{{ asset('/img/arrow1.png') }}">
                    </div>
                    <div class="col-lg-8">
                        <img class="img-responsive" src="{{ asset('/img/app-bg.png') }}" alt="">
                    </div>
                    <div class="col-lg-2">
                        <br>
                        <img class="hidden-xs hidden-sm hidden-md" src="{{ asset('/img/arrow2.png') }}">
                        <h5>{{ trans('Nasable_lang::message.awesomepackaged') }}</h5>
                        <p>... {{ trans('Nasable_lang::message.by') }} <a href="http://acacha.org/sergitur">Sergi Tur Badenas</a> {{ trans('Nasable_lang::message.at') }} <a href="http://acacha.org">acacha.org</a> {{ trans('Nasable_lang::message.readytouse') }}</p>
                    </div>
                </div>
            </div> <!--/ .container -->
        </div><!--/ #headerwrap -->
    </section>
