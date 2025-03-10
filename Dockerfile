FROM ubuntu:latest

# Configuración inicial
ENV DEBIAN_FRONTEND=noninteractive
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV LC_ALL=C.UTF-8

# Actualizar sistema e instalar dependencias básicas
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    software-properties-common \
    ca-certificates \
    curl \
    gnupg && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Añadir repositorios necesarios
RUN add-apt-repository -y ppa:ondrej/apache2 && \
    add-apt-repository -y ppa:ondrej/php && \
    apt-get update

# Instalar paquetes principales
RUN apt-get install -y --no-install-recommends \
    apache2 \
    cron \
    unzip \
    wget \
    php8.2 \
    libapache2-mod-php8.2 \
    php8.2-mysql \
    php8.2-xml \
    php8.2-gd \
    php8.2-mbstring \
    php8.2-bcmath \
    php8.2-cli \
    php8.2-zip \
    php8.2-curl \
    php8.2-intl \
    php8.2-mongodb \
    php8.2-apcu && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin \
    --filename=composer

# Configurar Apache
COPY cv.conf /etc/apache2/sites-available/
RUN a2dissite 000-default && \
    a2ensite cv && \
    a2enmod rewrite headers

# Configurar entorno de trabajo
WORKDIR /var/www/html/cv
COPY . .

# Permisos y optimización
RUN chown -R www-data:www-data var/ && \
    composer install --no-dev --optimize-autoloader

# Comando de inicio
#CMD bash -c "composer install && php bin/console doctrine:schema:update --force && /usr/sbin/apache2ctl -D FOREGROUND"
CMD bash -c "composer install && /usr/sbin/apache2ctl -D FOREGROUND"