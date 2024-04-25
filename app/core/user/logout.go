package user

import (
	"database/sql"
)

type Logout struct {
	db *sql.DB
}

func NewLogout(db *sql.DB) *Logout {
	return &Logout{db: db}
}

func (l *Logout) ByToken(token string) error {
	_, err := l.db.Exec(`
		DELETE FROM user_session WHERE token = ?`,
		token,
	)
	if err != nil {
		return err
	}
	return nil
}
