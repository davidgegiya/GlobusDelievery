# Даёшь контейнеризацию!

Разработка и отладка проекта велась с помощью Docker. Все составные части приложения были помещены в отдельные контейнеры. Оркестрация была произведена с помощью системы [Docker compose](https://github.com/DavidaaWoW/LaravelCarServiceApplication/blob/main/docker-compose.yml)

В данном файле отражено взаимодействие контейнеров между собой.

## MySQL

Берём готовый образ MySQL, указываем пароль от root, прописываем дефолтный порт.

Содержимое [папки mysql](https://github.com/DavidaaWoW/LaravelCarServiceApplication/blob/main/mysql/init.sql) перекидываем в внутреннюю директорию контейнера, в которой скрипты выполняются автоматически.

В файле ```init.sql``` создаётся БД, дефолтный юзер, сообщается об использовании базы RSCHIR5

## Apache

Строим образ из [Apache.Dockerfile](https://github.com/DavidaaWoW/LaravelCarServiceApplication/blob/main/docker/Apache.Dockerfile)

Внутри устанавливаем необходимые расширения, подключаем их, а также прокидываем глобальные конфигурации в контейнер.

Целиком монтируем исходную директорию в веб-сервер.

Прокидываем порт с 80 на 81

## Nginx

Веб-сервер nginx используется по дефолту для прослушивания всех запросов. В случае запроса динамического контента, перенаправляет запросы на Apache.

Образ строится из [Nginx.Dockerfile](https://github.com/DavidaaWoW/LaravelCarServiceApplication/blob/main/docker/Nginx.Dockerfile), в котором просто заменяем дефолтную конфигурацию nginx

Также монтируем исходную директорию

Прокидываем порт с 80 на 82

## Redis

Берём готовый образ redis. 

*В проекте redis используется для хранения кешей laravel и данных сессий пользователей*
