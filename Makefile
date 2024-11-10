# Run Pint to check for code style issues (without fixing)
pint-test:
	@echo "=============Running Pint in test mode============="
	./vendor/bin/pint --test

# Run Pint with --fix to automatically fix code style issues
pint-fix:
	@echo "=============Running Pint to correct code style issues============="
	./vendor/bin/pint

# Run PHPStan for static analysis
phpstan:
	@echo "=============Running PHPStan============="
	./vendor/bin/phpstan analyse --memory-limit=1G

# Run backend tests
phpunit:
	@echo "=============Running PHPUnit============="
	./vendor/bin/sail phpunit

# Run both Pint and PHPStan checks
check: pint-test phpstan phpunit
