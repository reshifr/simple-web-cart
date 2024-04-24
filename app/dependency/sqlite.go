package dependency

import (
	"database/sql"
	"os"

	_ "github.com/mattn/go-sqlite3"
)

var conn *sql.DB

func SQLite() *sql.DB {
	if conn != nil {
		return conn
	}
	var err error
	sqliteDB := os.Getenv("SQLITE_DB")
	if conn, err = sql.Open("sqlite3", sqliteDB); err != nil {
		panic(err)
	}
	return conn
}
