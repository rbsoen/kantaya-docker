FROM nouphet/docker-php4

COPY Kantaya /var/www/html/
COPY php.ini /etc/php.ini
WORKDIR /var/www/html

# untuk sementara waktu berilah semua permission
RUN chmod -R 777 *

EXPOSE 80

CMD [ "apache2-foreground" ]
