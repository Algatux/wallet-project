FROM httpd:2.4.25

MAINTAINER Alessandro Galli <a.galli85@gmail.com>

RUN useradd -u 1000 wallet-dev -G www-data \
    && usermod -g sudo wallet-dev

COPY config/httpd.conf /usr/local/apache2/conf/
COPY config/wallet-host.conf /usr/local/apache2/conf/

RUN mkdir /var/log/apache2/  \
    && chown -R wallet-dev:wallet-dev /var/log/apache2/

EXPOSE 80
