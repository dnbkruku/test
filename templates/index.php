<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php
if($data) {
    echo '<table><tr><td>#</td><td>Марка</td><td>Модель</td><td>Цена</td><td>Превью</td></tr>';
    foreach($data as $k => $v){
        echo '<tr><td><a href="/test/view/'.$v['id'].'"><img src="/test/images/'.$v['id'].'_mini.jpg" /></a></td><td><a href="/test/view/'.$v['id'].'">'.$v['vendor'].'</a></td><td><a href="/test/view/'.$v['id'].'">'.$v['model'].'</a></td><td>'.$v['price'].'</td><td>'.mb_strcut($v['description'],0,250).'</td></tr>';
    }
    echo '</table>';
}
else{
    echo 'Нет записей<br/>';
}
?>

<?=$navi?>
<a href="/test/add">Добавить</a>
</body>
</html>