FROM composer AS builder

COPY . /app
WORKDIR /app
RUN composer install --no-dev

FROM php:7.2-cli-alpine

ENV CONFIG_FILE='/app/config/config.php'
ENV LOG_FILE='/app/config/log.php'
ENV PORT=8080

WORKDIR /app
COPY --from=builder /app /app
COPY ./launcher.sh /app/launcher.sh
RUN chmod +x launcher.sh

CMD ./launcher.sh
