@extends('layouts.app')

@section('page-header')
    <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-account-multiple"></i>
    </span> Customers
@endsection

@section('styles')
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
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Branch</th>
                        <th>Items</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($category as $cat)
                        <tr>
                            <td>#</td>
                            <td>{{ $cat->name }}</td>
                            <td> {{ $cat->branch->name }}</td>
                            <td> {{ count($cat->items) > 0 ? count($cat->items) : 0 }}</td>
                            <td><label class="badge badge-danger">Pending</label></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Floating Action Buttons Start --}}
    <div class="floating-container">
        <div class="floating-button">+</div>
        <div class="element-container">

            <button class="float-element" data-bs-toggle="modal" data-bs-target="#create-Cat">
                <i class="material-icons">Add
                </i>
            </button>
        </div>
    </div>
    {{-- Floating Action Button End --}}

    <!-- Modal Start -->
    <form method="POST" action="{{ route('category.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="create-Cat" tabindex="-1" aria-labelledby="cardModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h2 class="modal-title" id="cardModalLabel">Create Category</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="name">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-gradient-success btn-icon-text">
                            <i class="mdi mdi-close-box btn-icon-prepend"></i> Save
                        </button>
                        <button type="button" class="btn btn-gradient-danger btn-icon-text" data-bs-dismiss="modal">
                            <i class="mdi mdi-hospital btn-icon-prepend"></i> Cancel
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
@endsection
