@extends('layouts.app')

@section('page-header')
    <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-account-multiple"></i>
    </span> Customers
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/summernote/src/styles/bs5/summernote-bs5.html') }}">
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
            max-width: 200px;
            max-height: 200px;
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
                    <h4>Customer</h4>
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
                        <div class="col-lg">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Phone</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="phone">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Address</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="address">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Gender</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="gender" name="gender">
                                        <option> -- Pick Gender --</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="prefer not to say">prefer not to say</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg content-center">
                            <div class="preview-container">
                                <img id="imagePreview" src="#" alt="Image Preview" style="display: none;">
                            </div>
                            <div class="mb-3">
                                <label for="fileInput" class="form-label">Choose an image</label>
                                <input class="form-control" type="file" id="fileInput" name="image" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="descriptions">
                        <label for="editor" class="form-label">Special Note</label>
                        <textarea id="summernote" name="medical_informations">-</textarea>
                    </div>
                    <br>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                        <button type="button" class="btn btn-secondary">Cancel</button>
                    </div>
                </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendors/summernote/summernote-lite.min.js') }}"></script>
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
    <script>
        $('#summernote').summernote({
            placeholder: 'Allergies, Sickness, Etc',
            tabsize: 2,
            height: 120,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    </script>
@endsection
