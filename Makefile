SHELL := /bin/bash


UNAME := $(shell uname -s)
OS    := UNKNOWN

ifeq ($(UNAME),Linux)
    OS := linux
endif

ifeq ($(UNAME),Darwin)
    OS := macos
endif

.PHONY: setup
setup: app.env

app.env:
	@cp app.env.dist app.env
	$(eval GITHUB_TOKEN = $(shell bash -c 'read -p "github-oauth.github.com[token]: " result; echo $$result'))
ifeq ($(OS),macos)
	@sed -i '' 's;APP_GITHUB_CLIENT_TOKEN=;APP_GITHUB_CLIENT_TOKEN=$(GITHUB_TOKEN);g' app.env
endif
ifneq ($(OS),macos)
	@sed -i'' 's;APP_GITHUB_CLIENT_TOKEN=;APP_GITHUB_CLIENT_TOKEN=$(GITHUB_TOKEN);g' app.env
endif

.PHONY: start
start:
	docker-compose up -d --build

.PHONY: destroy
destroy:
	docker-compose down --volumes