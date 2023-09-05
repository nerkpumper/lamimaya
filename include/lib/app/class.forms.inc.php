<?php

class Form
{	
	private static $defaultColsGroup = "l8|m8|s12|x12";
	private static $defaultColsLabel = "l2|m2|s12|x12";
	private static $defaultColsInput = "l8|m8|s12|x12";
	private static $defaultAlignText = "text-left";
	
	private static $ColsGroup = "";
	private static $ColsLabel = "";
	private static $ColsInput = "";
	
	private static $alignText = "text-left";
	private static $alignLabel = "text-left";
	
	private static $margin = "";
	
	public static function setMargin ($margin)
	{
		self::$margin = $margin;
	}
	
	public static function noMargin()
	{
		self::$margin = "";
	}
	
	public static function line($classCols="l12|m12|s12|x12")
	{
		$cols = self::getClassCols($classCols);
		
		echo "<div class='".$cols."'><div class='hr-line-dashed'></div></div>";
		
	}
	
	
	public static function alignTextDefault()
	{
		self::$alignText = "text-left";
	}
	
	public static function alignTextRight()
	{
		self::$alignText = "text-right";
	}
	
	public static function alignTextCenter()
	{
		self::$alignText = "text-center";
	}
	
	public static function alignTextLeft()
	{
		self::$alignText = "text-left";
	}
	
	public static function alignLabelDefault()
	{
		self::$alignLabel = "text-left";
	}
	
	public static function alignLabelRight()
	{
		self::$alignLabel = "text-right";
	}
	
	public static function alignLabelCenter()
	{
		self::$alignLabel = "text-center";
	}
	
	public static function alignLabelLeft()
	{
		self::$alignLabel = "text-left";
	}
	
	public static function setCols ($colsGroup, $colsLabel, $colsInput)
	{
		self::$ColsGroup = $colsGroup;
		self::$ColsLabel = $colsLabel;
		self::$ColsInput = $colsInput;
	}
	
	public static function setColsGroup ($colsGroup)
	{
		self::$ColsGroup = $colsGroup;
	}
	
	public static function setColsLabel ($colsLabel)
	{		
		self::$ColsLabel = $colsLabel;
	}
	
	public static function setColsInput ($colsInput)
	{
		self::$ColsInput = $colsInput;
	}
	
	public static function setColsDefault ()
	{
		self::$ColsGroup = "";
		self::$ColsLabel = "";
		self::$ColsInput = "";
	}
	
	public static function setColsGroupDefault ()
	{
		self::$ColsGroup = "";
	}
	
	public static function setColsLabelDefault ()
	{
		self::$ColsLabel = "";
	}
	
	public static function setColsInputDefault ()
	{
		self::$ColsInput = "";
	}
	
	public static function row()
	{
		echo "<div class='row'>";
	}
	
	public static function endRow()
	{
		echo "</div>";
	}
	
	public static function colnbsp($classCols="l12|m12|s12|x12")
	{
		$cols = self::getClassCols($classCols);
		
		echo "<div class='".$cols."'>&nbsp;</div>";
	}
	
	public static function col($classCols="l12|m12|s12|x12")
	{
		$cols = self::getClassCols($classCols);
		
		echo "<div class='".$cols."'>";
	}
	
	public static function endCol()
	{
		echo "</div>";
	}
	
	public static function btnExportarExcel($functionName, $align = "pull-right")
	{
		//<button @click.prevent="sendToExcel" class="btn btn-outline btn-primary dim pull-right" type="button"><i class="fa fa-file-excel-o"></i> Exportar</button>
		echo "<button @click.prevent='".$functionName."' class='btn btn-outline btn-primary dim ".$align."' type='button'><i class='fa fa-file-excel-o'></i> Exportar</button>";
	}
	
	public static function frmExportarExcel()
	{
		echo "<form action='".URL_BASE."reporteadorbytabla' method='post' target='_blank' id='FormularioExportacion'>";
		echo "  <input type='hidden' id='ptituloReporte' name='ptituloReporte' />";
		echo "  <input type='hidden' id='psubTituloReporte' name='psubTituloReporte'/>";
		echo "  <input type='hidden' id='pexcluir' name='pexcluir'/>";
		echo "  <input type='hidden' id='pnombreReporte' name='pnombreReporte'/>";
		echo "  <input type='hidden' id='pformulaTotales' name='pformulaTotales'/>";
		
		
		echo "  <input type='hidden' id='pTableHeader' name='pTableHeader' />";
		echo "  <input type='hidden' id='pTableBody' name='pTableBody' />";
		echo "</form>";
	}
	
	
	public static function open($id, array $options = [])
	{
		$html = "";
		
		$method = self::array_get($options, 'method', 'post');
		
		$html .= "<form id='" . $id . "' method='" . $method . "' class='form-horizontal'><fieldset>";
		
		echo $html;
	}
	
	public static function close()
	{
		$html = "";
		
		$html .= "</fieldset></form>";
		
		echo $html;
	}
	
	public static function check($id, $label = "",  $vif = "")
	{
		$html = "";
	
		if (self::$ColsGroup == "")
		{
			self::$ColsGroup = self::$defaultColsGroup;
		}
	
		if (self::$ColsLabel == "")
		{
			self::$ColsLabel = self::$defaultColsLabel;
		}
	
		if (self::$ColsInput == "")
		{
			self::$ColsInput = self::$defaultColsInput;
		}
	
		
	
		$classGroup = self::getClassCols(self::$ColsGroup);
		$classLabel = self::getClassCols(self::$ColsLabel);
		$classInput = self::getClassCols(self::$ColsInput);
	
		$html .= "<div class='" . $classGroup . "' " . ($vif != "" ? "v-if='" . $vif . "'" : "") . " >";
		$html .= "  <div class='form-group' v-bind:class=\"{'has-error': err" . ucfirst($id) . "}\">";
		$html .= "    <label class='" . $classLabel . " control-label' >" . $label . "</label>";
		$html .= "    <div class='" . $classInput . "'>";
		//$html .= "      <div class='i-checks'><label> <input v-model='".$id."' id='".$id."' type='checkbox' value='' > <i></i> ". $label ." </label></div>";
		$html .= "         <input class='icheckbox_square-green' type='checkbox' id='".$id."' v-model='".$id."'> ";
		$html .= "      <span v-if='err" . ucfirst($id) . "' class='help-block'>";
		$html .= "        <strong>{{ err" . ucfirst($id) . " }}</strong>";
		$html .= "      </span>";
		$html .= "    </div>";
		$html .= "  </div>";
		$html .= "</div>";
	
		echo $html;
	}
	
	public static function select($id, $label, $opciones, $claveCero = "", $seleccione = "", $hidden = false, $disabled = false, $vif = '')
	{
		$html = "";
		
		if (self::$ColsGroup == "")
		{
			self::$ColsGroup = self::$defaultColsGroup;
		}
		
		if (self::$ColsLabel == "")
		{
			self::$ColsLabel = self::$defaultColsLabel;
		}
		
		if (self::$ColsInput == "")
		{
			self::$ColsInput = self::$defaultColsInput;
		}
		
		if (trim($seleccione) == "")
		{
			$seleccione = "Seleccione una opci&oacute;n";
		}
	
		$classGroup = self::getClassCols(self::$ColsGroup);
		$classLabel = self::getClassCols(self::$ColsLabel);
		$classInput = self::getClassCols(self::$ColsInput);
	
		$html .= "<div class='" . $classGroup . " ".self::$margin."' " . ($vif != "" ? "v-if='" . $vif . "'" : "") . " "  . ($hidden ? "style='display: none;'" : "") . " >";
		$html .= "  <div class='form-group' v-bind:class=\"{'has-error': err" . ucfirst($id) . "}\">";
		$html .= "    <label class='" . $classLabel . " control-label' >" . $label . "</label>";
		$html .= "    <div class='" . $classInput . "'>";
		$html .= "      <select v-model='" . $id . "' id='" . $id . "' name='" . $id . "' ref='" . $id . "' class='form-control' " . ($disabled ? "disabled='disabled'" : "") . ">";
		$html .= "        <option value='" . ($claveCero != "" ? $claveCero : "0")  . "'>-- " . $seleccione  . " --</option>";
			
		foreach ($opciones as $opcion)
		{
			$html .= "<option value='" . $opcion["value"] . "'>". $opcion["theoption"] ."</option>";
		}
			
		$html .= "      </select>";		
		$html .= "      <span v-if='err" . ucfirst($id) . "' class='help-block'>";
		$html .= "        <strong>{{ err" . ucfirst($id) . " }}</strong>";
		$html .= "      </span>";
		$html .= "    </div>";
		$html .= "  </div>";
		$html .= "</div>";
	
		echo $html;
	}
	
	public static function selectNOTCERO($id, $label, $opciones,  $hidden = false, $disabled = false, $vif = '')
	{
		$html = "";
	
		if (self::$ColsGroup == "")
		{
			self::$ColsGroup = self::$defaultColsGroup;
		}
	
		if (self::$ColsLabel == "")
		{
			self::$ColsLabel = self::$defaultColsLabel;
		}
	
		if (self::$ColsInput == "")
		{
			self::$ColsInput = self::$defaultColsInput;
		}
	
		
	
		$classGroup = self::getClassCols(self::$ColsGroup);
		$classLabel = self::getClassCols(self::$ColsLabel);
		$classInput = self::getClassCols(self::$ColsInput);
	
		$html .= "<div class='" . $classGroup . " ".self::$margin."' " . ($vif != "" ? "v-if='" . $vif . "'" : "") . " "  . ($hidden ? "style='display: none;'" : "") . " >";
		$html .= "  <div class='form-group' v-bind:class=\"{'has-error': err" . ucfirst($id) . "}\">";
		$html .= "    <label class='" . $classLabel . " control-label' >" . $label . "</label>";
		$html .= "    <div class='" . $classInput . "'>";
		$html .= "      <select v-model='" . $id . "' id='" . $id . "' name='" . $id . "' ref='" . $id . "' class='form-control' " . ($disabled ? "disabled='disabled'" : "") . ">";
// 			$html .= "        <option value='" . ($claveCero != "" ? $claveCero : "0")  . "'>-- " . $seleccione  . " --</option>";
			
		foreach ($opciones as $opcion)
		{
			$html .= "<option value='" . $opcion["value"] . "'>". $opcion["theoption"] ."</option>";
		}
			
		$html .= "      </select>";
		$html .= "      <span v-if='err" . ucfirst($id) . "' class='help-block'>";
		$html .= "        <strong>{{ err" . ucfirst($id) . " }}</strong>";
		$html .= "      </span>";
		$html .= "    </div>";
		$html .= "  </div>";
		$html .= "</div>";
	
		echo $html;
	}
	
	public static function label($id, $label = "", $emphasis = "", $withError = false, $withSuccess = false)
	{
		$html = "";
		//$html .= self::$ColsGroup;
	
		if (self::$ColsGroup == "")
		{
			self::$ColsGroup = self::$defaultColsGroup;
		}
	
		if (self::$ColsLabel == "")
		{
			self::$ColsLabel = self::$defaultColsLabel;
		}
	
		if (self::$ColsInput == "")
		{
			self::$ColsInput = self::$defaultColsInput;
		}
	
		$classGroup = self::getClassCols(self::$ColsGroup);
		$classLabel = self::getClassCols(self::$ColsLabel);
		$classInput = self::getClassCols(self::$ColsInput);
	
		$html .= "<div class='" . $classGroup . " ".self::$margin."'>";
		$html .= "  <div class='form-group' " . ($withError && $withSuccess ? "v-bind:class=\"{'has-error': err" . ucfirst($id) . ", 'has-success': suc" . ucfirst($id) . "}\"" : ($withError ? "v-bind:class=\"{'has-error': err" . ucfirst($id) . "}\"" : ($withSuccess ? "v-bind:class=\"{'has-success': suc" . ucfirst($id) . "}\"" : "") )) . " >";
		$html .= "    <label class='" . $classLabel . " control-label " . self::$alignLabel . "' >" . $label . "</label>";
		$html .= "    <div class='" . $classInput . " " . $emphasis . "'>";
					
		$html .= "      {{" . $id . "}}";
		
		if ($withError || $withSuccess)
		{
			$html .= "      <span " . ($withError && $withSuccess ? " v-if='err" . ucfirst($id) . " || suc" . ucfirst($id) . "'" : ($withError ? " v-if='err" . ucfirst($id) . "'" : ($withSuccess ? " v-if='suc" . ucfirst($id) . "'" : "")) ) . " class='help-block'>";
			$html .= "        <strong> " . ($withError && $withSuccess ? "{{ err" . ucfirst($id) . " }}{{ suc" . ucfirst($id) . " }}" : ($withError ? "{{ err" . ucfirst($id) . " }}" : ($withSuccess ? "{{ suc" . ucfirst($id) . " }}" : "") ) ) . "</strong>";
			$html .= "      </span>";
		}
		
		$html .= "    </div>";
		$html .= "  </div>";
		$html .= "</div>";
		
			
	
		echo $html;
	}
	
	public static function labelH($type, $id, $label = "", $emphasis = "",  $withError = false, $withSuccess = false, $hidden = false, $htmlAdicional = "")
	{
		$html = "";
		//$html .= self::$ColsGroup;
	
		if (self::$ColsGroup == "")
		{
			self::$ColsGroup = self::$defaultColsGroup;
		}
	
		if (self::$ColsLabel == "")
		{
			self::$ColsLabel = self::$defaultColsLabel;
		}
	
		if (self::$ColsInput == "")
		{
			self::$ColsInput = self::$defaultColsInput;
		}
	
		$classGroup = self::getClassCols(self::$ColsGroup);
		$classLabel = self::getClassCols(self::$ColsLabel);
		$classInput = self::getClassCols(self::$ColsInput);
	
		$html .= "<div class='" . $classGroup . "' " . ($hidden ? "style='display: none;'" : "") . ">";
		//$html .= "  <div class='form-group' v-bind:class=\"{'has-error': err" . ucfirst($id) . ", 'has-success': suc" . ucfirst($id) . "}\">";
		$html .= "  <div class='form-group' " . ($withError && $withSuccess ? "v-bind:class=\"{'has-error': err" . ucfirst($id) . ", 'has-success': suc" . ucfirst($id) . "}\"" : ($withError ? "v-bind:class=\"{'has-error': err" . ucfirst($id) . "}\"" : ($withSuccess ? "v-bind:class=\"{'has-success': suc" . ucfirst($id) . "}\"" : "") )) . " >";
		$html .= "    <label class='" . $classLabel . " control-label " . self::$alignLabel . "'  >" . $label . "</label>";
		$html .= "    <div class='" . $classInput . "' " . $classLabel . ">";
			
		$html .= "      <" . $type . " class='" . $emphasis . "'>{{" . $id . "}} " . $htmlAdicional . " </" . $type . ">";
		
		if ($withError || $withSuccess)
		{
			$html .= "      <span " . ($withError && $withSuccess ? " v-if='err" . ucfirst($id) . " || suc" . ucfirst($id) . "'" : ($withError ? " v-if='err" . ucfirst($id) . "'" : ($withSuccess ? " v-if='suc" . ucfirst($id) . "'" : "")) ) . " class='help-block'>";
			$html .= "        <strong> " . ($withError && $withSuccess ? "{{ err" . ucfirst($id) . " }}{{ suc" . ucfirst($id) . " }}" : ($withError ? "{{ err" . ucfirst($id) . " }}" : ($withSuccess ? "{{ suc" . ucfirst($id) . " }}" : "") ) ) . "</strong>";
			$html .= "      </span>";
		}
	
		$html .= "    </div>";
		$html .= "  </div>";
		$html .= "</div>";
	
			
	
		echo $html;
	}
	
	private static function input($type, $id, $label = "", $maxLength = "", $withError = false, $withSuccess = false, $atributtes = "")
	{
		$html = "";		
		//$html .= self::$ColsGroup;
		
		if (self::$ColsGroup == "")
		{
			self::$ColsGroup = self::$defaultColsGroup;
		}
		
		if (self::$ColsLabel == "")
		{
			self::$ColsLabel = self::$defaultColsLabel;
		}
		
		if (self::$ColsInput == "")
		{
			self::$ColsInput = self::$defaultColsInput;
		}
	
		$classGroup = self::getClassCols(self::$ColsGroup);
		$classLabel = self::getClassCols(self::$ColsLabel);
		$classInput = self::getClassCols(self::$ColsInput);
		
		if ($type != "hidden")
		{
			$html .= "<div class='" . $classGroup . " ".self::$margin."' >";
			//$html .= "  <div class='form-group' v-bind:class=\"{'has-error': err" . ucfirst($id) . "}\">";
			$html .= "  <div class='form-group ' " . ($withError && $withSuccess ? "v-bind:class=\"{'has-error': err" . ucfirst($id) . ", 'has-success': suc" . ucfirst($id) . "}\"" : ($withError ? "v-bind:class=\"{'has-error': err" . ucfirst($id) . "}\"" : ($withSuccess ? "v-bind:class=\"{'has-success': suc" . ucfirst($id) . "}\"" : "") )) . " >";
			$html .= "    <label class='" . $classLabel . " control-label " . self::$alignLabel . "' >" . $label . "</label>";
			$html .= "    <div class='" . $classInput . " '>";
		}
 		
 		$html .= "      <input type='" . $type . "' v-model='" . $id . "' id='" . $id . "' name='" . $id . "' ref='" . $id . "' class='form-control ". self::$alignText  ."' " . ($maxLength != "" ? "maxlength='" . $maxLength . "'" : "") . " ".$atributtes." >";
 		
 		if ($type != "hidden")
 		{
	 		if ($withError || $withSuccess)
			{
				$html .= "      <span " . ($withError && $withSuccess ? " v-if='err" . ucfirst($id) . " || suc" . ucfirst($id) . "'" : ($withError ? " v-if='err" . ucfirst($id) . "'" : ($withSuccess ? " v-if='suc" . ucfirst($id) . "'" : "")) ) . " class='help-block'>";
				$html .= "        <strong> " . ($withError && $withSuccess ? "{{ err" . ucfirst($id) . " }}{{ suc" . ucfirst($id) . " }}" : ($withError ? "{{ err" . ucfirst($id) . " }}" : ($withSuccess ? "{{ suc" . ucfirst($id) . " }}" : "") ) ) . "</strong>";
				$html .= "      </span>";
			}
			$html .= "    </div>";
 			$html .= "  </div>";
 			$html .= "</div>";
 		}
 		
		
		return $html;
	}
	
	public static function text($id, $label = "", $maxLength = "", $withError = false, $withSuccess = false, $atributtes = "")
	{
		echo self::input("text", $id, $label, $maxLength, $withError, $withSuccess, $atributtes);
	}
	
	public static function password($id, $label = "", $maxLength = "", $withError = false, $withSuccess = false, $atributtes = "")
	{
		echo self::input("password", $id, $label, $maxLength, $withError, $withSuccess, $atributtes);
	}
	
	public static function email($id, $label = "", $maxLength = "", $withError = false, $withSuccess = false, $atributtes = "")
	{
		echo self::input("email", $id, $label, $maxLength, $withError, $withSuccess, $atributtes);
	}
	
	public static function number($id, $label = "", $maxLength = "", $withError = false, $withSuccess = false, $atributtes = "")
	{
		echo self::input("number", $id, $label, $maxLength, $withError, $withSuccess, $atributtes);
	}
	
	public static function hidden($id, $label = "", $maxLength = "", $withError = false, $withSuccess = false, $atributtes = "")
	{
		echo self::input("hidden", $id, $label, $maxLength, $withError, $withSuccess, $atributtes);
	}
	
	public static function textarea($id, $label = "", $rows = "", $cols = "", $maxLength = "", $withError = false, $withSuccess = false)
	{
		$html = "";
		//$html .= self::$ColsGroup;
		
		if ($rows == "")
		{
			$rows = "10";
		}
		
		if ($cols == "")
		{
			$cols = "10";
		}
	
		if (self::$ColsGroup == "")
		{
			self::$ColsGroup = self::$defaultColsGroup;
		}
	
		if (self::$ColsLabel == "")
		{
			self::$ColsLabel = self::$defaultColsLabel;
		}
	
		if (self::$ColsInput == "")
		{
			self::$ColsInput = self::$defaultColsInput;
		}
	
		$classGroup = self::getClassCols(self::$ColsGroup);
		$classLabel = self::getClassCols(self::$ColsLabel);
		$classInput = self::getClassCols(self::$ColsInput);
	
		$html .= "<div class='" . $classGroup . "  ".self::$margin."'>";
		//$html .= "  <div class='form-group' v-bind:class=\"{'has-error': err" . ucfirst($id) . "}\">";
		$html .= "  <div class='form-group' " . ($withError && $withSuccess ? "v-bind:class=\"{'has-error': err" . ucfirst($id) . ", 'has-success': suc" . ucfirst($id) . "}\"" : ($withError ? "v-bind:class=\"{'has-error': err" . ucfirst($id) . "}\"" : ($withSuccess ? "v-bind:class=\"{'has-success': suc" . ucfirst($id) . "}\"" : "") )) . " >";
		$html .= "    <label class='" . $classLabel . " control-label' >" . $label . "</label>";
		$html .= "    <div class='" . $classInput . "'>";
		
			
		$html .= "      <textarea rows='" . $rows . "' cols='" . $cols . "' v-model='" . $id . "' id='" . $id . "' name='" . $id . "' class='form-control' " . ($maxLength != "" ? "maxlength='" . $maxLength . "'" : "") . "></textarea>";
			
		if ($withError || $withSuccess)
		{
			$html .= "      <span " . ($withError && $withSuccess ? " v-if='err" . ucfirst($id) . " || suc" . ucfirst($id) . "'" : ($withError ? " v-if='err" . ucfirst($id) . "'" : ($withSuccess ? " v-if='suc" . ucfirst($id) . "'" : "")) ) . " class='help-block'>";
			$html .= "        <strong> " . ($withError && $withSuccess ? "{{ err" . ucfirst($id) . " }}{{ suc" . ucfirst($id) . " }}" : ($withError ? "{{ err" . ucfirst($id) . " }}" : ($withSuccess ? "{{ suc" . ucfirst($id) . " }}" : "") ) ) . "</strong>";
			$html .= "      </span>";
		}
		$html .= "    </div>";
		$html .= "  </div>";
		$html .= "</div>";
		
			
	
		echo $html;
	}
	
	public static function openGroupForButtons()
	{
		$html = "";
		
		if (self::$ColsGroup == "")
		{
			self::$ColsGroup = self::$defaultColsGroup;
		}
		
		$classGroup = self::getClassCols(self::$ColsGroup);		
	
		$html .= "<div class='" . $classGroup . "' pull-right>";
		$html .= "  <div class='form-group'>";		
				
		
	
		echo $html;
	}
	
	public static function offsetForButtons($offset)
	{
		$html = "";
		
		$offset = "l" . $offset;
	
		$classButton = self::getClassCols($offset);
			
		$html .= "    <div class='" . $classButton . "'>";		
		$html .= "    </div>";
	
		echo $html;
	}
	
	private static function singleBoton($type, $label, $clicEvent, $vif = "", $classAdd = " pull-right", $colsButton = "l1")
	{
		$html = "";
		
		$classButton = self::getClassCols($colsButton);
			
		$html .= "    <div class='" . $classButton . "'  " . ($vif != "" ? "v-if='" . $vif . "'" : "") . ">";
		$html .= "      <button class='btn " . $type . " " . $classAdd . " '  v-on:click.prevent='" . $clicEvent . "'>" . $label . "</button>";
		$html .= "    </div>";		
	
		return $html;
	}
	
	public static function singleButton ($label, $clicEvent, $vif = "", $classAdd = "" , $colsButton = "l1")
	{
		echo self::singleBoton("btn-default", $label, $clicEvent, $vif, $classAdd, $colsButton);
	}
	
	public static function singleButtonPrimary ($label, $clicEvent, $vif = "", $classAdd = "" , $colsButton = "l1")
	{
		echo self::singleBoton("btn-primary", $label, $clicEvent, $vif, $classAdd, $colsButton);
	}	
	
	public static function singleButtonSuccess ($label, $clicEvent, $vif = "", $classAdd = "" , $colsButton = "l1")
	{
		echo self::singleBoton("btn-success", $label, $clicEvent, $vif, $classAdd, $colsButton);
	}
	
	public static function singleButtonInfo ($label, $clicEvent, $vif = "", $classAdd = "" , $colsButton = "l1")
	{
		echo self::singleBoton("btn-info", $label, $clicEvent, $vif, $classAdd, $colsButton);
	}
	
	public static function singleButtonWarning ($label, $clicEvent, $vif = "", $classAdd = "" , $colsButton = "l1")
	{
		echo self::singleBoton("btn-warning", $label, $clicEvent, $vif, $classAdd, $colsButton);
	}
	
	public static function singleButtonDanger ($label, $clicEvent, $vif = "", $classAdd = "" , $colsButton = "l1")
	{
		echo self::singleBoton("btn-danger", $label, $clicEvent, $vif, $classAdd, $colsButton);
	}
	
	public static function singleButtonLink ($label, $clicEvent, $vif = "", $classAdd = "" , $colsButton = "l1")
	{
		echo self::singleBoton("btn-link", $label, $clicEvent, $vif, $classAdd, $colsButton);
	}
	
	public static function closeGroupForButtons()
	{
		$html = "";	
	
		$html .= "  </div>";
		$html .= "</div>";
	
		echo $html;
	}
	
	private static function boton($type, $label, $clicEvent, $vif = "" , $classAdd = "pull-right" , $colsButton = "l10")
	{
		$html = "";
		
		if (self::$ColsGroup == "")
		{
			self::$ColsGroup = self::$defaultColsGroup;
		}
			
		$classGroup = self::getClassCols(self::$ColsGroup);
		$classButton = self::getClassCols($colsButton);
	
		$html .= "<div class='" . $classGroup . "' " . ($vif != "" ? "v-if='" . $vif . "'" : "") . ">";
		$html .= "  <div class='form-group'>";
		$html .= "    <div class='" . $classButton . "'>";
		$html .= "      <button class='btn " .$type . " " . $classAdd . " '  v-on:click.prevent='" . $clicEvent . "'>" . $label . "</button>";
		$html .= "    </div>";
		$html .= "  </div>";
		$html .= "</div>";
	
		return $html;
	}
	
	public static function button ($label, $clicEvent, $vif = "", $classAdd = "" , $colsButton = "l10")
	{
		echo self::boton("btn-default", $label, $clicEvent, $vif, $classAdd, $colsButton);
	}
	
	public static function buttonPrimary ($label, $clicEvent, $vif = "", $classAdd = "", $colsButton = "l10")
	{
		echo self::boton("btn-primary", $label, $clicEvent, $vif, $classAdd, $colsButton);
	}
	
	public static function buttonSuccess ($label, $clicEvent, $vif = "", $classAdd = "", $colsButton = "l10")
	{
		echo self::boton("btn-success", $label, $clicEvent, $vif, $classAdd, $colsButton);
	}
	
	public static function buttonInfo ($label, $clicEvent, $vif = "", $classAdd = "" , $colsButton = "l10")
	{
		echo self::boton("btn-info", $label, $clicEvent, $vif, $classAdd,  $colsButton);
	}
	
	public static function buttonWarning ($label, $clicEvent, $vif = "", $classAdd = "" , $colsButton = "l10")
	{
		echo self::boton("btn-warning", $label, $clicEvent, $vif, $classAdd, $colsButton);
	}
	
	public static function buttonDanger ($label, $clicEvent, $vif = "", $classAdd = "" ,$colsButton = "l10")
	{
		echo self::boton("btn-danger", $label, $clicEvent, $vif, $classAdd, $colsButton);
	}
	
	public static function buttonLink ($label, $clicEvent, $vif = "", $classAdd = "" ,  $colsButton = "l10")
	{
		echo self::boton("btn-link", $label, $clicEvent, $vif, $classAdd, $colsButton);
	}
	
	
	
	private static function getClassCols($cols)
	{
		$colLG = "col-lg-8";
		$colMD = "col-md-8";
		$colSM = "col-sm-12";
		$colXS = "col-xs-12";
		
		$varTemp = 0;
		foreach (explode("|", $cols) as $cg)
		{
			if (isset($cg[2]))
			{
				$varTemp = $cg[1] . $cg[2];
				if ($varTemp > 12)
				{
					$varTemp = "12";
				}
			}
			else
			{
				if (isset($cg[1]))
				{
					$varTemp = $cg[1];
				}
			}
			
			if (!is_numeric($varTemp))
			{
				$varTemp = "1";
			}
			
				
			if (isset($cg[0]))
			{
				if ($cg[0] == "l")
				{
					$colLG = "col-lg-" . $varTemp;
				}
				else
				{
					if ($cg[0] == "m")
					{
						$colMD = "col-md-" . $varTemp;
					}
					else
					{
						if ($cg[0] == "s")
						{
							$colSM = "col-sm-" . $varTemp;
						}
						else
						{
							if ($cg[0] == "x")
							{
								$colXS = "col-xs-" . $varTemp;
							}
						}
					}
				}
			}
		}
		
		return $colLG . " " . $colMD . " " . $colSM . " " . $colXS;
	}
	
	public static function array_get(array $options, $key, $default)
	{
		return isset($options[$key]) ? $options[$key] : $default;
	}
}