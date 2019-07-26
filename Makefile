.PHONY: build up
build:
	@docker build -t jeckel/php-fake-json-server .

up:
	@docker run --rm -v $(shell pwd):/app -p 8080:8080 jeckel/php-fake-json-server
