package handler

import (
	"encoding/json"
	"net/http"
	"os"
	"simple-web-cart/app/core/product"
	"simple-web-cart/app/dependency"

	"github.com/gorilla/mux"
)

func ProductList(w http.ResponseWriter, r *http.Request) {
	if !Allowed(w, r, []string{http.MethodGet}) {
		return
	}
	body := make(map[string]interface{})
	if r.Method == http.MethodGet {
		db := dependency.SQLite()
		productGet := product.NewGet(db)
		prefixUrl := "http://" + r.Host + "/products/"
		products, err := productGet.All(prefixUrl)
		w.Header().Set("Content-Type", "application/json")
		if err != nil {
			body["error"] = "Something problem to get all products."
			w.WriteHeader(http.StatusInternalServerError)
		} else {
			body["data"] = products
			w.WriteHeader(http.StatusOK)
		}
	}
	responseBody, _ := json.Marshal(body)
	w.Write(responseBody)
}

func ProductImage(w http.ResponseWriter, r *http.Request) {
	if !Allowed(w, r, []string{http.MethodGet}) {
		return
	}
	if r.Method == http.MethodGet {
		vars := mux.Vars(r)
		image := "build/images/" + vars["image"]
		imageFile, err := os.ReadFile(image)
		if err != nil {
			body := map[string]string{"error": "Image not found."}
			responseBody, _ := json.Marshal(body)
			w.Header().Set("Content-Type", "application/json")
			w.WriteHeader(http.StatusNotFound)
			w.Write(responseBody)
		} else {
			w.Header().Set("Content-Type", "image/jpeg")
			w.WriteHeader(http.StatusOK)
			w.Write(imageFile)
		}
	}
}
