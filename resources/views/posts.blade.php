@extends('layouts.app')
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GPAO || Posts</title>
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
                                    <i class="fa fa-tasks"></i>
                                </span> Posts
                            </h3>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal"><i class="fas fa-plus">&#xE147;</i> <span>Add New
                                                Post</span></button> <br><br>
                                        @if (isset($_GET['succAdd']))
                                            <div class="alert alert-success alert-dismissible fade show">
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="alert">&times;</button>
                                                Post added successfully !
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
                                                    <th>Name</th>
                                                    <th> Task</th>
                                                    <th> Action</th>
                                                </thead>
                                                <tbody>
                                                    @if (!$u->isEmpty())
                                                        @foreach ($u as $post)
                                                            <tr class="data">
                                                                <input type="hidden" class="serdelete"
                                                                    value="{{ $post->id }}">
                                                                <td># {{ $post->id }}</td>
                                                                <td>{{ $post->name }}</td>
                                                                <td class="text-right">
                                                                    <span class="badge rounded-pill bg-info text-dark">
                                                                        {{ $post->task_id }}</span>
                                                                </td>
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
                                                <h5 class="modal-title" id="exampleModalLabel">New post</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                </button>
                                            </div>
                                            <form method="POST" action="addPost">
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

                                                    <div class="form-group">
                                                        <label for="task">{{ __('Task') }}</label>
                                                        <select name="task" id="task" class="form-control" required>
                                                            <option value=""> --------- </option>
                                                            @foreach ($t as $tasks)
                                                            <option value="{{$tasks->name}}" >{{$tasks->name}}</option>
                                                            @endforeach
                                                        </select>
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
                                    text: "Are you sure you want to delete defenitively this post? ",
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
                                            url: '/deletePost/' + delete_id,
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

</html>
