<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js">
</script>
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
<title>GPAO || Users</title>

@extends('layouts.app')
<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

$current_page = 'Users'; ?>
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
                                </span> Users
                            </h3>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal"><i class="fas fa-plus">&#xE147;</i> <span>Add New
                                                User</span></button> <br><br>
                                        @if (isset($_GET['succAdd']))
                                            <div class="alert alert-success alert-dismissible fade show">
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="alert">&times;</button>
                                                User added successfully !
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
                                            <table class="table">
                                                <div class="input-group" >
                                                    <div class="form-outline" >
                                                        <input  onkeyup="Search('input','data')" id="input" type="search" placeholder="search" class="form-control" />
                                                    </div>
                                                    <button type="button" class="btn btn-secondary">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div><br>
                                                <thead class=" text-primary">
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th> Email</th>
                                                    <th> Role</th>
                                                    <th> Position</th>
                                                    <th> Salary</th>
                                                    <th> Action</th>
                                                </thead>
                                                <tbody>
                                                    @if (!$u->isEmpty())
                                                        @foreach ($u as $user)
                                                            <tr class="data">
                                                                <input type="hidden" class="serdelete"
                                                                    value="{{ $user->id }}">
                                                                <td># {{ $user->id }}</td>
                                                                <td>{{ $user->name }}</td>
                                                                <td>{{ $user->email }}</td>
                                                                <td class="text-right">
                                                                    @if ($user->role == 'supplier')
                                                                        <span class="badge rounded-pill bg-info text-dark">
                                                                            {{ $user->role }}</span>
                                                                    @elseif ($user->role == 'admin')
                                                                            <span class="badge rounded-pill bg-warning text-light">
                                                                                {{ $user->role }}</span>
                                                                        @else
                                                                            <span class="badge rounded-pill bg-success text-light">
                                                                                {{ $user->role }}</span>
                                                                        @endif
                                                                </td>
                                                                <td>{{ $user->position }}</td>
                                                                <td>{{ $user->salary }}</td>
                                                                <td style="white-space:nowrap">
                                                                    <a id="Edit" class="btn btn-success"
                                                                        href="users?Edit={{ $user->id }}"
                                                                        name="edit" value="edit" class="settings"
                                                                        title="Settings" data-toggle="tooltip"><i
                                                                            class="fas fa-edit"></i></a>
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
                                                <h5 class="modal-title" id="exampleModalLabel">New User</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                </button>
                                            </div>
                                            <form method="POST" action="addUser">
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
                                                        <div class="col-md-6 pl-1">
                                                            <div class="form-group">
                                                                <label>Email</label>
                                                                <input id="email" type="email" class="form-control"
                                                                    name="email" value="{{ old('email') }}" required
                                                                    autocomplete="email">
                                                                <p style="color:red;padding: 5px;display: none;"
                                                                    id="invalid">*Email already exists</p>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="role">{{ __('role') }}</label>
                                                        <select name="role" id="role" class="form-control" required>
                                                            <option value=""> --------- </option>
                                                            <option value="admin">admin</option>
                                                            <option value="user">user</option>
                                                            <option value="supplier">Supplier</option>
                                                        </select>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 pr-1">
                                                            <div class="form-group">
                                                                <label>Position</label>
                                                                    <select name="position" id="position" class="form-control">
                                                                        <option value="">-----</option>
                                                                        @foreach ($p as $post)
                                                                        <option value="{{$post->name}}">{{$post->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 pl-1">
                                                            <div class="form-group">
                                                                <label>Salary (DT)</label>
                                                                <input id="salary" type="number" class="form-control"
                                                                    name="salary" >

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 pr-1">
                                                            <div class="form-group">
                                                                <label for="password">{{ __('Password') }}</label>
                                                                <input id="password" type="password" minlength="6"
                                                                    class="form-control" name="password" required
                                                                    autocomplete="new-password">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 pr-1">
                                                            <div class="form-group">
                                                                <label
                                                                    for="password-confirm">{{ __('Confirm Password') }}</label>
                                                                <input id="password-confirm" type="password"
                                                                    class="form-control" name="password_confirmation"
                                                                    data-rule-equalTo="#password" required
                                                                    autocomplete="new-password">
                                                                <p style="color:red;padding: 5px;display: none;"
                                                                    id="invalidPass">*Password doesn't match</p>
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
                    // ************* Confirm password **************** //
                    $(document).ready(function() {
                        $('#password-confirm').on('keyup', function() {
                            var val = $(this).val();
                            var pass = $('#password').val();
                            $("#invalidPass").css("display", "none");
                            if (val != pass) {
                                $("#password-confirm").css("color", "red");
                                $("#invalidPass").css("display", "block");
                                $("#subAjout").attr("disabled", true);
                            }
                        })
                        $('#password-confirm').on('keydown', function() {
                            $("#password-confirm").css("color", "green");
                            $("#invalidPass").css("display", "none");
                            $("#subAjout").removeAttr("disabled");
                        })
                    })
                    $(document).ready(function() {
                        $('#email').on('keyup', function() {
                            var val = $(this).val();
                            $.ajax({
                                url: "<?php echo url('CHECK'); ?>",
                                data: {
                                    em: val,
                                    query: "email"
                                },
                                type: "GET",
                                success: function(data) {
                                    $("#invalid").css("display", "none");
                                    if (data > 0) {
                                        $("#email").css("color", "red");
                                        $("#invalid").css("display", "block");
                                        $("#subAjout").attr("disabled", true);
                                    } else if (data == 0) {
                                        $("#email").css("color", "green");
                                        $("#invalid").css("display", "none");
                                        $("#subAjout").removeAttr("disabled");
                                    }
                                }
                            })
                        })

                        $('#email').on('keydown', function() {
                            $("#email").css("color", "green");
                            $("#invalid").css("display", "none");
                            $("#subAjout").removeAttr("disabled");

                        })
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
                                    text: "Are you sure you want to delete defenitively this user? ",
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
                                            url: '/deleteUser/' + delete_id,
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

                <?php
    if (request()->has("Edit")) {
    $id = request()->input("Edit");
    $row = App\Models\User::where("id", $id)->first();
    ?>
                <div id="myModalEdit" class="modal" style="padding-top:150px">
                    <div class="modal-content1">
                        <span class="close">&times;</span><br>
                        <div class="user">
                            <center>
                                <h2> Update Infos </h2>
                            </center>
                            <hr>
                            <form class="form" action="editUser" id="edit" method="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <br>
                                <input id="name" type="text" class="form-control" name="name"
                                    value="{{ $row->name }}" required autocomplete="name" autofocus>
                                <br><input id="email" type="email" class="form-control" name="email"
                                    value="{{ $row->email }}" required autocomplete="email"> <br>
                                <select name="role" id="role" class="form-control" value="{{ $row->role }}"
                                    required>
                                    <option value="{{ $row->role }}"> {{ $row->role }}</option>
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                    <option value="supplier">Supplier</option>
                                </select><br>
                              
                                    <select name="position" id="position"  class="form-control">
                                        <option value="">{{$row->position}}</option>
                                        @foreach ($p as $post)
                                        <option value="{{$post->name}}">{{$post->name}}</option>
                                        @endforeach
                                    </select><br>
                                <input id="salary" type="number" class="form-control" name="salary"
                                    value="{{ $row->salary }}" > <br>
                                <input id="password" type="password" placeholder="new password" minlength="6"
                                    class="form-control" name="password">
                                <input type="hidden" value="{{ $id }}" name="id_u">
                                <br>
                                <input type="hidden" name="idU" value="{{ $row->id }}">
                                <input type="hidden" name="old_name" value="{{ $row->name }}">
                                <center> <button class="btn btn-primary" name="editing" type="submit">Update </button>
                                </center>
                            </form>
                        </div>
                    </div>
                </div>

                <?php } ?>
            </div>
            <!-- ************************************************* -->
            <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->


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
</body>
