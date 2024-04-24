package cart

type Item struct {
	Price    int    `json:"price"`
	Amount   int    `json:"amount"`
	Name     string `json:"name"`
	ImageUrl string `json:"image_url"`
}
