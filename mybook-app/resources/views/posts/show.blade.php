@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2>詳細</h2>
                <br>
                <div class="card text-center">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <h4 class="card-title">{{ $post->title }}</h4>
                        <p class="card-text">出版社：{{ $post->publication }}</p>
                        <p class="card-text">著者名：{{ $post->author }}</p>
                        <p class="card-text">ジャンル：{{ $post->category->name }}</p>
                        <p class="card-text">金額（税抜き）: {{ $post->price }}円</p>
                        {{-- @if~@endif = 画像があれば表示する --}}
                        @if ($post->image)
                            <div>
                                <img src="{{ asset('storage/images/' . $post->image) }}" style="height:200px">
                            </div>
                        @endif
                        <br>
                        <p class="show-text">【メモ】</p>
                        <div class="remarks-box">
                            <p class="remarks-text">{{ $post->remarks }}</p>
                        </div>
                        <div class="button">
                            {{-- ログイン中のuser_idとPostsのuser_idとAuthのidが一致したら、削除のボタンを表示する --}}
                            @if ($post->user_id === Auth::id())
                                {{-- $post->idは、パラメーターを渡す事により表示される投稿にidが振られる --}}
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-dark">編集</a>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        <a class="navbar-brand">
                            {{ config('app.name') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
