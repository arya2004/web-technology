package handlers

import (
	"net/http"
	"strconv"

	"github.com/arya2004/farmmart/internal/database"
	"github.com/arya2004/farmmart/internal/middleware"
	"github.com/arya2004/farmmart/internal/models"
	"github.com/gin-gonic/gin"
)

func ViewCart(ctx *gin.Context) {
	u := middleware.GetCurrentUser(ctx)
	var cart models.Cart

	if err := database.DB.Preload("Items.Product").FirstOrCreate(&cart, models.Cart{UserID: u.ID}).Error; err != nil {
		ctx.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
		return
	}
	cart.CalcTotal()
	ctx.JSON(http.StatusOK, cart)
}

func AddToCart(ctx *gin.Context) {
	u := middleware.GetCurrentUser(ctx)
	var req struct {
		ProductID uint `json:"product_id" binding:"required"`
		Quantity  uint `json:"quantity"  binding:"required,gt=0"`
	}

	if err := ctx.ShouldBindJSON(&req); err != nil {
		ctx.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}

	var cart models.Cart
	database.DB.FirstOrCreate(&cart, models.Cart{UserID: u.ID})

	var item models.CartItem
	err := database.DB.Where("cart_id = ? AND product_id = ?", cart.ID, req.ProductID).First(&item).Error

	if err == nil {
		item.Quantity += req.Quantity
		database.DB.Save(&item)
	} else {
		item = models.CartItem{CartID: cart.ID, ProductID: req.ProductID, Quantity: req.Quantity}
		database.DB.Create(&item)
	}

	ctx.Status(http.StatusCreated)



}


func RemoveFromCart(ctx *gin.Context) {
	u := middleware.GetCurrentUser(ctx)
	itemID, _ := strconv.Atoi(ctx.Param("itemID"))

	var item models.CartItem
	if err := database.DB.Joins("JOIN carts ON carts.id = cart_items.cart_id AND carts.user_id = ?", u.ID).
		First(&item, itemID).Error; err != nil {
		ctx.JSON(http.StatusNotFound, gin.H{"error": "item not found"})
		return
	}

	database.DB.Delete(&item)
	ctx.Status(http.StatusNoContent)
}