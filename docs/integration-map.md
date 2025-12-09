# Cross-Module Integration Map

This document maps business events to accounting entries.  
Each business event will later trigger journal entries inside the Accounting module.

---

## Inventory → Accounting

### 1. Purchase Receive (Receiving Goods)

**Debit:** Inventory  
**Credit:** Accounts Payable

Business meaning: inventory value increases, company owes money to supplier.

---

### 2. Sales Shipment (COGS Recognition)

**Debit:** Cost of Goods Sold  
**Credit:** Inventory

Business meaning: inventory decreases, cost is recognized as expense.

---

### 3. Customer Invoice (Optional Future Slice)

**Debit:** Accounts Receivable  
**Credit:** Revenue

---

## HR → Accounting

### 4. Payroll Approval

**Debit:** Salary Expense  
**Credit:** Salary Payable

Business meaning: payroll cost recognized, amount owed to employees.

---

### 5. Payroll Payment

**Debit:** Salary Payable  
**Credit:** Cash/Bank

---

## Stock Adjustments

### 6. Adjustment Increase

**Debit:** Inventory  
**Credit:** Inventory Adjustment Gain

### 7. Adjustment Decrease

**Debit:** Inventory Adjustment Loss  
**Credit:** Inventory

---

## Notes

-   All integrations are implemented via events or service classes.
-   Weighted Average valuation determines the cost of inventory movements.
