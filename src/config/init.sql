-- SQL Initialization Script

CREATE TABLE IF NOT EXISTS financial_records (
    ID CHAR(9) NOT NULL PRIMARY KEY,
    date DATE NOT NULL,
    description VARCHAR(255) NOT NULL,
    income DECIMAL(10, 2) DEFAULT 0.00,
    expense DECIMAL(10, 2) DEFAULT 0.00,
    balance DECIMAL(10, 2) DEFAULT 0.00,
    INDEX idx_date (date),
    INDEX idx_income (income),
    INDEX idx_expense (expense)
);