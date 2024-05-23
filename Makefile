phinx fresh:
	docker compose run --rm cli vendor/bin/phinx rollback -e development -t 0
	docker compose run --rm cli vendor/bin/phinx migrate -e development

phinx empty:
	docker compose run --rm cli vendor/bin/phinx rollback -e development -t 0

phinx migrate:
	docker compose run --rm cli vendor/bin/phinx -e development migrate