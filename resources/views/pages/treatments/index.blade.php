@extends('layouts.app')
@section('styles')
    <style>
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: scale(1.05);
            /* Slightly increase the size */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            /* Add shadow on hover */
        }

        /* Floating action button */
        @import url("https://fonts.googleapis.com/css?family=Roboto");

        @-webkit-keyframes come-in {
            0% {
                -webkit-transform: translatey(100px);
                transform: translatey(100px);
                opacity: 0;
            }

            30% {
                -webkit-transform: translateX(-50px) scale(0.4);
                transform: translateX(-50px) scale(0.4);
            }

            70% {
                -webkit-transform: translateX(0px) scale(1.2);
                transform: translateX(0px) scale(1.2);
            }

            100% {
                -webkit-transform: translatey(0px) scale(1);
                transform: translatey(0px) scale(1);
                opacity: 1;
            }
        }

        @keyframes come-in {
            0% {
                -webkit-transform: translatey(100px);
                transform: translatey(100px);
                opacity: 0;
            }

            30% {
                -webkit-transform: translateX(-50px) scale(0.4);
                transform: translateX(-50px) scale(0.4);
            }

            70% {
                -webkit-transform: translateX(0px) scale(1.2);
                transform: translateX(0px) scale(1.2);
            }

            100% {
                -webkit-transform: translatey(0px) scale(1);
                transform: translatey(0px) scale(1);
                opacity: 1;
            }
        }

        .floating-container {
            position: fixed;
            width: 100px;
            height: 100px;
            bottom: 0;
            right: 0;
            margin: 35px 25px;
        }

        .floating-container:hover {
            height: 150px;
        }

        .floating-container:hover .floating-button {
            box-shadow: 0 10px 25px rgba(44, 179, 240, 0.6);
            -webkit-transform: translatey(5px);
            transform: translatey(5px);
            -webkit-transition: all 0.3s;
            transition: all 0.3s;
        }

        .floating-container:hover .element-container {
            cursor: pointer;
        }

        .floating-container:hover .element-container .float-element:nth-child(1) {
            -webkit-animation: come-in 0.4s forwards 0.2s;
            animation: come-in 0.4s forwards 0.2s;
        }

        .floating-container:hover .element-container .float-element:nth-child(2) {
            -webkit-animation: come-in 0.4s forwards 0.4s;
            animation: come-in 0.4s forwards 0.4s;
        }

        .floating-container:hover .element-container .float-element:nth-child(3) {
            -webkit-animation: come-in 0.4s forwards 0.6s;
            animation: come-in 0.4s forwards 0.6s;
        }

        .floating-container .floating-button {
            position: absolute;
            width: 65px;
            height: 65px;
            background: #2cb3f0;
            bottom: 0;
            border-radius: 50%;
            left: 0;
            right: 0;
            margin: auto;
            color: white;
            line-height: 65px;
            text-align: center;
            font-size: 23px;
            z-index: 100;
            box-shadow: 0 10px 25px -5px rgba(44, 179, 240, 0.6);
            cursor: pointer;
            -webkit-transition: all 0.3s;
            transition: all 0.3s;
        }

        .floating-container .float-element {
            position: relative;
            display: block;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            margin: 15px auto;
            color: white;
            font-weight: 500;
            text-align: center;
            line-height: 50px;
            z-index: 0;
            opacity: 0;
            -webkit-transform: translateY(100px);
            transform: translateY(100px);
        }

        .floating-container .float-element .material-icons {
            vertical-align: middle;
            font-size: 16px;
        }

        .floating-container .float-element:nth-child(1) {
            background: #42A5F5;
            box-shadow: 0 20px 20px -10px rgba(66, 165, 245, 0.5);
        }

        .floating-container .float-element:nth-child(2) {
            background: #4CAF50;
            box-shadow: 0 20px 20px -10px rgba(76, 175, 80, 0.5);
        }

        .floating-container .float-element:nth-child(3) {
            background: #FF9800;
            box-shadow: 0 20px 20px -10px rgba(255, 152, 0, 0.5);
        }

        .action-span {
            cursor: pointer;
        }

        .action-span i {
            font-size: 1.5rem;
        }
    </style>
@endsection

@section('page-header')
    <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-account-multiple"></i>
    </span> Treatments
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex justify-content-between">
                <div class="col-lg-6">
                    <h4>Treatments</h4>
                </div>
                <div class="col-lg-6 text-end">
                    <h4>{{ Auth::user()->branches[0]->name }}</h4>
                </div>
            </div>

        </div>
        <div class="card-body">
            @if (isset($treatments[0]->name))
                <div class="row d-flex justify-content-evenly">
                    @foreach ($treatments as $treat)
                        <div class="col justify-content-center mb-4" style="flex: 0 0 0% !important">
                            <div class="card rounded-xl text-white bg-primary mb-2 p-2 card-hover"
                                style="max-width: 18rem; min-width: 16rem;" data-bs-toggle="modal"
                                data-bs-target="#customer-view-{{ $treat->id }}">
                                <img class="card-img-top border border-light"
                                    src="{{ asset('assets/images/logos/logo-bg.png') }}" alt="Card image cap">
                                <div class="card-header py-1"></div>
                                <div class="card-body">
                                    <h3>{{ $treat->name }}</h3>
                                    <h4>Rp. {{ number_format($treat->price) }}</h4>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div>
                    <h4>-- No Treatment Available --</h4>
                </div>
            @endif
        </div>
    </div>

    {{-- Floating Action Buttons Start --}}
    <div class="floating-container">
        <div class="floating-button">+</div>
        <div class="element-container">

            <button class="float-element" data-bs-toggle="modal" data-bs-target="#create-appointment">
                <i class="material-icons">Add
                </i>
            </button>
        </div>
    </div>
    {{-- Floating Action Button End --}}

    <!-- Modal Create Start -->
    <form method="POST" action="{{ route('treatments.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal fade create-app" id="create-appointment" aria-labelledby="cardModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h2 class="modal-title" id="cardModalLabel">Create Treatment</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row d-flex align-items-center">
                                <div class="col-lg">

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="name">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Price</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" name="price">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Components</label>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Component</th>
                                                    <th>Qty</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table-body">
                                                <tr>
                                                    <td class="row-number">1</td>
                                                    <td>
                                                        <select class="form-control select2" data-placeholder="Pick Supply"
                                                            name="supply_id[]">
                                                            <option value=""></option>
                                                            @foreach ($supplies as $supply)
                                                                <option value="{{ $supply->id }}">{{ $supply->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        {{-- <select class="form-select single-select-field supply_id"
                                                            data-placeholder="Pick Supply" name="supply_id[]">
                                                            <option value=""></option>
                                                            @foreach ($supplies as $supply)
                                                                <option value="{{ $supply->id }}">{{ $supply->name }}
                                                                </option>
                                                            @endforeach
                                                        </select> --}}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="qty[]">
                                                    </td>
                                                    <td>
                                                        <span class="action-span add-row-span">
                                                            <i class="mdi mdi-plus"></i>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-gradient-success btn-icon-text">
                            <i class="mdi mdi-check-box btn-icon-prepend"></i> Save
                        </button>
                        <button type="button" class="btn btn-gradient-danger btn-icon-text" data-bs-dismiss="modal">
                            <i class="mdi mdi-hospital btn-icon-prepend"></i> Cancel
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Modal Create End -->

    <!-- Modal view Start -->
    @foreach ($treatments as $treat)
        <div class="modal fade" id="customer-view-{{ $treat->id }}" tabindex="-1" aria-labelledby="cardModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h2 class="modal-title" id="cardModalLabel">{{ $treat->name }}</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img class="card-img-top border border-light"
                                    src="{{ asset('assets/images/logos/logo-bg.png') }}" alt="{{ $treat->name }}">
                            </div>
                            <div
                                class="col-md-6 d-flex flex-column justify-content-center align-items-center information py-4 px44">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <td class="text-center">Name</td>
                                            <td class="text-start">{{ $treat->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Price</td>
                                            <td class="text-start">Rp. {{ number_format($treat->price) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <!-- Move accordion below the table -->
                                                <div class="accordion" id="accordionExample">
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingOne">
                                                            <button class="accordion-button bg-primary" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                                aria-expanded="true" aria-controls="collapseOne">
                                                                Components
                                                            </button>
                                                        </h2>
                                                        <div id="collapseOne" class="accordion-collapse collapse show"
                                                            aria-labelledby="headingOne"
                                                            data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <table>
                                                                    <tbody>
                                                                        @foreach ($treat->components as $key => $comp)
                                                                            <tr>
                                                                                <td>{{ $key + 1 }}</td>
                                                                                <td>{{ $comp->supplies->name }}</td>
                                                                                <td>{{ $comp->qty }} -
                                                                                    {{ $comp->supplies->itemsStock[0]->units }}
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                                <br>
                                                                @php
                                                                    $displayReasonText = false;
                                                                @endphp

                                                                @foreach ($treat->components as $comp)
                                                                    @if ($comp->supplies->itemsStock[0]->qty < $comp->qty)
                                                                        <!-- Use '==' for comparison, not '=' -->
                                                                        @if (!$displayReasonText)
                                                                            <b class="text-danger">Not Possible to
                                                                                do. Reason:</b>
                                                                            @php
                                                                                $displayReasonText = true;
                                                                            @endphp
                                                                        @endif
                                                                        <li>{{ $comp->supplies->name }} - is not Enough
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        {{-- <button type="submit" class="btn btn-gradient-success btn-icon-text">
                            <i class="mdi mdi-close-box btn-icon-prepend"></i> Save
                        </button> --}}
                        <button type="button" class="btn btn-gradient-danger btn-icon-text" data-bs-dismiss="modal">
                            <i class="mdi mdi-close-box btn-icon-prepend"></i> Close
                        </button>

                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- Modal view End -->

@endsection
@section('scripts')
    {{-- <script>
        $(document).ready(function() {

            $("#customer-name").select2({});
        });

        $(document).ready(function() {
            $('.supply_id[0]').select2({
                theme: 'bootstrap-5'
            });
        });
    </script> --}}

    <script>
        $('.select2').select2({
            theme: 'bootstrap-5', // Assuming you're using Bootstrap 5 theme for Select2
            width: '100%',
            dropdownParent: $('#create-appointment')
        });
    </script>

    <script>
        let rowIndex = 3; // Adjust this to match your initial row count

        // Function to initialize Select2 on elements
        function initializeSelect2() {
            $('.select2').select2({
                theme: 'bootstrap-5', // Assuming you're using Bootstrap 5 theme for Select2
                width: '100%',
                dropdownParent: $('#create-appointment')
            });
        }

        // Initialize Select2 for any existing rows when the page loads
        initializeSelect2();

        // Function to re-index the rows after adding/removing
        function reindexRows() {
            $('#table-body tr').each(function(index) {
                $(this).find('.row-number').text(index + 1); // Update the row number

                // Update the select ID and name attributes for each row
                const selectElement = $(this).find('select');
                const newIndex = index; // Use the current row index

                selectElement.attr('id', `supply_id[${newIndex}]`);
                selectElement.attr('name', `supply_id[${newIndex}]`);
            });

            // Reinitialize Select2 for all rows after renaming the IDs
            initializeSelect2();
        }
        // Add a new row
        $(document).on('click', '.add-row-span', function() {
            const newRow = `
        <tr>
            <td class="row-number">${rowIndex + 1}</td>
            <td>
                <select class="form-control select2" data-placeholder="Pick Supply" name="supply_id[]">
                    <option value=""></option>
                    @foreach ($supplies as $supply)
                        <option value="{{ $supply->id }}">{{ $supply->name }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="text" class="form-control" name="qty[]">
            </td>
            <td>
                <span class="action-span remove-row-span">
                    <i class="mdi mdi-minus"></i>
                </span>
            </td>
        </tr>`;

            // Append the new row
            $('#table-body').append(newRow);

            rowIndex++; // Increment the row index

            // Re-index all rows and reinitialize Select2
            reindexRows();
        });

        // Remove a row
        $(document).on('click', '.remove-row-span', function() {
            $(this).closest('tr').remove(); // Remove the row

            // Reindex rows and reinitialize Select2 after removal
            reindexRows();
        });
    </script>
@endsection
