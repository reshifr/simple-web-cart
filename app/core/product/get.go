package product

import (
	"database/sql"
)

type Get struct {
	db *sql.DB
}

func NewGet(db *sql.DB) *Get {
	return &Get{db: db}
}

func (g *Get) All(prefixUrl string) ([]*Product, error) {
	rows, err := g.db.Query(`SELECT * FROM product`)
	if err != nil {
		return nil, err
	}
	products := []*Product{}
	for rows.Next() {
		product := &Product{}
		var image string
		err := rows.Scan(&product.Id, &product.Price, &product.Name, &image)
		if err != nil {
			return nil, err
		}
		product.ImageUrl = prefixUrl + image + ".png"
		products = append(products, product)
	}
	return products, nil
}
