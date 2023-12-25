
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">







@extends('layouts.app')
<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

$current_page = 'Projects'; ?>
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
                                </span> New project
                            </h3>

                        </div>

                        <div class="row" style="margin:20px">
                            <div class="col-xl-4">
                                <div class="card overflow-hidden">
                                    <div class="bg-light bg-soft">
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
                                                                <input type="text" value="" id="project-name"
                                                                    required name="name" class="form-control">
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

                                                        <input value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"
                                                            class="form-control" id="start-date" disabled>



                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="roles" class="col-md-3 col-form-label">Delivery date
                                                    </label>
                                                    <div class="col-md-9">

                                                        <input class="form-control" type="date"
                                                            min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" required
                                                            id="delivery-date" value="" name="dueDateValue">

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
                                <link rel="stylesheet"
                                    href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css" />
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
                                <style>
                                    .chosen-container {
                                        background-color: #fff;
                                        border: 1px solid #aaa;
                                        border-radius: 4px;
                                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
                                        width: 100%;
                                    }

                                    .chosen-container-multi .chosen-choices li.search-field input[type="text"] {
                                        font-size: 14px;
                                        padding: 8px;
                                        border: none;
                                        box-shadow: none;
                                        width: 100%;
                                    }

                                    .chosen-container-multi .chosen-choices li.search-choice {
                                        background-color: #ddd;
                                        border: none;
                                        border-radius: 4px;
                                        color: #333;
                                        margin: 4px;
                                        padding: 4px 8px;
                                        font-size: 14px;
                                    }

                                    .chosen-container-multi .chosen-choices li.search-choice .search-choice-close {
                                        margin-left: 8px;
                                        color: #333;
                                        font-size: 14px;
                                    }

                                    .chosen-container-active.chosen-with-drop .chosen-single,
                                    .chosen-container-active.chosen-with-drop .chosen-choices {
                                        border-color: #1abc9c;
                                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
                                    }

                                    .chosen-container-multi .chosen-choices li.search-choice .search-choice-close:hover {
                                        color: #c0392b;
                                    }
                                </style>
                             
                            </div>
                            <div class="col-lg-3">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    select tasks
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content"  style="background: white">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Select project's tasks</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-md-9">
                                                    <select class="selectpicker" data-container="body" data-size="5" data-live-search="true" 
                                                        id="choices-multiple-remove-button" required name="tasks" multiple title="Choose one of the following...">
                                                        @foreach ($t as $task)
                                                            <option value="{{ $task->id }}" data-tokens="{{ $task->id }}">
                                                                {{ $task->name }}:{{ $task->minutes }}minutes</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="button" data-bs-dismiss="modal"
                                                    class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" class="form-control" id="total-minutes" name="total-minutes"
                                    readonly>
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
                                                <th class="actions">Action</th>

                                            </tr>
                                        </thead>
                                        <tbody id="datatable-body">
                                            <tr></tr>

                                        </tbody>

                                    </table>
                             
                                </div>
                                <div class="row panel kpi-container">
                                    <div class="col-sm-3"> <label for="roles" class="col-md-1 col-form-label"><img
                                                class="rounded-circle " src="" id="imageid"></label></div>
                                    <div class="col-sm-9">
                                        <div class="col-sm-8 d-flex flex-wrap gap-2">

                                            <div class="col-sm-7 d-flex flex-wrap gap-2 float-end">
                                                <div class="col-sm-7 d-flex flex-wrap gap-2 float-end">
                                                    <strong>New Product :</strong>
                                                </div>
                                                <select  class="selectpicker" data-container="body" data-size="5" data-live-search="true" 
                                                    id="id_select2_example" name="products[]" title="Choose one of the following..." >
                                                   
                                                    @foreach ($p as $product)
                                                        <option data-tokens="{{ $product->product_name }}" value="{{ $product->product_name }}"
                                                            productId="{{ $product->id }}">
                                                            {{ $product->product_name }}
                                                        </option>
                                                        <option data-divider="true"></option>
                                                    @endforeach

                                                </select>
                                           

                                            </div>

                                            <div class="col-sm-1 " style="padding-top: 3%;">

                                                <button type="button" class="btn btn-primary waves-effect"
                                                    id="addRow_btn" onclick="addRow()">
                                                    Add
                                                </button>
                                            </div>
                                            <div id="total-quantity" style="display: none;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-muted">
                                    <div class="d-flex flex-wrap gap-2 float-end">

                                        <button id="saveBtn" type="button"
                                            class="btn btn-primary waves-effect waves-light"
                                            onclick="save()">Save</button>

                                        <a href="{{ url('/') }}" class="btn btn-secondary waves-effect">Back</a>

                                    </div>
                                </div>

                            </div>
                            {{-- **************************************** --}}




                        </div>
                    @endsection
</body>


<script>
    var out = []

    let qte = localStorage.setItem("quantity", 0);
    var quantityInputs = document.getElementsByClassName('quantity');
    for (var i = 0; i < quantityInputs.length; i++) {
        quantityInputs[i].addEventListener('keyup', updateTotalQuantity);
    }

    // **************************************************************************************** //
    function updateTotalQuantity() {
        var totalQuantity = 0;

        for (var i = 0; i < quantityInputs.length; i++) {
            if (quantityInputs[i].value == "") {
                quantityInputs[i].value = 0;

            }
            totalQuantity += parseInt(quantityInputs[i].value);

        }
        document.getElementById('total-quantity').innerHTML = 'Total quantity: ' + totalQuantity;
        localStorage.setItem("quantity", totalQuantity)
        TotalTaskMinutes();


    }

    function TotalTaskMinutes() {
        var totalQuantityInput = localStorage.getItem("quantity");

        var selectedTaskOptions = document.querySelectorAll('#choices-multiple-remove-button option:checked');
        var taskMinutes = {};
        selectedTaskOptions.forEach(function(option) {
            var taskId = option.value;
            var taskName = option.textContent.split(':')[0].trim();
            var minutes = parseInt(option.textContent.split(':')[1].trim());
            var totalMinutes = minutes * parseInt(totalQuantityInput);
            console.log(totalQuantityInput);
            taskMinutes[taskId] = {
                name: taskName,
                totalMinutes: totalMinutes
            };
        });
        var output = "";
        for (var taskId in taskMinutes) {
            // let obj  = { taskMinutes[taskId].name : taskMinutes[taskId].totalMinutes+"minutes" }
            // output.push(obj)
            output += taskMinutes[taskId].name + ': ' + taskMinutes[taskId].totalMinutes + ' minutes , ';
            out.push({
                task: taskMinutes[taskId].name,
                minutes: taskMinutes[taskId].totalMinutes
            })
        }
        var totalMinutesOutput = document.getElementById('total-minutes');
        totalMinutesOutput.value = output;



    }

    // **************************************************************************************** //
    function addRow() {
        const selectedOption = document.getElementById("id_select2_example").options[document.getElementById(
            "id_select2_example").selectedIndex];
        if (selectedOption.value !== "empty") {
            // Remove the selected option from the select element


            var table = document.getElementById("datatable").getElementsByTagName("tbody")[0];
            var newRow = table.insertRow();
            newRow.setAttribute('data-productId', productId);

            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);
            var cell4 = newRow.insertCell(3);
            var cell5 = newRow.insertCell(4);


            var productId = document.getElementById("id_select2_example").options[document.getElementById(
                "id_select2_example").selectedIndex].getAttribute("productId");
            newRow.setAttribute("data-product-id", productId);
            cell1.innerHTML = table.rows.length - 1;
            cell2.innerHTML = document.getElementById("id_select2_example").value;
            cell3.innerHTML =
                `<input type="number" id="quantity-input${productId}" value="0" min="0" name="quantity${productId}" class="form-control quantity" required>` +
                '<div id="quantity-error" class="text-danger"></div>';
            cell5.innerHTML =
                '<button type="button" class="btn btn-danger waves-effect" onclick="deleteRow(this)">Delete</button>';


            // Check if the quantity is available
            var quantityInput = cell3.getElementsByTagName('input')[0];
            $(quantityInput).on('keyup', function() {
                var quantity = $(this).val();
                $.get('/check-stock/' + productId + '/' + quantity, function(data) {
                    if (!data.available) {
                        var errorMessage = data.message;
                        $('#quantity-error', $(quantityInput).parent()).html(
                            errorMessage);
                        $(quantityInput).val('0');
                        updateTotalQuantity();
                    } else {
                        $('#quantity-error', $(quantityInput).parent()).html('');

                    }
                });
            });
            var quantityInputs = document.getElementsByClassName('quantity');

            for (var i = 0; i < quantityInputs.length; i++) {
                quantityInputs[i].addEventListener('keyup', updateTotalQuantity);
            }
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "{{ route('getProductImage', ['id' => ':id']) }}".replace(':id', productId), true);
            console.log(xhr);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var imagePath = xhr.responseText.replace(/^"(.+(?="$))"$/, '$1').replace(/\\/g, '/').trim()
                        .replace(
                            /\/\//g, '/');
                    var image = document.createElement("img");
                    image.src = imagePath;
                    image.alt = "Product Image";
                    image.style.maxWidth = "50px";
                    image.style.maxHeight = "50px";
                    console.log(imagePath);

                    cell4.appendChild(image);
                }
            };
            xhr.send();
            selectedOption.remove();
            var selectedOptionTask = document.getElementById('choices-multiple-remove-button');

            selectedOptionTask.addEventListener('change', function() {
                TotalTaskMinutes();
            });

        }

    }
    // ************************************************************* //
    function deleteRow(button) {
        var i = button.parentNode.parentNode.rowIndex;
        var table = document.getElementById("datatable");
        var productName = table.rows[i].cells[1].innerHTML;
        var productId = table.rows[i].cells[2].getElementsByTagName('input')[0].name.replace('quantity', '');

        // Add the option back to the select element
        var selectElement = document.getElementById('id_select2_example');
        var option = document.createElement("option");
        option.text = productName;
        option.value = productName;
        option.setAttribute('productId', productId);
        selectElement.add(option);

        // Remove the row
        table.deleteRow(i);
        updateTotalQuantity();
    }

    function save() {
        const projectName = document.getElementById('project-name').value;
        const startDate = document.getElementById('start-date').value;
        const deliveryDate = document.getElementById('delivery-date').value;
        const totalMinutes = document.getElementById('total-minutes').value;
        let selectedProducts = [];
        const rows = document.querySelectorAll('#datatable tbody tr');
        rows.forEach(row => {
            const productId = row.getAttribute('data-product-id');
            const productName = row.cells[1] ? row.cells[1].textContent : '';
            const quantityInput = row.querySelector(`input[type="number"]`);
            const quantity = quantityInput ? quantityInput.value : null;
            if (productName.trim() !== '') {
                selectedProducts.push({
                    productId,
                    productName,
                    quantity
                });
            }
        });

        selectedProducts.forEach(product => {
            console.log(selectedProducts);
        });
        const payload = {

            projectName: projectName,
            startDate: startDate,
            deliveryDate: deliveryDate,
            totalMinutes: out,
            products: selectedProducts
        };

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/addProject');
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

        xhr.onload = function() {
            if (xhr.status === 200) {
                alert('Project saved successfully.');
                window.location.reload()
            } else {
                alert('Failed to save project.');
            }
        };
        xhr.send(JSON.stringify(payload));
    }
</script>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script>
    $(document).ready(function(){
        $('#id_select2_example select').selectpicker();
    })
</script>
