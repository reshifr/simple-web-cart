package history

import (
	"database/sql"
	"time"
)

type Get struct {
	db *sql.DB
}

func NewGet(db *sql.DB) *Get {
	return &Get{db: db}
}
func (g *Get) All(userId int) ([]*History, error) {
	rows, err := g.db.Query(`
		SELECT total, timestamp FROM history
		WHERE user_id = ? ORDER BY timestamp DESC`,
		userId,
	)
	if err != nil {
		return nil, err
	}
	history := []*History{}
	for rows.Next() {
		h := &History{}
		var timestamp time.Time
		err := rows.Scan(&h.Total, &timestamp)
		if err != nil {
			return nil, err
		}
		h.Timestamp = timestamp.Unix()
		history = append(history, h)
	}
	return history, nil
}
