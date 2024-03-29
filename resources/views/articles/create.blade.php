@extends('layout')

@section('title', "Create | Articles")

@section('css')
    <link rel="stylesheet" href="{{asset('assets/extensions/filepond/filepond.css')}}">
    <link rel="stylesheet" href="{{asset('assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/pages/filepond.css')}}">

    <link rel="stylesheet" href="{{asset('assets/css/pages/summernote.css')}}">
    <link rel="stylesheet" href="{{asset('assets/extensions/summernote/summernote-lite.css')}}">

    <style>
        .image-preview-filepond{
            margin-bottom: 0px;
        }

        .filepond--drop-label{
            background-color: #f1f0ef;
        }
    </style>
@endsection

@section('content')
    @if ($errors->any())
        <div class="card-body pt-0">
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible show fade">
                    <i class="bi bi-file-excel"></i> {{ $error }}

                    <button type="button" class="btn-close btn-close-session" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endforeach
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Add Articles</h4>
        </div>

        <div class="card-content">
            <div class="card-body">
                <form method="POST" action="{{ url('/admin/articles') }}" id="form_create_user" enctype="multipart/form-data">
                    @method('POST')
                    @csrf

                    <input type="hidden" name="user_id" value="{{ getUserID() }}">

                    <div class="form-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" id="title" class="form-control  @error('title') is-invalid @enderror" name="title" placeholder="Title..." value="{{ old('title') }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label class="form-label">Slug <span class="text-danger">*</span></label>
                                <small class="text-muted">Can be custom or automatic from the title</small>
                                <input type="text" id="slug" class="form-control @error('slug') is-invalid @enderror" name="slug" placeholder="Slug..." value="{{ old('slug') }}">
                            </div>
                        </div>

                        <div class="form-group col-md-8">
                            <label class="form-label">Image <span class="text-danger">*</span></label>
                            <input type="file" class="image-preview-filepond" name="image" id="image">
                        </div>

                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label class="form-label">Content <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content">{{ old('content') }}</textarea>
                            </div>
                        </div>


                        <div class="col-sm-12 d-flex justify-content-end mt-4">
                            <button type="button" class="btn btn-primary me-1 mb-1 submit_create_user" id="submit_create_user" onclick='preventDoubleClick("form_create_user", "submit_create_user")'>Submit</button>

                            <a href="{{ url('/admin/articles') }}" class="btn btn-light-secondary mx-1 mb-1">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/extensions/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js')}}"></script>
    <script src="{{ asset('assets/extensions/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js')}}"></script>
    <script src="{{ asset('assets/extensions/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js')}}"></script>
    <script src="{{ asset('assets/extensions/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js')}}"></script>
    <script src="{{ asset('assets/extensions/filepond-plugin-image-filter/filepond-plugin-image-filter.min.js')}}"></script>
    <script src="{{ asset('assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js')}}"></script>
    <script src="{{ asset('assets/extensions/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js')}}"></script>

    <script src="{{asset('assets/extensions/filepond/filepond.js')}}"></script>
    <script src="{{asset('assets/js/pages/filepond.js')}}"></script>
    <script src="{{asset('assets/extensions/summernote/summernote-lite.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/summernote.js')}}"></script>

    <script>
        $(document).ready(function () {
            $(".filepond--drop-label").addClass("form-control")

            @if($errors->has('image'))
                $(".filepond--drop-label").addClass("is-invalid")
            @endif

            setTimeout(function() {
                @if($errors->has('content'))
                    $(".note-editing-area").addClass("is-invalid")
                @endif

                $(".note-editing-area").addClass("form-control")
            }, 100);

            $('#content').summernote({
                tabsize: 1,
                height: 1000,
            })
        });

        $('#title').on('input', function() {
            var title = $(this).val()
            var slug = title.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '')
            $('#slug').val(slug)
        })
    </script>
@endsection
