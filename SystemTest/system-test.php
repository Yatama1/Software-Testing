<?php
function testAPI($city) {
    $apiKey = "4ca76f6f7a10214fceb3e172f65bb1d8";
    $url = "https://api.openweathermap.org/data/2.5/weather?q=jakarta" . urlencode($city) . "&appid=$apiKey&units=metric&lang=id";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 200) {
        echo "✅ [PASS] $city → Data cuaca berhasil diambil.\n";
    } elseif ($httpCode == 404) {
        echo "⚠️ [INFO] $city → Kota tidak ditemukan.\n";
    } else {
        echo "❌ [FAIL] $city → Error koneksi atau API bermasalah.\n";
    }
}

echo "🌤️ SYSTEM TESTING - OPENWEATHERMAP API\n";
echo "=====================================\n";

$cities = ["Jakarta", "Surabaya", "Kotayangtidakada"];
foreach ($cities as $city) {
    testAPI($city);
}

echo "=====================================\n";
echo "✅ Pengujian system test selesai.\n";
?>
