package models

import (
	"log"

	"github.com/arya2004/farmmart/internal/database"
)

func AutoMigrate(){
	err := database.DB.AutoMigrate(
		&User{},
		&Product{},
		&Cart{},
		&CartItem{},
		&Order{},
		&OrderItem{},
	)

	if err != nil {
		log.Fatalf("migration failled: %v", err)
	}
}