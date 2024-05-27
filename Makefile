db-fresh:
	docker compose run --rm cli vendor/bin/phinx rollback -e development -t 0
	docker compose run --rm cli vendor/bin/phinx migrate -e development

db-empty:
	docker compose run --rm cli vendor/bin/phinx rollback -e development -t 0

db-migrate:
	docker compose run --rm cli vendor/bin/phinx -e development migrate