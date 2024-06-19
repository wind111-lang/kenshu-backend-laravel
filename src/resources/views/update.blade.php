<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ArticlePostPage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<h1>Update Article</h1>
@if( session('error') )
    <p>{{ session('error') }}</p>
@endif
<ul>
    @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
</ul>
<form method="POST" action="{{ route('article.update.submit', ["id" => htmlspecialchars($articleDetail['id'])]) }}">
    @csrf
    @method('PATCH')
    <div>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="{{ htmlspecialchars($articleDetail['title']) }}" required>
    </div>
    <div>
        <label for="body">Content:</label>
        <input type="text" id="body" name="body" value="{{ htmlspecialchars($articleDetail['body']) }}" required>
    </div>
    <input type="submit" value="Update Article">
</form>
<a href={{ route('article.detail', ["id" => htmlspecialchars($articleDetail['id'])]) }}>
    Back
</a>
</body>
</html>
