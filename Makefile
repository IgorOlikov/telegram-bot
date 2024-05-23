phinx fresh:
	docker compose run --rm cli vendor/bin/phinx rollback -t 0
	docker compose run --rm cli vendor/bin/phinx migrate

phinx empty:
	docker compose run --rm cli vendor/bin/phinx rollback -t 0

phinx migrate:
	docker compose run --rm cli vendor/bin/phinx migrate