<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // ログインしていなかったらログインページに遷移する（この処理を消すとログインしなくてもページを表示する）
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 一覧表示
     */
    public function index(Request $request)
    {
        // Postモデルに基づいてクエリビルダを初期化
        // リレーションシップをここで事前読み込み
        $query = Post::with('user');

        // 書籍名の検索キーワードがある場合、そのキーワードを含む商品をクエリに追加
        if ($book_name = $request->book_name) {
            $query->where('title', 'LIKE', "%{$book_name}%");
        }

        // 著者名の検索キーワードがある場合、そのキーワードを含む商品をクエリに追加
        if ($author_name = $request->author_name) {
            $query->where('author', 'LIKE', "%{$author_name}%");
        }

        // 日付検索（スタート）
        if (!empty($request->start_date)) {
            $query->where('date', '>=', $request->start_date);
        }

        // 日付検索（エンド）
        if (!empty($request->end_date)) {
            $query->where('date', '<=', $request->end_date);
        }

        // ページネーション
        // PostModelから投稿の昇順で取得し、ページ内に6個まで表示
        $posts = $query->orderBy('date', 'asc')->paginate(6);
        // 画面に渡す
        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * データ保存
     */
    public function create()
    {
        // 全てのカテゴリーを取得
        $categories = Category::all();
        // 画面に渡す
        return view('posts.create', compact('categories'));
    }

    /**
     * 入力情報を受け取り保存
     * PostRequest = Request/PostRequestで作成したバリデーションを使える
     */
    public function store(PostRequest $request)
    {
        // インスタンスを作成
        $post = new Post;

        // 購入年月日
        $post->date = $request->date;
        // 書籍タイトル
        $post->title = $request->title;
        // 著者
        $post->author = $request->author;
        // 出版社
        $post->publication = $request->publication;
        // 金額
        $post->price = $request->price;
        // 備考
        $post->remarks = $request->remarks;
        // ログイン中のユーザのidを入れる
        $post->user_id = Auth::id();
        // category_idを保存
        $post->category_id = $request->category_id;

        // 画像保存
        if (request('image')) {
            // getClientOriginalName = 元々のファイル名でファイルを保存する
            $original = request()->file('image')->getClientOriginalName();
            // 投稿した画像のパスに日時をいれる
            $name = date('Ymd_His') . '_' . $original;
            // imageファイルを取得後にstorage/imagesへ移動
            $file = request()->file('image')->move('storage/images', $name);
            $post->image = $name;
        }

        // インスタンスを保存
        $post->save();
        return redirect()->route('posts.index');
    }

    /**
     * 作成データを個別表示
     * ($id) = Postに紐づくid(個別指定できるようにするために使用)
     */
    public function show($id)
    {
        // PostModelからidを見つける
        $post = Post::find($id);
        // show.bladeに渡す
        return view('posts.show', compact('post'));
    }

    /**
     * 作成データを編集
     * ($id) = Postに紐づくid(個別指定できるようにするために使用)
     */
    public function edit($id)
    {
        // PostModelからidを見つける
        $post = Post::find($id);

        // 別のユーザがURLから編集をできなくする
        if (Auth::id() !== $post->user_id) {
            return abort(404);
        }

        // すべてのカテゴリーを取得
        $categories = Category::all();
        // postとcategoriesを編集画面に渡す
        return view('posts.edit', compact('post', 'categories'));
    }

    /**
     * 編集したデータを保存
     * ($id) = Postに紐づくid(個別指定できるようにするために使用)
     */
    public function update(PostRequest $request, $id)
    {
        // PostModelからidを見つける
        $post = Post::find($id);

        // もし、ログイン中のidとPost_user_idが違ったら404エラーへ飛ばす。
        // 下記記述することで、ログインユーザ以外が勝手に編集や削除をできなくする
        if (Auth::id() !== $post->user_id) {
            return abort(404);
        }

        // 購入年月日
        $post->date = $request->date;
        // タイトル
        $post->title = $request->title;
        // 著者名
        $post->author = $request->author;
        // 出版社
        $post->publication = $request->publication;
        // 金額
        $post->price = $request->price;
        // 備考
        $post->remarks = $request->remarks;
        // ログイン中のユーザのidを入れる
        $post->user_id = Auth::id();
        // category_idを更新する
        $post->category_id = $request->category_id;

        // 画像保存をする
        if (request('image')) {
            // getClientOriginalName = 元々のファイル名でファイルを保存する
            $original = request()->file('image')->getClientOriginalName();
            // 投稿した画像のパスに日時をいれる
            $name = date('Ymd_His') . '_' . $original;
            // imageファイルを取得後にstorage/imagesへ移動
            $file = request()->file('image')->move('storage/images', $name);
            $post->image = $name;
        }

        // インスタンスを保存
        $post->save();
        // 一覧画面へ遷移
        return redirect()->route('posts.index');
    }

    /**
     * データを削除
     * ($id) = Postに紐づくid(個別指定できるようにするために使用)
     */
    public function destroy($id)
    {
        // PostModelからidを見つける
        $post = Post::find($id);

        // もし、ログイン中のidとPost_user_idが違ったら404エラーへ飛ばす。
        // これを記述することで、ログインユーザ以外が勝手に編集や削除をできなくする
        if (Auth::id() !== $post->user_id) {
            return abort(404);
        }

        // 削除
        $post->delete();
        // 一覧画面へ遷移
        return redirect()->route('posts.index');
    }
}
