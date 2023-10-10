@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2>購入書籍一覧</h2>
                <br>
                <div>
                    <a href="{{route('posts.create')}}" class="btn btn-primary">本の新規登録</a>
                </div>
                <br>
                <div class="card text-center">
                    <div class="card-header">書籍一覧</div>

                    {{-- foreachで回すことで一覧で投稿を取得できる --}}
                    @foreach ($posts as $post)
                        <div class="card-body">
                            <h4 class="card-title">表題：{{$post->title}}</h4>
                            <h5 class="card-text">著者：{{$post->author}}</h5>
                            <p>購入年月日：{{$post->date}}</p>

                            {{-- @if~@endif = 画像があれば表示する --}}
                            @if ($post->image)
                                <div>
                                    <img src="{{asset('storage/images/'.$post->image)}}" style="height:200px">
                                </div>
                            @endif

                            {{-- $post->user->name = 投稿に紐ずくuserの名前を取得することができる --}}
                            <p class="card-text">登録者：{{ $post->user->name }}</p>
                            <p class="card-text">投稿日：{{$post->created_at}}</p>

                            {{-- $post->idでパラメーターを渡す事で表示される投稿にidが振られる --}}
                            <div>
                                <a href="{{route('posts.show', $post->id)}}" class="btn btn-primary">詳細</a>
                            </div>
                        </div>
                        <div class="card-footer text-muted"></div>
                        <br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center mb-5">
        {{ $posts->links() }}
    </div>
@endsection
