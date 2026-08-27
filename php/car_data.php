<?php
// Récupération des données d'une voiture pour les pages détail.
// Source 1 : voitures/data.php (contenu marketing riche pour les modèles d'origine)
// Source 2 : table voiture (fallback automatique pour les voitures ajoutées depuis l'admin)

if (!function_exists('ecodrive_slugify')) {
function ecodrive_slugify($str) {
    $str = mb_strtolower(trim($str), 'UTF-8');
    $str = preg_replace('/[^a-z0-9]+/', '-', $str);
    $str = trim($str, '-');
    return $str !== '' ? $str : 'voiture';
}
}

if (!function_exists('ecodrive_car_from_row')) {
function ecodrive_car_from_row($row) {
    if (!$row) return null;
    $name = trim($row['marque'] . ' ' . $row['modele']);
    $img = $row['image'] ?? '';
    $price = number_format((float)$row['prix'], 0, ',', ' ');
    $hp = (int)($row['horsepower'] ?? 0);
    $kwh = (float)($row['battery_kwh'] ?? 0);
    $range = (int)($row['range_km'] ?? 0);
    $kwhFmt = $kwh ? rtrim(rtrim(number_format($kwh, 1, ',', ' '), '0'), ',') : '';
    $annee = (int)($row['annee'] ?? 0);

    $highlights = [];
    if ($hp)    $highlights[] = ['label' => 'Puissance', 'value' => $hp, 'unit' => 'ch', 'sub' => ''];
    if ($kwh)   $highlights[] = ['label' => 'Batterie', 'value' => $kwhFmt, 'unit' => 'kWh', 'sub' => ''];
    if ($range) $highlights[] = ['label' => 'Autonomie', 'value' => $range, 'unit' => 'km', 'sub' => 'Cycle WLTP'];
    $highlights[] = ['label' => 'Année', 'value' => $annee ?: '2026', 'unit' => '', 'sub' => ''];

    return [
        'filename' => basename($row['details_page'] ?? '', '.php'),
        'page_title' => $name . ' — EcoDrive',
        'page_desc'  => ($row['description'] ?: $name . ', voiture 100% électrique.') . ' Réservez votre essai gratuit chez EcoDrive Tunisie.',
        'page_url'   => $row['details_page'] ?? 'voitures/' . ecodrive_slugify($name) . '.php',
        'page_image' => $img,
        'jsonld' => ['brand' => $row['marque'], 'price' => (string)$row['prix']],
        'breadcrumb' => $name,
        'slider' => ['dir' => ($img !== '' ? dirname($img) . '/' : ''), 'img' => ($img !== '' ? basename($img) : ''), 'alt' => $name],
        'price_display' => $price,
        'car_id' => (int)$row['id_voiture'],
        'highlights' => $highlights,
        'specs_motorisation' => [$hp ? "$hp ch" : '—', '—', 'Traction électrique', '—'],
        'specs_batterie' => [
            'capacite' => $kwhFmt ? $kwhFmt . ' kWh' : '—',
            'type' => 'Lithium-ion',
            'autonomie' => $range ? $range . ' km' : '—',
            'extra_name' => 'Type', 'extra_value' => '100% électrique',
            'battery_kwh' => $kwhFmt ? $kwhFmt . ' kWh' : '—',
            'battery_fill' => $kwh ? min(100, max(20, (int)round($kwh))) . '%' : '50%',
        ],
        'specs_recharge' => ['—', '—'],
        'specs_dimensions' => ['—', '—', '—', '—'],
        'description' => $row['description'] ?? '',
    ];
}
}

if (!function_exists('ecodrive_car_from_db')) {
function ecodrive_car_from_db($detailsPage = null, $slug = null) {
    global $conn;
    if (!$conn) return null;
    $row = null;
    if ($detailsPage !== null && $detailsPage !== '') {
        $stmt = $conn->prepare("SELECT * FROM voiture WHERE details_page = ? LIMIT 1");
        $stmt->bind_param("s", $detailsPage);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
    }
    if (!$row && $slug !== null && $slug !== '') {
        $rows = $conn->query("SELECT * FROM voiture")->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $r) {
            if (ecodrive_slugify($r['marque'] . ' ' . $r['modele']) === $slug) { $row = $r; break; }
        }
    }
    return $row ? ecodrive_car_from_row($row) : null;
}
}

if (!function_exists('ecodrive_car_from_slug')) {
function ecodrive_car_from_slug($slug) {
    if ($slug === '' || $slug === 'car-page') return null;
    // Source 1 : contenu riche de data.php
    $data = include __DIR__ . '/../voitures/data.php';
    if (isset($data[$slug]) && is_array($data[$slug])) {
        return $data[$slug];
    }
    // Source 2 : fallback base de données
    return ecodrive_car_from_db('voitures/' . $slug . '.php', $slug);
}
}