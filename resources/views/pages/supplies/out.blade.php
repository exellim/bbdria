@extends('layouts.app')

@section('page-header')
    <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-account-multiple"></i>
    </span> Supplies Out
@endsection

@section('styles')
    <style>
        @media (max-width: 991px) {
            .mobile-tabs .nav-item {
                display: none;
            }

            .mobile-tabs .nav-item.active {
                display: block;
            }

            .nav-tabs.mobile-tabs .nav-item.active>a:before {
                content: "\e259";
                position: absolute;
                top: 15px;
                right: 15px;
                display: inline-block;
                font-family: 'Glyphicons Halflings';
                font-style: normal;
                font-weight: 400;
                line-height: 1;
                -webkit-font-smoothing: antialiased;
            }

            .mobile-tabs .nav-item {
                float: none;
            }
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex justify-content-between">
                <div class="col-lg-6">
                    <h4>Supplies Out</h4>
                </div>
                <div class="col-lg-6 text-end">
                    <h4>{{ Auth::user()->branches[0]->name }}</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item font-bold" role="presentation">
                    <button class="nav-link active" id="Sales-tab" data-bs-toggle="tab" data-bs-target="#Sales"
                        type="button" role="tab" aria-controls="Sales" aria-selected="true">Sales</button>
                </li>
                <li class="nav-item font-bold" role="presentation">
                    <button class="nav-link" id="Appointment-tab" data-bs-toggle="tab" data-bs-target="#Appointment" type="button"
                        role="tab" aria-controls="Appointment" aria-selected="false">Appointment</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                {{-- Sales Start --}}
                <div class="tab-pane fade show active" id="Sales" role="tabpanel" aria-labelledby="Sales-tab">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Branch</th>
                                <th>Date</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                {{-- Sales End --}}

                {{-- Appointment Start --}}
                <div class="tab-pane fade" id="Appointment" role="tabpanel" aria-labelledby="Appointment-tab">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $key=>$appoint )
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $appoint->customer->name }}</td>
                                    <td>{{ $appoint->appointment_date }}</td>
                                    @php
                                        $total = 0;
                                        foreach ($appoint->details as $key => $value) {
                                            $total += $value->treatment->price;
                                        }
                                    @endphp
                                    <td>Rp. {{ number_format($total) }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" class="btn btn-primary">View</button>
                                            {{-- <button type="button" class="btn btn-primary">2</button> --}}
                                          </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Appointment End --}}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
