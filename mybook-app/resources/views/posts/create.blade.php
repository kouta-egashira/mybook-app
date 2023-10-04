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
                <h2>新規登録</h2>
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}  {{-- csrf_field() 悪意のあるユーザが来ないように保護 --}}
                    <div class="form-group">
                        <label>タイトル</label>
                        <input type="text" class="form-control" placeholder="タイトルを入力してください" name="title">
                    </div>
                    <br>
                    <div class="form-group">
                        <label>著者</label>
                        <input type="text" class="form-control" placeholder="著者を入力してください" name="author">
                    </div>
                    <br>
                    <div class="form-group">
                        <label>出版社</label>
                        <input type="text" class="form-control" placeholder="出版社を入力してください" name="publication">
                    </div>
                    <br>
                    <div class="form-group">
                        <label>金額</label>
                        <input type="int" class="form-control" placeholder="金額を入力してください" name="price">
                    </div>
                    <br>
                    <div class="form-group">
                        <label>備考</label>
                        <textarea class="form-control" placeholder="備考" rows="5" name="remarks"></textarea>
                    </div>
                    <br>
                    <div class="form-group">
                        <label>ISBN</label>
                        <input type="char" class="form-control" placeholder="ISBNを入力してください" name="isbn">
                    </div>
                    <br>
                    <div class="form-group">
                        <label>URL</label>
                        <input type="string" class="form-control" placeholder="URLを入力してください" name="url">
                    </div>
                    {{-- 画像アップロード --}}
                    {{-- <div>
                        <input id="image" type="file" name="image">
                    </div> --}}
                    <br>
                    <div>
                        <button type="submit" class="btn btn-primary">登録する</button>
                    </div>
                    <br>
                    <div>
                        <a href="{{route('posts.index')}}" class="btn btn-danger">一覧へ戻る</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
