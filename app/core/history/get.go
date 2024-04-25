package history

import (
	"database/sql"
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
		WHERE user_id = ? ORDER BY timestamp ASC`,
		userId,
	)
	if err != nil {
		return nil, err
	}
	history := []*History{}
	for rows.Next() {
		h := &History{}
		err := rows.Scan(&h.Total, &h.Timestamp)
		if err != nil {
			return nil, err
		}
		history = append(history, h)
	}
	return history, nil
}
