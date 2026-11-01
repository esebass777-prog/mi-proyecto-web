<?php
require '../conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa / GeoUbicación</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; margin: 0; color: #333; }
        header { background-color: #212529; color: white; padding: 15px 0; text-align: center; font-size: 20px; font-weight: bold; }
        .container { max-width: 800px; margin: 30px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .foto-perfil { width: 150px; height: 150px; border-radius: 50%; object-fit: cover; display: block; margin: 0 auto 25px auto; box-shadow: 0 4px 8px rgba(0,0,0,0.15); }
        h2 { margin-top: 0; border-bottom: 2px solid #dee2e6; padding-bottom: 10px; }
        h3 { color: #495057; margin-top: 25px; }
        .map-container { width: 100%; height: 400px; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .btn { background-color: #343a40; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; display: inline-block; margin-top: 25px; font-weight: bold; }
        .btn:hover { background-color: #23272b; }
    </style>
</head>
<body>
    <header>Mapa / GeoUbicación</header>
    <div class="container">
        <img src="/yoo.png" alt="Foto de perfil" class="foto-perfil">
        <h2>Ubicación y Cómo Llegar</h2>

        <h3>1. Mapa Estático (Iframe)</h3>
        <p>Ubicación de referencia institucional (UPVM):</p>
        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3757.6523968805427!2d-99.13017232500748!3d19.64215318168252!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d1f43e59c00a9f%3A0xe3c992b6aa422e2c!2sUniversidad%20Politécnica%20del%20Valle%20de%20México!5e0!3m2!1ses-419!2smx!4v1791083599383!5m2!1ses-419!2smx" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
        </div>

        <h3>2. Mapa Interactivo (Google Maps JavaScript API)</h3>
        <p>Mapa interactivo con marcador dinámico:</p>
        <div id="mapa" class="map-container"></div>

        <a href="../menu.php" class="btn">Volver al Menú</a>
    </div>

    <script>
        function initMap() {
            const ubicacionUPVM = { lat: 19.642153, lng: -99.130172 };
            const mapa = new google.maps.Map(document.getElementById("mapa"), {
                zoom: 15,
                center: ubicacionUPVM,
            });
            new google.maps.Marker({
                position: ubicacionUPVM,
                map: mapa,
                title: "Universidad Politécnica del Valle de México",
            });
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsZhqQdg81ZWHFVOijABI25hwlk9nlESU&callback=initMap"></script>
</body>
</html>