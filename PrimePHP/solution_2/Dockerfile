FROM php:8.3-cli

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" && \
    printf "zend_extension=opcache.so\nopcache.enable=1\nopcache.enable_cli=1\nopcache.jit_buffer_size=100M\nopcache.jit=tracing\nmemory_limit=-1\n" >> "$PHP_INI_DIR/php.ini"

WORKDIR /opt/app
COPY *.php .

ENTRYPOINT [ "php", "prime_sieve.php" ]
