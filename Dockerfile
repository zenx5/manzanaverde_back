FROM webdevops/php-apache-dev:8.1

WORKDIR ./app

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY . .

EXPOSE 8000

RUN composer install

RUN php artisan migrate --seed

RUN php artisan key:generate

RUN php artisan config:cache

RUN php artisan route:cache

RUN php artisan view:cache

RUN php artisan storage:link

RUN php artisan optimize

RUN php artisan config:clear

RUN php artisan route:clear

RUN php artisan view:clear

RUN php artisan cache:clear

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]



