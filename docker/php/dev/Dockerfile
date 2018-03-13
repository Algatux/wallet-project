FROM algatux/php-fpm-mongo:1.2

MAINTAINER Alessandro Galli <a.galli85@gmail.com>

COPY etc/conf.d/ /usr/local/etc/php/conf.d/
COPY --chown=php-user:php-user zsh/install.sh /home/php-user/install-zsh.sh
COPY --chown=php-user:php-user zsh/config /home/php-user/.zshrc

RUN chmod +x /home/php-user/install-zsh.sh \
    && /home/php-user/install-zsh.sh

ENV TERM xterm-256color

EXPOSE 9000
