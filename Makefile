help:
	@echo "\033[92m make all     - Run all commands"
	@echo "\033[92m make phpunit - Run unit tests"
	@echo "\033[92m make psalm   - Use static analyzing tool to analyze code"
	@echo "\033[92m make phpcs   - Apply code style fixer"

all: phpcs psalm phpunit

phpunit:
	php vendor/bin/phpunit
psalm:
	php vendor/bin/psalm --no-cache
phpcs:
	php vendor/bin/phpcs


