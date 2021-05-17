# Joke Api

This api was built to demonstrate a REST api written in Symfony 5 that interfaces with both an external vendor api and an in house sql server.

## Requirements
docker and docker-compose

## Instructions
Build project in docker:
```
git clone https://github.com/josenbaugh/joke-api
cd joke-api
docker-compose up -d
```
This will take a while the first time you run it.


Once the docker containers are up and running the api will be available:

```
curl http://localhost:8000/joke/random
```
