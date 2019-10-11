.PHONY: build up composer phpstan phpcs phpcbf phpmd phpunit test qa grumphp install-gumphp

DOCKER=docker-compose run --rm --no-deps api-mocker

build:
	@docker build -t jeckel/api-mocker .

up:
	docker-compose up api-mocker
	#@docker run --rm -v $(shell pwd):/app -p 8080:8080 -e docker=true jeckel/api-mocker

composer:
	@${DOCKER} composer ${CMD}

phpstan:
	@${DOCKER} vendor/bin/phpstan analyse

phpcs:
	@${DOCKER} vendor/bin/phpcs

phpcbf:
	@${DOCKER} vendor/bin/phpcbf

phpmd:
	@${DOCKER} vendor/bin/phpmd src text cleancode,codesize,design,naming,unusedcode

test: phpunit
phpunit:
	@${DOCKER} vendor/bin/phpunit --coverage-text

qa: grumphp

grumphp:
	@${DOCKER} vendor/bin/grumphp run

install-gumphp:
	@${DOCKER} vendor/bin/grumphp git:init

newman:
	docker-compose up --remove-orphans newman
