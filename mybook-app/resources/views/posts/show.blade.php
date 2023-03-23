@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2>詳細ページ</h2>
                <br>
                <div>
                    <a href="{{route('posts.create')}}" class="btn btn-primary">本の新規登録</a>
                </div>
                <br>
                <div>
                    <a href="{{route('posts.index')}}" class="btn btn-danger">一覧へ戻る</a>
                </div>

                <br>
                <div class="card text-center">
                    <div class="card-header">

                    </div>
                        <div class="card-body">
                            <h4 class="card-title">{{$post->title}}</h4>
                            <p class="card-text">著者：{{$post->author}}</p>
                            <p class="card-text">出版社：{{$post->publication}}</p>
                            <p class="card-text">金額：{{$post->price}}円（税込み）</p>

                            {{-- @if~@endif = 画像があれば表示する --}}
                            @if ($post->image)
                                <div>
                                    <img src="{{asset('storage/images/'.$post->image)}}" style="height:200px">
                                </div>
                            @endif
                            <p class="show-text">備考</p>
                            <div class="text-box">
                                <p class="remarks-text">{{$post->remarks}}</p>
                            </div>
                            <div class="button">
                                {{-- ログイン中のuser_idとPostsのuser_idとAuthのidが一致したら、削除のボタンを表示する --}}
                                @if ($post->user_id === Auth::id())
                                    {{-- $post->idは、パラメーターを渡す事により表示される投稿にidが振られる --}}
                                    <a href="{{route('posts.edit', $post->id)}}" class="btn btn-primary">編集画面へ</a>
                                    <form action='{{ route('posts.destroy', $post->id) }}' method='post'>
                                        {{ csrf_field() }}
                                        {{-- HTMLフォームはPUT、PATCH、DELETEアクションをサポートしてしていない為、擬似フォームメソッドを用いて送る --}}
                                        {{ method_field('DELETE') }}
                                        <br>
                                        <input type='submit' value='削除' class="btn btn-danger" onclick='return confirm("削除しますか？");'>
                                    </form>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            登録日：{{$post->created_at}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


