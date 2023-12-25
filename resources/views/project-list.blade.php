@extends('layouts.app')
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Projects || SEARCH </title>
</head>

<body>
    @section('content')
        <div class="container-scroller">
            @include('layouts.nav')
            <div class="container-fluid page-body-wrapper">
                @include('layouts.navBar')
                <div class="main-panel">
                    <div class="content-wrapper">
                        <div class="page-header">
                            <h3 class="page-title">
                                <span class="page-title-icon bg-gradient-primary text-white me-2">
                                    <i class="fa fa-search"></i>
                                </span> Search
                            </h3>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h3>Showing projects from <span class="badge bg-success txt-light">
                                                {{ $startDate }} </span> to <span
                                                class="badge bg-info txt-light">{{ $endDate }} </span> </h3>

                                        <div class="table-responsive">
                                            <table class="table">
                                                <div class="input-group">
                                                    <div class="form-outline">
                                                        <input onkeyup="Search('input','data')" id="input"
                                                            type="search" placeholder="search" class="form-control" />
                                                    </div>
                                                    <button type="button" class="btn btn-primary">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div><br>
                                                <thead class=" text-primary">
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th> Start date</th>
                                                    <th> Delivery date</th>
                                                    <th> Tasks </th>
                                                    <th> Total minutes</th>
                                                    <th>Project Status</th>
                                                </thead>
                                                <tbody>
                                                    @if (count($projects) > 0)
                                                        @foreach ($projects as $project)
                                                            <tr class="data">
                                                                <td># {{ $project->id }}</td>
                                                                <td>{{ $project->name }}</td>
                                                                <td>{{ $project->start_date }}</td>
                                                                <td>{{ $project->delivery_date }}</td>
                                                                <td>
                                                                    <?php $tasks_names = json_decode($project->tasks);
                                                                    foreach ($tasks_names as $tasks_name) {
                                                                        $task_name = $tasks_name->task;
                                                                        echo '<span
                                                                                                                                                                                                                    class="badge bg-success text-light"> ' .
                                                                            $task_name .
                                                                            ' </span> ';
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td> <?php
                                                                
                                                                $total_minutes = 0;
                                                                $task_strs = json_decode($project->tasks);
                                                                foreach ($task_strs as $task_str) {
                                                                    $total_minutes += (int) $task_str->minutes;
                                                                }
                                                                echo $total_minutes;
                                                                ?></td>
                                                                <td>
                                                                    @if ($project->status == 'In Progress')
                                                                        <span
                                                                            class="badge bg-warning text-light">{{ $project->status }}</span>
                                                                    @endif
                                                                    @if ($project->status == 'Completed')
                                                                        <span
                                                                            class="badge bg-success text-light">{{ $project->status }}</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection
</body>

</html>
