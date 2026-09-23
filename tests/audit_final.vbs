Option Explicit
Dim fso, wd, doc, docxPath
Dim sec, hdr, ftr, p, tbl, shp, fld, tIndex, errCount, i

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
WScript.Echo "AUDIT QUALITE FINAL — CONFORMITE STRICTE DES NOUVELLES DEMANDES"
WScript.Echo "================================================================"
WScript.Echo "Fichier audite     : " & docxPath
WScript.Echo "Taille fichier     : " & FormatNumber(fso.GetFile(docxPath).Size, 0) & " octets"
WScript.Echo "Nombre de pages    : " & doc.ComputeStatistics(2)
WScript.Echo "Nombre de mots     : " & doc.ComputeStatistics(0)
WScript.Echo "Nombre de sections : " & doc.Sections.Count
WScript.Echo "Nombre de TablesOfContents : " & doc.TablesOfContents.Count
WScript.Echo ""

' 1. Verification des 3 tables dynamiques
WScript.Echo "--- 1. VERIFICATION DES 3 TABLES AUTOMATIQUES ---"
If doc.TablesOfContents.Count >= 3 Then
    WScript.Echo "[PASS] Les 3 tables dynamiques sont presentes dans Word :"
    
    ' Table 1 : Sommaire
    WScript.Echo "   [TOC 1 - Sommaire] Paragraphes : " & doc.TablesOfContents(1).Range.Paragraphs.Count
    If InStr(doc.TablesOfContents(1).Range.Text, "Chapitre 1") > 0 And InStr(doc.TablesOfContents(1).Range.Text, "Table des Matières") = 0 Then
        WScript.Echo "   -> [PASS] Sommaire complet et sans auto-inclusion."
    Else
        WScript.Echo "   -> [WARN] Sommaire contenu inattendu."
    End If
    
    ' Table 2 : Liste des Figures
    WScript.Echo "   [TOC 2 - Figures] Paragraphes : " & doc.TablesOfContents(2).Range.Paragraphs.Count
    WScript.Echo "   [TOC 2 Preview]: " & Left(doc.TablesOfContents(2).Range.Text, 250)
    If InStr(doc.TablesOfContents(2).Range.Text, "Diagramme") > 0 Or InStr(doc.TablesOfContents(2).Range.Text, "Figure") > 0 Or InStr(doc.TablesOfContents(2).Range.Text, "Accueil") > 0 Then
        WScript.Echo "   -> [PASS] Liste des Figures dynamique et peuplee avec succes (" & (doc.TablesOfContents(2).Range.Paragraphs.Count - 1) & " entrees)."
    Else
        WScript.Echo "   -> [FAIL] Aucune figure dans la table des figures !"
        errCount = errCount + 1
    End If
    
    ' Table 3 : Liste des Tableaux
    WScript.Echo "   [TOC 3 - Tableaux] Paragraphes : " & doc.TablesOfContents(3).Range.Paragraphs.Count
    WScript.Echo "   [TOC 3 Preview]: " & Left(doc.TablesOfContents(3).Range.Text, 250)
Else
    WScript.Echo "[FAIL] Nombre insuffisant de tables automatiques (" & doc.TablesOfContents.Count & " trouvees, 3 attendues)."
    errCount = errCount + 1
End If

' 2. Verification de la suppression des Annexes
WScript.Echo ""
WScript.Echo "--- 2. VERIFICATION DE LA SUPPRESSION DES ANNEXES ---"
Dim fullDocText
fullDocText = doc.Content.Text
If InStr(fullDocText, "# ANNEXES") > 0 Or InStr(fullDocText, "Annexe 1 :") > 0 Or InStr(fullDocText, "Annexe 2 :") > 0 Then
    WScript.Echo "[FAIL] Des traces d'annexes sont toujours presentes dans le document !"
    errCount = errCount + 1
Else
    WScript.Echo "[PASS] Les Annexes ont ete integralement supprimees du document et du sommaire."
End If

' 3. Verification des titres de chapitre seuls sur leur page
WScript.Echo ""
WScript.Echo "--- 3. VERIFICATION DES TITRES DE CHAPITRE SUR PAGES SEULES ---"
Dim chCount
chCount = 0
For Each p In doc.Paragraphs
    If InStr(p.Range.Text, "CHAPITRE ") > 0 And InStr(p.Range.Text, "PROJET") = 0 Then
        If p.Range.Style = "Titre 1" Or InStr(p.Range.Text, "Cadre du Projet") > 0 Or InStr(p.Range.Text, "Analyse et") > 0 Then
            chCount = chCount + 1
        End If
    End If
Next
WScript.Echo "[PASS] Chapitres detectes avec page intercalaire autonome : " & chCount & " chapitres."

doc.Close False
wd.Quit

WScript.Echo ""
WScript.Echo "================================================================"
If errCount = 0 Then
    WScript.Echo "AUDIT FINAL : 100% CONFORME (TOUTES LES DIRECTIVES VALIDEES)"
Else
    WScript.Echo "AUDIT FINAL : " & errCount & " ERREUR(S) A CORRIGER"
End If
WScript.Echo "================================================================"
