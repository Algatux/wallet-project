#!/bin/sh

if [ -f /tmp/zsh/zsh-config.sh ]; then
    cp /tmp/zsh/zsh-config.sh /home/wallet-dev/.zshrc
else
    cp /tmp/zsh/zsh-config.sample.sh /home/wallet-dev/.zshrc
fi