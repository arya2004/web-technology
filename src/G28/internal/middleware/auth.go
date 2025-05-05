package middleware

import (
	"net/http"

	"github.com/arya2004/farmmart/internal/models"
	"github.com/gin-gonic/gin"
)

func AuthRequired() gin.HandlerFunc {
	return func(ctx *gin.Context) {
		if GetCurrentUser(ctx) == nil {
			ctx.AbortWithStatusJSON(http.StatusUnauthorized, gin.H{"error" : "login reqired"})
			return
		}
		ctx.Next()
	}
}


func RoleRequired(roles ...models.Role) gin.HandlerFunc {
	set := map[models.Role]struct{}{}
	for _, r := range roles {
		set[r] = struct{}{}
	}

	return func(ctx *gin.Context) {
		u := GetCurrentUser(ctx)
		if u == nil {
			ctx.AbortWithStatusJSON(http.StatusUnauthorized, gin.H{"error": "login requires"})
			return
		}
		if _, ok := set[u.Role]; !ok {
			ctx.AbortWithStatusJSON(http.StatusForbidden, gin.H{"error": "forbidden"})
			return
		}
		ctx.Next()
	}

}