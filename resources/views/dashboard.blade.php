@extends('adminlte::page')

@section('title', 'Analytics Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('css')
     <style type="text/css">
		@font-face 
		{
    		font-family: 'kiona';
     		src: url('{{ public_path('fonts/Kiona-Regular.ttf') }}');
		}
		p, h2
		{
			font-family: Book Antiqua;
			text-align: center;
			font-size: 1.5em;
			font-style: bold;
		}
		h1
		{
			font-family: Georgia;
			font-size: 0.75em;	
		}
		.content
		{
			display: flex;
			flex-wrap: wrap;
		}
		.content div
		{
			transition: transform .2s;
			height: 100%;
		}
		.content div:hover
		{
			transform: scale(1.05);
		}
		#pieChartDiv
		{
			width: 40%;
			height: auto;
		}
		#pieChart
		{
			height: 100%;
		}
		#lineChartDiv
		{
			width: 53%;
			height: auto;
		}
		#numberOfParkingSpaces, #averageRentTime, #averageSearchTime
		{
			font-size: 1.75em;	
		}
		#numberOfParkingSpacesDiv, #averageSearchTimeDiv, #averageRentTimeDiv
		{
			height: auto;
			padding: 20px;
		}
	</style>
@stop

@section('content')
	<div id = "pieChartDiv" >
		<p> User Searches by Areas (Per Day) </p>
		<canvas id = "pieChart"> </canvas>
	</div>
	<div id = "lineChartDiv" class = ".col-md-4">
		<p> User Searches by Hours </p>
		<canvas id="lineChart"> </canvas>
	</div>
	<div id = "numberOfParkingSpacesDiv">
		<h2> Parking Spaces Rented Today: </h2>
		<p id = "numberOfParkingSpaces"> <bold> 106 </bold> </p>
	</div>
	<div id = "averageSearchTimeDiv">
		<h2> Average Search Time Today: </h2>
		<p id = "averageSearchTime"> <bold> 45 s </bold> </p>
	</div>
	<div id = "averageRentTimeDiv">
		<h2> Average Rent Time Today: </h2>
		<p id = "averageRentTime"> <bold> 3 h </bold> </p>
	</div>
@stop

@section('js')
    <script> 
    	//pie
  		var ctxP = document.getElementById("pieChart").getContext('2d');
	  	var myPieChart = new Chart(ctxP, {
	    type: 'pie',
	    data: {
	      labels: ["Centru", "Sector 1", "Sector 2", "Sector 3", "Sector 4", "Sector 5", "Sector 6"],
	      datasets: [{
	        data: [300, 50, 100, 40, 120, 45, 150],
	        backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1", "#4D5360", "#008ae6", "#d279a6"],
	        hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5", "#616774", "#1aa3ff", "#df9fbf"]
	      }]
	    },
	    options: {
	      responsive: true
	    }
	  });
	  	//line
  var ctxL = document.getElementById("lineChart").getContext('2d');
  var myLineChart = new Chart(ctxL, {
    type: 'line',
    data: {
      labels: ["00 - 05", "06 - 09", "10 - 13", "14 - 16", "17 - 20", "21 - 00"],
      datasets: [
      	{
      	  label: "28/02/2019 (Thursday)",
          data: [12, 61, 41, 30, 53, 19],
          backgroundColor: [
            'rgba(0, 115, 230, .2)',
          ],
          borderColor: [
            '#0073e6',
          ],
          borderWidth: 2
      	},
      	{
          label: "01/03/2019 (Friday)",
          data: [20, 59, 47, 36, 56, 32],
          backgroundColor: [
            'rgba(77, 184, 255, .2)',
          ],
          borderColor: [
            '#4db8ff',
          ],
          borderWidth: 2
        },
        {
          label: "02/03/2019 (Saturday)",
          data: [20, 17, 32, 41, 43, 50],
          backgroundColor: [
            'rgba(51, 51, 204, .2)',
          ],
          borderColor: [
            '#3333cc',
          ],
          borderWidth: 2
        }
      ]
    },
    options: {
      responsive: true
    }
  });
    </script>
@stop