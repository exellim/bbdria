@extends('layouts.app')

@section('page-header')
    <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-account-multiple"></i>
    </span> Appointment
@endsection

@section('styles')
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex justify-content-between">
                <div class="col-lg-6">
                    <h4>{{ $appointments[0]->receipt_code }}</h4>
                </div>
                <div class="col-lg-6 text-end">
                    <h4>{{ Auth::user()->branches[0]->name }}</h4>
                </div>
            </div>

        </div>
        <form method="POST" action="{{ route('appointments.finish', $appointments[0]->receipt_code) }}"
            enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="container">
                    <div class="row d-flex align-items-center">
                        <h4>Customer's Data</h4>
                        <div class="col-lg">
                            <div class="form-group row">
                                <label class="col-sm-4">Name</label>
                                <div class="col-sm-5">
                                    <b>{{ $appointments[0]->customer->name }}</b>
                                    <input type="hidden" name="id_customer" value="{{ $appointments[0]->customer_id }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4">Phone</label>
                                <div class="col-sm-5">
                                    <b>{{ $appointments[0]->customer->phone }}</b>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4">Med. Informations</label>
                                <div class="col-sm-5">
                                    <b>
                                        {!! $appointments[0]->customer->medical_informations !!}
                                    </b>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg">
                            <div class="preview-container">
                                <img id="imagePreview" class="m-2 mw-50 w-50 rounded"
                                    src="{{ asset('storage/' . $appointments[0]->customer->image) }}" alt="Image Preview">
                            </div>
                        </div>
                    </div>

                    <!-- Appointed Dr, Asst, Beautician -->
                    <div class="row d-flex align-items-center">
                        <h4>PIC</h4>
                        <div class="col-lg">
                            <table class="table table-bordered" id="dynamicTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Role</th>
                                        <th scope="col">Select</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="doctorBody">
                                    <tr>
                                        <th scope="row">Doctor</th>
                                        <td>

                                            <select class="form-select doctor-select" data-placeholder="Pick Doctor"
                                                name="user_id[]">
                                                <option value="">Select an Doctor</option>
                                                @foreach ($users as $us)
                                                    @if ($us->roles->contains('name', 'doctor'))
                                                        <!-- If using a collection of roles -->
                                                        <option value="{{ $us->id }}">{{ $us->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary add-doctor">Add Doctor</button>
                                        </td>
                                    </tr>
                                </tbody>

                                <tbody id="assistantBody">
                                    <tr>
                                        <th scope="row">Assistant</th>
                                        <td>
                                            <select class="form-select assistant-select" style="width: 100%;"
                                                data-placeholder="Pick Assistant" name="user_id[]">
                                                <option value="">Select an Assistant</option>
                                                @foreach ($users as $us)
                                                    @if ($us->roles->contains('name', 'assistant'))
                                                        <!-- If using a collection of roles -->
                                                        <option value="{{ $us->id }}">{{ $us->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary add-assistant">Add Assistant</button>
                                        </td>
                                    </tr>
                                </tbody>

                                <tbody id="beauticianBody">
                                    <tr>
                                        <th scope="row">Beautician</th>
                                        <td>
                                            <select class="form-select beautician-select" style="width: 100%;"
                                                data-placeholder="Pick Beautician" name="user_id[]">
                                                <option value="">Select a Beautician</option>
                                                @foreach ($users as $us)
                                                    @if ($us->roles->contains('name', 'beautician'))
                                                        <!-- If using a collection of roles -->
                                                        <option value="{{ $us->id }}">{{ $us->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary add-beautician">Add Beautician</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Appointed End -->
                    <br>
                    <br>

                    <div class="d-flex align-items-center">
                        <div class="col-lg">
                            <h4>Treatment's Data</h4>
                            <table class="table">
                                <thead>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Qty</th>
                                </thead>
                                <tbody class="table-body">
                                    @foreach ($appointments[0]->details as $treat)
                                        <tr>
                                            <td colspan="3" class="bg-primary text-white">
                                                <b>{{ $treat->treatment->name }}</b>
                                            </td>
                                        </tr>
                                        @foreach ($treat->treatment->components as $comp)
                                            <tr>
                                                <td>
                                                    #
                                                </td>
                                                <td>
                                                    <input type="text" readonly class="form-control" id="supply_id[]"
                                                        name="supply_id[]" value="{{ $comp->supply_id }}" hidden>
                                                    <b>{{ $comp->supplies->name }}</b>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" id="qty[]" name="qty[]"
                                                        value="{{ $comp->qty }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-end">Total:</td>
                                        <td>
                                            <input type="text" hidden>
                                            Rp. {{ number_format($cost) }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                        <button type="button" class="btn btn-secondary">Cancel</button>
                    </div>
                </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Select2 for existing elements
            $('.form-select').select2({
                width: '100%',
                theme: 'bootstrap-5' // Assuming you're using Bootstrap 5 theme for Select2
            });
            // Function to reinitialize select2 for dynamic elements
            function initializeSelect2() {
                $('.form-select').select2({
                    width: '100%',
                    theme: 'bootstrap-5' // Assuming you're using Bootstrap 5 theme for Select2
                });
            }

            // Function to add a new row
            function addRow(bodyId, role, selectClass, options) {
                const rowCount = $(`#${bodyId} tr`).length + 1; // Count the current rows
                const newRow = `
                <tr>
                    <td></td>
                    <td>
                        <select class="form-select ${selectClass}" style="width: 100%;" name="user_id[]"
                        data-placeholder="Pick ${role}" required>
                            <option>Select a ${role}</option>
                            ${options}
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-danger remove-row">Remove</button>
                    </td>
                </tr>
            `;
                $(`#${bodyId}`).append(newRow);
                initializeSelect2();
            }

            // Add Doctor event
            $('.add-doctor').on('click', function(e) {
                e.preventDefault(); // Prevent form submission
                addRow('doctorBody', 'Doctor', 'doctor-select', `
                @foreach ($users as $us)
                    @if ($us->roles->contains('name', 'doctor'))
                        <!-- If using a collection of roles -->
                        <option value="{{ $us->id }}">{{ $us->name }}
                        </option>
                    @endif
                @endforeach
            `);
            });

            // Add Assistant event
            $('.add-assistant').on('click', function(e) {
                e.preventDefault(); // Prevent form submission
                addRow('assistantBody', 'Assistant', 'assistant-select', `
                @foreach ($users as $us)
                    @if ($us->roles->contains('name', 'assistant'))
                        <!-- If using a collection of roles -->
                        <option value="{{ $us->id }}">{{ $us->name }}
                        </option>
                    @endif
                @endforeach
            `);
            });

            // Add Beautician event
            $('.add-beautician').on('click', function(e) {
                e.preventDefault(); // Prevent form submission
                addRow('beauticianBody', 'Beautician', 'beautician-select', `
                @foreach ($users as $us)
                    @if ($us->roles->contains('name', 'beautician'))
                        <!-- If using a collection of roles -->
                        <option value="{{ $us->id }}">{{ $us->name }}
                        </option>
                    @endif
                @endforeach
            `);
            });

            // Remove row event
            $(document).on('click', '.remove-row', function(e) {
                e.preventDefault(); // Prevent form submission
                $(this).closest('tr').remove();
            });

        });
    </script>
@endsection
