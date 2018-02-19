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

$an = $_POST["anio"];
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
		<td><b>Gestion:</b> $an</td>
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
			<td></td>
		</tr>
		<tr>
			<td>Inyectables vía IM</td>
			<td></td>
		</tr>
		<tr>
			<td>Inyectables v+ia IV</td>
			<td></td>
		</tr>
		<tr>
			<td>Venoclisis y administración de sueros</td>
			<td></td>
		</tr>
		<tr>
			<td>Nebulización</td>
			<td></td>
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
			<td>4RA</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>5RA</td>
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