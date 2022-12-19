FROM php:8-apache AS web_app_php
RUN apt-get update && apt-get install -y
RUN docker-php-ext-install pdo pdo_mysql

FROM mysql:latest AS web_app_mysql
ADD base.sql /docker-entrypoint-initdb.d

