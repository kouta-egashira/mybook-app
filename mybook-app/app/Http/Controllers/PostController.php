<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
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

    // 一覧表示
    public function index(Request $request)
    {
        // Postモデルに基づいてクエリビルダを初期化
        $query = Post::query();

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
            $query->where('date', '>', $request->start_date)->get();
        }

        // 日付検索（エンド）
        if (!empty($request->end_date)) {
            $query->where('date', '<=', $request->end_date)->get();
        }

        // ページネーション
        $posts = $query->orderBy('created_at')->paginate(6); // PostModelから投稿の降順で取得し、6個まで表示
        $posts->load('user'); // load(‘user’)で$postsに紐ずくuserにアクセスできる
        return view('posts.index', ['posts' => $posts]); // compactで$postsをviewに渡す
    }

    // データ保存
    public function create()
    {
        return view('posts.create');
    }

    // 入力してきた情報を受け取り保存
    public function store(PostRequest $request) // PostRequest = Request/PostRequestで作成したバリデーションを使う
    {
        // dd($request);
        // インスタンスを作成
        $post = new Post;
        $post->date = $request->date; // 購入年月日
        $post->title = $request->title; // postの中にtitleを保存する。titleはrequestに来ていたtitle
        $post->author = $request->author;
        $post->publication = $request->publication;
        $post->price = $request->price;
        $post->remarks = $request->remarks;
        $post->user_id = Auth::id(); // ログイン中のユーザのidを入れられる

        // 画像保存をする
        if (request('image')) {
            // getClientOriginalName = 元々のファイル名でファイルを保存する
            $original = request()->file('image')->getClientOriginalName();
            $name = date('Ymd_His') . '_' . $original; // 投稿した画像のパスに日時をいれる
            $file = request()->file('image')->move('storage/images', $name);
            $post->image = $name;
        }

        $post->save(); // インスタンスを作成したら保存しないといけない
        return redirect()->route('posts.index');
    }

    // 作成データを個別表示
    public function show($id) //$id = どの詳細かわかるようにidで受け取るように記載
    {
        $post = Post::find($id); // PostModelからidを見つけるs
        return view('posts.show', compact('post')); // show.bladeに送る
    }

    // 作成データを編集
    public function edit($id)
    {  //$id = どの詳細かわかるようにidで受け取るように記載
        $post = Post::find($id); // PostModelからidを見つける

        // 別のユーザがURLから編集をできなくする
        if (Auth::id() !== $post->user_id) {
            return abort(404);
        }
        // show.bladeに送る
        return view('posts.edit', compact('post'));
    }

    // 編集したデータを保存
    public function update(PostRequest $request, $id)
    { //$id = idをいどを受け取るとどのpostか分かり、変更したい内容が来る
        $post = Post::find($id); // PostModelからidを見つける
        // もし、ログイン中のidとPost_user_idが違ったら404エラーへ飛ばす。
        // 下記記述することで、ログインユーザ以外が勝手に編集や削除をできなくする
        if (Auth::id() !== $post->user_id) {
            return abort(404);
        }
        $post->date = $request->date; // 購入年月日
        $post->title = $request->title; // 書籍タイトル
        $post->author = $request->author; // 著者名
        $post->publication = $request->publication; // 出版社
        $post->price = $request->price; // 金額
        $post->remarks = $request->remarks; // 備考
        $post->user_id = Auth::id(); // ログイン中のユーザのidを入れられる
        // 画像保存をする
        if (request('image')) {
            // getClientOriginalName = 元々のファイル名でファイルを保存する
            $original = request()->file('image')->getClientOriginalName();
            $name = date('Ymd_His') . '_' . $original; // 投稿した画像のパスに日時をいれる
            $file = request()->file('image')->move('storage/images', $name);
            $post->image = $name;
        }
        $post->save(); // セーブする
        return redirect()->route('posts.index'); //indexにもどす
    }

    // データを削除
    public function destroy($id)
    {  //$id = どの詳細かわかるようにidで受け取るように記載
        // PostModelからidを見つける
        $post = Post::find($id);

        // もし、ログイン中のidとPost_user_idが違ったら404エラーへ飛ばす。
        // これを記述することで、ログインユーザ以外が勝手に編集や削除をできなくする
        if (Auth::id() !== $post->user_id) {
            return abort(404);
        }

        $post->delete(); // 削除
        return redirect()->route('posts.index');
    }
}
