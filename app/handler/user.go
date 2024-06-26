package handler

import (
	"encoding/json"
	"net/http"
	"simple-web-cart/app/core/user"
	"simple-web-cart/app/dependency"
	"strings"
)

func UserLogin(w http.ResponseWriter, r *http.Request) {
	if !Allowed(w, r, []string{http.MethodPost}) {
		return
	}
	body := make(map[string]string)
	if r.Method == http.MethodPost {
		db := dependency.SQLite()
		username := r.PostFormValue("username")
		password := r.PostFormValue("password")
		userLogin := user.NewLogin(db)
		token, err := userLogin.Make(username, password)
		w.Header().Set("Content-Type", "application/json")
		if err != nil {
			body["error"] = "Failed to login."
			w.WriteHeader(http.StatusUnauthorized)
		} else {
			body["token"] = token
			w.WriteHeader(http.StatusOK)
		}
	}
	responseBody, _ := json.Marshal(body)
	w.Write(responseBody)
}

func UserLogout(w http.ResponseWriter, r *http.Request) {
	if !Allowed(w, r, []string{http.MethodDelete}) {
		return
	}
	userAuth := Auth(w, r)
	if userAuth == nil {
		return
	}
	body := make(map[string]string)
	if r.Method == http.MethodDelete {
		db := dependency.SQLite()
		auth := r.Header.Get("Authorization")
		token := strings.Split(auth, "Bearer ")[1]
		userLogout := user.NewLogout(db)
		err := userLogout.ByToken(token)
		w.Header().Set("Content-Type", "application/json")
		if err != nil {
			body["error"] = "Failed to logout."
			w.WriteHeader(http.StatusUnauthorized)
		} else {
			body["message"] = "Succeed."
			w.WriteHeader(http.StatusOK)
		}
	}
	responseBody, _ := json.Marshal(body)
	w.Write(responseBody)
}
