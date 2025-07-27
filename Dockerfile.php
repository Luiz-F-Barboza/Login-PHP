# Usa uma imagem base oficial do PHP com FPM (FastCGI Process Manager)
FROM php:8.2-fpm-alpine

# Instala dependências do sistema necessárias para extensões PHP
RUN apk add --no-cache \
    autoconf \
    build-base \
    libzip-dev \
    libpng-dev \
    jpeg-dev \
    git \
    oniguruma-dev \
    # Adicione outras dependências do sistema se precisar para outras extensões
    && rm -rf /var/cache/apk/*

# Instala extensões PHP comuns e essenciais para a maioria das aplicações web
# - pdo_mysql e mysqli são para conectar ao MySQL
# - gd é para manipulação de imagens
# - zip é para lidar com arquivos zip (pode ser útil para Composer/dependências)
# - mbstring é para funções de string multi-byte (bom para UTF-8)
RUN docker-php-ext-install pdo_mysql mysqli gd zip mbstring

# Define o diretório de trabalho dentro do contêiner
WORKDIR /var/www/html

# Copia o arquivo composer.json e composer.lock (se você usar Composer)
# Isso permite que o Composer instale as dependências antes de copiar todo o código
COPY composer.* ./

# Instala dependências do Composer (se você estiver usando Composer no seu projeto)
# Se você não usa Composer, pode remover este bloco.
RUN if [ -f "composer.json" ]; then \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --no-dev --optimize-autoloader; \
    fi

# Copia todo o código da sua aplicação PHP para o diretório de trabalho do contêiner
COPY . .

# Expõe a porta que o PHP-FPM usa (padrão 9000 para PHP-FPM)
EXPOSE 9000

# Comando para iniciar o PHP-FPM quando o contêiner for executado
CMD ["php-fpm"]