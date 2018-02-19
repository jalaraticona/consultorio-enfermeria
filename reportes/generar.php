<?php
require_once("../public/usuario.php");
require_once('tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Unicersidad Mayor de San Andres - Facultad de Medicina, Enfermería, Nutrición y Tecnología Médica');
$pdf->SetTitle('Carrera de Enfermería');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.'', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', 'B', 20);

// add a page
$pdf->AddPage();

$pdf->Write(0, 'Producción de Servicios Consultorio de Enfermería', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('helvetica', '', 9);

// -----------------------------------------------------------------------------

$anio_actual = $_POST["anio"];
$me = $_POST["mes"];
$ti = $_POST["tipo"];

$u = new usuario();
$sql = "SELECT pe.* FROM persona as pe, enfermera as en WHERE en.id_enf = ".$_SESSION["id_enf"]." and en.ci = pe.ci";
$datos = $u->getDatosInsumosSql($sql);
$nombre = $datos[0]->nombre." ".$datos[0]->paterno." ".$datos[0]->materno;

$tbl = <<<EOD
<table cellspacing="0" cellpadding="3">
	<tr>
		<td><b>Establecimiento:</b> Consultorio Carrera de Enfermería - UMSA</td>
		<td><b>Red de servicio:</b> </td>
		<td><b>Responsable:</b> $nombre</td>
	</tr>
	<tr>
		<td><b>Gestion:</b> $anio_actual</td>
		<td><b>Mes:</b> $me</td>
		<td><b>Tipo de Reporte:</b> $ti</td>
	</tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

$tbl=<<<EOD
<table cellspacing="0" cellpadding="1" border="1">
	<tr>
		<td align="center"><b>PRODUCCION DE SERVICIOS: ACTIVIDADES DE ENFERMERIA</b></td>
	</tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

$sql = "SELECT re.fec_reg, se.nombre, se.tipo FROM registrahistoria as re, servicio as se WHERE re.id_servicio = se.id_servicio and year(re.fec_reg) = ".$anio_actual." ";
$datos = $u->getDatosPacienteSql($sql);
$cur = 0; $iny = 0; $ven = 0; $sue = 0; $vac = 0; $neb = 0;
if(sizeof($datos) > 0){
	foreach ($datos as $dato) {
		if($dato->nombre == "curacion pequeña" || $dato->nombre == "curacion mediana" || $dato->nombre == "retiro de puntos"){
			$cur++;
		}
		if($dato->tipo == "vacuna"){
			$vac++;
		}
		if($dato->nombre == "inyectable"){
			$iny++;
		}
		if($dato->nombre == "nebulizacion"){
			$neb++;
		}
	}
}

$tbl = <<<EOD
<table cellspacing="0" cellpadding="1" border="1">
	<thead>
		<tr>
			<th align="center"><b>ACTIVIDADES</b></th>
			<th align="center"><b>CANTIDAD</b></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Curaciones</td>
			<td>$cur</td>
		</tr>
		<tr>
			<td>Inyectables vía IM</td>
			<td>$iny</td>
		</tr>
		<tr>
			<td>Inyectables v+ia IV</td>
			<td>$iny</td>
		</tr>
		<tr>
			<td>Venoclisis y administración de sueros</td>
			<td>$ven</td>
		</tr>
		<tr>
			<td>Nebulización</td>
			<td>$neb</td>
		</tr>
		<tr>
			<td>Vacunas</td>
			<td>$vac</td>
		</tr>
	</tbody>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

$tbl=<<<EOD
<table cellspacing="0" cellpadding="1" border="1">
	<tr>
		<td align="center"><b>PRODUCCION DE SERVICIOS: PROGRAMA AMPLIADO DE INMUNIZACION FAMILIAR Y COMUNITARIO</b></td>
	</tr>
</table>
EOD;

$sql = "SELECT re.fec_reg, se.nombre, se.tipo FROM registrahistoria as re, servicio as se WHERE re.id_servicio = se.id_servicio and se.nombre = 'difteria' and year(re.fec_reg) = ".$anio_actual." ";
$datos = $u->getDatosPacienteSql($sql);
$prifefu = 0; $prifede = 0; $primafu = 0; $primade = 0;
$segfefu = 0; $segfede = 0; $segmafu = 0; $segmade = 0;
$terfefu = 0; $terfede = 0; $termafu = 0; $termade = 0;
$cuafefu = 0; $cuafede = 0; $cuamafu = 0; $cuamade = 0;
$quifefu = 0; $quifede = 0; $quimafu = 0; $quimade = 0;

if(sizeof($datos) > 0){
	/*foreach ($datos as $dato) {
		if($dato->nombre == "curacion pequeña" || $dato->nombre == "curacion mediana" || $dato->nombre == "retiro de puntos"){
			$cur++;
		}
		if($dato->tipo == "vacuna"){
			$vac++;
		}
		if($dato->nombre == "inyectable"){
			$iny++;
		}
		if($dato->nombre == "nebulizacion"){
			$neb++;
		}
	}*/
}
$totpri = $prifede + $prifefu + $primade + $primafu;
$totseg = $segfede + $segfefu + $segmade + $segmafu;
$totter = $terfede + $terfefu + $termade + $termafu;
$totcua = $cuafede + $cuafefu + $cuamade + $cuamafu;
$totqui = $quifede + $quifefu + $quimade + $quimafu;

$totfede = $prifede + $segfede + $terfede + $cuafede + $quifede;
$totfefu = $prifefu + $segfefu + $terfefu + $cuafefu + $quifefu;
$totmade = $primade + $segmade + $termade + $cuamade + $quimade;
$totmafu = $primafu + $segmafu + $termafu + $cuamafu + $quimafu;
$total = $totfede + $totmade + $totfefu + $totmafu;

$pdf->writeHTML($tbl, true, false, false, false, '');

$tbl=<<<EOD
<table cellspacing="0" cellpadding="1" border="1">
	<thead>
		<tr>
			<td colspan="6" align="center"><b>VACUNACION DIFTERIA Y TETANOS</b></td>
		</tr>
		<tr>
			<td></td>
			<td colspan="2" align="center">DENTRO DEL SERVICIO</td>
			<td colspan="2" align="center">FUERA DEL SERVICIO</td>
			<td></td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td align="center">DOSIS</td>
			<td align="center">FEMENINO</td>
			<td align="center">MASCULINO</td>
			<td align="center">FEMENINO</td>
			<td align="center">MASCULINO</td>
			<td align="center">TOTAL</td>
		</tr>
		<tr>
			<td>1RA</td>
			<td>$prifede</td>
			<td>$primade</td>
			<td>$prifefu</td>
			<td>$primafu</td>
			<td>$totpri</td>
		</tr>
		<tr>
			<td>2RA</td>
			<td>$segfede</td>
			<td>$segmade</td>
			<td>$segfefu</td>
			<td>$segmafu</td>
			<td>$totseg</td>
		</tr>
		<tr>
			<td>3RA</td>
			<td>$terfede</td>
			<td>$termade</td>
			<td>$terfefu</td>
			<td>$termafu</td>
			<td>$totter</td>
		</tr>
		<tr>
			<td>4RA</td>
			<td>$cuafede</td>
			<td>$cuamade</td>
			<td>$cuafefu</td>
			<td>$cuamafu</td>
			<td>$totcua</td>
		</tr>
		<tr>
			<td>5RA</td>
			<td>$quifede</td>
			<td>$quimade</td>
			<td>$quifefu</td>
			<td>$quimafu</td>
			<td>$totqui</td>
		</tr>
		<tr>
			<td>TOTAL</td>
			<td>$totfede</td>
			<td>$totmade</td>
			<td>$totfefu</td>
			<td>$totmafu</td>
			<td>$total</td>
		</tr>
	</tbody>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

$tbl=<<<EOD
<table cellspacing="0" cellpadding="1" border="1">
	<thead>
		<tr>
			<td colspan="6" align="center"><b>VACUNACION HEPATITIS B</b></td>
		</tr>
		<tr>
			<td></td>
			<td colspan="2" align="center">DENTRO DEL SERVICIO</td>
			<td colspan="2" align="center">FUERA DEL SERVICIO</td>
			<td></td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td align="center">DOSIS</td>
			<td align="center">FEMENINO</td>
			<td align="center">MASCULINO</td>
			<td align="center">FEMENINO</td>
			<td align="center">MASCULINO</td>
			<td align="center">TOTAL</td>
		</tr>
		<tr>
			<td>1RA</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>2RA</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>3RA</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>TOTAL</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</tbody>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

$tbl=<<<EOD
<table cellspacing="0" cellpadding="1" border="1">
	<thead>
		<tr>
			<td colspan="6" align="center"><b>VACUNACION INFLUENZA ESTACIONAL (DOSIS UNICA)</b></td>
		</tr>
		<tr>
			<td></td>
			<td colspan="2" align="center">DENTRO DEL SERVICIO</td>
			<td colspan="2" align="center">FUERA DEL SERVICIO</td>
			<td></td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td align="center">DOSIS</td>
			<td align="center">FEMENINO</td>
			<td align="center">MASCULINO</td>
			<td align="center">FEMENINO</td>
			<td align="center">MASCULINO</td>
			<td align="center">TOTAL</td>
		</tr>
		<tr>
			<td>Personal de salud</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Adultos mayores</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Otros</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>TOTAL</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</tbody>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

$tbl=<<<EOD
<table cellspacing="0" cellpadding="1" border="1">
	<thead>
		<tr>
			<td colspan="6" align="center"><b>VACUNACION FIEBRE AMARILLA (DOSIS UNICA</b></td>
		</tr>
		<tr>
			<td></td>
			<td colspan="2" align="center">DENTRO DEL SERVICIO</td>
			<td colspan="2" align="center">FUERA DEL SERVICIO</td>
			<td></td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td align="center">DOSIS</td>
			<td align="center">FEMENINO</td>
			<td align="center">MASCULINO</td>
			<td align="center">FEMENINO</td>
			<td align="center">MASCULINO</td>
			<td align="center">TOTAL</td>
		</tr>
		<tr>
			<td>Unica</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>TOTAL</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</tbody>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
$pdf->Output('Reporte_Produccion_Servicios.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>