@extends('layouts.app')
<?php $current_page = 'Dashboard'; ?>
<!DOCTYPE html>
<html lang="en">
<?php
use App\Models\projects;
use App\Models\products;
use App\Models\User;
use App\Models\tasks;
use App\Models\posts;

$results = DB::table('posts')
    ->join('projects', function ($join) {
        $join->whereRaw("JSON_CONTAINS(projects.tasks, CONCAT('{\"task\": \"', posts.task_id, '\"}'))");
    })
    ->select('posts.name', DB::raw('SUM(JSON_EXTRACT(projects.tasks, CONCAT("$[", indices.idx, "].minutes"))) as total_minutes'), DB::raw('(SUM(JSON_EXTRACT(projects.tasks, CONCAT("$[", indices.idx, "].minutes"))) / 10080) as total_weeks'))
    ->join(DB::raw('(SELECT 0 AS idx UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS indices'), function ($join) {
        $join->whereRaw('JSON_EXTRACT(projects.tasks, CONCAT("$[", indices.idx, "].task")) = posts.task_id');
    })
    ->groupBy('posts.name')
    ->get();
$counts = [];
for ($i = 1; $i <= 12; $i++) {
    $month = str_pad($i, 2, '0', STR_PAD_LEFT);
    $count = projects::whereMonth('delivery_date', '=', $month)
        ->where('status', '=', 'Completed')
        ->count();
    $counts[$i - 1] = $count;
}
$counts2 = [];
for ($i = 1; $i <= 12; $i++) {
    $month = str_pad($i, 2, '0', STR_PAD_LEFT);
    $count2 = projects::whereMonth('delivery_date', '=', $month)
        ->where('status', '=', 'In Progress')
        ->count();
    $counts2[$i - 1] = $count2;
}

?>


<head>

    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

    <meta charset="utf-8" />

    <link rel="icon" type="image/png" href="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Dashboard </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        window.onload = function() {

            var chart = new CanvasJS.Chart("chartContainer", {

                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "Hours Per Post"
                },

                toolTip: {
                    shared: true
                },
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries
                },

                data: [{
                        type: "column",
                        name: "total hours per week",
                        showInLegend: true,
                        dataPoints: [
                            <?php foreach ($results as $result) {
                                $weeks = intval($result->total_weeks);
                                echo "{label: '$result->name', y: " . round($result->total_minutes / 60 / $weeks, 2) . '},';
                            } ?>
                        ]
                    },
                    {
                        type: "area",
                        name: "Total weeks",
                        markerBorderColor: "white",
                        markerBorderThickness: 2,
                        showInLegend: true,
                        dataPoints: [
                            <?php foreach ($results as $result) {
                                $weeks = intval($result->total_weeks);
                                echo "{label: '$result->name', y: $weeks},";
                            } ?>
                        ]
                    }
                ]



            });
            chart.render();

            function addSymbols(e) {
                var suffixes = ["", "K", "M", "B"];
                var order = Math.max(Math.floor(Math.log(Math.abs(e.value)) / Math.log(1000)), 0);

                if (order > suffixes.length - 1)
                    order = suffixes.length - 1;

                var suffix = suffixes[order];
                return CanvasJS.formatNumber(e.value / Math.pow(1000, order)) + suffix;
            }

            function toggleDataSeries(e) {
                if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }
                e.chart.render();
            }

        }
    </script>



</head>



<body>
    @section('content')
        <div class="container-scroller">

            @include('layouts.nav')
            <!-- partial -->
            <div class="container-fluid page-body-wrapper">
                <!-- partial:partials/_sidebar.html -->
                @include('layouts.navBar')
                <!-- partial -->
                <div class="main-panel">
                    <div class="content-wrapper">
                        <div class="page-header">
                            <h3 class="page-title">
                                <span class="page-title-icon bg-gradient-primary text-white me-2">
                                    <i class="mdi mdi-home"></i>
                                </span> Dashboard
                            </h3>

                        </div>

                    
                            <div class="col-md-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Monthly Statistics for 2023</h4>
                                        <canvas id="areachart-multi" style="height: 370px; width: 100%;"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">General Statistics</h4>
                                            <canvas id="barChart" style="height:230px"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- content-wrapper ends -->
                            <!-- partial -->
                        </div>
                        <!-- main-panel ends -->
                    </div>
                    <!-- page-body-wrapper ends -->
                </div>

                <!-- container-scroller -->

                <!-- End custom js for this page -->
            @endsection
</body>

</html>
<script></script>
