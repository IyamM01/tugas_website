<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Ambil dan sanitasi input
    $name    = htmlspecialchars($_POST['name']);
    $email   = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Nomor WhatsApp tujuan (format internasional, tanpa +)
    $phone = '6285292275543'; // ← ganti ke nomor kamu

    // Format pesan
    $text = "Halo! Saya $name ($email)\n"
          . "Subjek: $subject\n"
          . "Pesan:\n$message";

    // Redirect ke WhatsApp
    $url = "https://wa.me/$phone?text=" . urlencode($text);
    header("Location: $url");
    exit;
} else {
    echo "Akses tidak diizinkan.";
}
