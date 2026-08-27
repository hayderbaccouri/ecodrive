<?php
// Auto-generated — see voitures/data.php + php/car-page.php
$cars = include __DIR__ . '/data.php';
$car = $cars['mercedes-classe-c-2026'] ?? null;
if (!$car) { header('Location: ../php/catalogue.php'); exit; }
include __DIR__ . '/../php/car-page.php';