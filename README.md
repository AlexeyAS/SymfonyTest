# SymfonyTest

## Install
1) `docker-compose up -d --build`
2) `cd symfony`
3) `composer install` OR `composer update`
4) `npm install && npm run dev`
5) Create <b>.env</b> file from <b>.env.example</b> and generate APP_KEY `php artisan key:generate`
6) Register new user for authorization.
7) (Optional) For send mail, change MAIL_HOST, MAIL_USERNAME, MAIL_PASSWORD, MAIL_ENCRYPTION, MAIL_FROM_ADDRESS in <b>.env</b> file
8) (Optional) Create the new database laravel_db with utf8_general_ci and run `php artisan migrate`

## About

- Создание/редактирование/удаление постов пользователя
- Список всех постов, фильтрация по имени, по тексту
- Список всех пользователей, фильтрация по имени, по почте, вывод постов на пользователя, разбивка на страницы
- *Отправка почты*
#