# Шаги по установке

1. Установить зависимости composer.json
```
$ composer install
```

2. Исправить конфиг для подключения к БД в файле ./protected/config/database.php

3. Принять миграции
```
$ cd protected/yiic
$ ./yiic migrate
```
4. Запустить PHP-сервер
```
php -S localhost:8099
```

## Справка по методам API
Создание пользователя
```
POST http://localhost:8099/api/create
Content-Type: application/json

{
"username": "test",
"email": "test@test.com",
"password": "123456"
}
```


Авторизация пользователя с присвоением токена
```
POST http://localhost:8099/api/login
Content-Type: application/json

{
  "username": "test",
  "password": "123456"
}
```


Создание поста 
```
POST http://localhost:8099/post/create?token=bE5fi8a5rEyrNzdh3tdBE5TkdH2QBN5r5K53T5RhZyay3sH9hEFtNz3QkR2kns3E
Content-Type: application/json

{
  "title": "Post Title",
  "content": "Content Content Content"
}
```


Обновление поста
```
POST http://localhost:8099/post/edit?id=1
Content-Type: application/json

{
  "title": "Post Title update",
  "content": "Content update"
}
```


Удаление поста
```
POST http://localhost:8099/post/delete?id=1
Content-Type: application/json

{
  "title": "Post",
  "content": "Content"
}
```


Получение поста
```
POST http://localhost:8099/post/view?id=1
Content-Type: application/json

{
  "title": "Post Title",
  "content": "Content"
}
```


Получение всех записей после авторизации по токену, сортировка, пагинация
```
POST http://localhost:8099/post/list?token=bE5fi8a5rEyrNzdh3tdBE5TkdH2QBN5r5K53T5RhZyay3sH9hEFtNz3QkR2kns3E
Content-Type: application/json

{
  "sort_field" : "id",
  "sort_order": "ASC",
  "page_size": 10,
  "page" : 0,
  "columns" : ["id", "title", "content"],
  "condition": "content='Content Content Content'"
}
```
