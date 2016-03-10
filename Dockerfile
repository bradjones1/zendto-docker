FROM ubuntu:14.04

ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get update
RUN apt-get install -yqq --no-install-recommends \
    wget \
    gdebi-core \
    php5-mysql \
    mysql-client

RUN wget http://zend.to/files/zendto_4.12-5.deb
RUN gdebi -n zendto_*.deb
RUN rm etc/apache2/sites-enabled/000-zendto
COPY default.conf /etc/apache2/sites-available/000-default.conf
RUN sed -i '/allow_call_time_pass_reference/d' /etc/php5/apache2/php.ini

CMD apache2ctl -D FOREGROUND
