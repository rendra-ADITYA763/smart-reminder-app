<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

$conn = include 'db.php';
$data = json_decode(file_get_contents("php://input"), true);
$type = $_GET['type'] ?? '';
$user_id = $_SESSION['user_id'];

if ($type === 'habits') {
    $stmt_del = $conn->prepare("DELETE FROM habits WHERE user_id = ?");
    $stmt_del->bind_param("i", $user_id);
    $stmt_del->execute();
    if (!empty($data)) {
        $stmt = $conn->prepare("INSERT INTO habits (user_id, activity, hour, completedToday, lastNotified) VALUES (?, ?, ?, ?, ?)");
        foreach ($data as $h) {
            $c = $h['completedToday'] ? 1 : 0;
            $stmt->bind_param("isiii", $user_id, $h['activity'], $h['hour'], $c, $h['lastNotified']);
            $stmt->execute();
        }
    }
} elseif ($type === 'schedule') {
    $stmt_del = $conn->prepare("DELETE FROM schedule WHERE user_id = ?");
    $stmt_del->bind_param("i", $user_id);
    $stmt_del->execute();
    if (!empty($data)) {
        $stmt = $conn->prepare("INSERT INTO schedule (user_id, subject, day, time) VALUES (?, ?, ?, ?)");
        foreach ($data as $s) {
            $stmt->bind_param("isss", $user_id, $s['subject'], $s['day'], $s['time']);
            $stmt->execute();
        }
    }
} elseif ($type === 'events') {
    $stmt_del = $conn->prepare("DELETE FROM events WHERE user_id = ?");
    $stmt_del->bind_param("i", $user_id);
    $stmt_del->execute();
    if (!empty($data)) {
        $stmt = $conn->prepare("INSERT INTO events (user_id, name, date, loc) VALUES (?, ?, ?, ?)");
        foreach ($data as $e) {
            $stmt->bind_param("isss", $user_id, $e['name'], $e['date'], $e['loc']);
            $stmt->execute();
        }
    }
} elseif ($type === 'logs') {
    $stmt_del = $conn->prepare("DELETE FROM logs WHERE user_id = ?");
    $stmt_del->bind_param("i", $user_id);
    $stmt_del->execute();
    // Insert logs in reverse order to keep chronologically correct in DB
    $data_rev = array_reverse($data);
    if (!empty($data_rev)) {
        $stmt = $conn->prepare("INSERT INTO logs (user_id, type, message, time) VALUES (?, ?, ?, ?)");
        foreach ($data_rev as $l) {
            $stmt->bind_param("isss", $user_id, $l['type'], $l['message'], $l['time']);
            $stmt->execute();
        }
    }
} elseif ($type === 'profile') {
    if (!empty($data)) {
        $stmt = $conn->prepare("UPDATE users SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $data['name'], $user_id);
        $stmt->execute();
        // Update session
        $_SESSION['user_name'] = $data['name'];
    }
}

echo json_encode(["status" => "success"]);
?>
