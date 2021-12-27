#EXAMPLE 2
FROM php:8-fpm

ENV USER=laravel
ENV GROUP=laravel

#RUN adduser -g ${GROUP} -s /bin/sh -D ${USER}

#RUN sed -i "s/user www-data/user ${USER}/g" /usr/local/etc/php-fpm.d/www.conf
#RUN sed -i "s/group www-data/group ${GROUP}/g" /usr/local/etc/php-fpm.d/www.conf

RUN mkdir -p /var/www/html/public

#Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer -v
#Install and enable zip
RUN apt-get update && apt-get install -y unzip  libzip-dev
#Install and enable Redis
RUN pecl install redis \
    && docker-php-ext-enable redis
#Enable gd libraries
RUN apt-get update && apt-get install -y unzip libfreetype6-dev libjpeg62-turbo-dev libpng-dev zlib1g-dev
RUN docker-php-ext-install zip
RUN docker-php-ext-enable zip
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install  gd
#Install and enable pdo
RUN docker-php-ext-install pdo pdo_mysql
#enable soap
RUN apt-get update -y && apt-get install -y libxml2-dev && apt-get clean -y && docker-php-ext-install soap
#Packages for Laravel Dusk to work.
RUN apt-get -y install libxpm4 libxrender1 libgtk2.0-0 libnss3 libgconf-2-4 libxi6
RUN apt-get -y install xvfb gtk2-engines-pixbuf
RUN apt-get -y install xfonts-cyrillic xfonts-100dpi xfonts-75dpi xfonts-base
RUN apt-get -y install imagemagick x11-apps
RUN apt-get install chromium -y
RUN display -version
#Install GMP or BCMatch for PHP for the hashids package to work
RUN docker-php-ext-install bcmath


CMD ["php-fpm","-y","/usr/local/etc/php-fpm.conf","-R"]