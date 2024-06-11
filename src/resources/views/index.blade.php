<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ArticlePostPage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
@if( session('loginSuccess') )
    <p>{{ session('loginSuccess') }}</p>
@endif

@if(Session::has('token'))
    <p>{{ Auth::User()['username'] }}さん, こんにちは!</p>
    <form method="post" action="{{ route('logout') }}">
        @csrf
        <input type="submit" value="Logout">
    </form>
    <h1>Form</h1>
    @if( session('error') )
        <p>{{ session('error') }}</p>
    @endif
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    <form method="POST" action="{{ route('articles.submit') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div>
            <label for="body">Content:</label>
            <input type="text" id="body" name="body" required>
        </div>
        <div>
            <label for="thumbnail">Thumbnail:</label>
            <input type="file" id="thumbnail" name="thumbnail" accept=".jpg, .jpeg, .png" required>
        </div>
        <div>
            <label for="postImage">PostImage:</label>
            <input type="file" id="postImage" name="postImage[]" accept=".jpg, .jpeg, .png" multiple required>
        </div>
        <div>
            <label for="tags">Tags:</label>
            <select multiple name="tags[]">
                <option value="organized" selected>総合</option>
                <option value="technology">テクノロジー</option>
                <option value="mobile">モバイル</option>
                <option value="app">アプリ</option>
                <option value="entertainment">エンタメ</option>
                <option value="beauty">ビューティー</option>
                <option value="fashion">ファッション</option>
                <option value="lifestyle">ライフスタイル</option>
                <option value="business">ビジネス</option>
                <option value="gourmet">グルメ</option>
                <option value="sports">スポーツ</option>
            </select>
        </div>
        <input type="submit" value="Post Article">
    </form>
@else
    <p>ログインしていません</p>
    <form method="get" action="{{ route('login') }}">
        <input type="submit" value="Login">
    </form>
    <form method="get" action="{{ route('register') }}">
        <input type="submit" value="Register">
    </form>
@endif
<h2>Articles</h2>
@if( count($articles) > 0 )
    <ul>
        @foreach($articles as $article)
            <h3>タイトル: {{ $article['title'] }}</h3>
            <h4></h4><p>投稿者: {{ $article['username'] }}</p>
            <p>本文: {{ $article['body'] }}</p>
            <p>投稿日時: {{ $article['posted_at'] }}</p>
            <p>更新日時: {{ $article['updated_at'] }}</p>
        @endforeach
    </ul>
@else
    <p>記事がありません</p>
@endif
</body>
</html>
