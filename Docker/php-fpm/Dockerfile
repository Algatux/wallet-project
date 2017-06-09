FROM php:7.0.16-fpm

MAINTAINER Alessandro Galli <a.galli85@gmail.com>

RUN useradd -u 1000 wallet-dev -G www-data

RUN apt-get update \
    && apt-get install -y software-properties-common apt-transport-https \
    && apt-key adv --keyserver keyserver.ubuntu.com --recv 68576280 \
    && apt-add-repository 'deb https://deb.nodesource.com/node_6.x jessie main' \
    && apt-get update \
    && export DEBIAN_FRONTEND=noninteractive \
    && apt-get install -y \
libbz2-dev \
libcurl4-openssl-dev \
libedit-dev \
libfontconfig \
libgmp-dev \
libicu-dev \
libmagickwand-dev \
libmagickcore-dev \
libmcrypt-dev \
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
sudo \
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
mongodb-1.2.4 \
    && docker-php-ext-enable \
mongodb \
    && npm install -g \
bower \
less

COPY config/sudoers /etc/sudoers
COPY config/id_rsa /root/.ssh/id_rsa
COPY config/id_rsa /home/wallet-dev/.ssh/id_rsa
COPY config/etc/conf.d/ /usr/local/etc/php/conf.d/
COPY config/etc/php-fpm.conf /usr/local/etc/php-fpm.d/wallet.conf

RUN touch /home/wallet-dev/.ssh/known_hosts \
    && chmod 400 /root/.ssh/id_rsa \
    && chmod 400 /home/wallet-dev/.ssh/id_rsa \
    && chown -R wallet-dev:wallet-dev /home/wallet-dev \

    && usermod -g sudo wallet-dev

USER wallet-dev

RUN curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer

COPY config/zsh /tmp/zsh
RUN sudo chmod a+x /tmp/zsh/*.sh \
    #to avoid issues like "text file busy"
    && sleep 0.01s \ 
    && /tmp/zsh/install-zsh.sh \
    && /tmp/zsh/install-zsh-config.sh \
    && sudo rm -rf /tmp/zsh

WORKDIR /var/www/wallet

ENV SYMFONY_DEPRECATIONS_HELPER="disabled"

EXPOSE 9000

USER root
