@extends('layouts.app')

@section('page-header')
    <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-account-multiple"></i>
    </span> Supplies
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
                    <h4>Medical Supplies</h4>
                </div>
                <div class="col-lg-6 text-end">
                    <h4>{{ Auth::user()->branches[0]->name }}</h4>
                </div>
            </div>

        </div>
        <div class="card-body">
            <table class="table table-responsive table-hover wrap" id="suppliesDt">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Branch</th>
                        <th>Stock</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($supplies as $supply)
                        <tr>
                            <td>#</td>
                            <td>{{ $supply->name }}</td>
                            <td>{{ $supply->branch->name }}</td>

                            <td> {{ round($supply->itemsStock[0]->qty / $supply->itemsStock[0]->capacity) }}
                                <small>({{ $supply->itemsStock[0]->qty }} - {{ $supply->itemsStock[0]->units }})</small>
                            </td>
                            <td>Rp. {{ number_format($supply->hjl, 0, '.', '.') }}</td>
                            <td><button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#view-edit-modal-{{ $supply->id }}">View/Edit</button></td>
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

            <button class="float-element" data-bs-toggle="modal" data-bs-target="#create-supply">
                <i class="material-icons">Add
                </i>
            </button>
        </div>
    </div>
    {{-- Floating Action Button End --}}

    <!-- Modal Create Start -->
    <form method="POST" action="{{ route('supplies.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="create-supply" tabindex="-1" aria-labelledby="cardModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h2 class="modal-title" id="cardModalLabel">Create Supply</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row d-flex align-items-center">
                                <div class="col-lg">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="name" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Descriptions</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="description">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Unit</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="units" required
                                                placeholder="Ml / Mg / Tab / Pcs">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Unit Capacity</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="capacity" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Reminder</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="reminder">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">HJL</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="hjl" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">HPP</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="hpp" required>
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

    @foreach ($supplies as $supply)
        <div class="modal fade" id="view-edit-modal-{{ $supply->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h2 class="modal-title" id="cardModalLabel"><span id="new-title"></span>{{ $supply->name }}</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div id="view-mode-{{ $supply->id }}">
                                <div class="row d-flex align-items-center justify-items-center">
                                    <div class="col-lg">
                                        <!-- View Mode -->
                                        <table class="table table-responsive mx-auto">
                                            <tbody class="table-body">
                                                <tr>
                                                    <td>Name</td>
                                                    <td>{{ $supply->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Description</td>
                                                    <td>{{ $supply->description ? $supply->description : '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>HJL</td>
                                                    <td>Rp. {{ number_format($supply->hjl) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>HPP</td>
                                                    <td>Rp. {{ number_format($supply->hpp) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Reminder</td>
                                                    <td>{{ $supply->itemsStock[0]->reminder }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="col-lg content-center">
                                            <div class="preview-container">
                                                <img src="{{ $supply->image ? asset('storage/' . $supply->image) : asset('assets/images/default-supplies.png') }}"
                                                    alt="Image Preview"
                                                    style="width:90%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="edit-mode-{{ $supply->id }}" style="display: none;">
                            <!-- Edit Mode -->
                            <form action="{{ route('supplies.update', $supply->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row d-flex align-items-center">
                                    <div class="col-lg">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="name" required
                                                    value="{{ $supply->name }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Descriptions</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="description"
                                                    value="{{ $supply->description }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Unit</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="units" required
                                                    value="{{ $supply->itemsStock[0]->units }}"
                                                    placeholder="Ml / Mg / Tab / Pcs">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Unit Capacity</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="capacity" required
                                                    value="{{ $supply->itemsStock[0]->capacity }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Reminder</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="reminder" required
                                                    value="{{ $supply->itemsStock[0]->reminder }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">HJL</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="hjl" required
                                                    value="{{ $supply->hjl }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">HPP</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="hpp" required
                                                    value="{{ $supply->hpp }}">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg content-center">
                                        <div class="preview-container">
                                            <img id="updatedImage"
                                                src="{{ $supply->image ? asset('storage/' . $supply->image) : '#' }}"
                                                alt="Image Preview">
                                        </div>
                                        <div class="mb-3">
                                            <label for="fileInput" class="form-label">Choose an image</label>
                                            <input class="form-control" type="file" id="updateImage" name="image"
                                                accept="image/*">
                                        </div>

                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Save Changes</button>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="toggleEditMode({{ $supply->id }})"
                            id="toggle-button-{{ $supply->id }}">Edit</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- Modal View and edit End --}}
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            new DataTable('#suppliesDt', {
                colReorder: true,
                responsive: true,
                layout: {
                    topStart: {
                        pageLength: {
                            menu: [5, 10, 25, 50]
                        },
                        buttons: [
                            'colvis',
                            {
                                extend: 'spacer',
                                style: 'bar',
                                // text: 'Export files:'
                            },
                            'excel',
                            'pdf'
                        ]
                    },
                },
            });
        });
    </script>
    <script>
        function toggleEditMode(id) {
            var viewMode = document.getElementById(`view-mode-${id}`);
            var editMode = document.getElementById(`edit-mode-${id}`);
            var toggleButton = document.getElementById(`toggle-button-${id}`);
            document.getElementById('new-title').innerHTML = "Update "
            if (viewMode.style.display === "none") {
                // Switch to view mode
                viewMode.style.display = "block";
                editMode.style.display = "none";
                toggleButton.textContent = "Edit";
            } else {
                // Switch to edit mode
                viewMode.style.display = "none";
                editMode.style.display = "block";
                toggleButton.textContent = "Cancel Edit";
            }
        }
    </script>
    <script>
        document.getElementById('fileInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgElement = document.getElementById('imagePreview');
                    imgElement.src = e.target.result; // Update with the new image
                    imgElement.style.display = 'block'; // Ensure the image is visible
                };
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('updateImage').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgElement = document.getElementById('updatedImage');
                    imgElement.src = e.target.result; // Update with the new image
                    imgElement.style.display = 'block'; // Ensure the image is visible
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
