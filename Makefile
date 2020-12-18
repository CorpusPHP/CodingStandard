.PHONY: test
test: cs
	./vendor/bin/phpunit --coverage-text

.PHONY: cs
cs:
	./vendor/bin/phpcs

.PHONY: cbf
cbf:
	./vendor/bin/phpcbf

.PHONY: fix
fix: cbf
	vendor/bin/php-cs-fixer fix
