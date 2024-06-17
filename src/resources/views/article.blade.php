<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>{{ $articleDetail['title'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<h3>{{ $articleDetail['title'] }}</h3>
<p>投稿者: {{ $articleDetail['username'] }}</p>
<img src="{{ asset('storage/userIcon/') . $articleDetail['user_image'] }}" alt="userimage" width="50px" height="50px">
<p>投稿日時: {{ $articleDetail['posted_at'] }}</p>
<p>更新日時: {{ $articleDetail['updated_at'] }}</p>
<img src="{{ asset('storage/thumbnails/') . $articleDetail['thumb_url'] }}" alt="thumb" width="200px" height="200px">
<p>{{ $articleDetail['body'] }}</p>
@if(isset(Auth::User()['username']))
    @if(Auth::User()['username'] == $articleDetail['username'])
        <form method="get">
            <input type="submit" value="Edit">
        </form>
        <form method="post">
            @csrf
            <input type="submit" value="Delete">
        </form>
    @endif
@endif
</body>
</html>
