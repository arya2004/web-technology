package models

type Product struct {
	Base 
	Name string `gorm:"size:140;not null" json:"name" binding:"required"`
	Description string `gorm:"type:text" json:"description" binding:"max:2000"`
	Price float64 `gorm:"not null" json:"price" binding:"required,gt=0"`
	Stock uint `gorm:"not null;default:0" json:"stock" binding:"required"`
	ImageURL string `gorm:"size:255" json:"image_url"`
	FarmerID uint `gorm:"not null;index" json:"farmer_id"`
	Farmer User `json:"farmer"`
}