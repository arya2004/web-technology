package models

import (
	"golang.org/x/crypto/bcrypt"
	"gorm.io/gorm"
)

type Role string

const (
	RoleFarmer Role = "farmer"
	RoleCustomer Role = "customer"
	RoleAdmin Role = "admin"
)


type User struct {
	Base
	Name     string `gorm:"size:120;not null" json:"name" binding:"required"`
	Email    string `gorm:"size:120;uniqueIndex;not null" json:"email" binding:"required,email"`
	Password string `gorm:"size:255;not null" json:"-"                       binding:"required,min=8"`
	Role     Role   `gorm:"size:16;not null;default:customer" json:"role"`
	Products []Product
	Cart     Cart
	Orders   []Order
}


func (u *User) BeforeCreate(tx *gorm.DB) (err error){
	hashed, err := bcrypt.GenerateFromPassword([]byte(u.Password), bcrypt.DefaultCost)
	if err != nil {
		return err
	}

	u.Password = string(hashed)
	return nil
}

func (u *User) CheckPassword(pw string) bool {
	return bcrypt.CompareHashAndPassword([]byte(u.Password), []byte(pw)) == nil
}