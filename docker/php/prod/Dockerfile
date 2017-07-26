FROM php:7.0.16-fpm

MAINTAINER Alessandro Galli <a.galli85@gmail.com>

RUN apt-get update \
    && apt-get install -y software-properties-common apt-transport-https \
    && apt-key adv --keyserver keyserver.ubuntu.com --recv 68576280 \
    && apt-add-repository 'deb https://deb.nodesource.com/node_6.x jessie main' \
    && apt-get update \
    && export DEBIAN_FRONTEND=noninteractive

RUN apt-get install -y \
        libbz2-dev \
        libcurl4-openssl-dev \
        libedit-dev \
        libfontconfig \
        libgmp-dev \
        libicu-dev \
        libmcrypt-dev \
        libmemcached-dev \
        libpng-dev \
        libsqlite3-dev \
        libssl-dev \
        libtidy-dev \
        libxml2-dev \
        libxslt-dev \
        libzip-dev \
        curl \
        zsh \
        git \
        bzip2 \
        nodejs \
        ssh \
        openssl \
    && apt-get clean \
    && docker-php-ext-install -j5 \
        bcmath \
        bz2 \
        calendar \
        ctype \
        curl \
        dom \
        exif \
        fileinfo \
        gd \
        gettext \
        hash \
        iconv \
        intl \
        json \
        mbstring \
        mcrypt \
        mysqli \
        opcache \
        pdo_mysql \
        pdo_sqlite \
        posix \
        readline \
        session \
        shmop \
        simplexml \
        xml \
        xmlrpc \
        xsl \
        zip \
    && CFLAGS="-I/usr/src/php" docker-php-ext-install -j5 xmlreader \
    && pecl install \
        mongodb-1.2.9 \
    && docker-php-ext-enable \
        mongodb \
    && docker-php-ext-disable \
        xdebug
    && npm install -g \
        bower \
        less

COPY docker/php/prod/etc/conf.d/ /usr/local/etc/php/conf.d/
COPY docker/php/prod/etc/php-fpm.conf /usr/local/etc/php-fpm.d/dv-project.conf

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN useradd -m -G sudo,www-data php-user \
    && chown -R php-user:php-user /home/php-user \
    && mkdir -p /home/php-user/mysql \
    && mkdir -p /home/php-user/mongo

USER php-user

WORKDIR /home/php-user/project

EXPOSE 9000
