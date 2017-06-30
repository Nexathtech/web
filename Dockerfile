FROM footniko/ubuntu-base-kodi

# Deploy and build application
COPY . /srv/kodi
WORKDIR /srv/kodi
# Since we are using phusion/baseimage image, all necessary scripts invokes automatically from /etc/my_init.d and /etc/service/* 
RUN cp -R ./build/* / && \
    composer install --prefer-dist --optimize-autoloader --no-progress --no-interaction && \
    echo "true" >> automated_build && \
    chown -R nobody:nogroup .
