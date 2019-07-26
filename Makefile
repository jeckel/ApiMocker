.PHONY: build up
build:
	@docker build -t fake-json-server .

up:
	@docker run --rm -v $(shell pwd):/app -p 8080:8080 -h localhost fake-json-server
