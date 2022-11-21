# Даёшь контейнеризацию!

Разработка и отладка проекта велась с помощью Docker. Все составные части приложения были помещены в отдельные контейнеры. Оркестрация была произведена с помощью системы [Docker compose](https://github.com/DavidaaWoW/GlobusDelievery/blob/master/docker-compose.yml)

В данном файле отражено взаимодействие контейнеров между собой.

## MySQL

Берём готовый образ MySQL, указываем пароль от root, прописываем дефолтный порт.

Содержимое [папки mysql](https://github.com/DavidaaWoW/GlobusDelievery/blob/master/mysql/init.sql) перекидываем в внутреннюю директорию контейнера, в которой скрипты выполняются автоматически.

В файле ```init.sql``` создаётся БД, сообщается об использовании базы GlobusDelievery, также происходит создание триггеров, и импорт данных из CSV файлов про который далее рассказано [здесь](https://github.com/DavidaaWoW/GlobusDelievery/tree/master/database/source)

## Apache

Строим образ из [Apache.Dockerfile](https://github.com/DavidaaWoW/GlobusDelievery/blob/master/docker/Apache.Dockerfile)

Внутри устанавливаем необходимые расширения, подключаем их, а также прокидываем глобальные конфигурации в контейнер.

Целиком монтируем исходную директорию в веб-сервер.

Прокидываем порт с 80 на 81

## Redis

Берём готовый образ redis. 

*В проекте redis используется для хранения кешей laravel и данных сессий пользователей*
