FROM phpdockerio/php7-fpm:latest

# Install selected extensions and other stuff
RUN curl -sL https://deb.nodesource.com/setup_6.x | bash - \
	&& apt-get update \
    && apt-get -y install php7.0-mongodb \
		php7.0-mysql \
		php7.0-redis \
		php7.0-bz2 \
		php7.0-intl \
		php7.0-mbstring \
		php7.0-ssh2 \
		zsh \
		nodejs \
		git \
    && npm install -g \
		bower \
		less \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

WORKDIR "/application"
