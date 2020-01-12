@extends('layouts.app')

@section('head')
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
    title: {
        text: "register user of week"
    },
    axisY: {
        title: "Number of users"
    },
    data: [{
        type: "line",
        dataPoints:  {!! $jsonData !!}
    }]
});
chart.render();

}
</script>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
@endsection
