package handlers

import (
	"net/http"
	"time"

	"github.com/arya2004/farmmart/internal/database"
	"github.com/arya2004/farmmart/internal/middleware"
	"github.com/arya2004/farmmart/internal/models"
	"github.com/gin-gonic/gin"
	"gorm.io/gorm"
)

func ListOrders(ctx *gin.Context) {
	u := middleware.GetCurrentUser(ctx)
	var orders []models.Order
	database.DB.Preload("Items.Product").Where("user_id = ?", u.ID).Order("created_at DESC").Find(&orders)

	ctx.JSON(http.StatusOK, orders)
}


func Checkout(ctx *gin.Context) {
	u := middleware.GetCurrentUser(ctx)

	var cart models.Cart
	if err := database.DB.Preload("Items.Product").First(&cart, "user_id = ?", u.ID).Error; err != nil || len(cart.Items) == 0 {
		ctx.JSON(http.StatusBadRequest, gin.H{"error": "cart empty"})
		return
	}

	order := models.Order{
		UserID: u.ID,
		Status: models.OrderPaid,
	}

	for _, it := range cart.Items {
		order.Items = append(order.Items, models.OrderItem{
			ProductID: it.ProductID,
			Price:     it.Product.Price,
			Quantity:  it.Quantity,
		})
		order.Total += it.Product.Price * float64(it.Quantity)
	}
	now := time.Now()
	order.PaidAt = &now

	err := database.DB.Transaction(func(tx *gorm.DB) error {
		if err := tx.Create(&order).Error; err != nil {
			return err
		}
		// Empty the cart
		if err := tx.Delete(&models.CartItem{}, "cart_id = ?", cart.ID).Error; err != nil {
			return err
		}
		return nil
	})
	if err != nil {
		ctx.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
		return
	}

	ctx.JSON(http.StatusCreated, order)


}