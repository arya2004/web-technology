package middleware

import (
	"github.com/arya2004/farmmart/internal/database"
	"github.com/arya2004/farmmart/internal/models"
	"github.com/gin-contrib/sessions"
	"github.com/gin-gonic/gin"
)

func CurrentUser() gin.HandlerFunc {
	return func (c *gin.Context)  {
		sess := sessions.Default(c)
		if uid, ok := sess.Get("uid").(int); ok && uid != 0 {
			var u models.User
			if err := database.DB.First(&u, uid).Error; err == nil {
				c.Set("currentUser", &u)
			}
		}

		c.Next()
	}
}


func GetCurrentUser(c *gin.Context) *models.User {
	if v, ok := c.Get("currentUser"); ok {
		if u, ok := v.(*models.User); ok {
			return u
		}
	}

	return nil
}