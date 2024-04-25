#!/bin/bash

DB=data/database.db

/usr/bin/sqlite3 $DB < db/schema.sql
/usr/bin/sqlite3 $DB < db/data.sql
