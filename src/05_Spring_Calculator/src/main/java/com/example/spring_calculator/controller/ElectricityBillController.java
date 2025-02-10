package com.example.spring_calculator.controller;

import com.example.spring_calculator.models.Bill;
import org.springframework.web.bind.annotation.*;

import java.util.HashMap;
import java.util.Map;

@RestController
public class ElectricityBillController {


    @PostMapping("/calculate")
    public Map<String, Object> calculateBill(@RequestBody Bill bills) {
        double bill = 0;
        int units = bills.getValue();
        if (units <= 50) {
            bill = units * 3.50;
        } else if (units <= 150) {
            bill = (50 * 3.50) + ((units - 50) * 4.00);
        } else if (units <= 250) {
            bill = (50 * 3.50) + (100 * 4.00) + ((units - 150) * 5.20);
        } else {
            bill = (50 * 3.50) + (100 * 4.00) + (100 * 5.20) + ((units - 250) * 6.50);
        }

        Map<String, Object> response = new HashMap<>();
        response.put("units", units);
        response.put("totalPrice", bill);

        return response;
    }

}
