<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ArticlePostPage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<h1>Form</h1>
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
<a href="{{ route('index') }}">Back</a>
</body>
</html>
