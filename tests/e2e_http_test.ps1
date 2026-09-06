# Test E2E EcoDrive - inscription -> verif email -> connexion -> reservation
$ErrorActionPreference = 'Stop'
$base = 'http://localhost/ecodrive'
$verificationLog = 'C:\xampp\ecodrive-private\logs\verification_links.txt'
$email = "e2e-$(Get-Date -Format 'yyyyMMddHHmmss')@example.com"
$pass  = 'MotDePasse123'
$results = @()
function Check($name, $ok, $detail = '') {
    $script:results += [pscustomobject]@{ Test = $name; OK = $ok; Detail = $detail }
    if ($ok) { Write-Output "[OK]   $name" } else { Write-Output "[FAIL] $name :: $detail" }
}

# 1. GET inscription + CSRF
$r1 = Invoke-WebRequest -Uri "$base/php/inscription.php" -SessionVariable sess -UseBasicParsing
$csrf = ([regex]::Match($r1.Content, 'name="csrf_token"\s+value="([^"]+)"')).Groups[1].Value
Check 'GET inscription.php (200 + CSRF)' (($r1.StatusCode -eq 200) -and $csrf)

# 2. POST inscription -> redirection connexion.php?registered=1&verify=1
try {
    $r2 = Invoke-WebRequest -Uri "$base/php/inscription.php" -Method Post -WebSession $sess -UseBasicParsing `
        -Body @{ fullname = 'Test E2E'; email = $email; password = $pass; password_confirm = $pass; csrf_token = $csrf } `
        -MaximumRedirection 5
    $finalUrl = $r2.BaseResponse.ResponseUri.AbsoluteUri
    Check 'POST inscription (redirect + page connexion)' (($finalUrl -match 'connexion\.php') -and ($finalUrl -match 'registered=1'))
} catch { Check 'POST inscription' $false $_.Exception.Message }

# 3. Token de verification ecrit dans le log
Start-Sleep -Milliseconds 500
$logLine = Select-String -Path $verificationLog -Pattern ([regex]::Escape($email)) | Select-Object -Last 1
$token = if ($logLine) { ([regex]::Match($logLine.Line, 'token=([a-f0-9]+)')).Groups[1].Value } else { '' }
Check 'Lien de verification logge' ([bool]$token)

# 4. GET verifier-email.php?token=... -> succes
if ($token) {
    $r3 = Invoke-WebRequest -Uri "$base/php/verifier-email.php?token=$token" -WebSession $sess -UseBasicParsing
    Check 'GET verifier-email (compte active)' ($r3.Content -match 'maintenant vous connecter')
} else { Check 'GET verifier-email' $false 'pas de token' }

# 5. Connexion avec le compte verifie
$r4 = Invoke-WebRequest -Uri "$base/php/connexion.php" -WebSession $sess -UseBasicParsing
$csrf2 = ([regex]::Match($r4.Content, 'name="csrf_token"\s+value="([^"]+)"')).Groups[1].Value
try {
    $r5 = Invoke-WebRequest -Uri "$base/php/connexion.php" -Method Post -WebSession $sess -UseBasicParsing `
        -Body @{ email = $email; password = $pass; csrf_token = $csrf2 } -MaximumRedirection 5
    $loggedOk = ($r5.Content -match 'eco<span>drive</span>') -and ($r5.Content -notmatch 'type="password"')
    Check 'POST connexion (session utilisateur)' $loggedOk
} catch { Check 'POST connexion' $false $_.Exception.Message }

# 6. Reservation d'un essai (demain, hors dimanche)
$date = (Get-Date).AddDays(1); while ($date.DayOfWeek -eq 'Sunday') { $date = $date.AddDays(1) }
$dStr = $date.ToString('yyyy-MM-dd')
$r6 = Invoke-WebRequest -Uri "$base/php/reservation.php?car=1" -WebSession $sess -UseBasicParsing
$csrf3 = ([regex]::Match($r6.Content, 'name="csrf_token"\s+value="([^"]+)"')).Groups[1].Value
Check 'GET reservation.php?car=1 (formulaire + CSRF)' (($r6.StatusCode -eq 200) -and $csrf3)
try {
    $r7 = Invoke-WebRequest -Uri "$base/php/reservation.php" -Method Post -WebSession $sess -UseBasicParsing `
        -Body @{ voiture_id = '1'; date_essai = $dStr; heure_debut = '10:00'; notes = 'Test E2E automatise'; csrf_token = $csrf3 } `
        -MaximumRedirection 5
    Check "POST reservation ($dStr 10:00)" ($r7.StatusCode -eq 200)
} catch { Check 'POST reservation' $false $_.Exception.Message }

# 7. Newsletter
$r8 = Invoke-WebRequest -Uri "$base/index.php" -WebSession $sess -UseBasicParsing
$csrf4 = ([regex]::Match($r8.Content, 'name="csrf_token"\s+value="([^"]+)"')).Groups[1].Value
try {
    $r9 = Invoke-WebRequest -Uri "$base/php/newsletter.php" -Method Post -WebSession $sess -UseBasicParsing `
        -Body @{ email = $email; csrf_token = $csrf4 } -MaximumRedirection 0 -ErrorAction SilentlyContinue
    Check 'POST newsletter' ($null -ne $r9)
} catch {
    $resp = $_.Exception.Response
    $isRedirect = ($null -ne $resp) -and ([int]$resp.StatusCode -in 301,302,303)
    Check 'POST newsletter (redirect)' $isRedirect
}

Write-Output ''
$okCount = ($results | Where-Object OK).Count
Write-Output "Resultat : $okCount / $($results.Count) tests OK - compte test : $email"
