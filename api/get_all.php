<?php
header('Content-Type: application/json');
$conn = include 'db.php';

$result = [
    'habits' => $conn->query("SELECT * FROM habits")->fetch_all(MYSQLI_ASSOC),
    'schedule' => $conn->query("SELECT * FROM schedule")->fetch_all(MYSQLI_ASSOC),
    'events' => $conn->query("SELECT * FROM events")->fetch_all(MYSQLI_ASSOC),
    'logs' => $conn->query("SELECT * FROM logs ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC),
    'profile' => $conn->query("SELECT * FROM user_profile WHERE id = 1")->fetch_assoc()
];

// Type casting for JS compatibility
foreach ($result['habits'] as &$h) {
    $h['completedToday'] = (bool)$h['completedToday'];
    $h['hour'] = (int)$h['hour'];
    $h['lastNotified'] = (int)$h['lastNotified'];
}

echo json_encode($result);
?>
