#!/bin/sh

if [ -f /tmp/zsh/zsh-config.sh ]; then
    cp /tmp/zsh/zsh-config.sh /var/www/php-user/.zshrc
else
    cp /tmp/zsh/zsh-config.sample.sh /var/www/php-user/.zshrc
fi