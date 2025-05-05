package handlers

import (
	"net/http"

	"github.com/arya2004/farmmart/internal/database"
	"github.com/arya2004/farmmart/internal/middleware"
	"github.com/arya2004/farmmart/internal/models"
	"github.com/gin-contrib/sessions"
	"github.com/gin-gonic/gin"
)

func Register(ctx *gin.Context) {
	var form models.User
	if err := ctx.ShouldBind(&form); err != nil {
		ctx.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}
	form.Role = models.RoleCustomer
	if err := database.DB.Create(&form).Error; err != nil {
		ctx.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}

	sess := sessions.Default(ctx)
	sess.Set("uid", form.ID)
	_ = sess.Save()
	ctx.JSON(http.StatusCreated, gin.H{"user": form})
}


func Login(ctx *gin.Context) {
	var req struct {
		Email    string `form:"email" json:"email" binding:"required,email"`
		Password string `form:"password" json:"password" binding:"required"`
	}

	if err := ctx.ShouldBind(&req); err != nil {
		ctx.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})	
		return
	}

	var u models.User
	if err := database.DB.Where("email = ?", req.Email).First(&u).Error; err != nil || !u.CheckPassword(req.Password) {
		ctx.JSON(http.StatusUnauthorized, gin.H{"error": "invalid creds"})
		return
	}

	sess := sessions.Default(ctx)
	sess.Set("uid", u.ID)
	_ = sess.Save()
	ctx.JSON(http.StatusOK, gin.H{"user": u})
}

func Logout(ctx *gin.Context) {
	sess := sessions.Default(ctx)
	sess.Clear()
	_ = sess.Save()
	ctx.JSON(http.StatusOK, gin.H{"message": "loggedo ut"})
}

func Me(c *gin.Context) {
	if u := middleware.GetCurrentUser(c); u != nil {
		c.JSON(http.StatusOK, gin.H{"user": u})
	} else {
		c.JSON(http.StatusUnauthorized, gin.H{"error": "not logged in"})
	}
}