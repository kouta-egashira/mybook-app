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
                <h2>書籍追加</h2>
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}  {{-- csrf_field() 悪意のあるユーザが来ないように保護 --}}

                    {{-- 年月日入力 --}}
                    <div class="form-group">
                        <label>購入年月日</label>
                        <input type="date" class="form-control" name="date">
                    </div>
                    <br>
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
                    {{-- 画像アップロード --}}
                    <div>
                        <input id="image" type="file" name="image">
                    </div>
                    <br>
                    <div>
                        <button type="submit" class="btn btn-primary">登録する</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
