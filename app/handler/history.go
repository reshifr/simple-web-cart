package handler

import (
	"encoding/json"
	"net/http"
	"simple-web-cart/app/core/history"
	"simple-web-cart/app/dependency"
)

func History(w http.ResponseWriter, r *http.Request) {
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
		historyGet := history.NewGet(db)
		history, err := historyGet.All(user.Id)
		w.Header().Set("Content-Type", "application/json")
		if err != nil {
			body["error"] = "Something problem to get history."
			w.WriteHeader(http.StatusInternalServerError)
		} else {
			body["data"] = history
			w.WriteHeader(http.StatusOK)
		}
	}
	responseBody, _ := json.Marshal(body)
	w.Write(responseBody)
}
