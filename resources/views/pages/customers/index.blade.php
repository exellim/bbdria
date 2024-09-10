@extends('layouts.app')

@section('page-header')
    <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-account-multiple"></i>
    </span> Customers
@endsection

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
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex justify-content-between">
                <div class="col-lg-6">
                    <h4>Customer</h4>
                </div>
                <div class="col-lg-6 text-end">
                    <h4>{{ Auth::user()->branches[0]->name }}</h4>
                </div>
            </div>

        </div>
        <div class="card-body">
            @if (isset($customers[0]->name))
                <div class="row">
                    @foreach ($customers as $customer)
                        <div class="col-md-4">
                            <div class="card rounded-xl text-white bg-primary mb-3 p-2 card-hover" style="max-width: 18rem;"
                                data-bs-toggle="modal" data-bs-target="#customer-view-{{ $customer->id }}">
                                <img class="card-img-top border border-light" src="{{ asset('storage/' . $customer->image) }}"
                                    alt="Card image cap">
                                <div class="card-header py-1">
                                </div>
                                <div class="card-body">
                                    <h3>{{ Str::limit($customer->name, 10, '...') }}</h3>
                                    <h4>{{ $customer->phone }}</h4>
                                    <h4>{{ $customer->address }}</h4>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div>
                    <h4>-- No customer Existed --</h4>
                </div>
            @endif
        </div>
    </div>

    {{-- Floating Action Buttons Start --}}
    <div class="floating-container">
        <div class="floating-button">+</div>
        <div class="element-container">

            <a class="float-element" href="{{ route('customer.create') }}">
                <i class="material-icons">Add
                </i>
            </a>
        </div>
    </div>
    {{-- Floating Action Button End --}}

    <!-- Modal Start -->
    @foreach ($customers as $customer)
        <div class="modal fade" id="customer-view-{{ $customer->id }}" tabindex="-1" aria-labelledby="cardModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h2 class="modal-title" id="cardModalLabel">{{ $customer->name }}</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img class="card-img-top border border-light"
                                    src="{{ asset('storage/' . $customer->image) }}" alt="Card image cap">
                            </div>
                            <div
                                class="col-md-6 d-flex flex-column justify-content-center align-items-center information py-4 px44">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <td class="text-center">Name</td>
                                            <td class="text-start">{{ $customer->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Phone</td>
                                            <td class="text-start">{{ $customer->phone }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Address</td>
                                            <td class="text-start">{{ $customer->address }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Gender</td>
                                            <td class="text-start">{{ $customer->gender }}</td>
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
                                                                Special Note
                                                            </button>
                                                        </h2>
                                                        <div id="collapseOne" class="accordion-collapse collapse show"
                                                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                {!! $customer->medical_informations !!}
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
                        <a class="btn btn-gradient-primary btn-icon-text" href="{{ route('customer.galleries', $customer->id) }}" target="_blank">
                            <i class="mdi mdi-folder-image btn-icon-prepend"></i> Open Gallery </a>
                        <a class="btn btn-gradient-success btn-icon-text" href="#" target="_blank">
                            <i class="mdi mdi-hospital btn-icon-prepend"></i> Open Medical Reports </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- Modal End -->
@endsection

@section('scripts')
@endsection
