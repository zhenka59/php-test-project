<?php

$this->pageTitle=Yii::app()->name;
?>

<h1>Страница Авторов книг</h1>


<ul>

<?php



   ?>


    <?php

    new Author;
    $condition = 'fio';
    $authorName=Author::model()->findAll($condition);
    //$authorName = Author::find()->orderBy('fio')->all();

    ?>
    <li>Автор 2</li>
    <li>Автор 3</li>

</ul>



