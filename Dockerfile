# includes most required extensions
FROM php:8.1-apache

ENV REPORT_PATH="/mqaf"

# install locales, gettext, zip, yaml
RUN apt-get update \
 && apt-get install -y --no-install-recommends \
    locales gettext zlib1g-dev libzip-dev libyaml-dev default-mysql-client nano \
 && locale-gen \
    en_GB.UTF-8 && locale-gen de_DE.UTF-8 && locale-gen pt_BR.UTF-8 && locale-gen hu_HU.UTF-8 \
 && apt-get --assume-yes autoremove \
 && rm -rf /var/lib/apt/lists/* \
 && pecl install yaml \
 && docker-php-ext-enable yaml \
 && docker-php-ext-install gettext zip \
 && docker-php-ext-install pdo pdo_mysql \
 && a2enmod rewrite

# install composer from its official Docker image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN mkdir -p /opt/metadata-qa/input
RUN mkdir -p /opt/metadata-qa/output

# copy application files, install PHP libraries and initialize
USER www-data
WORKDIR /var/www/html

# TODO: chown www-data
COPY composer.json .
COPY common-functions.php .
COPY index.php .
COPY .htaccess .
COPY classes classes
COPY locale locale
COPY js js
COPY styles styles
COPY templates templates
COPY configuration.cnf.template configuration.cnf

RUN composer install --prefer-dist --no-dev
RUN composer clear-cache

RUN sed -i.bak 's,<path to input directory>,/opt/metadata-qa/input,' configuration.cnf
RUN sed -i.bak 's,<path to output directory>,/opt/metadata-qa/output,' configuration.cnf
RUN sed -i.bak 's,MY_HOST=localhost,MY_HOST=database,' configuration.cnf
# RUN sed -i.bak 's,MY_PORT=3306,MY_PORT=3307,' configuration.cnf
RUN sed -i.bak 's,MY_DB=<MySQL database name>,MY_DB=mqaf,' configuration.cnf
RUN sed -i.bak 's,MY_USER=<MySQL user name>,MY_USER=mqaf,' configuration.cnf
RUN sed -i.bak 's,MY_PASSWORD=<MySQL password>,MY_PASSWORD=mqaf,' configuration.cnf
RUN echo "dockerized=true" >> configuration.cnf

# RUN mkdir config metadata-qa \
#  && echo dir=metadata-qa > configuration.cnf \
#  && echo include=config/configuration.cnf >> configuration.cnf
# && sed -i.bak 's,</VirtualHost>,        RedirectMatch ^/$ /metadata-qa-ddb/\n        <Directory /var/www/html/metadata-qa-ddb>\n                Options Indexes FollowSymLinks MultiViews\n                AllowOverride All\n                Order allow\,deny\n                allow from all\n                DirectoryIndex index.php index.html\n        </Directory>\n</VirtualHost>,' /etc/apache2/sites-available/000-default.conf \
