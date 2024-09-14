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

        .cust-image {
            max-width: 350px;
            padding: 10px;
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

        a.disabled {
            pointer-events: none;
            cursor: default;
        }
    </style>
@endsection

@section('page-header')
    <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-account-multiple"></i>
    </span> Appointments
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex justify-content-between">
                <div class="col-lg-6">
                    <h4>Appointments</h4>
                </div>
                <div class="col-lg-6 text-end">
                    <h4>{{ Auth::user()->branches[0]->name }}</h4>
                </div>
            </div>

        </div>
        <div class="card-body">
            @php
                use Carbon\Carbon;

                // Get the current year and month
                $currentYear = now()->year;
                $currentMonth = now()->month;

                // Helper function to convert date string to Carbon instance
                function toCarbon($dateString)
                {
                    return Carbon::parse($dateString);
                }

                // Filter and sort appointments for the current month
                $currentMonthAppointments = $appointments
                    ->filter(function ($appoint) use ($currentYear, $currentMonth) {
                        $appointmentDate = toCarbon($appoint->appointment_date);
                        return $appointmentDate->year == $currentYear && $appointmentDate->month == $currentMonth;
                    })
                    ->sort(function ($a, $b) {
                        $dateComparison = toCarbon($a->appointment_date)->lt(toCarbon($b->appointment_date))
                            ? -1
                            : (toCarbon($a->appointment_date)->gt(toCarbon($b->appointment_date))
                                ? 1
                                : 0);
                        if ($dateComparison == 0) {
                            // If dates are the same, compare times
                            return toCarbon($a->appointment_time)->lt(toCarbon($b->appointment_time))
                                ? -1
                                : (toCarbon($a->appointment_time)->gt(toCarbon($b->appointment_time))
                                    ? 1
                                    : 0);
                        }
                        return $dateComparison;
                    });

                // Filter and sort appointments for upcoming months
                $upcomingMonthAppointments = $appointments
                    ->filter(function ($appoint) use ($currentYear, $currentMonth) {
                        $appointmentDate = toCarbon($appoint->appointment_date);
                        $appointmentYear = $appointmentDate->year;
                        $appointmentMonth = $appointmentDate->month;

                        // Check if the appointment is in a future month within the current year or in the next year
                        return ($appointmentYear == $currentYear && $appointmentMonth > $currentMonth) ||
                            $appointmentYear > $currentYear;
                    })
                    ->sort(function ($a, $b) {
                        $dateComparison = toCarbon($a->appointment_date)->lt(toCarbon($b->appointment_date))
                            ? -1
                            : (toCarbon($a->appointment_date)->gt(toCarbon($b->appointment_date))
                                ? 1
                                : 0);
                        if ($dateComparison == 0) {
                            // If dates are the same, compare times
                            return toCarbon($a->appointment_time)->lt(toCarbon($b->appointment_time))
                                ? -1
                                : (toCarbon($a->appointment_time)->gt(toCarbon($b->appointment_time))
                                    ? 1
                                    : 0);
                        }
                        return $dateComparison;
                    });
            @endphp

            @if ($currentMonthAppointments->isNotEmpty())
                <h4>This Month</h4>
                <div class="row d-flex">
                    @foreach ($currentMonthAppointments as $appoint)
                        <div class="col justify-content-center mb-4" style="flex: 0 0 0% !important">
                            <div class="card rounded-xl text-white bg-primary mb-2 p-2 card-hover"
                                style="max-width: 18rem; min-width: 16rem; max-height:460px;" data-bs-toggle="modal"
                                data-bs-target="#customer-view-{{ $appoint->id }}">
                                <img class="card-img-top border border-light"
                                    src="{{ asset('storage/' . $appoint->customer->image) }}" alt="Card image cap">
                                <div class="card-header">
                                    <h4>{{ $appoint->receipt_code }}</h4>
                                    <strong>Status: {{ $appoint->status }}</strong>
                                </div>
                                <div class="card-body items-center">
                                    <!-- <h5>{{ Str::limit($appoint->customer->name, 18, '') }}</h5> -->
                                    {{-- <h4>Date:{{ toCarbon($appoint->appointment_date)->format('Y-m-d') }}
                                        Time:{{ $appoint->appointment_time }}</h4> --}}
                                    <table>
                                        <tbody>
                                            <tr>
                                            <td>Name</td>
                                                <td>:</td>
                                                <td style="overflow: hidden;">{{ Str::limit($appoint->customer->name, 18,'') }}</td>
                                            </tr>
                                            <tr>
                                                <td>Date</td>
                                                <td>:</td>
                                                <td>{{ toCarbon($appoint->appointment_date)->format('Y-m-d') }}</td>
                                            </tr>
                                            <tr>
                                                <td>Time</td>
                                                <td>:</td>
                                                <td>{{ $appoint->appointment_time }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div>
                    <h4>-- No Appointment for Current Month --</h4>
                </div>
            @endif
            <hr class="bg-danger border-2 border-top border-danger" />

            @if ($upcomingMonthAppointments->isNotEmpty())
                <h4>Upcoming Months</h4>
                <div class="row d-flex">
                    @foreach ($upcomingMonthAppointments as $appoint)
                    <div class="col justify-content-center mb-4" style="flex: 0 0 0% !important">
                        <div class="card rounded-xl text-white bg-primary mb-2 p-2 card-hover"
                            style="max-width: 18rem; min-width: 16rem; max-height:460px;" data-bs-toggle="modal"
                            data-bs-target="#customer-view-{{ $appoint->id }}">
                            <img class="card-img-top border border-light"
                                src="{{ asset('storage/' . $appoint->customer->image) }}" alt="Card image cap">
                            <div class="card-header">
                                <h4>{{ $appoint->receipt_code }}</h4>
                                <strong>Status: {{ $appoint->status }}</strong>
                            </div>
                            <div class="card-body items-center">
                                <h5>{{ Str::limit($appoint->customer->name, 18, '') }}</h5>
                                {{-- <h4>Date:{{ toCarbon($appoint->appointment_date)->format('Y-m-d') }}
                                    Time:{{ $appoint->appointment_time }}</h4> --}}
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>Date</td>
                                            <td>:</td>
                                            <td>{{ toCarbon($appoint->appointment_date)->format('Y-m-d') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Time</td>
                                            <td>:</td>
                                            <td>{{ $appoint->appointment_time }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div>
                    <h4>-- No Upcoming Appointments --</h4>
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
    <form method="POST" action="{{ route('appointments.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="create-appointment" tabindex="-1" aria-labelledby="cardModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h2 class="modal-title" id="cardModalLabel">Create Appointment</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row d-flex align-items-center">
                                <div class="col-lg">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Name</label>
                                        <div class="col-sm-9">
                                            <select required class="form-select single-select-field customer-name"
                                                id="customer-name" data-placeholder="Pick Customer" name="customer_id">
                                                <option value=""></option>
                                                @foreach ($customers as $cust)
                                                    <option value="{{ $cust->id }}">{{ $cust->name }} -
                                                        {{ $cust->branch->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Appointment Date</label>
                                        <div class="col-sm-9">
                                            <input required type="date" class="form-control" name="appointment_date">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Appointment Time</label>
                                        <div class="col-sm-9">
                                            <input required type="time" class="form-control" name="appointment_time">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">DP</label>
                                        <div class="col-sm-9">
                                            <input required type="text" class="form-control" name="dp">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Treatment</label>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Treatment</th>
                                                    <th>Price</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table-body">
                                                <tr>
                                                    <td class="row-number">1</td>
                                                    <td>
                                                        <select required
                                                            class="form-select single-select-field treatment_id[0]"
                                                            id="treatment_id[0]" data-placeholder="Pick Treatment"
                                                            name="treatment_id[]">
                                                            <option value=""></option>
                                                            @foreach ($treatment as $treat)
                                                                <option value="{{ $treat->id }}">{{ $treat->name }} -
                                                                    {{ $cust->branch->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input required type="text" readonly class="form-control"
                                                            id="treatment_price[]" name="treatment_price[]">
                                                    </td>
                                                    <td>
                                                        <span class="action-span add-row-span">
                                                            <i class="mdi mdi-plus"></i>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2"></td>
                                                    <td>
                                                        <strong>Grand Total:</strong>
                                                        <input type="text" id="grand-total" readonly
                                                            class="form-control">
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-gradient-success btn-icon-text">
                            <i class="mdi mdi-hospital btn-icon-prepend"></i> Save
                        </button>
                        <button type="button" class="btn btn-gradient-danger btn-icon-text" data-bs-dismiss="modal">
                            <i class="mdi mdi-close-box btn-icon-prepend"></i> Cancel
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Modal Create End -->

    {{-- Modal View Start --}}
    @foreach ($appointments as $appoint)
        <form method="POST" action="{{ route('appointments.update.time', $appoint->id) }}"
            enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="modal fade" id="customer-view-{{ $appoint->id }}" tabindex="-1"
                aria-labelledby="cardModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h2 class="modal-title" id="cardModalLabel">{{ $appoint->customer->name }}</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row d-flex align-items-center">
                                    <!-- Table Section on the Left -->
                                    <div class="col-lg-6">
                                        <table class="table table-responsive">
                                            <tbody>
                                                <tr>
                                                    <td>Name</td>
                                                    <td>{{ $appoint->customer->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Receipt</td>
                                                    <td>{{ $appoint->receipt_code }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Dp</td>
                                                    <td>Rp. {{ number_format($appoint->dp) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Appointment Time</td>
                                                    <td>
                                                        <div id="editable-{{ $appoint->id }}">
                                                            {{ $appoint->appointment_date }} /
                                                            {{ $appoint->appointment_time }}
                                                        </div>
                                                        <div id="editable-show-{{ $appoint->id }}" hidden>
                                                            <input required type="date" class="form-control"
                                                                name="appointment_date"
                                                                value="{{ $appoint->appointment_date }}">
                                                            <input required type="time" class="form-control"
                                                                name="appointment_time"
                                                                value="{{ $appoint->appointment_time }}">
                                                        </div>
                                                        @if ($appoint->status === 'finish')
                                                        @else
                                                            <button type="button" onclick="editme({{ $appoint->id }})"
                                                                class="btn btn-sm btn-danger btn-rounded">
                                                                <i class="mdi mdi-clock"></i>
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <!-- Move accordion below the table -->
                                                        <div class="accordion" id="accordionExample">
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="headingOne">
                                                                    <button class="accordion-button bg-primary"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#collapseOne" aria-expanded="true"
                                                                        aria-controls="collapseOne">
                                                                        Treatment
                                                                    </button>
                                                                </h2>
                                                                <div id="collapseOne"
                                                                    class="accordion-collapse collapse show"
                                                                    aria-labelledby="headingOne"
                                                                    data-bs-parent="#accordionExample">
                                                                    <div class="accordion-body">
                                                                        <table>
                                                                            <tbody>
                                                                                @foreach ($appoint->details as $key => $det)
                                                                                    <tr>
                                                                                        <td>{{ $key + 1 }}</td>
                                                                                        <td>{{ $det->treatment->name }}
                                                                                        </td>
                                                                                        <td>Rp.
                                                                                            {{ number_format($det->treatment->price) }}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if ($appoint->status === 'finish')
                                                <tr>
                                                    <td colspan="2">
                                                        <!-- Move accordion below the table -->
                                                        <div class="accordion" id="accordionExample">
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="headingOne">
                                                                    <button class="accordion-button bg-primary"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#collapseOne" aria-expanded="true"
                                                                        aria-controls="collapseOne">
                                                                        Treated By
                                                                    </button>
                                                                </h2>
                                                                <div id="collapseOne"
                                                                    class="accordion-collapse collapse show"
                                                                    aria-labelledby="headingOne"
                                                                    data-bs-parent="#accordionExample">
                                                                    <div class="accordion-body">
                                                                        <table>
                                                                            <tbody>
                                                                                @foreach ($appoint->pics as $key => $pic)
                                                                                    <tr>
                                                                                        <td>{{ $key + 1 }}</td>
                                                                                        <td>{{ $pic->user->name }}</td>
                                                                                        <td>{{ $pic->user->roles[0]->name }}</td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Image Section on the Right -->
                                    <div class="col-lg-6 text-center">
                                        <div class="preview-container">
                                            <img class="cust-image img-fluid"
                                                src="{{ asset('storage/' . $appoint->customer->image) }}" alt="">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-gradient-success btn-icon-text"
                                    id="save_button-{{ $appoint->id }}" hidden>
                                    <i class="mdi mdi-hospital btn-icon-prepend"></i> Save
                                </button>
                                @if ($appoint->status === 'finish')
                                @else
                                    <a href="{{ route('appointments.changetr', $appoint->receipt_code) }}"
                                        id="stopme-{{ $appoint->id }}" target="_blank"
                                        class="btn btn-gradient-warning btn-icon-text">
                                        <i class="mdi mdi-contrast-circle btn-icon-prepend"></i> Change Treatment
                                    </a>
                                    <a href="{{ route('appointments.attend', $appoint->id) }}" id="stopme"
                                        target="_blank" class="btn btn-gradient-primary btn-icon-text">
                                        <i class="mdi mdi-briefcase-check btn-icon-prepend"></i> Attend
                                    </a>
                                @endif
                                <button type="button" class="btn btn-gradient-danger btn-icon-text"
                                    data-bs-dismiss="modal">
                                    <i class="mdi mdi-close-box btn-icon-prepend"></i> Close
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach
    {{-- Modal View End --}}
@endsection
@section('scripts')
    <script>
        function editme(index) {
            const editable = document.querySelector('#editable-' + index);
            const editableShow = document.querySelector('#editable-show-' + index);
            const stopme = document.querySelector('#stopme');
            const stopme_2 = document.querySelector('#stopme-' + index);
            const save_button = document.querySelector('#save_button-' + index);

            if (editable.hasAttribute('hidden')) {
                editable.removeAttribute('hidden');
                editableShow.setAttribute('hidden', 'true');
                stopme.removeAttribute('hidden');
                stopme_2.removeAttribute('hidden');
                save_button.setAttribute('hidden', 'true');
            } else {
                stopme.setAttribute('hidden', 'true');
                stopme_2.setAttribute('hidden', 'true');
                editable.setAttribute('hidden', 'true');
                editableShow.removeAttribute('hidden');
                save_button.removeAttribute('hidden');

            }
        }
    </script>

    <script>
        $('#customer-name').select2({
            theme: 'bootstrap-5',
            width: '100%',
            dropdownParent: $('#create-appointment')
        });
        $('.treatment_id[0]').select2({
            theme: 'bootstrap-5',
            width: '100%',
            dropdownParent: $('#create-appointment')
        });
    </script>

    <script>
        function formatCurrency(value) {
            // Use a locale-specific currency formatter
            const formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0, // Remove decimal places
                maximumFractionDigits: 0
            });

            // Format the value and replace 'Rp' with 'Rp.' for IDR format
            return formatter.format(value).replace('Rp', 'Rp.');
        }

        // Event listener for input field to format value on input change
        $(document).on('input', 'input[name="dp"]', function() {
            const input = $(this);
            let value = input.val().replace(/[^\d]/g, ''); // Remove non-numeric characters
            value = parseFloat(value) || 0; // Convert to float

            // Format the value and set it back to the input field
            input.val(formatCurrency(value));
        });
    </script>

    <script>
        let rowIndex = 3; // Adjust this to match your initial row count

        // Function to initialize Select2 on elements
        function initializeSelect2() {
            $('.single-select-field').select2({
                width: '100%',
                theme: 'bootstrap-5' // Assuming you're using Bootstrap 5 theme for Select2
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

                selectElement.attr('id', `treatment_id[${newIndex}]`);
                selectElement.attr('name', `treatment_id[${newIndex}]`);
            });

            // Reinitialize Select2 for all rows after renaming the IDs
            initializeSelect2();
        }

        // Function to fetch treatment price and update the price input
        function updateTreatmentPrice(selectElement) {
            const treatmentId = selectElement.val();
            const $priceInput = selectElement.closest('tr').find('input[name="treatment_price[]"]');

            if (treatmentId) {
                $.ajax({
                    url: "{{ route('treatment.price') }}",
                    type: 'GET',
                    data: {
                        treatment_id: treatmentId
                    },
                    success: function(response) {
                        if (response.price) {
                            const formattedPrice = formatCurrency(response.price);
                            $priceInput.val(formattedPrice);
                            calculateGrandTotal(); // Update grand total after price change
                        } else {
                            $priceInput.val('');
                            calculateGrandTotal(); // Update grand total after price change
                        }
                    },
                    error: function() {
                        $priceInput.val('');
                        calculateGrandTotal(); // Update grand total after price change
                    }
                });
            } else {
                $priceInput.val('');
                calculateGrandTotal(); // Update grand total after price change
            }
        }

        // Function to format a number as IDR currency with thousands separators
        function formatCurrency(value) {
            // Use a locale-specific currency formatter
            const formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0, // Remove decimal places
                maximumFractionDigits: 0
            });

            // Format the value
            return formatter.format(value).replace('Rp', 'Rp.').replace(/,00$/, '');
        }

        // Function to calculate and update grand total
        function calculateGrandTotal() {
            let grandTotal = 0;

            $('input[name="treatment_price[]"]').each(function() {
                // Remove currency symbols and non-numeric characters, then parse the value
                const priceText = $(this).val().replace(/[^\d]/g, '');
                const price = parseFloat(priceText) || 0;
                grandTotal += price;
            });

            $('#grand-total').val(formatCurrency(grandTotal)); // Update grand total field
        }

        // Add a new row
        $(document).on('click', '.add-row-span', function() {
            const newRow = `
        <tr>
            <td class="row-number">${rowIndex + 1}</td>
            <td>
                <select required class="form-select single-select-field treatment_id[${rowIndex}]"
                    id="treatment_id[${rowIndex}]" data-placeholder="Pick Treatment"
                    name="treatment_id[]">
                    <option value=""></option>
                    @foreach ($treatment as $treat)
                        <option value="{{ $treat->id }}">{{ $treat->name }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input required type="text" readonly class="form-control" name="treatment_price[]">
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

            // Update grand total after row removal
            calculateGrandTotal();
        });

        // Update treatment price when a treatment is selected
        $(document).on('change', '.single-select-field', function() {
            updateTreatmentPrice($(this));
        });
    </script>
@endsection
