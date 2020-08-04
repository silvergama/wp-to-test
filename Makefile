docker/build:
	docker build -t silvergama/wordpress:wp-cli -f Dockerfile .

docker/up:
	docker-compose up -d

docker/down:
	docker-compose down
