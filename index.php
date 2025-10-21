<?php
$apiKey = "4ca76f6f7a10214fceb3e172f65bb1d8";
$weather = null;
$error = "";

if (isset($_GET['city'])) {
    $city = htmlspecialchars($_GET['city']);

    if (empty($city)) {
        $error = "Masukkan nama kota terlebih dahulu!";
    } else {
        $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($city) . "&appid=$apiKey&units=metric&lang=id";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == 404) {
            $error = "Kota tidak ditemukan!";
        } elseif ($httpCode != 200 || !$response) {
            $error = "Gagal terhubung ke API!";
        } else {
            $data = json_decode($response, true);
            if (isset($data['main'])) {
                $weather = $data;
            } else {
                $error = "Data tidak ditemukan!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Cek Cuaca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow-lg mx-auto" style="max-width: 500px;">
        <div class="card-body text-center">
            <h2 class="text-primary mb-4">🌤️ Aplikasi Cek Cuaca</h2>

            <form method="GET" action="">
                <div class="input-group mb-3">
                    <input type="text" name="city" class="form-control" placeholder="Masukkan nama kota..."
                           value="<?php echo isset($_GET['city']) ? htmlspecialchars($_GET['city']) : ''; ?>">
                    <button type="submit" class="btn btn-primary">Cek Cuaca</button>
                </div>
            </form>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if ($weather): ?>
                <div class="mt-4">
                    <h3 class="text-primary"><?php echo $weather['name']; ?></h3>
                    <p class="text-muted text-capitalize"><?php echo $weather['weather'][0]['description']; ?></p>
                    <h1 class="display-5 text-primary"><?php echo round($weather['main']['temp']); ?>°C</h1>
                    <p class="text-secondary">
                        💧 Kelembapan: <?php echo $weather['main']['humidity']; ?>% <br>
                        💨 Angin: <?php echo $weather['wind']['speed']; ?> m/s
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
