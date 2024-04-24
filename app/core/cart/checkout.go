package cart

import (
	"database/sql"
)

const (
	CouponMinTotal           = 50_000
	CouponTotalMultipleValue = 100_000
)

type checkoutItem struct {
	price  int
	amount int
}

type Checkout struct {
	db *sql.DB
}

func NewCheckout(db *sql.DB) *Checkout {
	return &Checkout{db: db}
}

func (c *Checkout) All(userId int) error {
	txn, err := c.db.Begin()
	if err != nil {
		return err
	}
	rows, err := txn.Query(`
		SELECT product.price, cart.amount FROM product
		INNER JOIN cart ON product.id = cart.product_id
		WHERE cart.user_id = ?`,
		userId,
	)
	if err != nil {
		txn.Rollback()
		return err
	}
	items := []*checkoutItem{}
	for rows.Next() {
		item := &checkoutItem{}
		err := rows.Scan(&item.price, &item.amount)
		if err != nil {
			txn.Rollback()
			return err
		}
		items = append(items, item)
	}
	if len(items) == 0 {
		txn.Rollback()
		return ErrEmptyCart
	}
	_, err = txn.Exec(`
		DELETE FROM cart WHERE user_id = ?`,
		userId,
	)
	if err != nil {
		txn.Rollback()
		return err
	}
	total := 0
	for _, item := range items {
		total += item.price * item.amount
	}
	_, err = txn.Exec(`
		INSERT INTO history (user_id, total) VALUES (?, ?)`,
		userId,
		total,
	)
	if err != nil {
		txn.Rollback()
		return err
	}
	row := txn.QueryRow(`
		SELECT coupons FROM user WHERE id = ?`,
		userId,
	)
	newCoupons := 0
	row.Scan(&newCoupons)
	if total > CouponMinTotal {
		newCoupons += total/CouponTotalMultipleValue + 1
	}
	_, err = txn.Exec(`
		UPDATE user SET coupons = ? WHERE id = ?`,
		newCoupons,
		userId,
	)
	if err != nil {
		txn.Rollback()
		return err
	}
	txn.Commit()
	return nil
}
