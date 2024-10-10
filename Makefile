.PHONY: install
install:
	- docker-compose up -d --build
	- docker exec -ti poc_in_memory_repositories_php bin/console doctrine:migration:migrate -n

stop:
	docker-compose down

.PHONY: tests
tests:
	docker exec -ti poc_in_memory_repositories_php vendor/bin/phpunit
