<?php
require_once 'actions.php';
require_once "../helpers/include_view.php"
?>

<?php include_view('header.view.php') ?>

<h1 class="text-3xl font-bold mb-4">Financial Records</h1>

<h2 class="text-xl mb-4">Current Balance:
    <span class="<?php echo ($current_balance >= 0) ? 'text-green-500' : 'text-red-500'; ?>">
        <?php echo ($current_balance < 0 ? '-' : '') . '$' . number_format($current_balance !== null ? abs($current_balance) : 0, 2); ?>
    </span>
</h2>

<form action="financial_records.php" method="POST" class="mb-4 bg-white p-5 rounded shadow-md">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <input type="date" name="date" class="border p-2 rounded" value="<?php echo date('Y-m-d'); ?>" required>
        <input type="text" name="description" placeholder="Description" class="border p-2 rounded" required>
        <input type="number" name="amount" placeholder="Amount" class="border p-2 rounded" step="0.01" min="0" required>
        <select name="transaction_type" class="border p-2 rounded mr-2" required>
            <option value="" disabled selected>Select Transaction Type</option>
            <option value="income">Income</option>
            <option value="expense">Expense</option>
        </select>
    </div>
    <button type="submit" class="bg-blue-500 text-white p-2 rounded mt-4 hover:bg-blue-600 transition">Add Transaction</button>
</form>

<table class="min-w-full bg-white border border-gray-200 rounded shadow-md">
    <thead>
        <tr>
            <th class="border px-4 py-2">ID</th>
            <th class="border px-4 py-2">Date</th>
            <th class="border px-4 py-2">Description</th>
            <th class="border px-4 py-2">Income</th>
            <th class="border px-4 py-2">Expense</th>
            <th class="border px-4 py-2">Balance Change</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($records as $record): ?>
            <tr>
                <td class="border px-4 py-2"><?php echo $record['ID']; ?></td>
                <td class="border px-4 py-2"><?php echo $record['date']; ?></td>
                <td class="border px-4 py-2"><?php echo $record['description']; ?></td>
                <td class="border px-4 py-2 text-green-500"><?php echo ($record['income'] > 0 ? '$' . number_format($record['income'], 2) : '-'); ?></td>
                <td class="border px-4 py-2 text-red-500"><?php echo ($record['expense'] > 0 ? '$' . number_format($record['expense'], 2) : '-'); ?></td>
                <td class="border px-4 py-2 <?php echo ($record['income'] - $record['expense'] >= 0) ? 'text-green-500' : 'text-red-500'; ?>">
                    <?php echo ($record['income'] - $record['expense'] >= 0 ? '+' : '-'); ?>$<?php echo number_format($record['income'] - $record['expense'] !== null ? abs($record['income'] - $record['expense']) : 0, 2); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include_view('footer.view.php') ?>