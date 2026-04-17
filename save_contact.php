<?php
declare(strict_types=1);

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode([
        "success" => false,
        "message" => "Only POST method is allowed.",
    ]);
    exit;
}

require_once __DIR__ . "/db.php";

$name = trim($_POST["name"] ?? "");
$contact = trim($_POST["contact"] ?? "");
$subject = trim($_POST["subject"] ?? "General Enquiry");
$message = trim($_POST["message"] ?? "");

if ($name === "" || $contact === "" || $message === "") {
    http_response_code(422);
    echo json_encode([
        "success" => false,
        "message" => "Name, contact, and message are required.",
    ]);
    exit;
}

try {
    $stmt = $pdo->prepare(
        "INSERT INTO contact_messages (name, contact, subject, message) VALUES (:name, :contact, :subject, :message)"
    );
    $stmt->execute([
        ":name" => $name,
        ":contact" => $contact,
        ":subject" => $subject,
        ":message" => $message,
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Contact message saved successfully.",
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Failed to save message.",
    ]);
}
