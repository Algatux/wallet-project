FROM php:7.0.16-fpm

MAINTAINER Alessandro Galli <a.galli85@gmail.com>

RUN apt-get update \
    && apt-get install -y software-properties-common apt-transport-https \
    && apt-key adv --keyserver keyserver.ubuntu.com --recv 68576280 \
    && apt-add-repository 'deb https://deb.nodesource.com/node_6.x jessie main' \
    && apt-get update \
    && export DEBIAN_FRONTEND=noninteractive

RUN apt-get install -y sudo

RUN groupadd -g 1001 user-dev \
    && useradd -u 1000 -g 1001 -G www-data,sudo user-dev

RUN cat /etc/passwd | grep user-dev

RUN apt-get install -y \
libbz2-dev \
libcurl4-openssl-dev \
libedit-dev \
libfontconfig \
libgmp-dev \
libicu-dev \
libmagickwand-dev \
libmagickcore-dev \
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
nano \
netcat \
inotify-tools \
git \
bzip2 \
nodejs \
ssh \
openssl \
pdftk \
compass-yui-plugin \
imagemagick \
mysql-client \
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
ftp \
gd \
gettext \
gmp \
hash \
iconv \
intl \
json \ 
mbstring \
mcrypt \
mysqli \
opcache \
pcntl \
pdo_mysql \
pdo_sqlite \
posix \
readline \
session \
shmop \
simplexml \
soap \
sockets \
sysvmsg \
sysvsem \
sysvshm \
tidy \
tokenizer \
wddx \
xml \
xmlrpc \
xsl \
zip \
    && CFLAGS="-I/usr/src/php" docker-php-ext-install -j5 xmlreader \
    && pecl install \
igbinary-2.0.1 \
imagick-3.4.3RC2 \
memcached-3.0.1 \
mongodb-1.2.9 \
msgpack-2.0.2 \
    && docker-php-ext-enable \
igbinary \
imagick \
memcached \
mongodb \
msgpack \
    && npm install -g \
bower \
less

COPY docker/php-fpm/config/sudoers /etc/sudoers
COPY docker/php-fpm/config/id_rsa /root/.ssh/id_rsa
COPY docker/php-fpm/config/id_rsa /home/user-dev/.ssh/id_rsa
COPY docker/php-fpm/config/etc/conf.d/ /usr/local/etc/php/conf.d/
COPY docker/php-fpm/config/etc/php-fpm.conf /usr/local/etc/php-fpm.d/dv-project.conf

RUN touch /home/user-dev/.ssh/known_hosts \
    && chmod 400 /root/.ssh/id_rsa \
    && chmod 400 /home/user-dev/.ssh/id_rsa \
    && chown -R user-dev:user-dev /home/user-dev

USER user-dev

RUN curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer \
    && composer config -g github-oauth.github.com 22ce07b82e42f2957ddebbdaba52f3304b50caf1

COPY docker/php-fpm/config/zsh /tmp/zsh
RUN sudo chmod a+x /tmp/zsh/*.sh \
    #to avoid issues like "text file busy"
    && sleep 0.01s \ 
    && /tmp/zsh/install-zsh.sh \
    && /tmp/zsh/install-zsh-config.sh \
    && sudo rm -rf /tmp/zsh

WORKDIR /var/www/project

ENV SYMFONY_DEPRECATIONS_HELPER="disabled"

EXPOSE 9000

USER root
