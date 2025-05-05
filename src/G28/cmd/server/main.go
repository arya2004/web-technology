package main

import (
	"log"

	"github.com/arya2004/farmmart/internal/config"
	"github.com/arya2004/farmmart/internal/database"
	"github.com/arya2004/farmmart/internal/routes"
	"github.com/gin-contrib/sessions"
	"github.com/gin-contrib/sessions/postgres"
	"github.com/gin-gonic/gin"
)

func main() {
	cfg := config.Load()

	database.Connect(cfg.DBConnStr)
	//models.AutoMigrate()

	r := gin.Default()


	sqlDB, err := database.DB.DB()
	if err != nil {
		log.Fatalf("failed to get *sql.DB: %v", err)
	}
	store, err := postgres.NewStore(sqlDB, []byte(cfg.SessionSecret))

	if err != nil {
		log.Fatalf("failed to create session store: %v", err)
	}
	r.Use(sessions.Sessions("farmmart_session", store))

	
	r.Static("/static", "./static")
	r.LoadHTMLGlob("templates/**/*")
	routes.Register(r)
	


	if err := r.Run(":" + cfg.AppPort); err != nil {
		log.Fatalf("server stopped: %v", err)
	}
}
