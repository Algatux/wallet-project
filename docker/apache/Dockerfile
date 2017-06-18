FROM httpd:2.4.25

MAINTAINER Alessandro Galli <a.galli85@gmail.com>

RUN groupadd -g 1001 user-dev \
    && useradd -u 1000 -g 1001 -G sudo user-dev \
    && usermod -G user-dev www-data

RUN cat /etc/passwd | grep user-dev

COPY  docker/apache/config/*.conf /usr/local/apache2/conf/

RUN mkdir /var/log/apache2/  \
    && chown -R user-dev:user-dev /var/log/apache2

EXPOSE 80
