<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<form action="/test/submit/" method="post" enctype="multipart/form-data">
    <label>Марка</label>
    <input type="text" name="vendor"/><br/>
    <label>Модель</label>
    <input type="text" name="model"/><br/>
    <label>Тип кузова</label>
    <input type="text" name="type"/><br/>
    <label>Цена</label>
    <input type="text" name="price"/><br/>
    <label>Цвет</label><br/>
    <?php
    foreach($data as $k=>$v){
        echo '<input type="checkbox" name="colors['.$v['id'].']">'.$v['name'].'<br/>';
    }
    ?>
    <label>Описание</label>
    <input type="text" name="description"/><br/>
    <label>Фото:</label>
    <input type="file" name="img" /><br/>
    <input type="submit" value="Отправить" />
</form>
<a href="/test/">Назад</a>
</body>
</html>