@extends('public/template/layout')

@section('title', 'Berita Terkini Hari Ini, Kabar Akurat Terpercaya')

@section('content')
    <div class="page-heading d-flex justify-content-between mb-3">
        <h3>Latest News</h3>
        <div class="input-group" style="width: 30%">
            <input type="text" class="form-control" placeholder="Search..." aria-label="Search..." aria-describedby="button-addon2" id="search_articles" value="">
            <button class="btn btn-outline-secondary" type="button" id="button-addon1" onclick="clearSearch()">Clear</button>
            <button class="btn btn-primary" type="button" id="button-addon1" onclick="getArticles()">Cari</button>
        </div>
        <div class="filter-show d-flex align-items-center">
            <span class="me-2">Filter:</span>
            <select class="form-select" id="filter_show" name="filter_show" onchange="getArticles()">
                <option value="10" selected>10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="all">All</option>
            </select>
        </div>
    </div>

    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body row">
                                <div class="loading text-center">
                                    <div class="spinner-grow mt-3" style="width: 3rem; height: 3rem;" role="status">
                                    </div>
                                    <p class="my-3 ms-2 ">Loading...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

{{-- @if (!$articles->isEmpty())
    @foreach ($articles as $article)
        <div class="row g-0 col-md-6 mb-3">
            <img src="{{ $article->image }}" class="img-fluid rounded-start col-lg-6" style="width: 200px; object-fit: contain;">

            <div class="card-body col-md-6 d-flex flex-column">
                <h5 class="card-title fw-bold">{{$article->title}}</h5>
                {!! cut_sentences($article->content,2) !!}

                <p class="mt-auto mb-0"> <!-- Apply mt-auto directly to the paragraph -->
                    <small class="text-muted">{{ @$article->user->name }} - {{ \Carbon\Carbon::parse($article->publication_date)->diffForHumans() }}</small>
                </p>
            </div>
        </div>
    @endforeach
@else
    <div class="col-12 text-center">
        No news yet
    </div>
@endif --}}

@section('js')
    <script src="{{asset('assets/extensions/moment/moment.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            getArticles();
		});

        function getArticles() {
            let limit = $('#filter_show').val();
            let search = $('#search_articles').val() ?? '';

            console.log(search, 'ini seracghnya')

            $.ajax({
                type: "GET",
                url: "{{ url('/get-public-articles')}}/"+limit+'/'+ search,
                dataType: "json",
                beforeSend: function(){
                    $('.loading').show();
                },
                success: function (articles) {
                    let html = '';
                    if (articles.length > 0) {
                        articles.forEach(function (article) {
                            html += `
                                <div class="row g-0 col-md-6 mb-3">
                                    <img src="{{ asset('${article.image}') }}" class="img-fluid rounded-start col-lg-6" style="width: 200px; object-fit: contain;">

                                    <div class="card-body col-md-6 d-flex flex-column">
                                        <a href="{{ url('/read') }}/${article.slug}">
                                            <h5 class="card-title fw-bold">${article.title}</h5>
                                        </a>
                                        ${cutSentences(article.content)}

                                        <p class="mt-auto mb-0">
                                            <small class="text-muted">${article?.user?.name} - ${moment(article.publication_date).fromNow()}</small>
                                        </p>
                                    </div>
                                </div>
                            `
                        });
                    } else {
                        html += `
                            <div class="col-12 text-center">
                                No News
                            </div>
                        `;
                    }
                    $('.card-body').html(html);
                },
                complete: function(){
                    $('.loading').hide();
                }
            });
        }

        function clearSearch() {
            $('#search_articles').val('');
            getArticles();
        }
    </script>
@endsection
