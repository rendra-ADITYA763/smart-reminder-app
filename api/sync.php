<?php
header('Content-Type: application/json');
$conn = include 'db.php';
$data = json_decode(file_get_contents("php://input"), true);
$type = $_GET['type'] ?? '';

if ($type === 'habits') {
    $conn->query("TRUNCATE TABLE habits");
    if (!empty($data)) {
        $stmt = $conn->prepare("INSERT INTO habits (activity, hour, completedToday, lastNotified) VALUES (?, ?, ?, ?)");
        foreach ($data as $h) {
            $c = $h['completedToday'] ? 1 : 0;
            $stmt->bind_param("siii", $h['activity'], $h['hour'], $c, $h['lastNotified']);
            $stmt->execute();
        }
    }
} elseif ($type === 'schedule') {
    $conn->query("TRUNCATE TABLE schedule");
    if (!empty($data)) {
        $stmt = $conn->prepare("INSERT INTO schedule (subject, day, time) VALUES (?, ?, ?)");
        foreach ($data as $s) {
            $stmt->bind_param("sss", $s['subject'], $s['day'], $s['time']);
            $stmt->execute();
        }
    }
} elseif ($type === 'events') {
    $conn->query("TRUNCATE TABLE events");
    if (!empty($data)) {
        $stmt = $conn->prepare("INSERT INTO events (name, date, loc) VALUES (?, ?, ?)");
        foreach ($data as $e) {
            $stmt->bind_param("sss", $e['name'], $e['date'], $e['loc']);
            $stmt->execute();
        }
    }
} elseif ($type === 'logs') {
    $conn->query("TRUNCATE TABLE logs");
    // Insert logs in reverse order to keep chronologically correct in DB
    $data_rev = array_reverse($data);
    if (!empty($data_rev)) {
        $stmt = $conn->prepare("INSERT INTO logs (type, message, time) VALUES (?, ?, ?)");
        foreach ($data_rev as $l) {
            $stmt->bind_param("sss", $l['type'], $l['message'], $l['time']);
            $stmt->execute();
        }
    }
} elseif ($type === 'profile') {
    if (!empty($data)) {
        $stmt = $conn->prepare("UPDATE user_profile SET name = ? WHERE id = 1");
        $stmt->bind_param("s", $data['name']);
        $stmt->execute();
    }
}

echo json_encode(["status" => "success"]);
?>
