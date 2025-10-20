import { useState } from "react";
import axios from "axios";

export default function Weather() {
  const [city, setCity] = useState(""); // nama kota dari input
  const [weather, setWeather] = useState(null); // data cuaca
  const [error, setError] = useState(""); // pesan error
  const [loading, setLoading] = useState(false); // loading state

  // 🔹 API key OpenWeatherMap kamu
  const apiKey = "4ca76f6f7a10214fceb3e172f65bb1d8";

  // 🔹 Fungsi ambil data cuaca
  const getWeather = async () => {
    if (!city.trim()) {
      setError("Masukkan nama kota terlebih dahulu!");
      setWeather(null);
      return;
    }

    setLoading(true);
    setError("");
    setWeather(null);

    try {
      const response = await axios.get(
        `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric&lang=id`
      );
      setWeather(response.data);
    } catch (err) {
      setError("Kota tidak ditemukan atau API bermasalah!");
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-400 to-blue-700 p-6">
      <div className="bg-white/90 backdrop-blur-md p-6 rounded-2xl shadow-xl max-w-md w-full">
        <h2 className="text-3xl font-bold text-center text-blue-700 mb-6">
          🌤️ Aplikasi Cek Cuaca
        </h2>

        {/* Input nama kota */}
        <div className="flex gap-2 mb-4">
          <input
            type="text"
            placeholder="Masukkan nama kota (contoh: Jakarta)"
            value={city}
            onChange={(e) => setCity(e.target.value)}
            onKeyDown={(e) => e.key === "Enter" && getWeather()}
            className="border border-blue-300 p-3 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-400"
          />
          <button
            onClick={getWeather}
            className="bg-blue-600 text-white px-4 rounded-lg hover:bg-blue-700 transition-all"
          >
            🔍
          </button>
        </div>

        {/* Loading */}
        {loading && (
          <p className="text-center text-gray-600 font-medium">Mengambil data cuaca...</p>
        )}

        {/* Error */}
        {error && (
          <p className="text-red-600 mt-3 text-center font-medium">{error}</p>
        )}

        {/* Hasil cuaca */}
        {weather && (
          <div className="mt-6 text-center">
            <h3 className="text-2xl font-semibold text-blue-800">{weather.name}</h3>
            <p className="text-gray-700 capitalize">
              {weather.weather[0].description}
            </p>
            <p className="text-4xl font-bold text-blue-600 mt-2">
              {weather.main.temp}°C
            </p>
            <p className="text-sm text-gray-600 mt-1">
              Kelembapan: {weather.main.humidity}% | Angin: {weather.wind.speed} m/s
            </p>
          </div>
        )}
      </div>
    </div>
  );
}

