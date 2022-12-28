FROM php:7.4-apache
SHELL ["/bin/bash", "-c"]
RUN ln -s ../mods-available/{expires,headers,rewrite}.load /etc/apache2/mods-enabled/
RUN sed -e '/<Directory \/var\/www\/>/,/<\/Directory>/s/AllowOverride None/AllowOverride All/' -i /etc/apache2/apache2.conf
ENV TZ=America/New_York
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN dpkg-reconfigure -f noninteractive tzdata
ADD devsetup.ini /usr/local/etc/php/conf.d/
COPY . /var/www/html
RUN chown www-data /var/www/html/lists
