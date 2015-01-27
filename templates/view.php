<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php
if($data) {
    echo '<img src="/test/images/'.$data['id'].'_big.jpg" /><br/>Марка: '.$data['vendor'].'<br/>Модель: '.$data['model'].'<br/>Цена: '.$data['price'].'<br />Тип кузова: '.$data['type'].'<br/>Цвет: '.$data['colors_names'].'<br />Описание: '.$data['description'].'<br/>';
}
else{
    echo 'Автомобиль не найден<br/>';
}
?>

<a href="/test/add">Добавить</a>
<a href="/test/">Назад</a>
</body>
</html>