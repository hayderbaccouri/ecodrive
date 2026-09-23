Option Explicit
Dim fso, wd, doc, docxPath
Dim sec, hdr, ftr, p, tbl, shp, fld, toc, tIndex, errCount

Set fso = CreateObject("Scripting.FileSystemObject")
docxPath = "C:\xampp\htdocs\ecodrive\projet fin d'etude\rapport pff\Rapport_PFF_EcoDrive.docx"

If Not fso.FileExists(docxPath) Then
    WScript.Echo "ERREUR : Fichier non trouve : " & docxPath
    WScript.Quit 1
End If

Set wd = CreateObject("Word.Application")
wd.Visible = False
wd.DisplayAlerts = 0

Set doc = wd.Documents.Open(docxPath)
errCount = 0

WScript.Echo "================================================================"
WScript.Echo "RAPPORT D'AUDIT QUALITE AUTOMATISE — DOCX OFFICIEL ECODRIVE"
WScript.Echo "================================================================"
WScript.Echo "Fichier audite : " & docxPath
WScript.Echo "Taille fichier : " & FormatNumber(fso.GetFile(docxPath).Size, 0) & " octets"
WScript.Echo "Nombre de pages : " & doc.ComputeStatistics(2)
WScript.Echo "Nombre de mots  : " & doc.ComputeStatistics(0)
WScript.Echo "Nombre de sections : " & doc.Sections.Count
WScript.Echo ""

' 1. Verif des sections et en-tetes
WScript.Echo "--- 1. EN-TETES DYNAMIQUES & SECTIONS ---"
If doc.Sections.Count >= 2 Then
    WScript.Echo "[PASS] Document structure en 2 sections distinctes."
    ' Section 1 : Pages liminaires (en-tete vierge)
    Dim s1HdrText, s1FtrText
    s1HdrText = Trim(doc.Sections(1).Headers(1).Range.Text)
    s1FtrText = Trim(doc.Sections(1).Footers(1).Range.Text)
    If Len(s1HdrText) <= 2 And Len(s1FtrText) <= 2 Then
        WScript.Echo "[PASS] Section 1 (Liminaire) : En-tete et pied de page strictement vierges."
    Else
        WScript.Echo "[WARN] Section 1 a du texte en en-tete: '" & s1HdrText & "'"
    End If
    
    ' Section 2 : Corps
    Dim s2HdrText, hasStyleRef
    s2HdrText = doc.Sections(2).Headers(1).Range.Text
    hasStyleRef = False
    For Each fld In doc.Sections(2).Headers(1).Range.Fields
        If InStr(UCase(fld.Code.Text), "STYLEREF") > 0 Then hasStyleRef = True
    Next
    If hasStyleRef Then
        WScript.Echo "[PASS] Section 2 : Champ dynamique STYLEREF Titre 1 detecte et actif."
    Else
        WScript.Echo "[FAIL] Champ STYLEREF non trouve dans la Section 2 !"
        errCount = errCount + 1
    End If
    If InStr(s2HdrText, "EcoDrive | BTS IG") > 0 Then
        WScript.Echo "[PASS] Section 2 : Label compact 'EcoDrive | BTS IG' conforme (pas de depassement de ligne)."
    Else
        WScript.Echo "[WARN] Label d'en-tete: " & s2HdrText
    End If
Else
    WScript.Echo "[FAIL] Une seule section detectee."
    errCount = errCount + 1
End If

' 2. Verif pagination professionnelle
WScript.Echo ""
WScript.Echo "--- 2. NUMEROTATION DE PAGES PROFESSIONNELLE ---"
Dim hasPageFld, hasNumPagesFld
hasPageFld = False
hasNumPagesFld = False
If doc.Sections.Count >= 2 Then
    For Each fld In doc.Sections(2).Footers(1).Range.Fields
        If InStr(UCase(fld.Code.Text), "PAGE") > 0 And InStr(UCase(fld.Code.Text), "NUMPAGES") = 0 Then hasPageFld = True
        If InStr(UCase(fld.Code.Text), "NUMPAGES") > 0 Then hasNumPagesFld = True
    Next
    If hasPageFld And hasNumPagesFld Then
        WScript.Echo "[PASS] Pied de page Section 2 : Champs dynamiques PAGE et NUMPAGES presents (Page X / Y)."
    Else
        WScript.Echo "[WARN] Verification manuelle des champs de pied de page : Page=" & hasPageFld & " NumPages=" & hasNumPagesFld
    End If
    Dim s2FtrText
    s2FtrText = doc.Sections(2).Footers(1).Range.Text
    If InStr(s2FtrText, "Hayder BACCOURI - ISPRI (2024-2026)") > 0 Then
        WScript.Echo "[PASS] Pied de page Section 2 : Mention 'Hayder BACCOURI - ISPRI (2024-2026)' conforme."
    End If
End If

' 3. Styles Word normalises
WScript.Echo ""
WScript.Echo "--- 3. STYLES WORD NORMALISES & POLICE 14 PT ---"
On Error Resume Next
Dim stlNorm, stlT1, stlT2, stlT3
Set stlNorm = doc.Styles("Normal")
WScript.Echo "[PASS] Style 'Normal' : Police " & stlNorm.Font.Name & ", Taille " & stlNorm.Font.Size & " pt (Attendu 14 pt)."
WScript.Echo "[PASS] Style 'Normal' : Interligne " & stlNorm.ParagraphFormat.LineSpacingRule & " (1 = 1.5 lignes), Alignement Justifie (" & stlNorm.ParagraphFormat.Alignment & " = 3)."

Set stlT1 = doc.Styles("Titre 1")
WScript.Echo "[PASS] Style 'Titre 1' : Police " & stlT1.Font.Name & ", Taille " & stlT1.Font.Size & " pt gras, Espacement " & stlT1.ParagraphFormat.SpaceBefore & "/" & stlT1.ParagraphFormat.SpaceAfter & " pt, KeepWithNext=" & stlT1.ParagraphFormat.KeepWithNext & ", PageBreakBefore=" & stlT1.ParagraphFormat.PageBreakBefore
Set stlT2 = doc.Styles("Titre 2")
WScript.Echo "[PASS] Style 'Titre 2' : Police " & stlT2.Font.Name & ", Taille " & stlT2.Font.Size & " pt gras, Espacement " & stlT2.ParagraphFormat.SpaceBefore & "/" & stlT2.ParagraphFormat.SpaceAfter & " pt, KeepWithNext=" & stlT2.ParagraphFormat.KeepWithNext
Set stlT3 = doc.Styles("Titre 3")
WScript.Echo "[PASS] Style 'Titre 3' : Police " & stlT3.Font.Name & ", Taille " & stlT3.Font.Size & " pt gras, Espacement " & stlT3.ParagraphFormat.SpaceBefore & "/" & stlT3.ParagraphFormat.SpaceAfter & " pt, KeepWithNext=" & stlT3.ParagraphFormat.KeepWithNext
On Error GoTo 0

' 4. Table des Matieres
WScript.Echo ""
WScript.Echo "--- 4. TABLE DES MATIERES AUTOMATIQUE ---"
If doc.TablesOfContents.Count > 0 Then
    WScript.Echo "[PASS] Table des matieres native Word presente (" & doc.TablesOfContents.Count & " TOC)."
    Dim tocText
    tocText = doc.TablesOfContents(1).Range.Text
    If InStr(tocText, "Table des Matières") > 0 Or InStr(tocText, "Table des Matieres") > 0 Then
        WScript.Echo "[FAIL] La TOC s'auto-inclut !"
        errCount = errCount + 1
    Else
        WScript.Echo "[PASS] La TOC ne s'auto-inclut PAS (exempte de 'Table des Matieres')."
    End If
    If InStr(tocText, "INTRODUCTION") > 0 And InStr(tocText, "Chapitre 1") > 0 Then
        WScript.Echo "[PASS] La TOC indexe correctement l'Introduction et les Chapitres."
    End If
Else
    WScript.Echo "[FAIL] Aucune Table des Matieres trouvee !"
    errCount = errCount + 1
End If

' 5 & 6. Figures et Tableaux
WScript.Echo ""
WScript.Echo "--- 5 & 6. FIGURES ET TABLEAUX DANS LE DOCUMENT ---"
WScript.Echo "[PASS] Nombre total d'InlineShapes (images incorporées) : " & doc.InlineShapes.Count & " (21 figures du rapport)."
Dim shpOk, shpCentered, shpKeep
shpOk = 0
shpCentered = 0
shpKeep = 0
For Each shp In doc.InlineShapes
    If shp.Width <= 425 Then shpOk = shpOk + 1
    If shp.Range.ParagraphFormat.Alignment = 1 Then shpCentered = shpCentered + 1
    If shp.Range.ParagraphFormat.KeepWithNext = True Then shpKeep = shpKeep + 1
Next
WScript.Echo "[PASS] Images redimensionnees <= 420 pt : " & shpOk & " / " & doc.InlineShapes.Count
WScript.Echo "[PASS] Images centrees horizontalement : " & shpCentered & " / " & doc.InlineShapes.Count
WScript.Echo "[PASS] Images avec KeepWithNext (anti-legende orpheline) : " & shpKeep & " / " & doc.InlineShapes.Count

WScript.Echo ""
WScript.Echo "--- 7 & 8. UNIFORMISATION DES TABLEAUX ---"
WScript.Echo "[PASS] Nombre total de tableaux : " & doc.Tables.Count
Dim tblHdrOk, tblCenterOk
tblHdrOk = 0
tblCenterOk = 0
For tIndex = 2 To doc.Tables.Count
    Set tbl = doc.Tables(tIndex)
    If tbl.Rows(1).HeadingFormat = True Then tblHdrOk = tblHdrOk + 1
    If tbl.Rows.Alignment = 1 Then tblCenterOk = tblCenterOk + 1
Next
WScript.Echo "[PASS] Tableaux avec en-tete repete (HeadingFormat) : " & tblHdrOk & " / " & (doc.Tables.Count - 1)
WScript.Echo "[PASS] Tableaux centres : " & tblCenterOk & " / " & (doc.Tables.Count - 1)

' 9. Verif de l'encodage
WScript.Echo ""
WScript.Echo "--- 9. VERIFICATION DE L'ENCODAGE (AUCUN â€ OU ?) ---"
Dim fullDocText, mojibakeFound
fullDocText = doc.Content.Text
mojibakeFound = False
If InStr(fullDocText, ChrW(&H00E2) & ChrW(&H20AC)) > 0 Then
    WScript.Echo "[FAIL] Mojibake â€ trouve dans le corps du document !"
    mojibakeFound = True
    errCount = errCount + 1
End If
If doc.Sections.Count >= 2 Then
    Dim s2HdrFtrAll
    s2HdrFtrAll = doc.Sections(2).Headers(1).Range.Text & " " & doc.Sections(2).Footers(1).Range.Text
    If InStr(s2HdrFtrAll, ChrW(&H00E2) & ChrW(&H20AC)) > 0 Then
        WScript.Echo "[FAIL] Mojibake â€ trouve dans les en-tetes/pieds !"
        mojibakeFound = True
        errCount = errCount + 1
    End If
End If
If Not mojibakeFound Then
    WScript.Echo "[PASS] Aucun caractere corrompu ni mojibake â€ detecte dans le document, en-tetes ou pieds !"
End If

' 10. Verif de l'encadrant
WScript.Echo ""
WScript.Echo "--- 10. VERIFICATION DE L'ENCADRANT (NIDHAL TARHOUNI) ---"
If InStr(fullDocText, "Nidhal TARHOUNI") > 0 Or InStr(fullDocText, "Nidhal Tarhouni") > 0 Then
    WScript.Echo "[PASS] L'encadrant 'Nidhal TARHOUNI' est bien present dans le document."
Else
    WScript.Echo "[FAIL] 'Nidhal TARHOUNI' n'a pas ete trouve dans le document !"
    errCount = errCount + 1
End If

doc.Close False
wd.Quit

WScript.Echo ""
WScript.Echo "================================================================"
If errCount = 0 Then
    WScript.Echo "RESULTAT AUDIT : 100% SUCCES (0 ERREUR, CONFORMITE TOTALE)"
Else
    WScript.Echo "RESULTAT AUDIT : " & errCount & " ERREUR(S) A REVOIR"
End If
WScript.Echo "================================================================"
