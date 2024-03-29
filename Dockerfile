FROM composer AS builder

COPY . /app
WORKDIR /app
RUN composer install --no-dev

FROM php:7.3-cli-alpine

ENV PORT=8080

WORKDIR /app
COPY --from=builder /app /app
COPY ./launcher.sh /app/launcher.sh
RUN chmod +x launcher.sh

CMD ./launcher.sh
