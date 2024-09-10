@extends('layouts.app')

@section('page-header')
    <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-account-multiple"></i>
    </span> Items
@endsection

@section('styles')
    <style>
        .form-control {
            border-width: 2px;
            border-color: #858585;
        }

        select.form-control {
            /* border-color: #858585 !important;
                                                color: #858585 !important; */
            outline: 2px solid #858585 !important;
        }

        .preview-container {
            max-width: 100%;
            max-height: 100%;
            overflow: hidden;
            border: 1px solid #ddd;
            border-radius: .25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }

        .preview-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex justify-content-between">
                <div class="col-lg-6">
                    <h4>Items</h4>
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
                        <th>Category</th>
                        <th>Branch</th>
                        <th>Stock</th>
                        <th>EXP</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>#</td>
                            <td>{{ $item->name }}</td>
                            <td> {{ $item->category->name }}</td>
                            <td>{{ $item->branch->name }} </td>
                            <td>{{ $item->itemsStock[0]->qty }} </td>
                            <td>{{ $item->expiry_date }}</td>
                            <td>Rp. {{ number_format($item->hpp) }} </td>
                            <td><button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#view-edit-modal-{{ $item->id }}">View/Edit</button></td>
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

    <!-- Modal Create Start -->
    <form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="create-Cat" tabindex="-1" aria-labelledby="cardModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h2 class="modal-title" id="cardModalLabel">Create Category</h2>
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
                                        <label class="col-sm-3 col-form-label">Expiry date</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control" name="expiry_date">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Descriptions</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="descriptions">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Category</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="category" name="category">
                                                <option> -- Pick Category --</option>
                                                @foreach ($category as $cat)
                                                    <option value="{{ $cat->id }}"> {{ $cat->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">HJL</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="hjl">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">HPP</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="hpp">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg content-center">
                                    <div class="preview-container">
                                        <img id="imagePreview" src="#" alt="Image Preview" style="display: none;">
                                    </div>
                                    <div class="mb-3">
                                        <label for="fileInput" class="form-label">Choose an image</label>
                                        <input class="form-control" type="file" id="fileInput" name="image"
                                            accept="image/*">
                                    </div>
                                </div>
                            </div>
                            <br>
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
    <!-- Modal Create End -->

    {{-- Modal View and edit Start --}}
    @foreach ($items as $item)
        <form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal fade" id="view-edit-modal-{{ $item->id }}" tabindex="-1"
                aria-labelledby="cardModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h2 class="modal-title" id="cardModalLabel">{{ $item->name }}</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row d-flex align-items-center">
                                    <div class="col-lg">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" value="{{ $item->name }}" readonly name="name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Expiry date</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" value="{{ $item->expiry_date }}" readonly name="expiry_date">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Descriptions</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" value="{{ $item->descriptions }}" readonly name="descriptions">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Category</label>
                                            <div class="col-sm-9">
                                                <select style="color: #000000 !important" class="form-control" id="category" name="category">
                                                    <option> -- Pick Category --</option>
                                                    @foreach ($category as $cat)
                                                        <option value="{{ $cat->id }}"
                                                            {{ isset($item) && $item->category_id == $cat->id ? 'selected' : '' }}>
                                                            {{ $cat->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">HJL</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" value="{{ $item->hjl }}" readonly name="hjl">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">HPP</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" value="{{ $item->hpp }}" readonly name="hpp">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg content-center">
                                        <div class="preview-container">
                                            <img id="imagePreview" src="{{ asset('storage/' . $item->image) }}" alt="Image Preview"
                                                style="{{ isset($item->image) ? '' : 'display: none;' }}">
                                        </div>
                                        <div id="input-image-div" class="mb-3" hidden>
                                            <label for="fileInput" class="form-label">Choose an image</label>
                                            <input class="form-control" type="file" id="fileInput" name="image"
                                                accept="image/*">
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-gradient-success btn-icon-text" hidden>
                                <i class="mdi mdi-close-box btn-icon-prepend"></i> Save
                            </button>
                            <button type="button" class="btn btn-gradient-danger btn-icon-text" data-bs-dismiss="modal">
                                <i class="mdi mdi-hospital btn-icon-prepend"></i> Close
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach
    {{-- Modal View and edit End --}}
@endsection

@section('scripts')
    <script>
        document.getElementById('fileInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgElement = document.getElementById('imagePreview');
                    imgElement.src = e.target.result;
                    imgElement.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
