start:
	./vendor/bin/sail up -d
bash:
	./vendor/bin/sail shell
bash-admin:
	./vendor/bin/sail root-shell
stop:
	./vendor/bin/sail down
restart:
	./vendor/bin/sail down
	./vendor/bin/sail up -d
