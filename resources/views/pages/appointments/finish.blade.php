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
        <form method="POST" action="{{ route('customer.store') }}" enctype="multipart/form-data">
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
                    <h4>Treatment's Data</h4>
                    <div class="d-flex align-items-center">
                        <div class="col-lg">
                            <h5>Treatments:</h5>
                            <table class="table">
                                <thead>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Qty</th>
                                </thead>
                                <tbody class="table-body">
                                    @foreach ($appointments[0]->details as $treat)
                                        <tr>
                                            <td colspan="3" class="bg-primary text-white"><b>{{ $treat->treatment->name }}</b></td>
                                        </tr>
                                        @foreach ($treat->treatment->components as $comp)
                                            <tr>
                                                <td>
                                                    #
                                                </td>
                                                <td>
                                                    <input type="text" readonly class="form-control" id="treatment_id[]"
                                                        name="treatment_id[]" value="{{ $comp->supply_id }}" hidden>
                                                    <b>{{ $comp->supplies->name }}</b>
                                                </td>
                                                <td>
                                                    <input type="text" readonly class="form-control" id="qty[]"
                                                        name="qty[]" value="{{ $comp->qty }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach

                                </tbody>
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
@endsection
