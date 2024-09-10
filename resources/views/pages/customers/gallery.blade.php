@extends('layouts.app')

@section('page-header')
    <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-account-multiple"></i>
    </span> Customers
@endsection

@section('styles')
    <style>
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
                    <h4>{{ $customer[0]->name }} Gallery</h4>
                </div>
                <div class="col-lg-6 text-end">
                    <h4>{{ Auth::user()->branches[0]->name }}</h4>
                </div>
            </div>

        </div>
        <div class="card-body">
            @if (isset($customer[0]->galleries[0]->name))
                <div class="row">
                    @foreach ($customer[0]->galleries as $images)
                        <div class="col-md-2">
                            <div class="card rounded-xl text-white bg-primary mb-3 p-2 card-hover" style="max-width: 18rem;"
                                data-bs-toggle="modal" data-bs-target="#cardModal">
                                <img class="card-img-top border border-light" src="{{ asset('storage/' . $images->image) }}"
                                    alt="Card image cap" data-bs-toggle="modal" data-bs-target="#imageModal-{{ $images->id }}"
                                    style="cursor: pointer;" />

                                <div class="card-header py-1">
                                    <h2>{{ $images->name }}</h2>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div>
                    <h4>-- No Image Existed --</h4>
                </div>
            @endif
        </div>
    </div>


    {{-- Floating Action Buttons Start --}}
    <div class="floating-container">
        <div class="floating-button">+</div>
        <div class="element-container">

            <button class="float-element" data-bs-toggle="modal" data-bs-target="#uploadImage">
                <i class="material-icons">Add
                </i>
            </button>
        </div>
    </div>
    {{-- Floating Action Button End --}}

    @if (isset($customer[0]->galleries[0]->name))
        @foreach ($customer[0]->galleries as $images)
            <!-- Modal for enlarging the image -->
            <div class="modal fade" id="imageModal-{{ $images->id }}" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-body d-flex justify-content-center">
                            <img src="{{ asset('storage/' . $images->image) }}" class="img-fluid"
                                alt="Enlarged image">
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
    @endif


    <!-- Modal for uploading image -->
    <form method="POST" action="{{ route('customer.galleriesstore', $customer[0]->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="uploadImage" tabindex="-1" aria-labelledby="uploadImageLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-body d-flex">
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
                    <div class="modal-body d-flex">
                        <label class="form-label">File Name</label>
                        <input class="form-control" id="name" name="name">
                    </div>
                    <div class="p-4">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                            <button type="button" class="btn btn-secondary">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
