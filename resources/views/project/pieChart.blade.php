
<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
  <script src="http://cdn.oesmith.co.uk/morris-0.4.1.min.js"></script>
<meta charset=utf-8 />
<div class="row">
	
<div class="col-sm-8">

<div id="chart"></div>

</div>

<div class="col-sm-4">
		<h5><span class="label finished">{{$doneTodos}}</span> FINISHED TODOs</h5>
		<br>
		<h5><span class="label ongoing"> {{$onGoing}}</span> ONGOING TODOs</h5>
		<br>
		<h5><span class="label notstarted"> {{$notStarted}} </span>  Not STARTED TODOs</h5>
		<br>
		<h5><span class="label postponed"> {{$postPoned}} </span> POSTPONED TODOs</h5>
	</div>
<script >
	Morris.Donut({
		element:'chart',
		data:[
		{label:"Finsihed Todos",value:{{$doneTodos}} },
		{ label: "onGoing",value: {{$onGoing}} },
		{label:"notStarted",value: {{$notStarted}} },
		{ label:"postPoned",value: {{$postPoned}} }
		],
		colors:['#3366ff','#008000','#cc0000','#ffcc00']
	});
</script>
<style>
		.finished{
		background-color:#3366ff ;
	}
	.ongoing{
		background-color: #008000;
	}
	.notstarted{
		background-color:#cc0000; 
	}
	.postponed{
		background-color: #ffcc00;
	}
</style>