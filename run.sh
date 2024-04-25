#!/bin/bash

rm -rf data/database.db
db/init.sh
go run app/main.go &> /dev/null &
(
	cd ui/src
	php -S localhost:8080
)
