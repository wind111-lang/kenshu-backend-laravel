<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>{{ $articleDetail['title'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<h3>{{ $articleDetail['title'] }}</h3>
<p>投稿者: {{ htmlspecialchars($articleDetail['username']) }}</p>
<img src="{{ asset('storage/userIcon') . '/' . htmlspecialchars($articleDetail['user_image']) }}" alt="usericon"
     width="50px" height="50px">
<p>投稿日時: {{ $articleDetail['posted_at'] }}</p>
<p>更新日時: {{ $articleDetail['updated_at'] }}</p>
<img src="{{ asset('storage/thumbnails') . '/' . htmlspecialchars($articleDetail['thumb_url']) }}" alt="thumb"
     width="200px" height="200px">
<p>{{ $articleDetail['body'] }}</p>
@foreach($articleDetail['img_url'] as $postImage)
    <img src="{{ asset('storage/postImages') . '/' . $postImage }}" alt="img" width="250px" height="250px">
@endforeach
<p>タグ:</p>
@foreach($articleDetail['tag'] as $tag)
    <p>{{ $tag }}</p>
@endforeach
@if(isset(Auth::User()['username']))
    @if(Auth::User()['username'] == htmlspecialchars($articleDetail['username']))
        <form method="GET" action={{route('article.update', ["id" => htmlspecialchars((int)$articleDetail['id'])] )}}>
            <input type="submit" value="Edit">
        </form>
        <form method="POST" action={{route('article.delete', ["id" => htmlspecialchars((int)$articleDetail['id'])] )}}>
            @csrf
            @method('DELETE')
            <input type="submit" value="Delete">
        </form>
    @endif
@endif
<a href="{{ route('index') }}">Back</a>
</body>
</html>
