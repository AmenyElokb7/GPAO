<title>GPAO || Products</title>

@extends('layouts.app')

<style>
    .table td {
        height: 35px !important;
    }
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
                                </span> Products
                            </h3>

                        </div>
                        <div class="row">
                            <div class="col-md-12">


                                <div class="card">
                                    <div class="card-header">
                                        <button type="button" class="btn btn-primary float-right"
                                            style="float:right;margin:10px" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal"><i class="fas fa-plus">&#xE147;</i> <span>Add New
                                                Product</span></button>
                                        <br><br><br><br>
                                        @if (isset($_GET['succAdd']))
                                            <div class="alert alert-success alert-dismissible fade show">
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="alert">&times;</button>
                                                Product added successfully !
                                            </div>
                                        @endif
                                        {{--  --}}
                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content" style="background-color: white">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">New Product</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                        </button>
                                                    </div>
                                                    <form method="POST" action="addProduct" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">

                                                            <div class="row">
                                                                <div class="form-group">
                                                                    <label>Barcode</label>
                                                                    <input id="barcode" type="number"
                                                                        class="form-control" name="barcode" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Image</label>
                                                                <input id="image" type="file" accept="image/*"
                                                                    class="form-control" name="image" required>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group">
                                                                    <label>Name</label>
                                                                    <input id="name" type="text"
                                                                        class="form-control" name="name" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Quantity</label>
                                                                    <input id="quantity" type="number"
                                                                        class="form-control" name="quantity" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Unit</label>
                                                                    <select name="unit" class="form-select"
                                                                        id="unit" required>
                                                                        @foreach ($units as $item)
                                                                            <option value="{{ $item->name }}">
                                                                                {{ $item->name }}</option>
                                                                        @endforeach

                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Supplier</label>
                                                                    <select name="supplier" class="form-select"
                                                                        data-container="body" data-size="5"
                                                                        data-live-search="true" id="supplier" required>
                                                                        @foreach ($supplier as $item)
                                                                            <option value="{{ $item->name }}">
                                                                                {{ $item->name }}</option>
                                                                        @endforeach

                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Price</label>
                                                                    <input id="price" type="number"
                                                                        class="form-control" name="price" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button id="subAjout" type="submit"
                                                                    class="btn btn-primary">
                                                                    {{ __('Add') }}
                                                                </button>
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                        {{--  --}}
                                    </div>
                                    <style>
                                        th {
                                            display: table-cell !important;
                                            
                                        }
                                    </style>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <div class="input-group">
                                                <div class="form-outline">
                                                    <input onkeyup="Search('input','data')" id="input" type="search"
                                                        placeholder="search" class="form-control" />
                                                </div>
                                                <button type="button" class="btn btn-secondary">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div><br>
                                            <table class="table">
                                                <thead class="text-primary">
                                                    <th>ID</th>
                                                    <th> Image</th>
                                                    <th> Barcode</th>
                                                    <th>Name</th>
                                                    <th> Quantity</th>
                                                    <th> Unit</th>
                                                    <th> Supplier</th>
                                                    <th> Price</th>
                                                    <th>Available</th>
                                                    <th> Action</th>
                                                </thead>
                                                <tbody>
                                                    @if (!$p->isEmpty())
                                                        @foreach ($p as $product)
                                                            <tr class="data">
                                                                <input type="hidden" class="serdelete"
                                                                    value="{{ $product->id }}">
                                                                <td># {{ $product->id }}</td>
                                                                <td><img src="uploads/imgs/{{ $product->image }}"
                                                                        alt="{{ $product->product_name }}" width="50"
                                                                        height="50" /></td>
                                                                <td>{!! $barcodes[$product->id] !!}<br>
                                                                </td>
                                                                <td>{{ $product->product_name }}</td>
                                                                <td>{{ $product->product_quantity }}</td>
                                                                <td>{{ $product->unit }}</td>
                                                                <td>{{ $product->supplier }}</td>
                                                                <td>{{ $product->product_price }}</td>
                                                                <td>{{ $product->isAvailable }}</td>
                                                                <td style="white-space:nowrap">
                                                                    <a id="Edit" class="btn btn-success sm"
                                                                        href="#" name="edit" value="edit"
                                                                        class="settings" title="Settings"
                                                                        data-bs-toggle="tooltip"><i
                                                                            class="fas fa-edit"></i></a>
                                                                    <button class="btn btn-danger sm delete servedeletebtn"
                                                                        type="button" title="Delete"
                                                                        data-bs-toggle="tooltip"><i
                                                                            class="fas fa-trash"></i></button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                            <br>
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination justify-content-end">
                                                    {{ $p->links() }}
                                                </ul>
                                            </nav>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- ************** --}}

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
                            text: "Are you sure you want to delete defenitively this product? ",
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
                                    url: '/deleteProduct/' + delete_id,
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

        <!-- ************************************************* -->

    @endsection
</body>
