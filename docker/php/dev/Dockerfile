FROM algatux/php-fpm-mongo:1.2

MAINTAINER Alessandro Galli <a.galli85@gmail.com>

COPY etc/conf.d/ /usr/local/etc/php/conf.d/

USER root

RUN apt-get install -y zsh wget \
     && apt-get autoclean \
     && apt-get autoremove

USER php-user

RUN wget https://github.com/robbyrussell/oh-my-zsh/raw/master/tools/install.sh -O - | zsh || true

ENV TERM xterm-256color

EXPOSE 9000
