@extends('layouts.app')
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GPAO || SEARCH </title>
</head>
<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
?>

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

                            <form method="POST" action="{{ url('/search-results') }}">
                                @csrf



                                <div class="col-12">
                                    <div class="card overflow-hidden">
                                        <div class="">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="text-primary p-3">
                                                        <h5 class="text-dark">
                                                             <i class="fa fa-search"></i> 
                                                            Search projects
                                                        </h5>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row justify-content-center">
                                                <div class="col-lg-3 col-sm-6">
                                                    <label for="startDate">Start Date</label>
                                                    <input type="date" name="start_date" class="form-control"
                                                        id="start_date" required>
                                                    <span id="startDateSelected"></span>
                                                </div>
                                                <div class="col-lg-3 col-sm-6">
                                                    <label for="endDate">End Date</label>
                                                    <input type="date" name="end_date" class="form-control"
                                                        id="end_date" required>
                                                    <span class="" id="endDateSelected"></span>
                                                </div>
                                                <div class="col-lg-3 col-sm-6">
                                                    <button type="submit" class="btn btn-primary" style="margin-top: 19px">Search</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    const startDateInput = document.getElementById('start_date');
                                    const endDateInput = document.getElementById('end_date');
                                
                                    startDateInput.addEventListener('input', function() {
                                        endDateInput.min = startDateInput.value;
                                    });
                                </script>
                                

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     
    @endsection
</body>

</html>
