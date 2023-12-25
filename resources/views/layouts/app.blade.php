<?php
use App\Models\posts;
use App\Models\projects;
use App\Models\tasks;
use App\Models\products;
use App\Models\User;
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
// *********************************************************************************************

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
$comp = projects::where('status', '=', 'Completed')
    ->get()
    ->count();
$prog = projects::where('status', '=', 'In Progress')
    ->get()
    ->count();

$projects = projects::all();
$projectNames = [];
$projectMinutes = [];

foreach ($projects as $project) {
    $projectNames[] = $project->name;
    $task_strs = explode(', ', $project->tasks);
    $total_minutes = 0;
    $task_strs = json_decode($project->tasks);
    foreach ($task_strs as $task_str) {
        $total_minutes += (int) $task_str->minutes;
    }
    $projectMinutes[] = $total_minutes;
}
$projectCount = projects::all()->count();
$tasksCount = tasks::all()->count();
$productsCount = products::all()->count();
$usersCount = User::where('role', '!=', 'admin')
    ->get()
    ->count();
?>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>


    <link rel="stylesheet" href="../../assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="../../assets/images/favicon.ico" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GPAO') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        .table thead th {
            color: black;
            font-weight: bold
        }
    </style>
</head>

<body>

    <div id="app">
        @yield('content')
    </div>
</body>
<!-- plugins:js -->
<script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="../../assets/js/jquery.cookie.js" type="text/javascript"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="../../assets/js/hoverable-collapse.js"></script>
<script src="../../assets/js/misc.js"></script>
<!-- endinject -->
<!-- Custom js for this page -->
<script src="../../assets/js/dashboard.js"></script>
<script src="../../assets/js/todolist.js"></script>

<script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page -->

<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="../../assets/js/off-canvas.js"></script>
<script src="../../assets/js/hoverable-collapse.js"></script>
<script src="../../assets/js/misc.js"></script>
<!-- endinject -->
<!-- Custom js for this page -->
<script>
    function Search(input, data) {
        var input = document.getElementById(input);
        var filter = input.value.toLowerCase();
        var element = document.getElementsByClassName(data);


        for (i = 0; i < element.length; i++) {

            if (element[i].innerText.toLowerCase().includes(filter)) {
                element[i].style.display = "";


            } else {
                element[i].style.display = "none";

            }
        }
    }
</script>
<script>
    $(function() {
        /* ChartJS
         * -------
         * Data and config for chartjs
         */
        'use strict';
        var data = {
            labels: ["Projects", "Tasks", "Products", "Users"],
            datasets: [{
                label: 'Statistics',
                data: [<?php echo $projectCount ?>, <?php echo $tasksCount ?>, <?php echo $usersCount ?>, <?php echo $productsCount ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1,
                fill: false
            }]
        };
        var dataDark = {
            labels: ["2013", "2014", "2014", "2015", "2016", "2017"],
            datasets: [{
                label: '# of Votes',
                data: [10, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1,
                fill: false
            }]
        };
        var multiLineData = {
            labels: ["Projects", "Tasks", "Users", "Products"],
            datasets: [{
                    label: 'Projects',
                    data: [12, 19, 3, 5, 2, 3],
                    borderColor: [
                        '#587ce4'
                    ],
                    borderWidth: 2,
                    fill: false
                },
                {
                    label: 'Tasks',
                    data: [5, 23, 7, 12, 42, 23],
                    borderColor: [
                        '#ede190'
                    ],
                    borderWidth: 2,
                    fill: false
                },
                {
                    label: 'Users',
                    data: [15, 10, 21, 32, 12, 33],
                    borderColor: [
                        '#f44252'
                    ],
                    borderWidth: 2,
                    fill: false
                }
            ]
        };
        var options = {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            legend: {
                display: false
            },
            elements: {
                point: {
                    radius: 0
                }
            }

        };
        var optionsDark = {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    },
                    gridLines: {
                        color: '#322f2f',
                        zeroLineColor: '#322f2f'
                    }
                }],
                xAxes: [{
                    ticks: {
                        beginAtZero: true
                    },
                    gridLines: {
                        color: '#322f2f',
                    }
                }],
            },
            legend: {
                display: false
            },
            elements: {
                point: {
                    radius: 0
                }
            }

        };
        var doughnutPieData = {
            datasets: [{
                data: [30, 40, 30],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
            }],

            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: [
                'Pink',
                'Blue',
                'Yellow',
            ]
        };
        var doughnutPieOptions = {
            responsive: true,
            animation: {
                animateScale: true,
                animateRotate: true
            }
        };
        var areaData = {
            labels: ["2013", "2014", "2015", "2016", "2017"],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1,
                fill: true, // 3: no fill
            }]
        };

        var areaDataDark = {
            labels: ["2013", "2014", "2015", "2016", "2017"],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1,
                fill: true, // 3: no fill
            }]
        };

        var areaOptions = {
            plugins: {
                filler: {
                    propagate: true
                }
            }
        }

        var areaOptionsDark = {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    },
                    gridLines: {
                        color: '#322f2f',
                        zeroLineColor: '#322f2f'
                    }
                }],
                xAxes: [{
                    ticks: {
                        beginAtZero: true
                    },
                    gridLines: {
                        color: '#322f2f',
                    }
                }],
            },
            plugins: {
                filler: {
                    propagate: true
                }
            }
        }

        var multiAreaData = {
            labels: [

                @for ($i = 1; $i <= 12; $i++)
                    "{{ date('F', mktime(0, 0, 0, $i, 1)) }}",
                @endfor
            ],
            datasets: [{
                    label: 'Completed Projects',
                    data: [

                    @foreach($counts as $i => $count) 
                            '{{ $count }}',
                        @endforeach


                    ],
                    borderColor: ['rgba(255, 99, 132, 0.5)'],
                    backgroundColor: ['rgba(255, 99, 132, 0.5)'],
                    borderWidth: 1,
                    fill: true
                },
                {
                    label: 'Projects In Progress',
                    data: [
                        @foreach($counts2 as $i => $count2) 
                               '{{ $count2 }}',
                        @endforeach  
                    ],
                    borderColor: ['rgba(255, 206, 86, 0.5)'],
                    backgroundColor: ['rgba(255, 206, 86, 0.5)'],
                    borderWidth: 1,
                    fill: true
                },

            ]
        };

        var multiAreaOptions = {
            plugins: {
                filler: {
                    propagate: true
                }
            },
            elements: {
                point: {
                    radius: 0
                }
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        display: true
                    }
                }],
                yAxes: [{
                    gridLines: {
                        display: true
                    }
                }]
            }
        }

        var scatterChartData = {
            datasets: [{
                    label: 'First Dataset',
                    data: [{
                            x: -10,
                            y: 0
                        },
                        {
                            x: 0,
                            y: 3
                        },
                        {
                            x: -25,
                            y: 5
                        },
                        {
                            x: 40,
                            y: 5
                        }
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)'
                    ],
                    borderWidth: 1
                },
                {
                    label: 'Second Dataset',
                    data: [{
                            x: 10,
                            y: 5
                        },
                        {
                            x: 20,
                            y: -30
                        },
                        {
                            x: -25,
                            y: 15
                        },
                        {
                            x: -10,
                            y: 5
                        }
                    ],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1
                }
            ]
        }

        var scatterChartDataDark = {
            datasets: [{
                    label: 'First Dataset',
                    data: [{
                            x: -10,
                            y: 0
                        },
                        {
                            x: 0,
                            y: 3
                        },
                        {
                            x: -25,
                            y: 5
                        },
                        {
                            x: 40,
                            y: 5
                        }
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)'
                    ],
                    borderWidth: 1
                },
                {
                    label: 'Second Dataset',
                    data: [{
                            x: 10,
                            y: 5
                        },
                        {
                            x: 20,
                            y: -30
                        },
                        {
                            x: -25,
                            y: 15
                        },
                        {
                            x: -10,
                            y: 5
                        }
                    ],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1
                }
            ]
        }

        var scatterChartOptions = {
            scales: {
                xAxes: [{
                    type: 'linear',
                    position: 'bottom'
                }]
            }
        }

        var scatterChartOptionsDark = {
            scales: {
                xAxes: [{
                    type: 'linear',
                    position: 'bottom',
                    gridLines: {
                        color: '#322f2f',
                        zeroLineColor: '#322f2f'
                    }
                }],
                yAxes: [{
                    gridLines: {
                        color: '#322f2f',
                        zeroLineColor: '#322f2f'
                    }
                }]
            }
        }
        // Get context with jQuery - using jQuery's .get() method.
        if ($("#barChart").length) {
            var barChartCanvas = $("#barChart").get(0).getContext("2d");
            // This will get the first returned node in the jQuery collection.
            var barChart = new Chart(barChartCanvas, {
                type: 'bar',
                data: data,
                options: options
            });
        }

        if ($("#barChartDark").length) {
            var barChartCanvasDark = $("#barChartDark").get(0).getContext("2d");
            // This will get the first returned node in the jQuery collection.
            var barChartDark = new Chart(barChartCanvasDark, {
                type: 'bar',
                data: dataDark,
                options: optionsDark
            });
        }

        if ($("#lineChart").length) {
            var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
            var lineChart = new Chart(lineChartCanvas, {
                type: 'line',
                data: data,
                options: options
            });
        }

        if ($("#lineChartDark").length) {
            var lineChartCanvasDark = $("#lineChartDark").get(0).getContext("2d");
            var lineChartDark = new Chart(lineChartCanvasDark, {
                type: 'line',
                data: dataDark,
                options: optionsDark
            });
        }

        if ($("#linechart-multi").length) {
            var multiLineCanvas = $("#linechart-multi").get(0).getContext("2d");
            var lineChart = new Chart(multiLineCanvas, {
                type: 'line',
                data: multiLineData,
                options: options
            });
        }

        if ($("#areachart-multi").length) {
            var multiAreaCanvas = $("#areachart-multi").get(0).getContext("2d");
            var multiAreaChart = new Chart(multiAreaCanvas, {
                type: 'line',
                data: multiAreaData,
                options: multiAreaOptions
            });
        }

        if ($("#doughnutChart").length) {
            var doughnutChartCanvas = $("#doughnutChart").get(0).getContext("2d");
            var doughnutChart = new Chart(doughnutChartCanvas, {
                type: 'doughnut',
                data: doughnutPieData,
                options: doughnutPieOptions
            });
        }

        if ($("#pieChart").length) {
            var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
            var pieChart = new Chart(pieChartCanvas, {
                type: 'pie',
                data: doughnutPieData,
                options: doughnutPieOptions
            });
        }

        if ($("#areaChart").length) {
            var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
            var areaChart = new Chart(areaChartCanvas, {
                type: 'line',
                data: areaData,
                options: areaOptions
            });
        }

        if ($("#areaChartDark").length) {
            var areaChartCanvas = $("#areaChartDark").get(0).getContext("2d");
            var areaChart = new Chart(areaChartCanvas, {
                type: 'line',
                data: areaDataDark,
                options: areaOptionsDark
            });
        }

        if ($("#scatterChart").length) {
            var scatterChartCanvas = $("#scatterChart").get(0).getContext("2d");
            var scatterChart = new Chart(scatterChartCanvas, {
                type: 'scatter',
                data: scatterChartData,
                options: scatterChartOptions
            });
        }

        if ($("#scatterChartDark").length) {
            var scatterChartCanvas = $("#scatterChartDark").get(0).getContext("2d");
            var scatterChart = new Chart(scatterChartCanvas, {
                type: 'scatter',
                data: scatterChartDataDark,
                options: scatterChartOptionsDark
            });
        }

        if ($("#browserTrafficChart").length) {
            var doughnutChartCanvas = $("#browserTrafficChart").get(0).getContext("2d");
            var doughnutChart = new Chart(doughnutChartCanvas, {
                type: 'doughnut',
                data: browserTrafficData,
                options: doughnutPieOptions
            });
        }
    });
</script>

</html>
