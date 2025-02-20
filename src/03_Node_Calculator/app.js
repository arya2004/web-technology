const express = require("express");
const app = express();
const PORT = 3000;


app.use(express.json());

const calculateBill = (units) => {
    let bill = 0;

    if (units <= 50) {
        bill = units * 3.50;
    } else if (units <= 150) {
        bill = (50 * 3.50) + ((units - 50) * 4.00);
    } else if (units <= 250) {
        bill = (50 * 3.50) + (100 * 4.00) + ((units - 150) * 5.20);
    } else {
        bill = (50 * 3.50) + (100 * 4.00) + (100 * 5.20) + ((units - 250) * 6.50);
    }

    return bill.toFixed(2); 
};


app.post("/calculate-bill", (req, res) => {
    let units = parseFloat(req.body.units);

    if (isNaN(units) || units < 0) {
        return res.status(400).json({ error: "Invalid input! Please enter a valid number of units." });
    }

    let totalBill = calculateBill(units);
    res.json({ units: units, total_bill: `Rs. ${totalBill}` });
});


app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});
