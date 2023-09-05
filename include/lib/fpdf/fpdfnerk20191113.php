<?php

//require_once "masterInclude.inc.php";
require_once 'fpdf.php';

class PDFNerk extends FPDF
{
	var $javascript;
	var $n_js;
	
	var $currentY = 0;
	var $lastOffset = 0;
	
	function setCurrentY($y = 5)
	{
		$this->currentY = $y;
	}
	
	function getCurrentY()
	{
		return $this->currentY;
	}
	
	function nextRow($offset = 0)
	{
		$this->currentY += 4 + $offset;
		$this->lastOffset = 4 + $offset;
	}
	
	function previousRow()
	{
		$this->currentY -= $this->lastOffset;
	}
	
	function putText($x, $texto)
	{
		$this->Text($x, $this->currentY, $texto);
	}
	
	function putTextRight($texto, $offsetRight = 0)
	{
		$this->Text($this->GetPageWidth() - $this->GetStringWidth($texto) - $offsetRight, $this->currentY, $texto);
	}
	
	function putTextCenter($texto, $offsetLeft = 0)
	{
		$this->Text($this->getCenterPage() -($this->GetStringWidth($texto) / 2) + $offsetLeft, $this->currentY, $texto);
	}
	
	function Circle($x, $y, $r, $style='D')
	{
		$this->Ellipse($x,$y,$r,$r,$style);
	}
	
	function Ellipse($x, $y, $rx, $ry, $style='D')
	{
		if($style=='F')
			$op='f';
			elseif($style=='FD' || $style=='DF')
			$op='B';
			else
				$op='S';
				$lx=4/3*(M_SQRT2-1)*$rx;
				$ly=4/3*(M_SQRT2-1)*$ry;
				$k=$this->k;
				$h=$this->h;
				$this->_out(sprintf('%.2F %.2F m %.2F %.2F %.2F %.2F %.2F %.2F c',
						($x+$rx)*$k,($h-$y)*$k,
						($x+$rx)*$k,($h-($y-$ly))*$k,
						($x+$lx)*$k,($h-($y-$ry))*$k,
						$x*$k,($h-($y-$ry))*$k));
				$this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c',
						($x-$lx)*$k,($h-($y-$ry))*$k,
						($x-$rx)*$k,($h-($y-$ly))*$k,
						($x-$rx)*$k,($h-$y)*$k));
				$this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c',
						($x-$rx)*$k,($h-($y+$ly))*$k,
						($x-$lx)*$k,($h-($y+$ry))*$k,
						$x*$k,($h-($y+$ry))*$k));
				$this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c %s',
						($x+$lx)*$k,($h-($y+$ry))*$k,
						($x+$rx)*$k,($h-($y+$ly))*$k,
						($x+$rx)*$k,($h-$y)*$k,
						$op));
	}
	
	function getCenterPage()
	{
		return $this->GetPageWidth() / 2;
	}
	
	// Rounded Rect
	
	function RoundedRect($x, $y, $w, $h, $r, $corners = '1234', $style = '')
	{
		$k = $this->k;
		$hp = $this->h;
		if($style=='F')
			$op='f';
			elseif($style=='FD' || $style=='DF')
			$op='B';
			else
				$op='S';
				$MyArc = 4/3 * (sqrt(2) - 1);
				$this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));
	
				$xc = $x+$w-$r;
				$yc = $y+$r;
				$this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));
				if (strpos($corners, '2')===false)
					$this->_out(sprintf('%.2F %.2F l', ($x+$w)*$k,($hp-$y)*$k ));
					else
						$this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
	
						$xc = $x+$w-$r;
						$yc = $y+$h-$r;
						$this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
						if (strpos($corners, '3')===false)
							$this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-($y+$h))*$k));
							else
								$this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
	
								$xc = $x+$r;
								$yc = $y+$h-$r;
								$this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
								if (strpos($corners, '4')===false)
									$this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-($y+$h))*$k));
									else
										$this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
	
										$xc = $x+$r ;
										$yc = $y+$r;
										$this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));
										if (strpos($corners, '1')===false)
										{
											$this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$y)*$k ));
											$this->_out(sprintf('%.2F %.2F l',($x+$r)*$k,($hp-$y)*$k ));
										}
										else
											$this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
											$this->_out($op);
	}
	
	function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
	{
		$h = $this->h;
		$this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
				$x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
	}
	
	// Fin Rounded Rect
	
	function Code39($xpos, $ypos, $code, $baseline=0.5, $height=5, $showCode = false, $center = false){
	
		$wide = $baseline;
		$narrow = $baseline / 3 ;
		$gap = $narrow;
		$xposi = $xpos;
	
		$barChar['0'] = 'nnnwwnwnn';
		$barChar['1'] = 'wnnwnnnnw';
		$barChar['2'] = 'nnwwnnnnw';
		$barChar['3'] = 'wnwwnnnnn';
		$barChar['4'] = 'nnnwwnnnw';
		$barChar['5'] = 'wnnwwnnnn';
		$barChar['6'] = 'nnwwwnnnn';
		$barChar['7'] = 'nnnwnnwnw';
		$barChar['8'] = 'wnnwnnwnn';
		$barChar['9'] = 'nnwwnnwnn';
		$barChar['A'] = 'wnnnnwnnw';
		$barChar['B'] = 'nnwnnwnnw';
		$barChar['C'] = 'wnwnnwnnn';
		$barChar['D'] = 'nnnnwwnnw';
		$barChar['E'] = 'wnnnwwnnn';
		$barChar['F'] = 'nnwnwwnnn';
		$barChar['G'] = 'nnnnnwwnw';
		$barChar['H'] = 'wnnnnwwnn';
		$barChar['I'] = 'nnwnnwwnn';
		$barChar['J'] = 'nnnnwwwnn';
		$barChar['K'] = 'wnnnnnnww';
		$barChar['L'] = 'nnwnnnnww';
		$barChar['M'] = 'wnwnnnnwn';
		$barChar['N'] = 'nnnnwnnww';
		$barChar['O'] = 'wnnnwnnwn';
		$barChar['P'] = 'nnwnwnnwn';
		$barChar['Q'] = 'nnnnnnwww';
		$barChar['R'] = 'wnnnnnwwn';
		$barChar['S'] = 'nnwnnnwwn';
		$barChar['T'] = 'nnnnwnwwn';
		$barChar['U'] = 'wwnnnnnnw';
		$barChar['V'] = 'nwwnnnnnw';
		$barChar['W'] = 'wwwnnnnnn';
		$barChar['X'] = 'nwnnwnnnw';
		$barChar['Y'] = 'wwnnwnnnn';
		$barChar['Z'] = 'nwwnwnnnn';
		$barChar['-'] = 'nwnnnnwnw';
		$barChar['.'] = 'wwnnnnwnn';
		$barChar[' '] = 'nwwnnnwnn';
		$barChar['*'] = 'nwnnwnwnn';
		$barChar['$'] = 'nwnwnwnnn';
		$barChar['/'] = 'nwnwnnnwn';
		$barChar['+'] = 'nwnnnwnwn';
		$barChar['%'] = 'nnnwnwnwn';
		
		$this->SetFont('Arial','',10);
		if ($showCode)
		{
			$this->Text($xpos, $ypos + $height + 4, $code);
		}
		
		$code = '*'.strtoupper($code).'*';
		
		if ($center)
		{
			$xposInicialToCenter = 0;
			for($i=0; $i<strlen($code); $i++){
				$char = $code[$i];
				if(!isset($barChar[$char])){
					$this->Error('Invalid character in barcode: '.$char);
				}
				$seq = $barChar[$char];
				for($bar=0; $bar<9; $bar++){
					if($seq[$bar] == 'n'){
						$lineWidth = $narrow;
					}else{
						$lineWidth = $wide;
					}
					
					$xposInicialToCenter += $lineWidth;
				}
				$xposInicialToCenter += $gap;
			}
			
			$xpos = $this->getCenterPage() - ($xposInicialToCenter/2);
		}
	
		
		
		$this->SetFillColor(0);
	
		
		for($i=0; $i<strlen($code); $i++){
			$char = $code[$i];
			if(!isset($barChar[$char])){
				$this->Error('Invalid character in barcode: '.$char);
			}
			$seq = $barChar[$char];
			for($bar=0; $bar<9; $bar++){
				if($seq[$bar] == 'n'){
					$lineWidth = $narrow;
				}else{
					$lineWidth = $wide;
				}
				if($bar % 2 == 0){
					$this->Rect($xpos, $ypos, $lineWidth, $height, 'F');
				}
				$xpos += $lineWidth;
			}
			$xpos += $gap;
		}
		
		if ($showCode)
		{
			$this->Text($xposi, $ypos + $height + 8, "xi: " . $xposi . " xf: " . $xpos);
			$this->Text($xposi, $ypos + $height + 12, $this->GetPageWidth());
		}
	}
	
	function IncludeJS($script) {
		$this->javascript=$script;
	}
	
	function _putjavascript() {
		$this->_newobj();
		$this->n_js=$this->n;
		$this->_out('<<');
		$this->_out('/Names [(EmbeddedJS) '.($this->n+1).' 0 R]');
		$this->_out('>>');
		$this->_out('endobj');
		$this->_newobj();
		$this->_out('<<');
		$this->_out('/S /JavaScript');
		$this->_out('/JS '.$this->_textstring($this->javascript));
		$this->_out('>>');
		$this->_out('endobj');
	}
	
	function _putresources() {
		parent::_putresources();
		if (!empty($this->javascript)) {
			$this->_putjavascript();
		}
	}
	
	function _putcatalog() {
		parent::_putcatalog();
		if (!empty($this->javascript)) {
			$this->_out('/Names <</JavaScript '.($this->n_js).' 0 R>>');
		}
	}

	function AutoPrint($dialog=false)
	{
		//Open the print dialog or start printing immediately on the standard printer
		$param=($dialog ? 'true' : 'false');
		$script="print($param);";		
		$this->IncludeJS($script);
	}

	function AutoPrintToPrinter($server, $printer, $dialog=false)
	{
		//Print on a shared printer (requires at least Acrobat 6)
		//$script = "var pp = getPrintParams();";
		$script = "";
		if($dialog)
			$script .= "pp.interactive = pp.constants.interactionLevel.full;";
			else
				$script .= "pp.interactive = pp.constants.interactionLevel.automatic;";
				$script .= "pp.printerName = '\\\\\\\\".$server."\\\\".$printer."';";
				$script .= "print(pp);";
				$this->IncludeJS($script);
	}
}

