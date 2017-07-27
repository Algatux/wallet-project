FROM php:7.0.21-fpm

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
        libpng-dev \
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
    && npm install -g \
        bower \
        less

COPY docker/php/dev/etc/conf.d/ /usr/local/etc/php/conf.d/
COPY docker/php/dev/etc/php-fpm.conf /usr/local/etc/php-fpm.d/dv-project.conf

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN useradd -m -G sudo,www-data -s /bin/zsh php-user \
    && chown -R php-user:php-user /home/php-user

USER php-user

RUN git clone git://github.com/robbyrussell/oh-my-zsh.git ~/.oh-my-zsh \
    && cp ~/.oh-my-zsh/templates/zshrc.zsh-template ~/.zshrc

WORKDIR /home/php-user/project

ENV SYMFONY_DEPRECATIONS_HELPER="disabled"

EXPOSE 9000
