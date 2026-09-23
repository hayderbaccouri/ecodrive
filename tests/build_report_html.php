<?php
/**
 * Script de génération du rapport PFF EcoDrive en HTML pour Microsoft Word
 * Conforme aux exigences du BTS Informatique de Gestion (ISPRI)
 * 100% PHP vanilla, sans dépendances externes ni Python.
 */

$baseDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'projet fin d\'etude' . DIRECTORY_SEPARATOR . 'rapport pff';
$mdPath  = $baseDir . DIRECTORY_SEPARATOR . 'Rapport_PFF_EcoDrive.md';
$htmlPath = $baseDir . DIRECTORY_SEPARATOR . 'Rapport_PFF_EcoDrive.html';

if (!file_exists($mdPath)) {
    die("Erreur : Impossible de trouver le fichier markdown : $mdPath\n");
}

$mdContent = file_get_contents($mdPath);
$lines = explode("\n", str_replace(["\r\n", "\r"], "\n", $mdContent));

$html = [];
$html[] = '<!DOCTYPE html>';
$html[] = '<html lang="fr">';
$html[] = '<head>';
$html[] = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
$html[] = '<meta charset="UTF-8">';
$html[] = '<title>Rapport de Projet de Fin de Formation - EcoDrive</title>';
$html[] = '<style>';
$html[] = '  @page { size: A4; margin: 2.5cm; }';
$html[] = '  body { font-family: "Calibri", "Segoe UI", Arial, sans-serif; font-size: 14pt; line-height: 1.5; color: #1e293b; text-align: justify; }';
$html[] = '  h1 { font-family: "Segoe UI", Arial, sans-serif; font-size: 20pt; line-height: 1.3; color: #0284c7; border-bottom: 2px solid #0284c7; padding-bottom: 5px; margin-top: 24pt; margin-bottom: 12pt; page-break-before: always; }';
$html[] = '  .first-h1 { page-break-before: avoid !important; }';
$html[] = '  h2 { font-family: "Segoe UI", Arial, sans-serif; font-size: 16pt; line-height: 1.3; color: #0f172a; margin-top: 18pt; margin-bottom: 8pt; border-bottom: 1px solid #cbd5e1; padding-bottom: 4px; }';
$html[] = '  h3 { font-family: "Segoe UI", Arial, sans-serif; font-size: 14pt; line-height: 1.3; color: #1e293b; margin-top: 14pt; margin-bottom: 6pt; font-weight: bold; }';
$html[] = '  h4.fig-caption { font-family: Calibri, sans-serif; font-size: 11pt; line-height: 1.3; font-style: italic; font-weight: bold; color: #475569; margin-top: 6pt; text-align: center; }';
$html[] = '  h5.table-caption { font-family: Calibri, sans-serif; font-size: 11pt; line-height: 1.3; font-weight: bold; font-style: italic; color: #0284c7; margin-bottom: 4pt; margin-top: 14pt; page-break-after: avoid; }';
$html[] = '  p { font-family: "Calibri", "Segoe UI", Arial, sans-serif; font-size: 14pt; line-height: 1.5; margin-top: 0; margin-bottom: 8pt; text-align: justify; }';
$html[] = '  ul, ol { margin-top: 4pt; margin-bottom: 10pt; padding-left: 24px; }';
$html[] = '  li { font-size: 14pt; line-height: 1.5; margin-bottom: 4pt; text-align: justify; }';
$html[] = '  table { width: 100%; border-collapse: collapse; margin: 12pt 0 16pt 0; font-size: 10.5pt; page-break-inside: avoid; }';
$html[] = '  th { background-color: #0284c7; color: #ffffff; padding: 8px 10px; border: 1px solid #94a3b8; font-weight: bold; text-align: left; font-size: 11pt; }';
$html[] = '  td { padding: 7px 10px; border: 1px solid #cbd5e1; vertical-align: top; line-height: 1.4; font-size: 10.5pt; }';
$html[] = '  tr:nth-child(even) td { background-color: #f8fafc; }';
$html[] = '  .fig-box { text-align: center; margin: 16pt 0 20pt 0; page-break-inside: avoid; }';
$html[] = '  .fig-img { width: 15.0cm; max-width: 100%; height: auto; display: block; margin: 0 auto; border: 1px solid #cbd5e1; border-radius: 4px; }';
$html[] = '  pre { background: #f8fafc; border: 1px solid #e2e8f0; border-left: 4px solid #0284c7; color: #0f172a; padding: 10px 12px; font-family: Consolas, "Courier New", monospace; font-size: 10pt; white-space: pre-wrap; word-wrap: break-word; margin: 10pt 0; line-height: 1.4; page-break-inside: avoid; }';
$html[] = '  code { font-family: Consolas, "Courier New", monospace; background: #f1f5f9; color: #0f172a; padding: 1px 4px; border-radius: 3px; font-size: 10pt; }';
$html[] = '  .page-break { page-break-before: always; clear: both; }';
$html[] = '</style>';
$html[] = '</head>';
$html[] = '<body>';

// 1. PAGE DE GARDE INSTITUTIONNELLE
$html[] = '<div style="border: 2px solid #0284c7; padding: 25px 30px; text-align: center; margin-bottom: 20px;">';
$html[] = '  <div style="font-size: 12pt; font-weight: bold; color: #334155; margin-bottom: 4px; text-transform: uppercase;">RÉPUBLIQUE TUNISIENNE</div>';
$html[] = '  <div style="font-size: 10pt; font-weight: bold; color: #475569; margin-bottom: 4px; text-transform: uppercase;">MINISTÈRE DE L\'ENSEIGNEMENT SUPÉRIEUR ET DE LA RECHERCHE SCIENTIFIQUE</div>';
$html[] = '  <div style="font-size: 12pt; font-weight: bold; color: #0284c7; margin-bottom: 20px;">ISPRI - INSTITUT SUPÉRIEUR PRIVÉ D\'INGÉNIERIE ET DE GESTION</div>';
$html[] = '  <hr style="border:0;border-top:1px solid #cbd5e1;margin:15px 0;">';
$html[] = '  <div style="font-size: 18pt; font-weight: bold; color: #0f172a; margin: 15px 0 6px;">PROJET DE FIN DE FORMATION (PFF)</div>';
$html[] = '  <div style="font-size: 11pt; color: #475569; margin-bottom: 4px;">En vue de l\'obtention du <strong>Brevet de Technicien Supérieur (BTS)</strong></div>';
$html[] = '  <div style="font-size: 12pt; font-weight: bold; color: #0284c7; margin-bottom: 4px;">Filière : Informatique de Gestion</div>';
$html[] = '  <div style="font-size: 10.5pt; color: #64748b; margin-bottom: 20px;">Session : 2024 - 2026</div>';
$html[] = '  <div style="border-top: 2px solid #0284c7; border-bottom: 2px solid #0284c7; padding: 16px 10px; margin: 20px 0; background-color: #f0f9ff;">';
$html[] = '    <div style="font-size: 11pt; font-weight: bold; color: #0369a1; text-transform: uppercase; letter-spacing: 1px;">THÈME DU PROJET :</div>';
$html[] = '    <div style="font-size: 26pt; font-weight: bold; color: #0284c7; margin: 6px 0;">EcoDrive</div>';
$html[] = '    <div style="font-size: 12pt; font-weight: 600; color: #1e293b; line-height: 1.4;">Conception et Réalisation d\'une Plateforme Web de Showroom et Catalogue de Véhicules Électriques en Tunisie</div>';
$html[] = '  </div>';
$html[] = '  <table style="width: 100%; border: none; margin-top: 25px; margin-bottom: 15px; font-size: 11pt;">';
$html[] = '    <tr>';
$html[] = '      <td style="width: 50%; border: none; text-align: left; vertical-align: top; padding: 8px; background: transparent;">';
$html[] = '        <span style="color: #64748b; font-size: 10.5pt;">Élaboré par :</span><br>';
$html[] = '        <strong style="font-size: 13pt; color: #0f172a;">Hayder BACCOURI</strong>';
$html[] = '      </td>';
$html[] = '      <td style="width: 50%; border: none; text-align: right; vertical-align: top; padding: 8px; background: transparent;">';
$html[] = '        <span style="color: #64748b; font-size: 10.5pt;">Encadrant Pédagogique &amp; Professionnel :</span><br>';
$html[] = '        <strong style="font-size: 13pt; color: #0f172a;">M. Nidhal TARHOUNI</strong>';
$html[] = '      </td>';
$html[] = '    </tr>';
$html[] = '  </table>';
$html[] = '  <div style="margin-top: 25px; font-size: 11pt; font-weight: bold; color: #334155;">';
$html[] = '    Année Universitaire : 2025 - 2026';
$html[] = '  </div>';
$html[] = '</div>';

// Ignore the raw markdown cover lines (until the first \newpage)
$startIndex = 0;
foreach ($lines as $idx => $l) {
    if (trim($l) === '\newpage') {
        $startIndex = $idx + 1;
        break;
    }
}

$inTable = false;
$inCode  = false;
$inList  = false;
$isFirstH1 = true;

for ($i = $startIndex; $i < count($lines); $i++) {
    $line = rtrim($lines[$i]);

    // Page break or Section break
    if (trim($line) === '\newpage') {
        if ($inTable) { $html[] = '</tbody></table>'; $inTable = false; }
        if ($inCode)  { $html[] = '</pre>'; $inCode = false; }
        if ($inList)  { $html[] = '</ul>'; $inList = false; }
        
        // Peek ahead: check if next non-empty content is h1 or Introduction Générale
        $nextIsH1 = false;
        $nextIsIntro = false;
        for ($k = $i + 1; $k < count($lines); $k++) {
            $trimmedK = trim($lines[$k]);
            if ($trimmedK === '') continue;
            if (preg_match('/^#\s+(.+)$/i', $trimmedK, $mk)) {
                $nextIsH1 = true;
                if (stripos($mk[1], 'INTRODUCTION') !== false) {
                    $nextIsIntro = true;
                }
            }
            break;
        }

        // Si nous arrivons sur l'Introduction Générale, insérer une balise de saut de section formelle Word
        if ($nextIsIntro) {
            $html[] = '<div class="section-break" id="sec-introduction" style="mso-break-type:section-break;page-break-before:always;"><br clear="all" style="mso-special-character:line-break;page-break-before:always;"></div>';
        } elseif (!$nextIsH1) {
            $html[] = '<div class="page-break"></div>';
        }
        continue;
    }

    // Code block toggle (```)
    if (strpos(trim($line), '```') === 0) {
        if ($inCode) {
            $html[] = '</pre>';
            $inCode = false;
        } else {
            if ($inTable) { $html[] = '</tbody></table>'; $inTable = false; }
            if ($inList)  { $html[] = '</ul>'; $inList = false; }
            $html[] = '<pre>';
            $inCode = true;
        }
        continue;
    }

    if ($inCode) {
        $html[] = htmlspecialchars($line, ENT_QUOTES, 'UTF-8');
        continue;
    }

    // Empty line
    if (trim($line) === '') {
        if ($inTable) { $html[] = '</tbody></table>'; $inTable = false; }
        if ($inList)  { $html[] = '</ul>'; $inList = false; }
        continue;
    }

    // Horizontal rule
    if (trim($line) === '---') {
        if ($inTable) { $html[] = '</tbody></table>'; $inTable = false; }
        if ($inList)  { $html[] = '</ul>'; $inList = false; }
        $html[] = '<hr style="border:0;border-top:1px solid #cbd5e1;margin:18pt 0;">';
        continue;
    }

    // Table row
    if (preg_match('/^\|(.+)\|$/', trim($line), $m)) {
        if ($inList) { $html[] = '</ul>'; $inList = false; }
        $rawCells = explode('|', $m[1]);
        $cells = array_map('trim', $rawCells);

        // Markdown separator row (e.g. |:---|:---|)
        if (preg_match('/^[:\s\-]+$/', $cells[0])) {
            continue;
        }

        if (!$inTable) {
            $html[] = '<table>';
            $html[] = '<thead><tr>';
            foreach ($cells as $c) {
                $content = htmlspecialchars($c, ENT_QUOTES, 'UTF-8');
                $content = preg_replace('/&lt;br\s*\/?&gt;/i', '<br>', $content);
                $content = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $content);
                $content = preg_replace('/`(.+?)`/', '<code>$1</code>', $content);
                $html[] = '<th>' . $content . '</th>';
            }
            $html[] = '</tr></thead><tbody>';
            $inTable = true;
        } else {
            $html[] = '<tr>';
            foreach ($cells as $c) {
                $content = htmlspecialchars($c, ENT_QUOTES, 'UTF-8');
                $content = preg_replace('/&lt;br\s*\/?&gt;/i', '<br>', $content);
                $content = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $content);
                $content = preg_replace('/\*([^\*]+?)\*/', '<em>$1</em>', $content);
                $content = preg_replace('/`(.+?)`/', '<code>$1</code>', $content);
                $content = preg_replace('/&lt;u&gt;(.+?)&lt;\/u&gt;/', '<u>$1</u>', $content);
                $html[] = '<td>' . $content . '</td>';
            }
            $html[] = '</tr>';
        }
        continue;
    } else {
        if ($inTable) {
            $html[] = '</tbody></table>';
            $inTable = false;
        }
    }

    // Table caption line e.g. *Tableau 1.1 : ...* -> Heading 5 (Titre 5)
    if (preg_match('/^\*Tableau\s+(\d+\.\d+)\s*:\s*(.+?)\*$/i', trim($line), $m)) {
        if ($inList) { $html[] = '</ul>'; $inList = false; }
        $html[] = '<h5 class="table-caption">Tableau ' . htmlspecialchars($m[1], ENT_QUOTES, 'UTF-8') . ' : ' . htmlspecialchars($m[2], ENT_QUOTES, 'UTF-8') . '</h5>';
        continue;
    }

    // Image: ![caption](path) -> Heading 4 (Titre 4) for caption
    if (preg_match('/^!\[(.*?)\]\((.*?)\)/', trim($line), $m)) {
        if ($inList) { $html[] = '</ul>'; $inList = false; }
        $caption = trim($m[1]);
        $src     = trim($m[2]);

        $fullSrc = realpath($baseDir . DIRECTORY_SEPARATOR . $src);
        if (!$fullSrc) {
            $fullSrc = realpath($baseDir . DIRECTORY_SEPARATOR . 'diagrammes' . DIRECTORY_SEPARATOR . basename($src));
        }
        if (!$fullSrc) {
            $fullSrc = realpath($baseDir . DIRECTORY_SEPARATOR . 'captures' . DIRECTORY_SEPARATOR . basename($src));
        }

        $figMap = [
            'UseCase_General'            => 'Figure 2.1 : Diagramme Général des Cas d\'Utilisation (UML)',
            'UseCase_Client'             => 'Figure 2.2 : Diagramme des Cas d\'Utilisation — Espace Client (UML)',
            'UseCase_Admin'              => 'Figure 2.3 : Diagramme des Cas d\'Utilisation — Panneau d\'Administration (UML)',
            'MCD_EcoDrive'               => 'Figure 3.1 : Modèle Conceptuel des Données (MCD Merise)',
            'Diagramme_Classes_EcoDrive' => 'Figure 3.2 : Diagramme de Classes Métier (UML)',
            'Sequence_Authentification'  => 'Figure 3.3 : Diagramme de Séquence — Authentification Sécurisée',
            'Sequence_Reservation'       => 'Figure 3.4 : Diagramme de Séquence — Réservation d\'Essai Routier',
            'Sequence_Administration'    => 'Figure 3.5 : Diagramme de Séquence — Validation Administrative',
            '01_accueil'                 => 'Figure 4.1 : Page d\'Accueil & Showroom Immersif (index.php)',
            '02_catalogue'               => 'Figure 4.2 : Catalogue Interactif et Filtres Multi-Critères (catalogue.php)',
            '03_fiche_technique'         => 'Figure 4.3 : Fiche Technique Détaillée (Tesla-Model-3.php)',
            '03_fiche_voiture_tesla'     => 'Figure 4.3 : Fiche Technique Détaillée (Tesla-Model-3.php)',
            '04_comparateur'             => 'Figure 4.4 : Comparateur Dynamique Multi-Modèles (comparer.php)',
            '05_bornes'                  => 'Figure 4.5 : Catalogue des Bornes de Recharge Exicom (bornes/index.php)',
            '05_bornes_catalogue'        => 'Figure 4.5 : Catalogue des Bornes de Recharge Exicom (bornes/index.php)',
            '06_fiche_borne'             => 'Figure 4.6 : Fiche Produit Borne de Recharge (ExicomSpinAir7kW.php)',
            '06_borne_fiche'             => 'Figure 4.6 : Fiche Produit Borne de Recharge (ExicomSpinAir7kW.php)',
            '07_contact_map'             => 'Figure 4.7 : Formulaire de Contact avec Carte Leaflet (contact.php)',
            '07_contact'                 => 'Figure 4.7 : Formulaire de Contact avec Carte Leaflet (contact.php)',
            '08_connexion'               => 'Figure 4.8 : Interface de Connexion Sécurisée (connexion.php)',
            '09_inscription'             => 'Figure 4.9 : Interface d\'Inscription avec Validation (inscription.php)',
            '10_reservation'             => 'Figure 4.10 : Module de Réservation d\'Essai Routier (reservation.php)',
            '11_dashboard_client'        => 'Figure 4.11 : Espace Client — Tableau de Bord Personnel (tableau-de-bord.php)',
            '11_espace_client_dashboard' => 'Figure 4.11 : Espace Client — Tableau de Bord Personnel (tableau-de-bord.php)',
            '12_administration'          => 'Figure 4.12 : Panneau d\'Administration Général (admin.php)',
            '13_admin_audit'             => 'Figure 4.13 : Journal d\'Audit de Sécurité et Traçabilité (admin.php?tab=audit)'
        ];

        $baseNameWithoutExt = pathinfo(basename($src), PATHINFO_FILENAME);
        if (isset($figMap[$baseNameWithoutExt])) {
            $caption = $figMap[$baseNameWithoutExt];
        } elseif (stripos($caption, 'Figure ') !== 0) {
            $caption = 'Figure : ' . $caption;
        }

        if ($fullSrc) {
            $relPath = str_replace('\\', '/', substr($fullSrc, strlen($baseDir) + 1));
            $captionHtml = htmlspecialchars($caption, ENT_QUOTES, 'UTF-8');
            $html[] = '<div class="fig-box">';
            $html[] = '  <img class="fig-img" width="550" src="' . htmlspecialchars($relPath, ENT_QUOTES, 'UTF-8') . '" alt="' . $captionHtml . '">';
            $html[] = '  <h4 class="fig-caption">' . $captionHtml . '</h4>';
            $html[] = '</div>';
            continue;
        } else {
            echo "Avertissement : Image non trouvée : $src\n";
        }
    }

    // Bullet list (- item)
    if (preg_match('/^(\s*)-\s+(.+)$/', $line, $m)) {
        if (!$inList) {
            $html[] = '<ul>';
            $inList = true;
        }
        $liContent = htmlspecialchars($m[2], ENT_QUOTES, 'UTF-8');
        $liContent = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $liContent);
        $liContent = preg_replace('/\*([^\*]+?)\*/', '<em>$1</em>', $liContent);
        $liContent = preg_replace('/`(.+?)`/', '<code>$1</code>', $liContent);
        $html[] = '  <li>' . $liContent . '</li>';
        continue;
    } else {
        if ($inList) {
            $html[] = '</ul>';
            $inList = false;
        }
    }

    // Headings
    if (preg_match('/^(#{1,4})\s+(.+)$/', $line, $m)) {
        $lvl = strlen($m[1]);
        $txt = htmlspecialchars($m[2], ENT_QUOTES, 'UTF-8');
        $txt = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $txt);
        $txt = preg_replace('/`(.+?)`/', '<code>$1</code>', $txt);

        // 1. Table des Matières
        if ($lvl === 1 && (stripos($txt, 'Table des Matières') !== false || stripos($txt, 'Sommaire') !== false)) {
            $html[] = '<p style="font-family:\'Segoe UI\',Arial,sans-serif;font-size:20pt;font-weight:bold;color:#0284c7;border-bottom:2px solid #0284c7;padding-bottom:5px;margin-top:24pt;margin-bottom:12pt;page-break-before:always;">' . $txt . '</p>';
            $html[] = '<p class="word-toc-placeholder">[WORD_TOC_PLACEHOLDER]</p>';
            while ($i + 1 < count($lines) && trim($lines[$i + 1]) !== '\newpage') {
                $i++;
            }
            continue;
        }

        // 2. Liste des Figures (Dynamique Word TOC 4-4)
        if ($lvl === 1 && stripos($txt, 'Liste des Figures') !== false) {
            $html[] = '<p style="font-family:\'Segoe UI\',Arial,sans-serif;font-size:20pt;font-weight:bold;color:#0284c7;border-bottom:2px solid #0284c7;padding-bottom:5px;margin-top:24pt;margin-bottom:12pt;page-break-before:always;">' . $txt . '</p>';
            $html[] = '<p class="word-tof-placeholder">[WORD_TOF_PLACEHOLDER]</p>';
            while ($i + 1 < count($lines) && trim($lines[$i + 1]) !== '\newpage') {
                $i++;
            }
            continue;
        }

        // 3. Liste des Tableaux (Dynamique Word TOC 5-5)
        if ($lvl === 1 && stripos($txt, 'Liste des Tableaux') !== false) {
            $html[] = '<p style="font-family:\'Segoe UI\',Arial,sans-serif;font-size:20pt;font-weight:bold;color:#0284c7;border-bottom:2px solid #0284c7;padding-bottom:5px;margin-top:24pt;margin-bottom:12pt;page-break-before:always;">' . $txt . '</p>';
            $html[] = '<p class="word-tot-placeholder">[WORD_TOT_PLACEHOLDER]</p>';
            while ($i + 1 < count($lines) && trim($lines[$i + 1]) !== '\newpage') {
                $i++;
            }
            continue;
        }

        // 4. Chaque titre de chapitre sur une page unique seul (Page Intercalaire de Chapitre)
        if ($lvl === 1 && preg_match('/^CHAPITRE\s+(\d+)\s*:\s*(.+)$/i', $txt, $mCh)) {
            $chNum = $mCh[1];
            $chTitle = $mCh[2];
            $html[] = '<div class="chapter-cover-page" style="page-break-before: always; page-break-after: always; padding-top: 180pt; text-align: center;">';
            $html[] = '  <div style="font-size: 13pt; font-weight: bold; color: #0284c7; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 12pt;">PROJET DE FIN DE FORMATION — BTS IG</div>';
            $html[] = '  <div style="display: inline-block; background-color: #0284c7; color: #ffffff; padding: 6px 18pt; border-radius: 4px; font-weight: bold; font-size: 16pt; margin-bottom: 16pt;">CHAPITRE ' . $chNum . '</div>';
            $html[] = '  <h1 style="font-family:\'Segoe UI\',Arial,sans-serif;font-size:24pt;font-weight:bold;color:#0f172a;line-height:1.3;border:none;margin:0 auto;max-width:500pt;">CHAPITRE ' . $chNum . ' : ' . $chTitle . '</h1>';
            $html[] = '  <div style="width: 80pt; height: 3pt; background-color: #0284c7; margin: 24pt auto 0 auto;"></div>';
            $html[] = '</div>';
            continue;
        }

        $cls = '';
        if ($lvl === 1 && $isFirstH1) {
            $cls = ' class="first-h1"';
            $isFirstH1 = false;
        }

        $html[] = "<h{$lvl}{$cls}>{$txt}</h{$lvl}>";
        continue;
    }

    // Raw HTML block handling (e.g. signature div in Dédicaces)
    if (preg_match('/^<div style="(.+?)">/i', trim($line), $m)) {
        $html[] = '<div style="' . htmlspecialchars($m[1], ENT_QUOTES, 'UTF-8') . '">';
        continue;
    }
    if (trim($line) === '</div>') {
        $html[] = '</div>';
        continue;
    }

    // Normal paragraph
    $p = htmlspecialchars($line, ENT_QUOTES, 'UTF-8');
    $p = preg_replace('/&lt;br\s*\/?&gt;/i', '<br>', $p);
    $p = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $p);
    $p = preg_replace('/\*([^\*]+?)\*/', '<em>$1</em>', $p);
    $p = preg_replace('/`(.+?)`/', '<code>$1</code>', $p);
    $p = preg_replace('/&lt;u&gt;(.+?)&lt;\/u&gt;/', '<u>$1</u>', $p);
    $html[] = "<p>{$p}</p>";
}

if ($inTable) { $html[] = '</tbody></table>'; }
if ($inCode)  { $html[] = '</pre>'; }
if ($inList)  { $html[] = '</ul>'; }

$html[] = '</body></html>';

// Enregistrement avec BOM UTF-8 (\xEF\xBB\xBF) pour garantir une détection 100% sans faille sous Word
file_put_contents($htmlPath, "\xEF\xBB\xBF" . implode("\n", $html));
echo "Rapport HTML généré avec succès avec BOM UTF-8 : $htmlPath (" . number_format(strlen(implode("\n", $html))) . " octets)\n";
