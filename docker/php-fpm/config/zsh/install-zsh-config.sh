#!/bin/sh

if [ -f /tmp/zsh/zsh-config.sh ]; then
    cp /tmp/zsh/zsh-config.sh /home/user-dev/.zshrc
else
    cp /tmp/zsh/zsh-config.sample.sh /home/user-dev/.zshrc
fi