
.PHONEY: test test-spec

test: clean-coverage test-spec

test-spec:
	phpdbg -qrr ./vendor/bin/phpspec run

coverage-clover:
	./vendor/bin/phpcov merge --clover=clover.xml coverage/

coverage-html:
	./vendor/bin/phpcov merge --html=coverage/html coverage/

coverage-text:
	./vendor/bin/phpcov merge --text coverage/

clean-coverage:
	rm -rf coverage/* clover.xml

clean: clean-coverage
