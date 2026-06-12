<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'habits' => [], 'schedule' => [], 'events' => [], 'logs' => [], 'profile' => ['name' => 'Guest']
    ]);
    exit;
}

$conn = include 'db.php';
$user_id = $_SESSION['user_id'];

// Fetch user data
function fetchUserData($conn, $table, $user_id, $order = '') {
    $stmt = $conn->prepare("SELECT * FROM `$table` WHERE user_id = ? $order");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

$result = [
    'habits' => fetchUserData($conn, 'habits', $user_id),
    'schedule' => fetchUserData($conn, 'schedule', $user_id),
    'events' => fetchUserData($conn, 'events', $user_id),
    'logs' => fetchUserData($conn, 'logs', $user_id, 'ORDER BY id DESC'),
    'profile' => ['name' => $_SESSION['user_name']]
];

// Type casting for JS compatibility
foreach ($result['habits'] as &$h) {
    $h['completedToday'] = (bool)$h['completedToday'];
    $h['hour'] = (int)$h['hour'];
    $h['lastNotified'] = (int)$h['lastNotified'];
}

echo json_encode($result);
?>
