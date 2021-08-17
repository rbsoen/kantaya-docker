FROM nouphet/docker-php4

RUN mkdir -p /patches
COPY kantaya.tar.gz /var/www/
COPY patches /patches
WORKDIR /var/www/

RUN tar xzf kantaya.tar.gz && \
	rm kantaya.tar.gz && \
	mv -v Kantaya/* html/ && \
	cd html && \
	for i in /patches/*.patch; do patch -p1 < $i; done

WORKDIR /var/www/html

# untuk sementara waktu berilah semua permission
RUN chmod -R 777 *

EXPOSE 80

CMD [ "apache2-foreground" ]
