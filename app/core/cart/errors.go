package cart

import "errors"

var (
	ErrPoductNotFound = errors.New("product not found")
	ErrEmptyCart      = errors.New("cart is empty")
)
