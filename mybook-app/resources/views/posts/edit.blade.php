@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                {{-- Request/PostRequestで作成したバリデーションメッセージを表示 --}}
                @if ($errors->any())
                    <div class="alert alert-danger"> {{-- エラーがあれば赤色で表示 --}}
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="return-btn">
                    <a href="{{route('posts.index')}}" class="btn btn-danger">一覧へ戻る</a>
                </div>
                {{-- $post->id どのpostの更新をするのか --}}
                <form action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data" method="POST">
                    {{csrf_field()}}  {{-- csrf_field() 悪意のあるユーザが来ないように保護 --}}
                    {{method_field('PATCH')}} {{-- htmlでPATCHは使えない為、method_field('PATCH')と記載 --}}
                    <div class="form-group">
                        <label>タイトル</label>
                        {{-- value="{{$post->title}} 編集時に前入力文字が表示されている --}}
                        <input type="text" class="form-control" placeholder="タイトルを入力して下さい" name="title" value="{{$post->title}}">
                    </div>
                    <br>
                    <div class="form-group">
                        <label>著者</label>
                        {{-- value="{{$post->title}} 編集時に前入力文字が表示されている --}}
                        <input type="text" class="form-control" placeholder="著者を入力して下さい" name="author" value="{{$post->author}}">
                    </div>
                    <br>
                    <div class="form-group">
                        <label>出版社</label>
                        {{-- value="{{$post->title}} 編集時に前入力文字が表示されている --}}
                        <input type="text" class="form-control" placeholder="出版社を入力して下さい" name="publication" value="{{$post->publication}}">
                    </div>
                    <br>
                    <div class="form-group">
                        <label>金額</label>
                        {{-- value="{{$post->title}} 編集時に前入力文字が表示されている --}}
                        <input type="int" class="form-control" placeholder="金額を入力して下さい" name="price" value="{{$post->price}}">
                    </div>
                    <br>
                    <div class="form-group">
                        <label>備考</label>
                        <textarea class="form-control" placeholder="備考" rows="5" name="remarks">{{$post->remarks}}</textarea>
                    </div>
                    {{-- @if~@endif = 画像があれば表示する --}}
                    @if ($post->image)
                    <div class="image-storage">
                        <img src="{{asset('storage/images/'.$post->image)}}" style="height:150px">
                    </div>
                    @endif
                    {{-- 画像アップロード --}}
                    <div class="form-group">
                        <div class="file-form">
                            <input id="image" type="file" name="image">
                        </div>
                    </div>
                    <div class="update-btn">
                        <button type="submit" class="btn btn-primary">更新する</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
