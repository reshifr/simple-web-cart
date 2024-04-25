package main

import (
	"fmt"
	"net/http"
	"simple-web-cart/app/handler"

	"github.com/gorilla/mux"
	"github.com/joho/godotenv"
)

func main() {
	err := godotenv.Load()
	if err != nil {
		panic(err)
	}

	router := mux.NewRouter()
	router.HandleFunc("/login", handler.UserLogin)
	router.HandleFunc("/products", handler.ProductList)
	router.HandleFunc("/products/{image}", handler.ProductImage)
	router.HandleFunc("/cart", handler.Cart)
	router.HandleFunc("/cart/add", handler.CartAdd)
	router.HandleFunc("/cart/checkout", handler.CartCheckout)
	router.HandleFunc("/history", handler.History)

	fmt.Println("Server listening on http://localhost:8000")
	if err := http.ListenAndServe("localhost:8000", router); err != nil {
		panic(err)
	}
}
