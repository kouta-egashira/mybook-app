@extends('layouts.app')
@section('content')
    <!-- 検索フォームのセクション -->
    <div class="search mt-5 d-flex justify-content-center">
        <!-- 検索フォーム。GETメソッドで、書籍一覧のルートにデータを送信 -->
        <form action="{{ route('posts.index') }}" method="GET" class="row g-3">
            <!-- 書籍名 -->
            <div class="col-sm-12 col-md-3">
                <input type="text" name="book_name" class="form-control" placeholder="書籍名" value="{{ request('book_name') }}">
            </div>

            <!-- 著者名 -->
            <div class="col-sm-12 col-md-2">
                <input type="text" name="author_name" class="form-control" placeholder="著者名"
                    value="{{ request('author_name') }}">
            </div>

            <!-- スタート日 -->
            <div class="col-sm-12 col-md-2">
                <input type="date" name="start_date" class="form-control" placeholder="日付"
                    value="{{ request('start_date') }}">
            </div>

            <!-- エンド日 -->
            <div class="col-sm-12 col-md-2">
                <input type="date" name="end_date" class="form-control" placeholder="日付"
                    value="{{ request('end_date') }}">
            </div>

            <!-- 絞り込みボタン -->
            <div class="col-auto">
                <button class="btn btn-outline-secondary" type="submit">絞込み</button>
                <!-- 検索条件をリセットするためのリンクボタン -->
                <a href="{{ route('posts.index') }}" class="btn btn-secondary">リセット</a>
            </div>
        </form>
    </div>
    <!-- 登録書籍数の動的表示 -->
    <br>
    <div class="text-center">
        <h5>登録書籍数：{{ $posts->total() }} 冊</h5>
    </div>
    <br>
    <div class="table-responsive">
        <table class="table" id="table-list" style="width: 1000px; max-width: 0 auto;">
            <tr class="table-info">
                <th scope="col" nowrap>購入年月日</th>
                <th scope="col" nowrap>書籍画像</th>
                <th scope="col" nowrap>書籍名</th>
                <th scope="col" nowrap>著者名</th>
                <th scope="col" nowrap>ジャンル</th>
                <th scope="col" nowrap>購入価格</th>
                <th scope="col" nowrap>詳細表示</th>
                <th scope="col" nowrap>削除</th>
            </tr>
            <!--レコードの繰り返し処理-->
            @foreach ($posts as $post)
                <tr>
                    <td class="index-text" nowrap>{{ $post->date }}</td>
                    <td class="index-text" nowrap><img style="width:80px;"
                            src="{{ asset('storage/images/' . $post->image) }}"></td>
                    <td class="index-text">{{ $post->title }}</td>
                    <td class="index-text break-text">{{ $post->author }}</td>
                    <td class="index-text" nowrap>{{ $post->category->name }}</td>
                    <td class="index-text" nowrap>{{ $post->price }}</td>
                    <td class="index-text" nowrap><a href="{{ route('posts.show', $post->id) }}"><button type="button"
                                class="btn btn-success">詳細</button></a></td>
                    <td>
                        <form action='{{ route('posts.destroy', $post->id) }}' method='post'>
                            {{ csrf_field() }}
                            {{-- HTMLフォームはPUT、PATCH、DELETEアクションをサポートしてしていない為、擬似フォームメソッドを用いて送る --}}
                            {{ method_field('DELETE') }}
                            <input type='submit' value='削除' class="btn btn-danger"
                                onclick='return confirm("削除しますか？");'>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <br>
    <div class="d-flex justify-content-center mb-5">
        <!-- ページネーションをクリックした際に検索条件を維持する -->
        {{ $posts->appends(request()->query())->links() }}
    </div>
@endsection
