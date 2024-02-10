@extends('layout')

@section('title', 'Articles')

@section('css')
    <style>
        .datatable-column-width{
            overflow: hidden; text-overflow: ellipsis; max-width: 200px;
        }
    </style>
@endsection

@section('content')
    <section class="section">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible show fade">
                <i class="bi bi-check-circle"></i> {{session('success')}}
                <button type="button" class="btn-close btn-close-session text-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    <a href="{{ url('admin/articles/create') }}" class="btn icon btn-success" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add">
                        <i class="bi bi-plus-circle"></i>
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table class="table" id="table_articles">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Image</th>
                            <th>Title</th>
                            {{-- <th>Content</th> --}}
                            <th>Publication Date</th>
                            <th>Author</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($articles as $key_article => $article)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><img src="{{ asset($article->image ?? 'assets/images/samples/building.jpg') }}" alt="can't load image" width="100px"></td>
                                <td>
                                    <div class="datatable-column-width">
                                        {{ substr($article->title, 0, 100) }}
                                    </div>
                                </td>
                                {{-- <td>
                                    <div class="datatable-column-width">
                                        {!! substr($article->content, 0, 100) !!} erohweui
                                    </div>
                                </td> --}}
                                <td>{{ $article->publication_date }}</td>
                                <td>{{ @$article->user->name }}</td>
                                <td>
                                    <div class="buttons">
                                        <a href="{{ url('admin/articles/'.$article->id.'/edit') }}" class="btn icon btn-primary tooltip-class" data-bs-placement="left" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <button type="button" class="btn icon btn-danger tooltip-class" data-bs-placement="right" title="Remove" data-bs-toggle="modal" data-bs-target="#modal_remove" onclick="modalRemove('{{ url('admin/articles/'.$article->id) }}')">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- Modal Remove--}}
        <div class="modal fade text-left" id="modal_remove" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title white" id="myModalLabel120">Confirmation</h5>

                        <button type="button" class="close" data-bs-dismiss="modal"aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        Are you sure want to remove this data?
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">No</span>
                        </button>

                        <form action="" method="post" id="form_delete_article">
                            @method("DELETE")
                            @csrf

                            <button type="submit" class="btn btn-danger ml-1" data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Yes</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    {{-- Modal Remove --}}
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            // Init Datatable
            $("#table_articles").DataTable();
		});

        // Init Tooltip
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('#table_articles .tooltip-class'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        }, false);

        // Modal Remove
        function modalRemove(url) {
            $('#form_delete_article').attr("action", url)
        }
    </script>
@endsection
