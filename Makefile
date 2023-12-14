.PHONY: build, run, test

build:
	-cp -n .env.example .env
	composer install --no-scripts
	./craft migrate/all --interactive 0
	./craft project-config/apply --interactive 0
	yarn
	yarn build

run:
	yarn watch
