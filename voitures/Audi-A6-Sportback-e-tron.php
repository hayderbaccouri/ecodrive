<?php
// Auto-generated — see voitures/data.php + php/car-page.php
$cars = include __DIR__ . '/data.php';
$car = $cars['Audi-A6-Sportback-e-tron'] ?? null;
if (!$car) { header('Location: ../php/catalogue.php'); exit; }
include __DIR__ . '/../php/car-page.php';