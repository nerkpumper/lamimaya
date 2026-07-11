<?php

if (PHP_SAPI == 'cli')
	die('Este archivo solo se puede ver desde un navegador web');

class XlsxGen
{
	private array $sharedStrings = [];
	private array $styles = [];
	private int $sharedIndex = 0;
	private array $rows = [];
	private array $merges = [];
	private array $colWidths = [];
	private array $rowHeights = [];
	private ?array $image = null;
	private string $sheetTitle = 'Sheet';
	private string $orientation = 'landscape';
	private string $paperSize = 'A4';

	public function addSharedString(string $s): int
	{
		$idx = array_search($s, $this->sharedStrings, true);
		if ($idx === false) {
			$idx = $this->sharedIndex++;
			$this->sharedStrings[$idx] = $s;
		}
		return $idx;
	}

	public function addStyle(array $style): int
	{
		$this->styles[] = $style;
		return count($this->styles) - 1;
	}

	public function setCellValue(string $cell, $value, ?int $styleIdx = null): void
	{
		$col = preg_replace('/[0-9]/', '', $cell);
		$row = (int)preg_replace('/[A-Z]/', '', $cell);
		$isNumeric = is_numeric($value);
		$isString = !$isNumeric;
		if ($isString) {
			$si = $this->addSharedString((string)$value);
			$this->rows[$row][$col] = ['t' => 's', 'v' => $si, 's' => $styleIdx];
		} else {
			$this->rows[$row][$col] = ['t' => 'n', 'v' => $value, 's' => $styleIdx];
		}
	}

	public function setCellValueByColumnAndRow(int $col, int $row, $value, ?int $styleIdx = null): void
	{
		$letter = $this->colFromIndex($col);
		$this->setCellValue($letter . $row, $value, $styleIdx);
	}

	public function setCellFormula(string $cell, string $formula, ?int $styleIdx = null): void
	{
		$col = preg_replace('/[0-9]/', '', $cell);
		$row = (int)preg_replace('/[A-Z]/', '', $cell);
		$this->rows[$row][$col] = ['t' => 'f', 'v' => $formula, 's' => $styleIdx];
	}

	public function mergeCells(string $range): void
	{
		$this->merges[] = $range;
	}

	public function setColumnWidth(string $col, float $w): void
	{
		$this->colWidths[$col] = $w;
	}

	public function setRowHeight(int $row, float $h): void
	{
		$this->rowHeights[$row] = $h;
	}

	public function setImage(string $path, string $coords, int $offsetX = 5, int $offsetY = 5, int $width = 380, int $height = 90): void
	{
		if (!file_exists($path)) return;
		$this->image = [
			'path' => $path,
			'coords' => $coords,
			'offsetX' => $offsetX,
			'offsetY' => $offsetY,
			'width' => $width,
			'height' => $height,
		];
	}

	public function setSheetTitle(string $t): void { $this->sheetTitle = $t; }
	public function setOrientation(string $o): void { $this->orientation = $o; }
	public function setPaperSize(string $s): void { $this->paperSize = $s; }

	private function colToIndex(string $col): int
	{
		$idx = 0;
		for ($i = 0; $i < strlen($col); $i++)
			$idx = $idx * 26 + (ord($col[$i]) - 64);
		return $idx - 1;
	}

	private function colFromIndex(int $idx): string
	{
		$c = '';
		while ($idx >= 0) {
			$c = chr($idx % 26 + 65) . $c;
			$idx = intdiv($idx, 26) - 1;
		}
		return $c;
	}

	private function xl(string $s): string { return htmlspecialchars($s, ENT_XML1, 'UTF-8'); }

	public function save(string $outputPath): bool
	{
		if (!extension_loaded('zip')) {
			trigger_error('Zip extension required', E_USER_ERROR);
			return false;
		}
		$zip = new ZipArchive();
		if ($zip->open($outputPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true)
			return false;

		$ssXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<sst xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" count="' . count($this->sharedStrings) . '" uniqueCount="' . count($this->sharedStrings) . '">';
		foreach ($this->sharedStrings as $s)
			$ssXml .= '<si><t>' . $this->xl($s) . '</t></si>';
		$ssXml .= '</sst>';
		$zip->addFromString('xl/sharedStrings.xml', $ssXml);

		$numFmts = '';
		$fonts = '<fonts count="' . max(1, count($this->styles)) . '"><font><sz val="11"/><name val="Calibri"/></font>';
		$fills = '<fills count="2"><fill><patternFill patternType="none"/></fill><fill><patternFill patternType="gray125"/></fill>';
		$borders = '<borders count="1"><border><left/><right/><top/><bottom/><diagonal/></border>';
		$cellStyleXfs = '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>';
		$cellXfs = '<cellXfs count="' . (count($this->styles) + 1) . '"><xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/>';

		foreach ($this->styles as $st) {
			$fontId = 0;
			$fillId = 0;
			$borderId = 0;
			$numFmtId = 0;
			$applyFont = '';
			$applyFill = '';
			$applyBorder = '';
			$applyAlign = '';

			if (isset($st['font'])) {
				$fontId = count($this->styles) + 1;
				$applyFont = ' applyFont="1"';
				$f = $st['font'];
				$fonts .= '<font>';
				if (!empty($f['bold'])) $fonts .= '<b/>';
				if (isset($f['size'])) $fonts .= '<sz val="' . $f['size'] . '"/>';
				if (!empty($f['name'])) $fonts .= '<name val="' . $this->xl($f['name']) . '"/>';
				if (isset($f['color']['rgb'])) {
					$c = $f['color']['rgb'];
					if (strlen($c) == 6) $c = '00' . $c;
					$fonts .= '<color rgb="' . $c . '"/>';
				}
				$fonts .= '</font>';
			}
			if (isset($st['fill'])) {
				$fillId = count($this->styles) + 1;
				$applyFill = ' applyFill="1"';
				$f = $st['fill'];
				$fills .= '<fill><patternFill patternType="solid"><fgColor rgb="' . (isset($f['rgb']) ? $f['rgb'] : '00000000') . '"/></patternFill></fill>';
			}
			if (isset($st['border'])) {
				$borderId = count($this->styles) + 1;
				$applyBorder = ' applyBorder="1"';
				$b = $st['border'];
				$borders .= '<border>';
				foreach (['left', 'right', 'top', 'bottom'] as $side) {
					if (isset($b[$side])) {
						$borders .= '<' . $side . ' style="' . $b[$side] . '"><color auto="1"/></' . $side . '>';
					} else {
						$borders .= '<' . $side . '/>';
					}
				}
				$borders .= '<diagonal/></border>';
			}
			$alignStr = '';
			if (isset($st['alignment'])) {
				$applyAlign = ' applyAlignment="1"';
				$a = $st['alignment'];
				$alignStr .= '<alignment';
				if (!empty($a['horizontal'])) $alignStr .= ' horizontal="' . $a['horizontal'] . '"';
				if (!empty($a['vertical'])) $alignStr .= ' vertical="' . $a['vertical'] . '"';
				if (!empty($a['wrap'])) $alignStr .= ' wrapText="1"';
				$alignStr .= '/>';
			}
			$cellXfs .= '<xf numFmtId="' . $numFmtId . '" fontId="' . $fontId . '" fillId="' . $fillId . '" borderId="' . $borderId . '" xfId="0"' . $applyFont . $applyFill . $applyBorder . $applyAlign . '>' . $alignStr . '</xf>';
		}
		$fonts .= '</fonts>';
		$fills .= '</fills>';
		$borders .= '</borders>';
		$cellXfs .= '</cellXfs>';

		$stylesXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
			. $numFmts . $fonts . $fills . $borders . $cellStyleXfs . $cellXfs .
			'</styleSheet>';
		$zip->addFromString('xl/styles.xml', $stylesXml);

		$ws = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"
           xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
<sheetPr><pageSetUpPr fitToPage="0"/></sheetPr>';
		if (!empty($this->colWidths)) {
			$ws .= '<cols>';
			foreach ($this->colWidths as $col => $w)
				$ws .= '<col min="' . ($this->colToIndex($col) + 1) . '" max="' . ($this->colToIndex($col) + 1) . '" width="' . $w . '" customWidth="1"/>';
			$ws .= '</cols>';
		}
		$ws .= '<sheetData>';
		ksort($this->rows);
		foreach ($this->rows as $rNum => $cols) {
			$ws .= '<row r="' . $rNum . '"' . (isset($this->rowHeights[$rNum]) ? ' ht="' . $this->rowHeights[$rNum] . '" customHeight="1"' : '') . '>';
			ksort($cols);
			foreach ($cols as $col => $cell) {
				$ref = $col . $rNum;
				$s = $cell['s'] !== null ? ($cell['s'] + 1) : 0;
				if ($cell['t'] === 'f') {
					$ws .= '<c r="' . $ref . '"' . ($s > 0 ? ' s="' . $s . '"' : '') . '><f>' . $this->xl((string)$cell['v']) . '</f><v></v></c>';
				} else {
					$t = $cell['t'];
					$v = $cell['v'];
					$ws .= '<c r="' . $ref . '" t="' . $t . '"' . ($s > 0 ? ' s="' . $s . '"' : '') . '><v>' . $this->xl((string)$v) . '</v></c>';
				}
			}
			$ws .= '</row>';
		}
		$ws .= '</sheetData>';

		if (!empty($this->merges)) {
			$ws .= '<mergeCells count="' . count($this->merges) . '">';
			foreach ($this->merges as $m) $ws .= '<mergeCell ref="' . $m . '"/>';
			$ws .= '</mergeCells>';
		}

		$imageRId = 0;
		if ($this->image) {
			$imageRId = 1;
			$ws .= '<drawing r:id="rIdImg1"/>';
		}

		$pageSetup = '';
		if ($this->orientation === 'landscape' || $this->paperSize === 'A4') {
			$ori = $this->orientation === 'landscape' ? 'landscape' : 'portrait';
			$size = $this->paperSize === 'A4' ? '9' : '1';
			$pageSetup = '<pageSetup orientation="' . $ori . '" paperSize="' . $size . '"/>';
		}
		$ws .= $pageSetup . '</worksheet>';
		$zip->addFromString('xl/worksheets/sheet1.xml', $ws);

		$wb = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"
          xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
<sheets><sheet name="' . $this->xl($this->sheetTitle) . '" sheetId="1" r:id="rId1"/></sheets></workbook>';
		$zip->addFromString('xl/workbook.xml', $wb);

		$rels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>
<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/package/2006/relationships/metadata/core-properties" Target="docProps/core.xml"/>
<Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/extended-properties" Target="docProps/app.xml"/>
</Relationships>';
		$zip->addFromString('_rels/.rels', $rels);

		$wbRels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>
<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/sharedStrings" Target="sharedStrings.xml"/>
<Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>';
		if ($imageRId) {
			$wbRels .= '<Relationship Id="rIdImg1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/drawing" Target="drawings/drawing1.xml"/>';
		}
		$wbRels .= '</Relationships>';
		$zip->addFromString('xl/_rels/workbook.xml.rels', $wbRels);

		$ct = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
<Default Extension="xml" ContentType="application/xml"/>
<Default Extension="jpeg" ContentType="image/jpeg"/>
<Default Extension="png" ContentType="image/png"/>
<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>
<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>
<Override PartName="/xl/sharedStrings.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sharedStrings+xml"/>
<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>';
		if ($imageRId) {
			$ct .= '<Override PartName="/xl/drawings/drawing1.xml" ContentType="application/vnd.openxmlformats-officedocument.drawing+xml"/>';
		}
		$ct .= '</Types>';
		$zip->addFromString('[Content_Types].xml', $ct);

		if ($this->image && $imageRId) {
			$imgCol = preg_replace('/[0-9]/', '', $this->image['coords']);
			$imgRow = (int)preg_replace('/[A-Z]/', '', $this->image['coords']);
			$colIdx = $this->colToIndex($imgCol);
			$rowIdx = $imgRow - 1;

			$drawingXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<xdr:wsDr xmlns:xdr="http://schemas.openxmlformats.org/drawingml/2006/spreadsheetDrawing"
          xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main"
          xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
  <xdr:twoCellAnchor>
    <xdr:from><xdr:col>' . $colIdx . '</xdr:col><xdr:colOff>' . ($this->image['offsetX'] * 914400 / 96) . '</xdr:colOff><xdr:row>' . $rowIdx . '</xdr:row><xdr:rowOff>' . ($this->image['offsetY'] * 914400 / 96) . '</xdr:rowOff></xdr:from>
    <xdr:to><xdr:col>' . ($colIdx + 3) . '</xdr:col><xdr:colOff>0</xdr:colOff><xdr:row>' . ($rowIdx + 4) . '</xdr:row><xdr:rowOff>0</xdr:rowOff></xdr:to>
    <xdr:pic>
      <xdr:nvPicPr>
        <xdr:cNvPr id="2" name="Logo"/>
        <xdr:cNvPicPr/>
      </xdr:nvPicPr>
      <xdr:blipFill>
        <a:blip r:embed="rId1"/>
        <a:stretch><a:fillRect/></a:stretch>
      </xdr:blipFill>
      <xdr:spPr>
        <a:xfrm><a:off x="0" y="0"/><a:ext cx="' . ($this->image['width'] * 914400 / 96) . '" cy="' . ($this->image['height'] * 914400 / 96) . '"/></a:xfrm>
        <a:prstGeom prst="rect"><a:avLst/></a:prstGeom>
      </xdr:spPr>
    </xdr:pic>
    <xdr:clientData/>
  </xdr:twoCellAnchor>
</xdr:wsDr>';
			$zip->addFromString('xl/drawings/drawing1.xml', $drawingXml);

			$drawRels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="../media/image1' . (str_ends_with(strtolower($this->image['path']), '.png') ? '.png' : '.jpeg') . '"/>
</Relationships>';
			$zip->addFromString('xl/drawings/_rels/drawing1.xml.rels', $drawRels);

			$ext = strtolower(pathinfo($this->image['path'], PATHINFO_EXTENSION));
			$mediaName = ($ext === 'png') ? 'image1.png' : 'image1.jpeg';
			$zip->addFile($this->image['path'], 'xl/media/' . $mediaName);
		}

		$core = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<cp:coreProperties xmlns:cp="http://schemas.openxmlformats.org/package/2006/metadata/core-properties"
                   xmlns:dc="http://purl.org/dc/elements/1.1/"
                   xmlns:dcterms="http://purl.org/dc/terms/"
                   xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
<dc:creator>Galvamex App</dc:creator>
<cp:lastModifiedBy>Galvamex App</cp:lastModifiedBy>
</cp:coreProperties>';
		$zip->addFromString('docProps/core.xml', $core);

		$app = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Properties xmlns="http://schemas.openxmlformats.org/officeDocument/2006/extended-properties"
            xmlns:vt="http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes">
<Application>Galvamex App</Application>
</Properties>';
		$zip->addFromString('docProps/app.xml', $app);

		$zip->close();
		return true;
	}
}
