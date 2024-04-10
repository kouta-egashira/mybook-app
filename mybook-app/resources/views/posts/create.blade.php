@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                {{-- Request/PostRequestで作成したバリデーションメッセージを表示 --}}
                @if ($errors->any())
                    {{-- エラーがあれば赤色で表示 --}}
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <h2>書籍追加</h2>
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    {{-- csrf_field() 悪意のあるユーザが来ないように保護 --}}
                    {{ csrf_field() }}

                    {{-- 入力欄 --}}
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
                        <label>ジャンル</label>
                        <select class="form-control" name="category_id">
                            <option value="">選択してください</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
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
                    <div class="flex justify-center">
                        <label class="block w-44">
                            <img id="preview" class="h-48 w-full" style="height:150px">
                        </label>
                        {{-- 画像アップロード動的切替JS --}}
                        <script>
                            function previewImage(obj) {
                                let fileReader = new FileReader();
                                fileReader.onload = (function() {
                                    document.getElementById('preview').src = fileReader.result;
                                });
                                fileReader.readAsDataURL(obj.files[0]);
                            }
                        </script>
                    </div>
                    <br>
                    {{-- 画像アップロード動的切替 --}}
                    <div class="flex justify-center md:px-20 xl:px-20">
                        <label class="block px-12 py-2 rounded-md bg-gray-300">
                            <input id="image" type="file" accept="image/*" name="image" value="{{ old('image') }}"
                                class="hidden -ml-12" onchange=" previewImage(this)">
                        </label>
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
