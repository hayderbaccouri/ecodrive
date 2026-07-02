<?php
$uri = htmlspecialchars($_SERVER['REQUEST_URI'] ?? '', ENT_QUOTES, 'UTF-8');
?><!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 — Page introuvable | EcoDrive</title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%26%23x26A1%3B%3C/text%3E%3C/svg%3E">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'DM Sans', sans-serif;
      background: #0d110c;
      color: #fff;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 2rem;
    }
    h1 {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(6rem, 12vw, 10rem);
      font-weight: 300;
      color: #00e5a0;
      line-height: 1;
      margin-bottom: 0.5rem;
    }
    h2 {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(1.5rem, 3vw, 2.2rem);
      font-weight: 400;
      color: rgba(255,255,255,0.7);
      margin-bottom: 1rem;
    }
    p {
      color: rgba(255,255,255,0.35);
      font-size: 0.92rem;
      margin-bottom: 2rem;
      max-width: 400px;
    }
    .btn {
      display: inline-block;
      padding: 0.85rem 2rem;
      background: #00e5a0;
      color: #0d110c;
      text-decoration: none;
      border-radius: 999px;
      font-weight: 600;
      font-size: 0.85rem;
      transition: opacity 0.2s, transform 0.2s;
    }
    .btn:hover { opacity: 0.85; transform: translateY(-2px); }
    .path { font-size: 0.72rem; color: rgba(255,255,255,0.15); margin-top: 3rem; }
  </style>
</head>
<body>
  <h1>404</h1>
  <h2>Page introuvable</h2>
  <p>La page que vous cherchez n'existe pas ou a été déplacée.</p>
  <a href="index.php" class="btn">Retour à l'accueil</a>
  <div class="path"><?= $uri ?></div>
<button class="back-to-top" aria-label="Retour en haut">&uarr;</button>
<script src="js/app.js"></script>
</body>
</html>