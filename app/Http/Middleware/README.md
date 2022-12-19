# [Middleware](https://laravel.com/docs/9.x/middleware#main-content)

Middleware в laravel отвечает за фильтрацию ```http``` запросов.

В данном проекте не было написано своих ```middleware```

Однако был использован доступный "из коробки" middleware [auth](https://github.com/DavidaaWoW/GlobusDelievery/blob/master/app/Http/Middleware/Authenticate.php)

Данный middleware позволяет фильтровать и разрешать, либо запрещать запросы пользователям, в зависимости от статуса их авторизации, а также устанавливать переадресацию в случае запрета.
