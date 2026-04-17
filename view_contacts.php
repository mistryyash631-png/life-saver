<?php
declare(strict_types=1);

require_once __DIR__ . "/db.php";

$rows = $pdo->query("SELECT id, name, contact, subject, message, created_at FROM contact_messages ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Messages</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f5f7fb; margin: 0; padding: 24px; }
    h1 { margin-top: 0; color: #b00020; }
    .table-wrap { background: #fff; border-radius: 12px; padding: 16px; box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08); overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    th, td { text-align: left; padding: 12px; border-bottom: 1px solid #ececec; vertical-align: top; }
    th { background: #fafafa; font-weight: 700; }
    .muted { color: #777; font-size: 14px; margin-bottom: 12px; }
  </style>
</head>
<body>
  <h1>Contact Form Messages</h1>
  <p class="muted">Total Messages: <?php echo count($rows); ?></p>
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Contact</th>
          <th>Subject</th>
          <th>Message</th>
          <th>Created At</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!$rows): ?>
          <tr><td colspan="6">No messages found.</td></tr>
        <?php else: ?>
          <?php foreach ($rows as $row): ?>
            <tr>
              <td><?php echo (int)$row["id"]; ?></td>
              <td><?php echo htmlspecialchars($row["name"]); ?></td>
              <td><?php echo htmlspecialchars($row["contact"]); ?></td>
              <td><?php echo htmlspecialchars($row["subject"]); ?></td>
              <td><?php echo nl2br(htmlspecialchars($row["message"])); ?></td>
              <td><?php echo htmlspecialchars($row["created_at"]); ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
