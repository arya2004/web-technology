package config

import (
	"log"
	"os"

	"github.com/joho/godotenv"
)

type Config struct {
	AppPort string
	SessionSecret string
	DBConnStr string
}

func Load() *Config {

	_ = godotenv.Load()

	appPort := getEnv("APP_PORT", "8080")
	dbConnStr := buildDSN()
	secret := getEnv("SESSION_SECRET", "dev-secret")

	return &Config{
		AppPort: appPort,
		SessionSecret: secret,
		DBConnStr: dbConnStr,
	}

}


func buildDSN() string {
	host := getEnv("DB_HOST", "localhost")
	port := getEnv("DB_PORT", "5432")
	user := getEnv("DB_USER", "farmmart")
	pass := getEnv("DB_PASSWORD", "farmmart_pass")
	name := getEnv("DB_NAME", "farmmart")
	ssl := getEnv("DB_SSLMODE", "disable")

	return "host=" + host +
		" user=" + user +
		" password=" + pass +
		" dbname=" + name +
		" port=" + port +
		" sslmode=" + ssl
}

func getEnv(key, fallback string) string {
	if v := os.Getenv(key); v != "" {
		return v
	}

	if fallback == "" {
		log.Fatalf("%s not set", key)
	}
	return fallback
}