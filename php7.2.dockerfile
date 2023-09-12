ARG PHP_VERSION=7.2-apache
FROM php:${PHP_VERSION}
ARG UID=root
ARG GID=root
ARG USER

RUN docker-php-ext-install \
    mysqli pdo pdo_mysql


# Instalando o Composer
RUN php -r "copy('http://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

# Setando o user:group do conteiner para o user:group da máquina host (ver arquivo .env e docker-compose.yml)
# Assim, o Composer passa a usar o mesmo user:group do usuário do host
# Configura também as pastas para o novo usuário
RUN chown -R 1000:888 /var/www/html
RUN chown -R 1000:888 /root/.composer
RUN mkdir -p /.composer && chown -R 1000:888 /.composer
RUN mkdir -p /.config && chown -R 1000:888 /.config
VOLUME /var/www/html
VOLUME /root/.composer
VOLUME /.composer
VOLUME /.config
