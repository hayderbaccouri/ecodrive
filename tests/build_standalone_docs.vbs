Option Explicit
Dim fso, sh, wd, doc, tempDir, baseDir, htmlFile, docxFile, pdfFile, shape, imgCount
Dim sec, hdr, ftr, rng, tbl, p, r, findRng, tIndex, i

Set fso = CreateObject("Scripting.FileSystemObject")
Set sh  = CreateObject("WScript.Shell")

baseDir = "C:\xampp\htdocs\ecodrive\projet fin d'etude\rapport pff"
tempDir = sh.ExpandEnvironmentStrings("%TEMP%") & "\ecodrive_pff_embed"

WScript.Echo "1. Copie dans le dossier temporaire..."
If fso.FolderExists(tempDir) Then fso.DeleteFolder tempDir, True
fso.CreateFolder tempDir

fso.CopyFile baseDir & "\Rapport_PFF_EcoDrive.html", tempDir & "\Rapport_PFF_EcoDrive.html"
fso.CopyFolder baseDir & "\diagrammes", tempDir & "\diagrammes"
fso.CopyFolder baseDir & "\captures", tempDir & "\captures"

htmlFile = tempDir & "\Rapport_PFF_EcoDrive.html"
docxFile = tempDir & "\Rapport_PFF_EcoDrive.docx"
pdfFile  = tempDir & "\Rapport_PFF_EcoDrive.pdf"

WScript.Echo "2. Lancement de Microsoft Word..."
Set wd = CreateObject("Word.Application")
wd.Visible = False
wd.DisplayAlerts = 0

WScript.Echo "3. Ouverture du document HTML..."
Set doc = wd.Documents.Open(htmlFile)

WScript.Echo "4. Configuration des marges A4 (2.5 cm)..."
doc.PageSetup.PaperSize    = 7     ' wdPaperA4
doc.PageSetup.TopMargin    = 70.87 ' 2.5 cm
doc.PageSetup.BottomMargin = 70.87 ' 2.5 cm
doc.PageSetup.LeftMargin   = 70.87 ' 2.5 cm
doc.PageSetup.RightMargin  = 70.87 ' 2.5 cm

WScript.Echo "5. Normalisation des Styles Word (Normal: 14pt 1.5, Titres 1 a 5)..."
On Error Resume Next
' Titre 1 (Titres de Chapitres)
With doc.Styles("Titre 1")
    .Font.Name = "Segoe UI"
    .Font.Size = 22
    .Font.Bold = True
    .Font.Color = RGB(2, 132, 199)
    .ParagraphFormat.SpaceBefore = 24
    .ParagraphFormat.SpaceAfter = 12
    .ParagraphFormat.KeepWithNext = True
End With

' Titre 2 (Sections principales)
With doc.Styles("Titre 2")
    .Font.Name = "Segoe UI"
    .Font.Size = 16
    .Font.Bold = True
    .Font.Color = RGB(15, 23, 42)
    .ParagraphFormat.SpaceBefore = 18
    .ParagraphFormat.SpaceAfter = 8
    .ParagraphFormat.KeepWithNext = True
End With

' Titre 3 (Sous-sections)
With doc.Styles("Titre 3")
    .Font.Name = "Segoe UI"
    .Font.Size = 14
    .Font.Bold = True
    .Font.Color = RGB(30, 41, 59)
    .ParagraphFormat.SpaceBefore = 14
    .ParagraphFormat.SpaceAfter = 6
    .ParagraphFormat.KeepWithNext = True
End With

' Titre 4 (Legende de Figure pour Liste des Figures automatique)
With doc.Styles("Titre 4")
    .Font.Name = "Calibri"
    .Font.Size = 11
    .Font.Bold = True
    .Font.Italic = True
    .Font.Color = RGB(71, 85, 105)
    .ParagraphFormat.Alignment = 1 ' wdAlignParagraphCenter
    .ParagraphFormat.SpaceBefore = 4
    .ParagraphFormat.SpaceAfter = 14
    .ParagraphFormat.KeepWithNext = False
End With

' Titre 5 (Legende de Tableau pour Liste des Tableaux automatique)
With doc.Styles("Titre 5")
    .Font.Name = "Calibri"
    .Font.Size = 11
    .Font.Bold = True
    .Font.Italic = True
    .Font.Color = RGB(2, 132, 199)
    .ParagraphFormat.Alignment = 0 ' wdAlignParagraphLeft
    .ParagraphFormat.SpaceBefore = 14
    .ParagraphFormat.SpaceAfter = 4
    .ParagraphFormat.KeepWithNext = True
End With

' Normal (Corps de texte avec interligne 1.5 et taille 14 pt)
With doc.Styles("Normal")
    .Font.Name = "Calibri"
    .Font.Size = 14
    .ParagraphFormat.LineSpacingRule = 1 ' wdLineSpace1pt5
    .ParagraphFormat.Alignment = 3       ' wdAlignParagraphJustify
    .ParagraphFormat.SpaceAfter = 6
End With
On Error GoTo 0

WScript.Echo "6. Configuration du saut de section avant l'Introduction Generale..."
Set findRng = doc.Content
With findRng.Find
    .Text = "INTRODUCTION G"
    .Forward = True
    .Wrap = 0 ' wdFindStop
    If .Execute Then
        If findRng.Sections(1).Index = 1 Then
            findRng.Paragraphs(1).Range.InsertBreak 2 ' wdSectionBreakNextPage
            WScript.Echo "   -> Saut de section insere avec succes."
        Else
            WScript.Echo "   -> Saut de section deja present."
        End If
    End If
End With

WScript.Echo "7. Insertion des 3 Tables dynamiques Word (TOC, Figures, Tableaux)..."
For Each p In doc.Paragraphs
    ' 1. Table des Matières
    If InStr(p.Range.Text, "[WORD_TOC_PLACEHOLDER]") > 0 Then
        Set rng = p.Range
        p.Range.Text = ""
        doc.Fields.Add rng, -1, "TOC \o ""1-3"" \h \z \u"
        WScript.Echo "   -> Table des Matieres (TOC 1-3) inseree avec succes."
    End If
    ' 2. Liste des Figures automatique
    If InStr(p.Range.Text, "[WORD_TOF_PLACEHOLDER]") > 0 Then
        Set rng = p.Range
        p.Range.Text = ""
        doc.Fields.Add rng, -1, "TOC \o ""4-4"" \h \z \u"
        WScript.Echo "   -> Liste des Figures automatique (TOC 4-4) inseree avec succes."
    End If
    ' 3. Liste des Tableaux automatique
    If InStr(p.Range.Text, "[WORD_TOT_PLACEHOLDER]") > 0 Then
        Set rng = p.Range
        p.Range.Text = ""
        doc.Fields.Add rng, -1, "TOC \o ""5-5"" \h \z \u"
        WScript.Echo "   -> Liste des Tableaux automatique (TOC 5-5) inseree avec succes."
    End If
Next

WScript.Echo "8. Incorporation et centrage des 21 images (avec KeepWithNext)..."
imgCount = 0
For Each shape In doc.InlineShapes
    On Error Resume Next
    If Not shape.LinkFormat Is Nothing Then
        shape.LinkFormat.SavePictureWithDocument = True
        shape.LinkFormat.BreakLink
    End If
    shape.LockAspectRatio = -1 ' msoTrue
    If shape.Width > 420 Then
        shape.Width = 420
    End If
    shape.Range.ParagraphFormat.Alignment = 1 ' wdAlignParagraphCenter
    shape.Range.ParagraphFormat.SpaceBefore = 8
    shape.Range.ParagraphFormat.SpaceAfter = 4
    shape.Range.ParagraphFormat.KeepWithNext = True ' Empeche la figure d'etre separee de sa legende
    imgCount = imgCount + 1
    On Error GoTo 0
Next
WScript.Echo "   -> " & imgCount & " image(s) incorporee(s) et centree(s)."

WScript.Echo "9. Uniformisation de tous les tableaux (en-tete bleu / lignes zebrees)..."
tIndex = 0
For Each tbl In doc.Tables
    tIndex = tIndex + 1
    On Error Resume Next
    ' Ne pas appliquer au tableau de mise en page de la page de garde (Tableau 1)
    If tIndex > 1 Then
        tbl.Rows.Alignment = 1 ' wdAlignRowCenter
        tbl.AllowAutoFit = True
        tbl.AutoFitBehavior 2  ' wdAutoFitWindow
        
        ' Ligne d'en-tete
        tbl.Rows(1).HeadingFormat = True
        tbl.Rows(1).Range.Shading.BackgroundPatternColor = RGB(2, 132, 199)
        tbl.Rows(1).Range.Font.Color = RGB(255, 255, 255)
        tbl.Rows(1).Range.Font.Bold = True
        tbl.Rows(1).Range.Font.Size = 10.5
        
        ' Zebrage des lignes et taille de police
        For r = 2 To tbl.Rows.Count
            tbl.Rows(r).AllowBreakAcrossPages = False
            tbl.Rows(r).Range.Font.Size = 10
            If r Mod 2 = 0 Then
                tbl.Rows(r).Range.Shading.BackgroundPatternColor = RGB(248, 250, 252)
            Else
                tbl.Rows(r).Range.Shading.BackgroundPatternColor = RGB(255, 255, 255)
            End If
        Next
    End If
    On Error GoTo 0
Next
WScript.Echo "   -> " & (tIndex - 1) & " tableau(x) uniformise(s)."

WScript.Echo "10. Configuration des en-tetes et pieds de page (Sections 1 et 2)..."
If doc.Sections.Count >= 2 Then
    WScript.Echo "    -> Document en 2 sections detecte."
    
    ' Section 1 : Pages liminaires (Garde, Dedicaces, Remerciements, Resume, Sommaire, Listes)
    Set sec = doc.Sections(1)
    sec.PageSetup.DifferentFirstPageHeaderFooter = True
    sec.Headers(1).Range.Text = ""
    sec.Headers(2).Range.Text = ""
    sec.Footers(1).Range.Text = ""
    sec.Footers(2).Range.Text = ""
    
    ' Section 2 : Corps du rapport (Introduction Generale a Fin)
    Set sec = doc.Sections(2)
    sec.PageSetup.DifferentFirstPageHeaderFooter = False
    sec.Headers(1).LinkToPrevious = False
    sec.Footers(1).LinkToPrevious = False
    
    ' En-tete Section 2 : "EcoDrive | BTS IG" a gauche, Titre 1 dynamique a droite
    Set hdr = sec.Headers(1)
    hdr.Range.Text = "EcoDrive | BTS IG" & vbTab & vbTab
    Set rng = hdr.Range
    rng.Collapse 0
    doc.Fields.Add rng, -1, "STYLEREF ""Titre 1"""
    hdr.Range.Font.Name = "Calibri"
    hdr.Range.Font.Size = 9.5
    hdr.Range.Font.Italic = True
    hdr.Range.Font.Color = RGB(100, 116, 139)
    hdr.Range.Borders(-3).LineStyle = 1 ' wdBorderBottom
    hdr.Range.Borders(-3).LineWidth = 4 ' 0.5 pt
    hdr.Range.Borders(-3).Color = RGB(203, 213, 225)
    
    ' Pied de page Section 2 : Auteur a gauche, Page X / Y a droite
    Set ftr = sec.Footers(1)
    ftr.Range.Text = "Hayder BACCOURI - ISPRI (2024-2026)" & vbTab & vbTab & "Page "
    ftr.Range.Font.Name = "Calibri"
    ftr.Range.Font.Size = 9.5
    ftr.Range.Font.Color = RGB(100, 116, 139)
    ftr.Range.Borders(-1).LineStyle = 1 ' wdBorderTop
    ftr.Range.Borders(-1).LineWidth = 4 ' 0.5 pt
    ftr.Range.Borders(-1).Color = RGB(203, 213, 225)
    
    Set rng = ftr.Range
    rng.Collapse 0
    doc.Fields.Add rng, 33 ' wdFieldPage
    
    Set rng = ftr.Range
    rng.Collapse 0
    rng.Text = " / "
    
    Set rng = ftr.Range
    rng.Collapse 0
    doc.Fields.Add rng, 26 ' wdFieldNumPages
Else
    WScript.Echo "    -> Section unique : application du DifferentFirstPageHeaderFooter..."
    Set sec = doc.Sections(1)
    sec.PageSetup.DifferentFirstPageHeaderFooter = True
    
    Set hdr = sec.Headers(1)
    hdr.Range.Text = "EcoDrive | BTS IG" & vbTab & vbTab
    Set rng = hdr.Range
    rng.Collapse 0
    doc.Fields.Add rng, -1, "STYLEREF ""Titre 1"""
    hdr.Range.Font.Name = "Calibri"
    hdr.Range.Font.Size = 9.5
    hdr.Range.Font.Italic = True
    hdr.Range.Font.Color = RGB(100, 116, 139)
    hdr.Range.Borders(-3).LineStyle = 1
    hdr.Range.Borders(-3).LineWidth = 4
    hdr.Range.Borders(-3).Color = RGB(203, 213, 225)
    
    sec.Headers(2).Range.Text = ""
    
    Set ftr = sec.Footers(1)
    ftr.Range.Text = "Hayder BACCOURI - ISPRI (2024-2026)" & vbTab & vbTab & "Page "
    ftr.Range.Font.Name = "Calibri"
    ftr.Range.Font.Size = 9.5
    ftr.Range.Font.Color = RGB(100, 116, 139)
    ftr.Range.Borders(-1).LineStyle = 1
    ftr.Range.Borders(-1).LineWidth = 4
    ftr.Range.Borders(-1).Color = RGB(203, 213, 225)
    
    Set rng = ftr.Range
    rng.Collapse 0
    doc.Fields.Add rng, 33
    Set rng = ftr.Range
    rng.Collapse 0
    rng.Text = " / "
    Set rng = ftr.Range
    rng.Collapse 0
    doc.Fields.Add rng, 26
    
    sec.Footers(2).Range.Text = ""
End If

WScript.Echo "11. Mise a jour complete de tous les champs et tables (TOC, Figures, Tableaux)..."
doc.Fields.Update
For i = 1 To doc.TablesOfContents.Count
    doc.TablesOfContents(i).Update
Next

WScript.Echo "12. Sauvegarde au format DOCX..."
doc.SaveAs2 docxFile, 16
WScript.Echo "    -> DOCX genere : " & fso.GetFile(docxFile).Size & " octets"

WScript.Echo "13. Sauvegarde au format PDF..."
doc.SaveAs2 pdfFile, 17
WScript.Echo "    -> PDF genere : " & fso.GetFile(pdfFile).Size & " octets"

doc.Close False
wd.Quit

WScript.Echo "14. Copie vers l'emplacement final..."
fso.CopyFile docxFile, baseDir & "\Rapport_PFF_EcoDrive.docx", True
fso.CopyFile pdfFile,  baseDir & "\Rapport_PFF_EcoDrive.pdf",  True

WScript.Echo "15. Nettoyage..."
fso.DeleteFolder tempDir, True

WScript.Echo "SUCCES INTEGRAL !"
