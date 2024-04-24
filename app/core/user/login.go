package user

import (
	"bytes"
	"crypto/rand"
	"crypto/sha256"
	"database/sql"
	"encoding/hex"
)

const (
	TokenSize = 32
)

type Login struct {
	db *sql.DB
}

func NewLogin(db *sql.DB) *Login {
	return &Login{db: db}
}

func (l *Login) Make(username, password string) (string, error) {
	row := l.db.QueryRow(`
		SELECT id, hashed_password FROM user WHERE username = ?`,
		username,
	)
	var userId int
	var hashedPassword []byte
	if err := row.Scan(&userId, &hashedPassword); err != nil {
		return "", err
	}
	targetHashedPassword := sha256.Sum256([]byte(password))
	if !bytes.Equal(hashedPassword, targetHashedPassword[:]) {
		return "", ErrLoginFailed
	}
	token, err := l.makeToken()
	if err != nil {
		return "", err
	}
	_, err = l.db.Exec(`
		INSERT INTO user_session VALUES (?, ?)`,
		userId,
		token,
	)
	if err != nil {
		return "", err
	}
	return token, nil
}

func (l *Login) Validate(token string) (*User, error) {
	row := l.db.QueryRow(`
		SELECT id, name, username FROM user
		INNER JOIN user_session ON user.id = user_session.user_id
		WHERE token = ?`,
		token,
	)
	user := &User{}
	if err := row.Scan(&user.Id, &user.Name, &user.Username); err != nil {
		return nil, ErrAuthFailed
	}
	return user, nil
}

func (*Login) makeToken() (string, error) {
	rawToken := [TokenSize]byte{}
	if _, err := rand.Read(rawToken[:]); err != nil {
		return "", err
	}
	token := hex.EncodeToString(rawToken[:])
	return token, nil
}
