@echo off
set CHROME="C:\Program Files\Google\Chrome\Application\chrome.exe"
set BASE=C:\xampp\htdocs\ecodrive\projet fin d'etude
set DIAG=%BASE%\rapport pff\diagrammes

copy /Y "%BASE%\use cases general.jpg" "%DIAG%\UseCase_General.jpg"
copy /Y "%BASE%\Use Cases-client.jpg" "%DIAG%\UseCase_Client.jpg"
copy /Y "%BASE%\UseCaseDiagram-administrateur.jpg" "%DIAG%\UseCase_Admin.jpg"

echo Converting SVGs to PNGs...
%CHROME% --headless --disable-gpu --window-size=1200,900 --screenshot="%DIAG%\MCD_EcoDrive.png" "file:///%DIAG%/MCD_EcoDrive.svg"
%CHROME% --headless --disable-gpu --window-size=1200,900 --screenshot="%DIAG%\Diagramme_Classes_EcoDrive.png" "file:///%DIAG%/Diagramme_Classes_EcoDrive.svg"
%CHROME% --headless --disable-gpu --window-size=1200,850 --screenshot="%DIAG%\Sequence_Authentification.png" "file:///%DIAG%/Sequence_Authentification.svg"
%CHROME% --headless --disable-gpu --window-size=1200,850 --screenshot="%DIAG%\Sequence_Reservation.png" "file:///%DIAG%/Sequence_Reservation.svg"
%CHROME% --headless --disable-gpu --window-size=1200,850 --screenshot="%DIAG%\Sequence_Administration.png" "file:///%DIAG%/Sequence_Administration.svg"

echo Done rendering diagrams!
dir "%DIAG%\*.png" "%DIAG%\*.jpg"
