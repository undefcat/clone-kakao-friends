<!doctype html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>하이요</h1>
<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label for="price">가격</label>
    <input type="number" id="price" name="price">
    <br>

    <label for="stock">재고</label>
    <input type="number" id="stock" name="stock">
    <br>

    <label for="currency">통화단위</label>
    <select name="currency" id="currency">
        <option value="KRW">KRW</option>
    </select>
    <br>

    <label for="name">상품명</label>
    <input type="text" id="name" name="name">
    <br>

    <label for="content">내용</label>
    <textarea name="content" id="content" cols="30" rows="10"></textarea>
    <br>

    @foreach (range(1, 1) as $i)
        <label for="images_{{ $i }}">첨부파일 {{ $i }}</label>
        <input type="file" id="images_{{ $i }}" name="images[]">
        <br>
    @endforeach

    <input type="submit" value="전송">
    <input type="reset" value="초기화">
</form>
</body>
</html>
