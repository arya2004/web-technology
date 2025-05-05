package models

type Cart struct {
	Base
	UserID uint `gorm:"uniqueIndex" json:"user_id"`
	Items []CartItem `json:"items"`
	Total float64 `gorm:"-" json:"total"`
}


func (c *Cart) CalcTotal() float64 {
	var t float64
	for _, it := range c.Items {
		t += it.SubTotal()
	}

	c.Total = t
	return t
}

type CartItem struct {
	Base
	CartID    uint    `gorm:"index" json:"cart_id"`
	ProductID uint    `json:"product_id" binding:"required"`
	Product   Product `json:"product"`
	Quantity  uint    `gorm:"not null;default:1" json:"quantity" binding:"required,gt=0"`
}


func (it *CartItem) SubTotal() float64 {
	return it.Product.Price * float64(it.Quantity)
}