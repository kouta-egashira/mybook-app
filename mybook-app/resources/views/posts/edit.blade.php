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
                {{-- $post->id どのpostの更新をするのか --}}
                <form action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data" method="POST">
                    {{-- csrf_field() 悪意のあるユーザが来ないように保護 --}}
                    {{ csrf_field() }}
                    {{-- htmlでPATCHは使えない為、method_field('PATCH')と記載 --}}
                    {{ method_field('PATCH') }}

                    {{-- 年月日入力 --}}
                    <div class="form-group">
                        <label>購入年月日</label>
                        <input type="date" class="form-control" name="date" value="{{ $post->date }}">
                    </div>
                    <div class="form-group">
                        <label>タイトル</label>
                        {{-- value="{{$post->title}} 編集時に前入力文字が表示されている --}}
                        <input type="text" class="form-control" placeholder="タイトルを入力して下さい" name="title"
                            value="{{ $post->title }}">
                    </div>
                    <br>
                    <div class="form-group">
                        <label>著者</label>
                        {{-- value="{{$post->title}} 編集時に前入力文字が表示されている --}}
                        <input type="text" class="form-control" placeholder="著者を入力して下さい" name="author"
                            value="{{ $post->author }}">
                    </div>
                    <br>
                    <div class="form-group">
                        <label>ジャンル</label>
                        <select class="form-control" name="category_id">
                            <option value="">選択してください</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $post->category_id === $category->id ? 'selected' : '' }}>{{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <br>
                    <div class="form-group">
                        <label>出版社</label>
                        {{-- value="{{$post->title}} 編集時に前入力文字が表示されている --}}
                        <input type="text" class="form-control" placeholder="出版社を入力して下さい" name="publication"
                            value="{{ $post->publication }}">
                    </div>
                    <br>
                    <div class="form-group">
                        <label>金額</label>
                        {{-- value="{{$post->title}} 編集時に前入力文字が表示されている --}}
                        <input type="int" class="form-control" placeholder="金額を入力して下さい" name="price"
                            value="{{ $post->price }}">
                    </div>
                    <br>
                    <div class="form-group">
                        <label>備考</label>
                        <textarea class="form-control" placeholder="備考" rows="5" name="remarks">{{ $post->remarks }}</textarea>
                    </div>
                    <br>
                    <div class="flex justify-center">
                        {{-- 更新前の画像表示 --}}
                        <label class="block w-44">
                            <img id="preview" class="h-48 w-full" style="height:150px"
                                src="{{ asset('storage/images/' . $post->image) }}">
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
                            <input id="image" type="file" accept="image/*" name="image"
                                value="{{ old('image') }}" class="hidden -ml-12" onchange=" previewImage(this)">
                        </label>
                    </div>
                    <br>
                    <div class="update-btn">
                        <button type="submit" class="btn btn-warning">更新</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
