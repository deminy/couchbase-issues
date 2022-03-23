# To build the image:
#     docker build -t deminy/php-couchbase:php7.4-3.2.2 .
FROM php:7.4-cli

RUN \
    set -ex && \
    apt-get update              && \
    apt-get install -y             \
        apt-transport-https        \
        gnupg                      \
        --no-install-recommends && \
    curl -sfL http://ftp.br.debian.org/debian/pool/main/libe/libevent/libevent-core-2.1-6_2.1.8-stable-4_amd64.deb -o libevent-core.deb && \
    dpkg -i libevent-core.deb                                                                                                           && \
    rm -f libevent-core.deb                                                                                                             && \
    curl -sfL https://packages.couchbase.com/clients/c/repos/deb/couchbase.key | apt-key add -                                         && \
    echo "deb https://packages.couchbase.com/clients/c/repos/deb/debian10 buster buster/main" > /etc/apt/sources.list.d/couchbase.list && \
    apt-get update               && \
    apt-get install -y              \
        libcouchbase3=3.2.4-1       \
        libcouchbase-dev=3.2.4-1    \
        libcouchbase3-tools=3.2.4-1 \
        libzip4                     \
        libzip-dev                  \
        --no-install-recommends  && \
    pecl update-channels            && \
    pecl install couchbase-3.2.2    && \
    docker-php-ext-enable couchbase && \
    rm -rf /var/lib/apt/lists/* /tmp/* /usr/src/php.tar.xz* $HOME/.composer/*-old.phar
