FROM ubuntu/apache2

WORKDIR /var/www/html

RUN ["apt", "update"]
RUN ["apt", "install", "-y", "php8.3"]
RUN ["a2enmod", "rewrite"]

RUN <<EOF
cat <<PHPINI >> /etc/php/8.3/apache2/php.ini

; Docker specific overrides
;===============================================================================
[PHP]
display_errors = On
html_errors = On

PHPINI

EOF

WORKDIR /opt
RUN ["mkdir", "music"]

WORKDIR /var/www/html
EXPOSE 80 
