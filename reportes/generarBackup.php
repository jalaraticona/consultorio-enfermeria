<?php
require_once("../public/usuario.php");
require_once('tcpdf/tcpdf.php');

$anio_actual = $_POST["anio"];
$me = $_POST["mes"];
$ti = $_POST["tipo"];

//si es produccion de servicios
if($ti == "servicios"){

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Universidad Mayor de San Andres - Facultad de Medicina, Enfermería, Nutrición y Tecnología Médica');
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
$sql = "SELECT * FROM enfermera WHERE id_enfermera = ".$_SESSION["id_enf"]." ";
$datos = $u->GetDatosSql($sql);
$nombre = $datos[0]->nombre." ".$datos[0]->paterno." ".$datos[0]->materno;

$meses = array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','noviembre','diciembre');
if($me == 0){
	$mess = "Enero - Diciembre";
}
else{
	$mess = $meses[$me-1];
}

$tbl = <<<EOD
<table cellspacing="0" cellpadding="3">
	<tr>
		<td><b>Establecimiento:</b> Consultorio Carrera de Enfermería - UMSA</td>
		<td><b>Red de servicio:</b> </td>
		<td><b>Responsable:</b> $nombre</td>
	</tr>
	<tr>
		<td><b>Gestion:</b> $anio_actual</td>
		<td><b>Mes:</b> $mess</td>
		<td><b>Tipo de Reporte:</b> $ti</td>
	</tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

if($me == 0){

$tbl=<<<EOD
<table cellspacing="0" cellpadding="1" border="1">
	<tr>
		<td align="center"><b>PRODUCCION DE SERVICIOS: ACTIVIDADES DE ENFERMERIA</b></td>
	</tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

$sql = "SELECT re.fec_reg, se.clave, se.tipo FROM historia as re, servicio as se WHERE re.id_servicio = se.id_servicio and year(re.fec_reg) = ".$anio_actual." ";
$datos = $u->GetDatosSql($sql);
$cur = 0; $iny = 0; $ven = 0; $sue = 0; $vac = 0; $neb = 0;
if(sizeof($datos) > 0){
	foreach ($datos as $dato) {
		if($dato->clave == "curacion pequeña" || $dato->clave == "curacion mediana" || $dato->clave == "retiro de puntos"){
			$cur++;
		}
		if($dato->tipo == "vacuna"){
			$vac++;
		}
		if($dato->clave == "inyectable"){
			$iny++;
		}
		if($dato->clave == "nebulizacion"){
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

$pdf->writeHTML($tbl, true, false, false, false, '');

$sql = "SELECT re.fec_reg, se.clave, se.tipo, pa.sexo, re.dosis, re.lugar FROM historia as re, servicio as se, paciente as pa WHERE re.id_servicio = se.id_servicio and pa.id_paciente = re.id_paciente and se.clave = 'difteria' and year(re.fec_reg) = ".$anio_actual." ";
$datos = $u->GetDatosSql($sql);
$prifefu = 0; $prifede = 0; $primafu = 0; $primade = 0;
$segfefu = 0; $segfede = 0; $segmafu = 0; $segmade = 0;
$terfefu = 0; $terfede = 0; $termafu = 0; $termade = 0;
$cuafefu = 0; $cuafede = 0; $cuamafu = 0; $cuamade = 0;
$quifefu = 0; $quifede = 0; $quimafu = 0; $quimade = 0;

if(sizeof($datos) > 0){
	foreach ($datos as $dato) {
		$sex = $dato->sexo;
		$lug = $dato->lugar;
		$dos = $dato->dosis;
		if ($sex == "femenino") {
			if($lug == "dentro"){
				if($dos == "primera"){
					$prifede++;
				}
				if($dos == "segunda"){
					$segfede++;
				}
				if($dos == "tercera"){
					$terfede++;
				}
				if($dos == "cuarta"){
					$cuafede++;
				}
				if($dos == "quinta"){
					$quifede++;
				}
			}
			if ($lug == "fuera") {
				if($dos == "primera"){
					$prifefu++;
				}
				if($dos == "segunda"){
					$segfefu++;
				}
				if($dos == "tercera"){
					$terfefu++;
				}
				if($dos == "cuarta"){
					$cuafefu++;
				}
				if($dos == "quinta"){
					$quifefu++;
				}
			}
		}
		if ($sex == "masculino") {
			if($lug == "dentro"){
				if($dos == "primera"){
					$primade++;
				}
				if($dos == "segunda"){
					$segmade++;
				}
				if($dos == "tercera"){
					$termade++;
				}
				if($dos == "cuarta"){
					$cuamade++;
				}
				if($dos == "quinta"){
					$quimade++;
				}
			}
			if ($lug == "fuera") {
				if($dos == "primera"){
					$primafu++;
				}
				if($dos == "segunda"){
					$segmafu++;
				}
				if($dos == "tercera"){
					$termafu++;
				}
				if($dos == "cuarta"){
					$cuamafu++;
				}
				if($dos == "quinta"){
					$quimafu++;
				}
			}
		}
	}
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

$sql = "SELECT re.fec_reg, se.clave, se.tipo, pa.sexo, re.dosis, re.lugar FROM historia as re, servicio as se, paciente as pa WHERE re.id_servicio = se.id_servicio and pa.id_paciente = re.id_paciente and se.clave = 'hepatitis b' and year(re.fec_reg) = ".$anio_actual." ";
$datos = $u->GetDatosSql($sql);
$prifefu = 0; $prifede = 0; $primafu = 0; $primade = 0;
$segfefu = 0; $segfede = 0; $segmafu = 0; $segmade = 0;
$terfefu = 0; $terfede = 0; $termafu = 0; $termade = 0;

if(sizeof($datos) > 0){
	foreach ($datos as $dato) {
		$sex = $dato->sexo;
		$lug = $dato->lugar;
		$dos = $dato->dosis;
		if ($sex == "femenino") {
			if($lug == "dentro"){
				if($dos == "primera"){
					$prifede++;
				}
				if($dos == "segunda"){
					$segfede++;
				}
				if($dos == "tercera"){
					$terfede++;
				}
			}
			if ($lug == "fuera") {
				if($dos == "primera"){
					$prifefu++;
				}
				if($dos == "segunda"){
					$segfefu++;
				}
				if($dos == "tercera"){
					$terfefu++;
				}
			}
		}
		if ($sex == "masculino") {
			if($lug == "dentro"){
				if($dos == "primera"){
					$primade++;
				}
				if($dos == "segunda"){
					$segmade++;
				}
				if($dos == "tercera"){
					$termade++;
				}
			}
			if ($lug == "fuera") {
				if($dos == "primera"){
					$primafu++;
				}
				if($dos == "segunda"){
					$segmafu++;
				}
				if($dos == "tercera"){
					$termafu++;
				}
			}
		}
	}
}
$totpri = $prifede + $prifefu + $primade + $primafu;
$totseg = $segfede + $segfefu + $segmade + $segmafu;
$totter = $terfede + $terfefu + $termade + $termafu;

$totfede = $prifede + $segfede + $terfede;
$totfefu = $prifefu + $segfefu + $terfefu;
$totmade = $primade + $segmade + $termade;
$totmafu = $primafu + $segmafu + $termafu;
$total = $totfede + $totmade + $totfefu + $totmafu;

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

$sql = "SELECT re.fec_reg, se.clave, se.tipo, pa.sexo, re.dosis, re.lugar, pa.fec_nac FROM historia as re, servicio as se, paciente as pa WHERE re.id_servicio = se.id_servicio and pa.id_paciente = re.id_paciente and se.clave = 'influenza estacional' and year(re.fec_reg) = ".$anio_actual." ";
$datos = $u->GetDatosSql($sql);
$prifefu = 0; $prifede = 0; $primafu = 0; $primade = 0;
$segfefu = 0; $segfede = 0; $segmafu = 0; $segmade = 0;
$terfefu = 0; $terfede = 0; $termafu = 0; $termade = 0;

if(sizeof($datos) > 0){
	foreach ($datos as $dato) {
		$sex = $dato->sexo;
		$lug = $dato->lugar;
		$dos = $dato->dosis;
		$fecha = $dato->fec_nac;
		$edad = $u->edad($fecha);
		if ($sex == "femenino") {
			if($lug == "dentro"){
				if($edad < 6){
					$prifede++;
				}
				if($edad > 5 and $edad < 66){
					$segfede++;
				}
				if($edad > 65){
					$terfede++;
				}
			}
			if ($lug == "fuera") {
				if($edad < 6){
					$prifefu++;
				}
				if($edad > 5 and $edad < 66){
					$segfefu++;
				}
				if($edad > 65){
					$terfefu++;
				}
			}
		}
		if ($sex == "masculino") {
			if($lug == "dentro"){
				if($edad < 6){
					$primade++;
				}
				if($edad > 5 and $edad < 66){
					$segmade++;
				}
				if($edad > 65){
					$termade++;
				}
			}
			if ($lug == "fuera") {
				if($edad < 6){
					$primafu++;
				}
				if($edad > 5 and $edad < 66){
					$segmafu++;
				}
				if($edad > 65){
					$termafu++;
				}
			}
		}
	}
}
$totpri = $prifede + $prifefu + $primade + $primafu;
$totseg = $segfede + $segfefu + $segmade + $segmafu;
$totter = $terfede + $terfefu + $termade + $termafu;

$totfede = $prifede + $segfede + $terfede;
$totfefu = $prifefu + $segfefu + $terfefu;
$totmade = $primade + $segmade + $termade;
$totmafu = $primafu + $segmafu + $termafu;
$total = $totfede + $totmade + $totfefu + $totmafu;

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
			<td>De 1 a 5 años</td>
			<td>$prifede</td>
			<td>$primade</td>
			<td>$prifefu</td>
			<td>$primafu</td>
			<td>$totpri</td>
		</tr>
		<tr>
			<td>De 6 a 65 años</td>
			<td>$segfede</td>
			<td>$segmade</td>
			<td>$segfefu</td>
			<td>$segmafu</td>
			<td>$totseg</td>
		</tr>
		<tr>
			<td>Mayor a 65 años (Adulto mayor)</td>
			<td>$terfede</td>
			<td>$termade</td>
			<td>$terfefu</td>
			<td>$termafu</td>
			<td>$totter</td>
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

$sql = "SELECT re.fec_reg, se.clave, se.tipo, pa.sexo, re.dosis, re.lugar, pa.fec_nac FROM historia as re, servicio as se, paciente as pa WHERE re.id_servicio = se.id_servicio and pa.id_paciente = re.id_paciente and se.clave = 'fiebre amarilla' and year(re.fec_reg) = ".$anio_actual." ";
$datos = $u->GetDatosSql($sql);
$prifefu = 0; $prifede = 0; $primafu = 0; $primade = 0;
$segfefu = 0; $segfede = 0; $segmafu = 0; $segmade = 0;
$terfefu = 0; $terfede = 0; $termafu = 0; $termade = 0;

if(sizeof($datos) > 0){
	foreach ($datos as $dato) {
		$sex = $dato->sexo;
		$lug = $dato->lugar;
		$dos = $dato->dosis;
		if ($sex == "femenino") {
			if($lug == "dentro"){
				$prifede++;
			}
			if ($lug == "fuera") {
				$prifefu++;
			}
		}
		if ($sex == "masculino") {
			if($lug == "dentro"){
				$primade++;
			}
			if ($lug == "fuera") {
				$primafu++;
			}
		}
	}
}
$totpri = $prifede + $prifefu + $primade + $primafu;

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
			<td>$prifede</td>
			<td>$primade</td>
			<td>$prifefu</td>
			<td>$primafu</td>
			<td>$totpri</td>
		</tr>
	</tbody>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

}// fin produccion de servicios anual
else{
$tbl=<<<EOD
<table cellspacing="0" cellpadding="1" border="1">
	<tr>
		<td align="center"><b>PRODUCCION DE SERVICIOS: ACTIVIDADES DE ENFERMERIA</b></td>
	</tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

$sql = "SELECT re.fec_reg, se.clave, se.tipo FROM historia as re, servicio as se WHERE re.id_servicio = se.id_servicio and year(re.fec_reg) = ".$anio_actual." and month(re.fec_reg) = ".$me." ";
$datos = $u->GetDatosSql($sql);
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

$sql = "SELECT re.fec_reg, se.clave, se.tipo, pa.sexo, re.dosis, re.lugar FROM historia as re, servicio as se, paciente as pa WHERE re.id_servicio = se.id_servicio and pa.id_paciente = re.id_paciente and se.clave = 'difteria' and year(re.fec_reg) = ".$anio_actual." and month(re.fec_reg) = ".$me." ";
$datos = $u->GetDatosSql($sql);
$prifefu = 0; $prifede = 0; $primafu = 0; $primade = 0;
$segfefu = 0; $segfede = 0; $segmafu = 0; $segmade = 0;
$terfefu = 0; $terfede = 0; $termafu = 0; $termade = 0;
$cuafefu = 0; $cuafede = 0; $cuamafu = 0; $cuamade = 0;
$quifefu = 0; $quifede = 0; $quimafu = 0; $quimade = 0;

if(sizeof($datos) > 0){
	foreach ($datos as $dato) {
		$sex = $dato->sexo;
		$lug = $dato->lugar;
		$dos = $dato->dosis;
		if ($sex == "femenino") {
			if($lug == "dentro"){
				if($dos == "primera"){
					$prifede++;
				}
				if($dos == "segunda"){
					$segfede++;
				}
				if($dos == "tercera"){
					$terfede++;
				}
				if($dos == "cuarta"){
					$cuafede++;
				}
				if($dos == "quinta"){
					$quifede++;
				}
			}
			if ($lug == "fuera") {
				if($dos == "primera"){
					$prifefu++;
				}
				if($dos == "segunda"){
					$segfefu++;
				}
				if($dos == "tercera"){
					$terfefu++;
				}
				if($dos == "cuarta"){
					$cuafefu++;
				}
				if($dos == "quinta"){
					$quifefu++;
				}
			}
		}
		if ($sex == "masculino") {
			if($lug == "dentro"){
				if($dos == "primera"){
					$primade++;
				}
				if($dos == "segunda"){
					$segmade++;
				}
				if($dos == "tercera"){
					$termade++;
				}
				if($dos == "cuarta"){
					$cuamade++;
				}
				if($dos == "quinta"){
					$quimade++;
				}
			}
			if ($lug == "fuera") {
				if($dos == "primera"){
					$primafu++;
				}
				if($dos == "segunda"){
					$segmafu++;
				}
				if($dos == "tercera"){
					$termafu++;
				}
				if($dos == "cuarta"){
					$cuamafu++;
				}
				if($dos == "quinta"){
					$quimafu++;
				}
			}
		}
	}
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

$sql = "SELECT re.fec_reg, se.clave, se.tipo, pa.sexo, re.dosis, re.lugar FROM historia as re, servicio as se, paciente as pa WHERE re.id_servicio = se.id_servicio and pa.id_paciente = re.id_paciente and se.clave = 'hepatitis b' and year(re.fec_reg) = ".$anio_actual." and month(re.fec_reg) = ".$me." ";
$datos = $u->GetDatosSql($sql);
$prifefu = 0; $prifede = 0; $primafu = 0; $primade = 0;
$segfefu = 0; $segfede = 0; $segmafu = 0; $segmade = 0;
$terfefu = 0; $terfede = 0; $termafu = 0; $termade = 0;

if(sizeof($datos) > 0){
	foreach ($datos as $dato) {
		$sex = $dato->sexo;
		$lug = $dato->lugar;
		$dos = $dato->dosis;
		if ($sex == "femenino") {
			if($lug == "dentro"){
				if($dos == "primera"){
					$prifede++;
				}
				if($dos == "segunda"){
					$segfede++;
				}
				if($dos == "tercera"){
					$terfede++;
				}
			}
			if ($lug == "fuera") {
				if($dos == "primera"){
					$prifefu++;
				}
				if($dos == "segunda"){
					$segfefu++;
				}
				if($dos == "tercera"){
					$terfefu++;
				}
			}
		}
		if ($sex == "masculino") {
			if($lug == "dentro"){
				if($dos == "primera"){
					$primade++;
				}
				if($dos == "segunda"){
					$segmade++;
				}
				if($dos == "tercera"){
					$termade++;
				}
			}
			if ($lug == "fuera") {
				if($dos == "primera"){
					$primafu++;
				}
				if($dos == "segunda"){
					$segmafu++;
				}
				if($dos == "tercera"){
					$termafu++;
				}
			}
		}
	}
}
$totpri = $prifede + $prifefu + $primade + $primafu;
$totseg = $segfede + $segfefu + $segmade + $segmafu;
$totter = $terfede + $terfefu + $termade + $termafu;

$totfede = $prifede + $segfede + $terfede;
$totfefu = $prifefu + $segfefu + $terfefu;
$totmade = $primade + $segmade + $termade;
$totmafu = $primafu + $segmafu + $termafu;
$total = $totfede + $totmade + $totfefu + $totmafu;

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

$sql = "SELECT re.fec_reg, se.clave, se.tipo, pa.sexo, re.dosis, re.lugar, pa.fec_nac FROM historia as re, servicio as se, paciente as pa WHERE re.id_servicio = se.id_servicio and pa.id_paciente = re.id_paciente and se.clave = 'influenza estacional' and year(re.fec_reg) = ".$anio_actual." and month(re.fec_reg) = ".$me." ";
$datos = $u->GetDatosSql($sql);
$prifefu = 0; $prifede = 0; $primafu = 0; $primade = 0;
$segfefu = 0; $segfede = 0; $segmafu = 0; $segmade = 0;
$terfefu = 0; $terfede = 0; $termafu = 0; $termade = 0;

if(sizeof($datos) > 0){
	foreach ($datos as $dato) {
		$sex = $dato->sexo;
		$lug = $dato->lugar;
		$dos = $dato->dosis;
		$fecha = $dato->fec_nac;
		$edad = edad($fecha);
		if ($sex == "femenino") {
			if($lug == "dentro"){
				if($edad < 6){
					$prifede++;
				}
				if($edad > 5 and $edad < 66){
					$segfede++;
				}
				if($edad > 65){
					$terfede++;
				}
			}
			if ($lug == "fuera") {
				if($edad < 6){
					$prifefu++;
				}
				if($edad > 5 and $edad < 66){
					$segfefu++;
				}
				if($edad > 65){
					$terfefu++;
				}
			}
		}
		if ($sex == "masculino") {
			if($lug == "dentro"){
				if($edad < 6){
					$primade++;
				}
				if($edad > 5 and $edad < 66){
					$segmade++;
				}
				if($edad > 65){
					$termade++;
				}
			}
			if ($lug == "fuera") {
				if($edad < 6){
					$primafu++;
				}
				if($edad > 5 and $edad < 66){
					$segmafu++;
				}
				if($edad > 65){
					$termafu++;
				}
			}
		}
	}
}
$totpri = $prifede + $prifefu + $primade + $primafu;
$totseg = $segfede + $segfefu + $segmade + $segmafu;
$totter = $terfede + $terfefu + $termade + $termafu;

$totfede = $prifede + $segfede + $terfede;
$totfefu = $prifefu + $segfefu + $terfefu;
$totmade = $primade + $segmade + $termade;
$totmafu = $primafu + $segmafu + $termafu;
$total = $totfede + $totmade + $totfefu + $totmafu;

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
			<td>De 1 a 5 años</td>
			<td>$prifede</td>
			<td>$primade</td>
			<td>$prifefu</td>
			<td>$primafu</td>
			<td>$totpri</td>
		</tr>
		<tr>
			<td>De 6 a 65 años</td>
			<td>$segfede</td>
			<td>$segmade</td>
			<td>$segfefu</td>
			<td>$segmafu</td>
			<td>$totseg</td>
		</tr>
		<tr>
			<td>Mayor a 65 años (Adulto mayor)</td>
			<td>$terfede</td>
			<td>$termade</td>
			<td>$terfefu</td>
			<td>$termafu</td>
			<td>$totter</td>
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

$sql = "SELECT re.fec_reg, se.clave, se.tipo, pa.sexo, re.dosis, re.lugar, pa.fec_nac FROM historia as re, servicio as se, paciente as pa WHERE re.id_servicio = se.id_servicio and pa.id_paciente = re.id_paciente and se.clave = 'fiebre amarilla' and year(re.fec_reg) = ".$anio_actual." and month(re.fec_reg) = ".$me." ";
$datos = $u->GetDatosSql($sql);
$prifefu = 0; $prifede = 0; $primafu = 0; $primade = 0;
$segfefu = 0; $segfede = 0; $segmafu = 0; $segmade = 0;
$terfefu = 0; $terfede = 0; $termafu = 0; $termade = 0;

if(sizeof($datos) > 0){
	foreach ($datos as $dato) {
		$sex = $dato->sexo;
		$lug = $dato->lugar;
		$dos = $dato->dosis;
		if ($sex == "femenino") {
			if($lug == "dentro"){
				$prifede++;
			}
			if ($lug == "fuera") {
				$prifefu++;
			}
		}
		if ($sex == "masculino") {
			if($lug == "dentro"){
				$primade++;
			}
			if ($lug == "fuera") {
				$primafu++;
			}
		}
	}
}
$totpri = $prifede + $prifefu + $primade + $primafu;

$tbl=<<<EOD
<table cellspacing="0" cellpadding="1" border="1">
	<thead>
		<tr>
			<td colspan="6" align="center"><b>VACUNACION FIEBRE AMARILLA (DOSIS UNICA)</b></td>
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
			<td>$prifede</td>
			<td>$primade</td>
			<td>$prifefu</td>
			<td>$primafu</td>
			<td>$totpri</td>
		</tr>
	</tbody>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');
}//fin produccion de servicios mensual
}// fin produccion de servicios
else{

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION2, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

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

$pdf->Write(0, 'KARDEX DE EXISTENCIA DE INSUMOS', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('helvetica', '', 9);

// -----------------------------------------------------------------------------

$u = new usuario();
$sql = "SELECT * FROM enfermera WHERE id_enfermera = ".$_SESSION["id_enf"]." ";
$datos = $u->GetDatosSql($sql);
$nombre = $datos[0]->nombre." ".$datos[0]->paterno." ".$datos[0]->materno;

$meses = array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','noviembre','diciembre');
if($me == 0){
	$mess = "Enero - Diciembre";
}
else{
	$mess = $meses[$me-1];
}

$tbl = <<<EOD
<table cellspacing="0" cellpadding="3">
	<tr>
		<td><b>Establecimiento:</b> Consultorio Carrera de Enfermería - UMSA</td>
		<td><b>Red de servicio:</b> </td>
		<td><b>Responsable:</b> $nombre</td>
	</tr>
	<tr>
		<td><b>Gestion:</b> $anio_actual</td>
		<td><b>Mes:</b> $mess</td>
		<td><b>Tipo de Reporte:</b> $ti</td>
	</tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

$sql = "SELECT * FROM registrodiario WHERE ";

}	


//Close and output PDF document
$pdf->Output('Reporte_Produccion_Servicios.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>