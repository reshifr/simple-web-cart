package handler

import (
	"encoding/json"
	"net/http"
	"simple-web-cart/app/core/user"
	"simple-web-cart/app/dependency"
	"strings"
)

func Auth(w http.ResponseWriter, r *http.Request) *user.User {
	db := dependency.SQLite()
	auth := r.Header.Get("Authorization")
	authValues := strings.Split(auth, "Bearer ")
	body := make(map[string]string)
	if len(authValues) != 2 {
		body["error"] = "Need access token."
		responseBody, _ := json.Marshal(body)
		w.Header().Set("Content-Type", "application/json")
		w.WriteHeader(http.StatusUnauthorized)
		w.Write(responseBody)
		return nil
	}
	token := authValues[1]
	userLogin := user.NewLogin(db)
	user, err := userLogin.Validate(token)
	if err != nil {
		body["error"] = "Authorization failed."
		responseBody, _ := json.Marshal(body)
		w.Header().Set("Content-Type", "application/json")
		w.WriteHeader(http.StatusUnauthorized)
		w.Write(responseBody)
		return nil
	}
	return user
}

func Allowed(w http.ResponseWriter, r *http.Request, methods []string) bool {
	for _, method := range methods {
		if r.Method != method {
			body := map[string]string{"error": "Unallowed method."}
			responseBody, _ := json.Marshal(body)
			w.Header().Set("Content-Type", "application/json")
			w.WriteHeader(http.StatusMethodNotAllowed)
			w.Write(responseBody)
			return false
		}
	}
	return true
}
