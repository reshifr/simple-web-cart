#!/bin/bash

DB=data/database.db

sqlite3 $DB < db/schema.sql
sqlite3 $DB < db/data.sql
