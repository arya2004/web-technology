package routes

import (
	"github.com/arya2004/farmmart/internal/handlers"
	"github.com/arya2004/farmmart/internal/middleware"
	"github.com/arya2004/farmmart/internal/models"
	"github.com/gin-gonic/gin"
)

func Register(r *gin.Engine) {
	// Global middleware: attach current user to context
	r.Use(middleware.CurrentUser())

	// ---------------- API ROUTES ----------------

	api := r.Group("/api")

	// Auth
	api.POST("/auth/register", handlers.Register)
	api.POST("/auth/login", handlers.Login)
	api.POST("/auth/logout", handlers.Logout)
	api.GET("/me", handlers.Me)

	// Products (public)
	api.GET("/products", handlers.ListProducts)
	api.GET("/products/:id", handlers.ShowProduct)

	// Cart & orders
	api.Use(middleware.RoleRequired(models.RoleCustomer, models.RoleFarmer))
	{
		api.GET("/cart", handlers.ViewCart)
		api.POST("/cart", handlers.AddToCart)
		api.DELETE("/cart/:itemID", handlers.RemoveFromCart)

		api.POST("/checkout", handlers.Checkout)
		api.GET("/orders", handlers.ListOrders)
	}

	// Farmer API
	farmer := r.Group("/farmer")
	farmer.Use(middleware.RoleRequired(models.RoleFarmer))
	{
		fp := farmer.Group("/products")
		fp.POST("", handlers.CreateProduct)
		fp.PUT("/:id", handlers.UpdateProduct)
		fp.DELETE("/:id", handlers.DeleteProduct)

		fp.GET("", func(c *gin.Context) {
			c.HTML(200, "_base.html", gin.H{
				"Title": "Farmer Dashboard",
				"Page":  "farmer_form.html",
			})
		})
	}

	// ---------------- HTML VIEWS ----------------

	r.GET("/", func(c *gin.Context) {
		c.HTML(200, "_base.html", gin.H{
			"Title": "Home",
		})
	})
	
	r.GET("/cart", middleware.AuthRequired(), func(c *gin.Context) {
		c.HTML(200, "_base.html", gin.H{
			"Title": "Your Cart",
		})
	})
	
	r.GET("/orders", middleware.AuthRequired(), func(c *gin.Context) {
		c.HTML(200, "_base.html", gin.H{
			"Title": "Your Orders",
		})
	})
	
	r.GET("/auth/login", func(c *gin.Context) {
		c.HTML(200, "_base.html", gin.H{
			"Title": "Login",
		})
	})
	
	r.GET("/auth/register", func(c *gin.Context) {
		c.HTML(200, "_base.html", gin.H{
			"Title": "Register",
		})
	})
	
	r.GET("/products", func(c *gin.Context) {
		c.HTML(200, "_base.html", gin.H{
			"Title": "Products",
		})
	})
	
	r.GET("/products/:id", func(c *gin.Context) {
		c.HTML(200, "_base.html", gin.H{
			"Title": "Product Details",
		})
	})
	
	
	
}
