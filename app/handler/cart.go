package handler

import (
	"encoding/json"
	"errors"
	"net/http"
	"simple-web-cart/app/core/cart"
	"simple-web-cart/app/dependency"
	"strconv"
)

func Cart(w http.ResponseWriter, r *http.Request) {
	if !Allowed(w, r, []string{http.MethodGet}) {
		return
	}
	user := Auth(w, r)
	if user == nil {
		return
	}
	body := make(map[string]interface{})
	if r.Method == http.MethodGet {
		db := dependency.SQLite()
		cartGet := cart.NewGet(db)
		prefixUrl := "http://" + r.Host + "/products/"
		cart, err := cartGet.All(user.Id, prefixUrl)
		w.Header().Set("Content-Type", "application/json")
		if err != nil {
			body["error"] = "Something problem to get cart."
			w.WriteHeader(http.StatusInternalServerError)
		} else {
			body["data"] = cart
			w.WriteHeader(http.StatusOK)
		}
	}
	responseBody, _ := json.Marshal(body)
	w.Write(responseBody)
}

func CartAdd(w http.ResponseWriter, r *http.Request) {
	if !Allowed(w, r, []string{http.MethodPost}) {
		return
	}
	user := Auth(w, r)
	if user == nil {
		return
	}
	body := make(map[string]string)
	if r.Method == http.MethodPost {
		db := dependency.SQLite()
		id, _ := strconv.Atoi(r.PostFormValue("id"))
		amount, _ := strconv.Atoi(r.PostFormValue("amount"))
		cartAdd := cart.NewAdd(db)
		err := cartAdd.Item(user.Id, id, amount)
		w.Header().Set("Content-Type", "application/json")
		if errors.Is(err, cart.ErrPoductNotFound) {
			body["error"] = "Product not found."
			w.WriteHeader(http.StatusNotFound)
		} else if err != nil {
			body["error"] = "Something problem to add product."
			w.WriteHeader(http.StatusInternalServerError)
		} else {
			body["message"] = "Succeed."
			w.WriteHeader(http.StatusOK)
		}
	}
	responseBody, _ := json.Marshal(body)
	w.Write(responseBody)
}

func CartCheckout(w http.ResponseWriter, r *http.Request) {
	if !Allowed(w, r, []string{http.MethodPost}) {
		return
	}
	user := Auth(w, r)
	if user == nil {
		return
	}
	body := make(map[string]string)
	if r.Method == http.MethodPost {
		db := dependency.SQLite()
		cartCheckout := cart.NewCheckout(db)
		err := cartCheckout.All(user.Id)
		w.Header().Set("Content-Type", "application/json")
		if errors.Is(err, cart.ErrEmptyCart) {
			body["error"] = "Cart is empty."
			w.WriteHeader(http.StatusBadRequest)
		} else if err != nil {
			body["error"] = "Something problem to add product."
			w.WriteHeader(http.StatusInternalServerError)
		} else {
			body["message"] = "Succeed."
			w.WriteHeader(http.StatusOK)
		}
	}
	responseBody, _ := json.Marshal(body)
	w.Write(responseBody)
}
