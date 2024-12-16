Сервис коротких ссылок + QR
-

Конфигурация OpenServer на момент разработки:
```
PHP_8.0
Apache_2.4-PHP_8.0-8.1
MySQL-8.0-Win10
```


```
git clone https://github.com/menshikovakate/short-links
```

Команда загрузки необходимых пакетов
```
composer install
```

Перед запуском миграций необходимо создать базу данных **short-links** или отредактировать параметры подключения в файле **config/db.php**
```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=short-links',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
```

Для создания используемых таблиц необходимо запустить команду
```
php yii migrate
```