<?php

$apiKey = "4ca76f6f7a10214fceb3e172f65bb1d8";
$baseUrl = "https://api.openweathermap.org/data/2.5/weather";

function runTest($id, $description, $city, $expectedStatus) {
    global $baseUrl, $apiKey;

    $url = "$baseUrl?q=" . urlencode($city) . "&appid=$apiKey&units=metric&lang=id";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $data = json_decode($response, true);

    echo "--------------------------------------------\n";
    echo "🧪 Test ID     : $id\n";
    echo "🧾 Deskripsi   : $description\n";
    echo "🏙️ Input Kota  : " . ($city ?: "(kosong)") . "\n";
    echo "🌐 URL         : $url\n";
    echo "🔢 HTTP Status : $httpCode\n";

    // Evaluasi hasil
    if ($httpCode == $expectedStatus) {
        echo "✅ [PASS] Status code sesuai ($expectedStatus)\n";
    } else {
        echo "❌ [FAIL] Status code tidak sesuai. Harus: $expectedStatus, Dapat: $httpCode\n";
    }

    // Tampilkan ringkasan data hasil API (jika ada)
    if ($httpCode == 200 && isset($data['main'])) {
        echo "🌡️ Suhu        : " . $data['main']['temp'] . "°C\n";
        echo "💧 Kelembapan  : " . $data['main']['humidity'] . "%\n";
        echo "☁️ Deskripsi   : " . ucfirst($data['weather'][0]['description']) . "\n";
    } elseif ($httpCode == 404) {
        echo "⚠️ Pesan API   : Kota tidak ditemukan\n";
    } elseif ($httpCode == 400) {
        echo "⚠️ Pesan API   : Input kota kosong / parameter tidak valid\n";
    } elseif (!$response) {
        echo "🚫 Koneksi gagal / API tidak merespons\n";
    }

    echo "--------------------------------------------\n\n";
}

// ==========================================================
// DAFTAR TEST CASE OTOMATIS
// ==========================================================

// 1️⃣ Test Case: Kota Valid
runTest(
    "AUTO_CUACA_001",
    "Memastikan API menampilkan data cuaca kota valid (Jakarta)",
    "Jakarta",
    200
);

// 2️⃣ Test Case: Kota Tidak Ditemukan
runTest(
    "AUTO_CUACA_002",
    "Memastikan API memberikan error 404 jika kota tidak ditemukan",
    "Kotayangtidakada123",
    404
);

// 3️⃣ Test Case: Input Kosong
runTest(
    "AUTO_CUACA_003",
    "Memastikan sistem menolak input kosong dan memberikan error 400",
    "",
    400
);

echo "✅ Semua pengujian otomatis selesai dijalankan.\n";
?>
