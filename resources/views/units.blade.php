<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js">
</script>
<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">


<link rel=”stylesheet” href=”https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css”>
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js">
</script>
<title>GPAO || units</title>

@extends('layouts.app')
<?php

use App\Models\unit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
 ?>
<style>
    /* ******************************** */
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


    .modal1.unit {
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
                                </span> Units
                            </h3>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal"><i class="fas fa-plus">&#xE147;</i> <span>Add New
                                                Unit</span></button> <br><br>
                                        @if (isset($_GET['succAdd']))
                                            <div class="alert alert-success alert-dismissible fade show">
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="alert">&times;</button>
                                                Unit added successfully !
                                            </div>
                                        @endif
                                    </div>
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination">
                                            {{ $u->links() }}
                                        </ul>
                                    </nav>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <div class="input-group" >
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
                                                    <th>Unit</th>
                                                    <th> Action</th>
                                                </thead>
                                                <tbody>
                                                    @if (!$u->isEmpty())
                                                        @foreach ($u as $unit)
                                                            <tr class="data">
                                                                <input type="hidden" class="serdelete"
                                                                    value="{{ $unit->id }}">
                                                                <td># {{ $unit->id }}</td>
                                                                <td>{{ $unit->name }}</td>
                                                                <td style="white-space:nowrap">
                                                                    <button class="btn btn-danger delete servedeletebtn"
                                                                        type="button" title="Delete"
                                                                        data-bs-toggle="tooltip"><i
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
                                <div class="modal fade" id="exampleModal" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: white">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">New unit</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                </button>
                                            </div>
                                            <form method="POST" action="addunit">
                                                @csrf
                                                <div class="modal-body">

                                                    <div class="row">
                                                        <div class="col-md-6 pr-1">
                                                            <div class="form-group">
                                                                <label>Name</label>
                                                                <input id="name" type="text" class="form-control"
                                                                    name="name" required autocomplete="name" autofocus>
                                                            </div>
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
                            </div>

                        </div>
                    </div>
                </div>
                <script>
                    $('#exampleModal').on('show.bs.modal', function(event) {
                        var button = $(event.relatedTarget)
                        var recipient = button.data('whatever')
                        var modal = $(this)
                    })
                   
                </script>
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
                                    text: "Are you sure you want to delete defenitively this unit? ",
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
                                            url: '/deleteunit/' + delete_id,
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
        @endsection
</body>
