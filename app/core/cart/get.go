package cart

import (
	"database/sql"
)

type Get struct {
	db *sql.DB
}

func NewGet(db *sql.DB) *Get {
	return &Get{db: db}
}

func (g *Get) All(userId int, prefixUrl string) ([]*Item, error) {
	rows, err := g.db.Query(`
		SELECT product.price, cart.amount, product.name, product.image FROM product
		INNER JOIN cart ON product.id = cart.product_id
		WHERE cart.user_id = ?`,
		userId,
	)
	if err != nil {
		return nil, err
	}
	items := []*Item{}
	for rows.Next() {
		item := &Item{}
		var image string
		err := rows.Scan(&item.Price, &item.Amount, &item.Name, &image)
		if err != nil {
			return nil, err
		}
		item.ImageUrl = prefixUrl + image + ".png"
		items = append(items, item)
	}
	return items, nil
}
