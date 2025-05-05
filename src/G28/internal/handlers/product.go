package handlers

import (
	"net/http"
	"strconv"

	"github.com/arya2004/farmmart/internal/database"
	"github.com/arya2004/farmmart/internal/middleware"
	"github.com/arya2004/farmmart/internal/models"
	"github.com/gin-gonic/gin"
)

func ListProducts(ctx *gin.Context) {
	var products []models.Product
	database.DB.Preload("Farmer").Find(&products)
	ctx.JSON(http.StatusOK, products)
}

func ShowProduct(ctx *gin.Context) {
	id, _ := strconv.Atoi(ctx.Param("id"))
	var p models.Product
	if err := database.DB.Preload("Farmer").First(&p, id).Error; err != nil {
		ctx.JSON(http.StatusNotFound, gin.H{"error": "product not found"})
		return
	}
	ctx.JSON(http.StatusOK, p)
}


func CreateProduct(ctx *gin.Context) {
	u := middleware.GetCurrentUser(ctx)

	var p models.Product
	if err := ctx.ShouldBind(&p); err != nil {
		ctx.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}
	p.FarmerID = u.ID

	if err := database.DB.Create(&p).Error; err != nil {
		ctx.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}
	ctx.JSON(http.StatusCreated, p)
}

func UpdateProduct(ctx *gin.Context) {
	u := middleware.GetCurrentUser(ctx)
	id, _ := strconv.Atoi(ctx.Param("id"))

	var p models.Product
	if err := database.DB.First(&p, id).Error; err != nil || p.FarmerID != u.ID {
		ctx.JSON(http.StatusNotFound, gin.H{"error": err.Error()})
		return
	}
	if err := database.DB.Save(&p).Error; err != nil {
		ctx.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}
	ctx.JSON(http.StatusOK, p)
}


func DeleteProduct(ctx *gin.Context) {
	u := middleware.GetCurrentUser(ctx)
	id, _ := strconv.Atoi(ctx.Param("id"))

	var p models.Product
	if err := database.DB.First(&p, id).Error; err != nil || p.FarmerID != u.ID {
		ctx.JSON(http.StatusNotFound, gin.H{"error": "product not found"})
		return
	}
	if err := database.DB.Delete(&p).Error; err != nil {
		ctx.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}
	ctx.Status(http.StatusNoContent)
}