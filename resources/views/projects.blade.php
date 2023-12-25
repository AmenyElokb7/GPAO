<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">


<link rel=”stylesheet” href=”https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css”>
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
    integrity="sha384-HhhxpbUBG+R4tPfM21e4DXc62weoLpF9CIdOy5i5ekVgx92BEdI8BhjKoOgMIoVf" crossorigin="anonymous">

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
    integrity="sha384-8sXs/As/ykzqj3ZDRhP8Gm26VPDwBwQdOVyWmBlRrXcge/CrNxk3Kx3Ood8Pzo7O" crossorigin="anonymous">
</script>

@extends('layouts.app')
<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Models\projects;

$current_page = 'Projects'; ?>

<body>
    @if (!Auth::check())
        <script>
            window.location.href = "/main"
            // alert("not logged")
        </script>
    @else
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
                                        <i class="fa fa-tasks"></i>
                                    </span> Projects
                                </h3>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <a href="{{ route('projects.new') }}" class="btn btn-primary float-right"
                                                style="float:right;margin:10px"><i class="fas fa-plus">&#xE147;</i>
                                                <span>Add New Project</span></a>
                                            @if (isset($_GET['succAdd']))
                                                <div class="alert alert-success alert-dismissible fade show">
                                                    <button type="button" class="close"
                                                        data-dismiss="alert">&times;</button>
                                                    Project added successfully !
                                                </div>
                                            @endif
                                        </div>
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination">
                                                {{ $p->links() }}
                                            </ul>
                                        </nav>

                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <div class="input-group" style="float: right" >
                                                    <div class="form-outline" >
                                                        <input  onkeyup="Search('input','data')" id="input" type="search" placeholder="search" class="form-control" />
                                                    </div>
                                                    <button type="button" class="btn btn-secondary">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div><br>
                                                <table class="table">
                                                    <thead class=" text-primary">
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th> Start date</th>
                                                        <th> Delivery date</th>
                                                        <th> Tasks </th>
                                                        <th> Total minutes</th>
                                                        <th>Project Status</th>
                                                        <th> Action</th>
                                                    </thead>
                                                    <tbody>
                                                        @if (!$p->isEmpty())
                                                            @foreach ($p as $project)
                                                                <tr class="data">
                                                                    <input type="hidden" class="serdelete"
                                                                        value="{{ $project->id }}">
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

                                                                    <td style="white-space:nowrap">
                                                                        <a class="btn btn-primary"
                                                                            href="{{ route('projects.show', $project->id) }}"
                                                                            target="_blank" class="settings"
                                                                            title="Settings" data-toggle="tooltip"><i
                                                                                class="fas fa-eye"></i></a>
                                                                        <button class="btn btn-danger delete servedeletebtn"
                                                                            type="button" title="Delete"
                                                                            data-toggle="tooltip"><i
                                                                                class="fas fa-trash"></i></button>
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

            <script src="js/sweetalert.min.js"></script>
            <!--------------------------DELETE-------------------------->
            <script>
                $(document).ready(function() {

                    $('.servedeletebtn').click(function(e) {
                        e.preventDefault();
                        var delete_id = $(this).closest("tr").find('.serdelete').val();
                        // alert(delete_id);
                        swal({
                                title: "Are You Sure?",
                                text: "Are you sure you want to delete defenitively this project? ",
                                icon: "warning",
                                buttons: true,
                                dangerMode: true,
                            })
                            .then((willDelete) => {
                                if (willDelete) {
                                    let csrf = "{{ csrf_token() }}";
                                    console.log(csrf);

                                    $.ajax({
                                        type: "delete",
                                        url: '/deleteProject/' + delete_id,
                                        dataType: "Json",
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        data: {
                                            id: delete_id,
                                        },
                                        cache: false,
                                        contentType: "application/json",
                                        success: function(response) {
                                            swal(response.status, {
                                                    icon: "success",
                                                })
                                                .then((result) => {
                                                    window.location.reload();
                                                });

                                        },
                                        error: (e) => {
                                            console.log(e.responseJSON);

                                        }
                                    });
                                }
                            });
                    });
                });
            </script>
            <!-- ************************************************* -->
            <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New Project</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" action="addProject">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input id="name" type="text" class="form-control" name="name" required
                                            autocomplete="name" autofocus>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label>Start date</label>
                                        <input id="start_date" type="datetime-local" class="form-control" name="start_date"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label>Delivery date</label>
                                        <input id="end_date" type="datetime-local" class="form-control" name="end_date"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label>Products</label>
                                        <input id="Products" type="text" class="form-control" name="Products" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button id="subAjout" type="submit" class="btn btn-primary">
                                        {{ __('Add') }}
                                    </button>
                                </div>
                        </form>
                    </div>
                </div>

            </div>
            <script>
                var modal6 = document.getElementById("myModalEdit");
                var span6 = document.getElementsByClassName("close")[0];

                <?php if (isset($_GET["Edit"])) { ?>
                modal6.style.display = "block";
                span6.onclick = function() {

                    modal6.style.display = "none";
                }
                <?php } ?>
                var btn6 = document.getElementById("Edit");
                btn6.onclick = function() {
                    modal5.style.display = "block";
                }
                span6.onclick = function() {

                    modal6.style.display = "none";
                }
                window.onclick = function(event) {
                    if (event.target == modal6) {

                        modal6.style.display = "none";

                    }
                }
            </script>
        @endsection
    @endif
</body>
