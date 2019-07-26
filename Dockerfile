FROM composer AS builder

COPY . /app
WORKDIR /app
RUN composer install --no-dev

FROM php:7.2-cli-alpine

ENV CONFIG_FILE='/app/config/config.php'
ENV LOG_FILE='/app/config/log.php'
ENV PORT=8080

COPY --from=builder /app /app
WORKDIR /app

CMD sh -c "php -S 0.0.0.0:$PORT -t public/"
