@extends('layouts.app')
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
                                </span> Tasks
                            </h3>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title"> Tasks managment</h4> <button type="button"
                                            class="btn btn-primary float-right" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal"><i class="fas fa-plus">&#xE147;</i> <span>Add New
                                                Task</span></button><br><br>
                                        @if (isset($_GET['succAdd']))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Task added successfully!</strong>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                          </div>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="text-primary">
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th> minutes</th>
                                                    <th> Action</th>
                                                </thead>
                                                <tbody>
                                                    @if (!$t->isEmpty())
                                                        @foreach ($t as $task)
                                                            <tr>
                                                                <input type="hidden" class="serdelete"
                                                                    value="{{ $task->id }}">
                                                                <td># {{ $task->id }}</td>
                                                                <td>{{ $task->name }}</td>
                                                                <td>{{ $task->minutes }}</td>
                                                                <td style="white-space:nowrap">
                                                                    <a id="Edit" class="btn btn-success" href="#"
                                                                        name="edit" value="edit" class="settings"
                                                                        title="Settings" data-bs-toggle="tooltip"><i
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
                                            url: '/deleteTask/' + delete_id,
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
                <script>
                    $('#exampleModal').on('show.bs.modal', function(event) {
                        var button = $(event.relatedTarget) // Button that triggered the modal
                        var recipient = button.data('whatever') // Extract info from data-* attributes
                        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                        var modal = $(this)

                    })
                </script>
                <!-- ************************************************* -->
                <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">New Task</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="addTask">
                                @csrf
                                <div class="modal-body">

                                    <div class="row">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input id="name" type="text" class="form-control" name="name"
                                                required autocomplete="name" autofocus>
                                        </div>
                                        <div class="form-group">
                                            <label>Minutes</label>
                                            <input id="minutes" type="number" class="form-control" name="minutes"
                                                required>
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
    @endsection
</body>
