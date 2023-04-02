<x-frontend-layout>

<div class="row mt-3">
    @foreach ($articles as $article)
        <div class="col-md-3 d-flex justify-content-center mb-4">
            <div class="card" style="width: 18rem;">
              <img src="{{ asset('img/news.jpg') }}" class="img-thumbnail"><br>
                <div class="menu-custom card-body">
                    <div class="card-title">
                        <h5><b>{{$article->title}}</b></h5>
                    </div>
                    <span>{{$article->content}}</span>
                    <p>{{$article->author}}</p>
                    <a href="{{$article->url}}" class="btn btn-dark">Detail</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</x-frontend-layout>



