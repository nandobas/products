BASE_DIR = $(shell pwd)
MIGRATE_POSTGRES = docker run --rm -it -v "$(BASE_DIR)/db/postgres":"/postgres" --network host migrate/migrate -path=/postgres/ -database "postgresql://postgres:postgres@localhost:5432/admin?sslmode=disable"
N_VERSION ?= $(N)
M_VERSION ?= $(M)

migrate-softexpert:
	$(MIGRATE_POSTGRES) up $(N_VERSION)

migrate: migrate-softexpert

migrate-down-softexpert:
	$(MIGRATE_POSTGRES) down $(N_VERSION) -all
	
migrate-down: migrate-down-softexpert

db-create-softexpert:
	docker-compose exec \
		-e PGPASSWORD=postgres \
		postgresql psql -h localhost -U postgres -c \
		"CREATE DATABASE admin"

db-create: db-create-softexpert

db-close-all-connections:
	docker-compose exec \
		-e PGPASSWORD=postgres \
		postgresql psql -h localhost -U postgres -c \
		"SELECT pg_terminate_backend(pg_stat_activity.pid) FROM pg_stat_activity WHERE pg_stat_activity.datname = '#{database}' AND pid <> pg_backend_pid();"

db-drop-softexpert: db-close-all-connections
	docker-compose exec \
		-e PGPASSWORD=postgres \
		postgresql psql -h localhost -U postgres -c \
		"DROP DATABASE IF EXISTS admin"


db-drop: db-drop-softexpert

db-reset: db-drop db-create migrate
