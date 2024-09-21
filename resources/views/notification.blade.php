<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
<div>
    <form action="/notification" method="post">
        @csrf
        <input type="text" name="message">
        <button type="submit">Send</button>

    </form>
</div>
</body>
</html>
