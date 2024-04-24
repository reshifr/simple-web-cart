package cart

import (
	"database/sql"
)

type Add struct {
	db *sql.DB
}

func NewAdd(db *sql.DB) *Add {
	return &Add{db: db}
}

func (a *Add) Item(userId int, productId int, amount int) error {
	txn, err := a.db.Begin()
	if err != nil {
		return err
	}
	row := txn.QueryRow(`
		SELECT amount FROM cart WHERE user_id = ? AND product_id = ?`,
		userId,
		productId,
	)
	newAmount := 0
	row.Scan(&newAmount)
	newAmount += amount
	_, err = txn.Exec(`
		INSERT OR REPLACE INTO cart VALUES (?, ?, ?)`,
		userId,
		productId,
		newAmount,
	)
	if err != nil {
		txn.Rollback()
		return ErrPoductNotFound
	}
	txn.Commit()
	return nil
}
