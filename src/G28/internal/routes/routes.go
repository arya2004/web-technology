package routes

import (
	"github.com/arya2004/farmmart/internal/handlers"
	"github.com/arya2004/farmmart/internal/middleware"
	"github.com/arya2004/farmmart/internal/models"
	"github.com/gin-gonic/gin"
)



func Register(r *gin.Engine) {
	// apply CurrentUser middleware globally
	r.Use(middleware.CurrentUser())


	auth := r.Group("/auth")
	{
		auth.POST("/register", handlers.Register)
		auth.POST("/login", handlers.Login)
		auth.POST("/logout", handlers.Logout)
	}
	r.GET("/me", handlers.Me)

	r.GET("/products", handlers.ListProducts)
	r.GET("/products/:id", handlers.ShowProduct)


	farmer := r.Group("/farmer")
	farmer.Use(middleware.RoleRequired(models.RoleFarmer))
	{
		fp := farmer.Group("/products")
		fp.POST("", handlers.CreateProduct)
		fp.PUT("/:id", handlers.UpdateProduct)
		fp.DELETE("/:id", handlers.DeleteProduct)
	}


	cust := r.Group("/")
	cust.Use(middleware.RoleRequired(models.RoleCustomer, models.RoleFarmer))
	{
		cust.GET("/cart", handlers.ViewCart)
		cust.POST("/cart", handlers.AddToCart)
		cust.DELETE("/cart/:itemID", handlers.RemoveFromCart)

		cust.POST("/checkout", handlers.Checkout)
		cust.GET("/orders", handlers.ListOrders)
	}
}
