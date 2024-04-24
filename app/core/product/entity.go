package product

type Product struct {
	Id       int    `json:"id"`
	Price    int    `json:"price"`
	Name     string `json:"name"`
	ImageUrl string `json:"image_url"`
}
