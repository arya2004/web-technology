package models

import "time"


type OrderStatus string

const (
	OrderPending   OrderStatus = "pending"
	OrderPaid      OrderStatus = "paid"
	OrderShipped   OrderStatus = "shipped"
	OrderCompleted OrderStatus = "completed"
	OrderCanceled  OrderStatus = "canceled"
)

type Order struct {
	Base
	UserID     uint         `json:"user_id"`
	User       User         `json:"user"`
	Items      []OrderItem  `json:"items"`
	Status     OrderStatus  `gorm:"size:20;default:pending" json:"status"`
	Total      float64      `json:"total"`
	PaidAt     *time.Time   `json:"paid_at,omitempty"`
	ShippedAt  *time.Time   `json:"shipped_at,omitempty"`
	FinishedAt *time.Time   `json:"finished_at,omitempty"`
}

type OrderItem struct {
	Base
	OrderID   uint    `json:"order_id"`
	ProductID uint    `json:"product_id"`
	Product   Product `json:"product"`
	Price     float64 `json:"price"`    // captured snapshot of price
	Quantity  uint    `json:"quantity"` // captured snapshot of qty
}