<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">


<link rel=”stylesheet” href=”https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css”>
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
<?php
use App\Models\products;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

$current_page = 'Projects'; ?>
@extends('layouts.app')

<style>
    /* ******************************** */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .modal1 {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        /* Location of the box */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
    }


    .modal1.user {
        width: 90%;
        max-width: 340px;
        margin: auto;
    }



    /* Modal Content */
    .modal-content1 {
        background-color: white;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 30%;
        height: auto;
        border-radius: 10px;
        transition: 0.8s all;
        margin-top: -90px;
        z-index: 99999999999;
        animation: fadein 0.5s;

    }

    #datatable td {
        height: 50px;
        width: auto !important;
    }

    .form-control.quantity {
        width: 150px !important
    }

    #datatable {
        table-layout: auto !important;
    }


    /* The Close Button */

    /* ******************** */
</style>

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
                                    <i class="fa fa-tasks"></i>
                                </span> Project Details
                            </h3>

                        </div>

                        <div class="row" style="margin:20px">
                            <div class="col-xl-4">
                                <div class="card overflow-hidden">
                                    <div class=" bg-soft">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="text-primary p-3">
                                                    <h5 class="text-primary">
                                                        <i class="fa fa-list"></i>
                                                        New project
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-sm-12">


                                                <table id="lineven-table-details" border="0" width="100%">
                                                    <tbody>
                                                        <tr>
                                                            <td class="ltd-label">Project Name</td>
                                                            <td class="ltd-value">
                                                                <input type="text" readonly value="{{ $project->name }}"
                                                                    class="form-control">
                                                            </td>
                                                        </tr>


                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- end card -->
                            </div>
                            <div class="col-lg-5">
                                <div class="card overflow-hidden">
                                    <div class="bg-light bg-soft">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="text-primary p-3">
                                                    <h5 class="text-primary">
                                                        <i class="fa fa-bullseye"></i>
                                                        Date
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="mb-3 row">
                                                    <label for="roles" class="col-md-3 col-form-label">Start date</label>
                                                    <div class="col-md-9">
                                                        <input value="{{ $project->start_date }}" readonly
                                                            class="form-control" id="start-date">
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="roles" class="col-md-3 col-form-label">Delivery date
                                                    </label>
                                                    <div class="col-md-9">
                                                        <input class="form-control" readonly type="date"
                                                            id="delivery-date" value="{{ $project->delivery_date }}">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                      
                        </div>
                        <div class="col-12">
                            <div class="card overflow-hidden">
                                <div class="bg-light bg-soft">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="text-primary p-3">
                                                <h5 class="text-primary">
                                                    <!-- <i class="fa fa-list"></i> -->
                                                    Products List
                                                </h5>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="datatable" class="table table-bordered dt-responsive  ">
                                        <thead class="table-light">
                                            @php
                                                $products = json_decode($project->products, true);
                                            @endphp
                                            <tr>
                                                <th>
                                                    # </th>
                                                <th>
                                                    Product Name
                                                </th>
                                                <th>
                                                    Quantity
                                                </th>
                                                <th>Image</th>

                                            </tr>
                                        </thead>
                                        <tbody id="datatable-body">
                                            @foreach ($products as $index => $product)
                                                <tr>
                                                    <td>{{ $product['productId'] }}</td>
                                                    <?php $p = products::where('id', $product['productId'])->first(); ?>
                                                    <td>{{ $product['productName'] }}</td>
                                                    <td>{{ $product['quantity'] }}</td>
                                                    <td><img src="uploads/imgs/{{ $p->image }}" alt=""
                                                            width="50" height="50"></td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="row panel kpi-container">
                                        <div class="col-sm-3"> <label for="roles" class="col-md-1 col-form-label"><img
                                                    class="rounded-circle " src="" id="imageid"></label></div>
                                        <div class="col-sm-9">
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap gap-2 float-end" style="margin:5px">
                                    <a href="{{ url('/') }}" class="btn btn-secondary waves-effect">Back</a>
                                    @if ($project->status == 'In Progress')
                                        <a href="{{ route('CompleteP', ['id' => $project->id]) }}"
                                            class="btn btn-success waves-effect">Finish Project</a>
                                    @endif
                                </div>
                            </div>
                            {{-- **************************************** --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
            @endsection
</body>
