#!/bin/sh

touch ${CONFIG_FILE} && chmod 777 ${CONFIG_FILE}
touch ${LOG_FILE} && chmod 777 ${LOG_FILE}

exec php -S 0.0.0.0:$PORT -t public/
