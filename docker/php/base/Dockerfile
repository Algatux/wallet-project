FROM php:7.2.3-fpm-stretch

MAINTAINER Alessandro Galli <a.galli85@gmail.com>

ENV DEBIAN_FRONTEND=noninteractive
ENV SYMFONY_DEPRECATIONS_HELPER="disabled"

RUN apt-get update \
    && apt-get install -y software-properties-common apt-transport-https gnupg \
    && apt-key adv --keyserver keyserver.ubuntu.com --recv 68576280 \
    && apt-add-repository 'deb https://deb.nodesource.com/node_9.x jessie main' \
    && apt-get update \
    && apt-get install -y \
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
    && apt-get autoclean \
    && apt-get autoremove \
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
        mongodb-1.3.0 \
    && docker-php-ext-enable \
        mongodb \
    && npm install -g \
        bower \
        less

COPY etc/php-fpm.conf /usr/local/etc/php-fpm.d/dv-project.conf

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN useradd -m -G sudo,www-data php-user \
    && chown -R php-user:php-user /home/php-user \
    && mkdir -p /home/php-user/mysql \
    && mkdir -p /home/php-user/mongo

USER php-user

WORKDIR /home/php-user/project

EXPOSE 9000
