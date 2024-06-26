<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ArticlePostPage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
@if(Session::has('token'))
    <p>{{ htmlspecialchars(Auth::User()['username']) }}さん, こんにちは!</p>
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
    <form method="POST" action="{{ route('article.submit') }}" enctype="multipart/form-data">
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
                <option value="総合" selected>総合</option>
                <option value="テクノロジー">テクノロジー</option>
                <option value="モバイル">モバイル</option>
                <option value="アプリ">アプリ</option>
                <option value="エンタメ">エンタメ</option>
                <option value="ビューティー">ビューティー</option>
                <option value="ファッション">ファッション</option>
                <option value="ライフスタイル">ライフスタイル</option>
                <option value="ビジネス">ビジネス</option>
                <option value="グルメ">グルメ</option>
                <option value="スポーツ">スポーツ</option>
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
            <p>投稿日時: {{ $article['posted_at'] }}</p>
            <p>更新日時: {{ $article['updated_at'] }}</p>
            <td><h5>投稿者:{{ $article['username'] }}</h5>
                <img src="{{ asset('storage/userIcon/' . htmlspecialchars($article['user_image'])) }}" alt="usericon" width="50px"
                     height="50px">
            </td>

            <a href="{{ route('article.detail', ["id" => htmlspecialchars((int)$article['id'])]) }}">
                <h3>{{ $article['title'] }}</h3>
                <img src="{{ asset('storage/thumbnails/' . htmlspecialchars($article['thumb_url'])) }}" alt="thumb" width="200px"
                     height="200px">
            </a>
            <p>タグ:</p>
            @foreach($article['tag'] as $tag)
                <td>{{ $tag }}</td>
            @endforeach
            @if(isset(Auth::User()['username']))
                @if(Auth::User()['username'] == $article['username'])
                    <form method="POST" action={{route('article.delete', ["id" => htmlspecialchars((int)$article['id'])]) }}>
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Delete">
                    </form>
                @endif
            @endif
        @endforeach
    </ul>
@else
    <p>記事がありません</p>
@endif
</body>
</html>
