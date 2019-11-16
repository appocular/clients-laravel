
.PHONEY: test
test: clean-coverage test-spec phpcs

.PHONEY: test-spec
test-spec:
	phpdbg -qrr ./vendor/bin/phpspec run

.PHONEY: phpcs
phpcs:
	./vendor/bin/phpcs

.PHONEY: coverage-clover
coverage-clover:
	./vendor/bin/phpcov merge --clover=clover.xml coverage/

.PHONEY: coverage-html
coverage-html:
	./vendor/bin/phpcov merge --html=coverage/html coverage/

.PHONEY: coverage-text
coverage-text:
	./vendor/bin/phpcov merge --text coverage/

.PHONEY: clean-coverage
clean-coverage:
	rm -rf coverage/* clover.xml

.PHONEY: clean
clean: clean-coverage
