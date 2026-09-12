# Development tasks for adminata-doctrine-orm-admin-bundle.
#
# `make help` lists them. The suite needs a MySQL: `make services-up` starts the one in
# docker-compose.yml, and the Panther tests additionally need a browser (a geckodriver on this
# machine, or the selenium service plus PANTHER_SELENIUM_HOST).

PHP ?= php
COMPOSER ?= composer
PHPUNIT ?= vendor/bin/phpunit

.DEFAULT_GOAL := help

help: ## This list
	@grep -hE '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) \
		| awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[36m%-18s\033[0m %s\n", $$1, $$2}'
.PHONY: help

install: ## Install the dependencies
	$(COMPOSER) install
.PHONY: install

services-up: ## Start the MySQL the suite runs against
	docker compose up -d database
.PHONY: services-up

services-down: ## Stop it again
	docker compose down
.PHONY: services-down

test: ## The whole suite
	$(PHPUNIT)
.PHONY: test

lint: ## php-cs-fixer over both configs, in check mode
	vendor/bin/php-cs-fixer check --diff
	vendor/bin/php-cs-fixer check --diff --config=.php-cs-fixer.adminata.php
.PHONY: lint

lint-fix: ## php-cs-fixer over both configs, applying the fixes
	vendor/bin/php-cs-fixer fix
	vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.adminata.php
.PHONY: lint-fix

phpstan: ## Static analysis
	vendor/bin/phpstan analyse --memory-limit=1G
.PHONY: phpstan

rector: ## Rector, reporting only
	vendor/bin/rector process --dry-run
.PHONY: rector

rector-fix: ## Rector, applying the changes
	vendor/bin/rector process
.PHONY: rector-fix

check-names: ## Nothing in this tree may still carry a Sonata name (adminata's engine, PLAN/v2 N20)
	php vendor/idct/adminata/upstream/rename/apply.php --check .
.PHONY: check-names

qa: lint check-names phpstan rector test ## Everything CI runs
.PHONY: qa

docs: ## Build the documentation into var/docs (warnings are errors)
	bin/docs.sh
.PHONY: docs
