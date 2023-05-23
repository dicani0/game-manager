start:
	./vendor/bin/sail up -d
bash:
	./vendor/bin/sail shell
stop:
	./vendor/bin/sail down
restart:
	./vendor/bin/sail down
	./vendor/bin/sail up -d
