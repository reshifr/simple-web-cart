package user

import "errors"

var (
	ErrLoginFailed = errors.New("failed to login")
	ErrAuthFailed  = errors.New("failed to authentication")
)
