<?php
header('Content-Type: application/json');

$configPath = __DIR__ . '/../config.key.php';
if (file_exists($configPath)) {
    include $configPath;
} else {
    $GEMINI_API_KEY = "";
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Only POST method is allowed"]);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$prompt = $input['prompt'] ?? '';

if (empty($prompt)) {
    echo json_encode(["error" => "Prompt is required"]);
    exit;
}

if ($GEMINI_API_KEY === "") {
    echo json_encode(["error" => "API Key belum di-setting. Silakan buka file api/gemini.php dan masukkan API key Anda."]);
    exit;
}

$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-3.5-flash:generateContent?key=" . $GEMINI_API_KEY;

// Menambahkan sistem konteks agar AI menjawab seputar kesehatan dan olahraga
$system_instruction = "Kamu adalah asisten ahli kesehatan dan kebugaran profesional. Jawablah pertanyaan seputar olahraga, diet, kesehatan, atau rutinitas harian dengan bahasa Indonesia yang ramah, ringkas, dan mudah dipahami. Gunakan pemformatan yang rapi jika perlu (poin-poin atau paragraf pendek).";

$data = [
    "contents" => [
        [
            "role" => "user",
            "parts" => [
                ["text" => $system_instruction . "\n\nPertanyaan User: " . $prompt]
            ]
        ]
    ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
// Nonaktifkan verifikasi SSL lokal (sering menjadi masalah di XAMPP Windows)
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$result = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_error = curl_error($ch);
curl_close($ch);

if ($result === FALSE) {
    echo json_encode(["error" => "Failed to connect to Google Gemini API. cURL Error: " . $curl_error]);
    exit;
}

$response_data = json_decode($result, true);

if ($httpcode !== 200) {
    $errMsg = $response_data['error']['message'] ?? "HTTP Error $httpcode";
    echo json_encode(["error" => "API Error: " . $errMsg]);
    exit;
}

if (isset($response_data['candidates'][0]['content']['parts'][0]['text'])) {
    echo json_encode(["reply" => $response_data['candidates'][0]['content']['parts'][0]['text']]);
} else {
    echo json_encode(["error" => "Invalid response format from API.", "raw" => $response_data]);
}
?>
