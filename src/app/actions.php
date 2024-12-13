<?php
require_once '../config/database.php';

function generateUniqueId() {
    return substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 9);
}

// Get current total balance (user's total money)
$query = "SELECT SUM(income) - SUM(expense) as total_balance FROM financial_records";
$stmt = $pdo->prepare($query);
$stmt->execute();
$current_balance = $stmt->fetchColumn() ?: 0;

// Fetch transaction history
$query = "SELECT *, (income - expense) as balance_change FROM financial_records ORDER BY date DESC, ID DESC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo->beginTransaction();

        $date = !empty($_POST['date']) ? $_POST['date'] : date('Y-m-d');
        $description = $_POST['description'];
        $transaction_type = $_POST['transaction_type'];
        $amount = !empty($_POST['amount']) ? floatval($_POST['amount']) : 0;

        $income = $transaction_type === 'income' ? $amount : 0;
        $expense = $transaction_type === 'expense' ? $amount : 0;

        if ($income > 0 || $expense > 0) {
            // Calculate new total balance
            $new_balance = $current_balance + $income - $expense;

            $id = generateUniqueId();
            $query = "INSERT INTO financial_records (ID, date, description, income, expense, balance) 
                     VALUES (:id, :date, :description, :income, :expense, :balance)";
            $stmt = $pdo->prepare($query);

            $stmt->execute([
                ':id' => $id,
                ':date' => $date,
                ':description' => $description,
                ':income' => $income,
                ':expense' => $expense,
                ':balance' => $new_balance  // Store updated total balance
            ]);

            $pdo->commit();
            header('Location: financial_records.php');
            exit;
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        error_log($e->getMessage());
        echo 'Error inserting record.';
    }
}
