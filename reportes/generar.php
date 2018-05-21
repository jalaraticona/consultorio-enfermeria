<?php
require_once("../public/usuario.php");
require_once('tcpdf/tcpdf.php');

$u = new usuario();
$inicio = $_POST["inicio"];
$final = $_POST["final"];
$tipo = $_POST["tipo"];

//INICIO DE GENERACION DE PDF
if($tipo == "servicios"){
	$esp = $_POST["servi"];
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

	$pdf->Write(0, 'Producción de Servicios Consultorio de Enfermería', '', 0, 'C', true, 0, false, false, 0);

	$pdf->SetFont('helvetica', '', 9);

	// PROCESO DE GENERACION DE REPORTE

	$tbl = '<table cellspacing="0" cellpadding="1" border="1">';
		$tbl .= '<tr>
		        <td align="center"><b>PRODUCCION DE SERVICIOS: ACTIVIDADES DE ENFERMERIA</b></td>
		        </tr>';
	$tbl .= '</table>';

	$pdf->writeHTML($tbl, true, false, false, false, '');

	$sql = "SELECT re.fec_reg, se.clave, se.tipo FROM historia as re, servicio as se WHERE re.fec_reg BETWEEN '".$inicio."' AND '".$final."' AND re.id_servicio = se.id_servicio ";
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
	$tbl = '<table cellspacing="0" cellpadding="1" border="1">';
		$tbl .= '<tr>
		        <td align="center"><b>ACTIVIDAD</b></td>
		        <td align="center"><b>CANTIDAD</b></td>
		        </tr>';
		$tbl .= '<tr>
		        <td>Curaciones: </td>
		        <td>' . $cur . '</td>
		    	</tr>';
		$tbl .= '<tr>
		        <td>Inyectables vía IM: </td>
		        <td>' . $iny . '</td>
		    	</tr>';
		$tbl .= '<tr>
		        <td>Inyectables vía IV: </td>
		        <td>' . $iny . '</td>
		    	</tr>';
		$tbl .= '<tr>
		        <td>Venoclisis y administración de sueros: </td>
		        <td>' . $ven . '</td>
		    	</tr>';
		$tbl .= '<tr>
		        <td>Nebulización: </td>
		        <td>' . $neb . '</td>
		    	</tr>';
		$tbl .= '<tr>
		        <td>Vacunaciones: </td>
		        <td>' . $vac . '</td>
		    	</tr>';
	$tbl .= '</table>';
	$pdf->writeHTML($tbl, true, false, false, false, '');

	$tbl = '<table cellspacing="0" cellpadding="1" border="1">';
		$tbl .= '<tr>
		        <td align="center"><b>PRODUCCION DE SERVICIOS: PROGRAMA AMPLIADO DE INMUNIZACION FAMILIAR Y COMUNITARIO</b></td>
		        </tr>';
	$tbl .= '</table>';

	$pdf->writeHTML($tbl, true, false, false, false, '');

	$sql = "SELECT count(*) as cant_serv FROM servicio WHERE tipo = 'vacuna' ";
	$datos = $u->GetDatosSql($sql);
	$cantidad = $datos[0]->cant_serv;

	foreach ($esp as $datito) {
		$sql = "SELECT re.fec_reg, se.clave, se.tipo, pa.sexo, re.dosis, re.lugar FROM  historia as re, servicio as se, paciente as pa WHERE re.fec_reg BETWEEN '".$inicio."' AND '".$final."' AND re.id_servicio = se.id_servicio and pa.id_paciente = re.id_paciente and se.clave = '".$datito."' ";
		$datos = $u->GetDatosSql($sql);
		$prifefu = 0; $prifede = 0; $primafu = 0; $primade = 0;
		$segfefu = 0; $segfede = 0; $segmafu = 0; $segmade = 0;
		$terfefu = 0; $terfede = 0; $termafu = 0; $termade = 0;
		$cuafefu = 0; $cuafede = 0; $cuamafu = 0; $cuamade = 0;
		$quifefu = 0; $quifede = 0; $quimafu = 0; $quimade = 0;

		//VERIFICAMOS LA CANTIDADES DE DOSIS QUE DEBEN RECIBIR Y SACAMOS REPORTE SEGUN ELLO
		$sql = "SELECT nro_dosis as num FROM servicio WHERE clave = '".$datito."' ";
		$data = $u->GetDatosSql($sql);
		$ca = $data[0]->num;

		//sacamos reporte segun la cantidad de dosis
		if($ca == 1){
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

			$tbl = '<table cellspacing="0" cellpadding="1" border="1">';
				$tbl .= '<tr>
				        <td colspan="6" align="center"><b>VACUNACION '.$datito.'</b></td>
				        </tr>';
				$tbl .= '<tr>
				        <td></td>
						<td colspan="2" align="center">DENTRO DEL SERVICIO</td>
						<td colspan="2" align="center">FUERA DEL SERVICIO</td>
						<td></td>
				    	</tr>';
				$tbl .= '<tr>
				        <td align="center">DOSIS</td>
						<td align="center">FEMENINO</td>
						<td align="center">MASCULINO</td>
						<td align="center">FEMENINO</td>
						<td align="center">MASCULINO</td>
						<td align="center">TOTAL</td>
				    	</tr>';
				$tbl .= '<tr>
				        <td>De 1 a 5 años</td>
						<td>'.$prifede.'</td>
						<td>'.$primade.'</td>
						<td>'.$prifefu.'</td>
						<td>'.$primafu.'</td>
						<td>'.$totpri.'</td>
				    	</tr>';
				$tbl .= '<tr>
				        <td>De 6 a 65 años</td>
						<td>'.$segfede.'</td>
						<td>'.$segmade.'</td>
						<td>'.$segfefu.'</td>
						<td>'.$segmafu.'</td>
						<td>'.$totseg.'</td>
				    	</tr>';
				$tbl .= '<tr>
				        <td>Mayor a 65 años (Adulto mayor)</td>
						<td>'.$terfede.'</td>
						<td>'.$termade.'</td>
						<td>'.$terfefu.'</td>
						<td>'.$termafu.'</td>
						<td>'.$totter.'</td>
				    	</tr>';
				$tbl .= '<tr>
				        <td>TOTAL</td>
						<td>'.$totfede.'</td>
						<td>'.$totmade.'</td>
						<td>'.$totfefu.'</td>
						<td>'.$totmafu.'</td>
						<td>'.$total.'</td>
				    	</tr>';
			$tbl .= '</table>';

			$pdf->writeHTML($tbl, true, false, false, false, '');
		}
		else{
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

			$tbl = '<table cellspacing="0" cellpadding="1" border="1">';
				$tbl .= '<tr>
				        <td colspan="6" align="center"><b>VACUNACION '.$datito.'</b></td>
				        </tr>';
				$tbl .= '<tr>
				        <td></td>
						<td colspan="2" align="center">DENTRO DEL SERVICIO</td>
						<td colspan="2" align="center">FUERA DEL SERVICIO</td>
						<td></td>
				    	</tr>';
				$tbl .= '<tr>
				        <td align="center">DOSIS</td>
						<td align="center">FEMENINO</td>
						<td align="center">MASCULINO</td>
						<td align="center">FEMENINO</td>
						<td align="center">MASCULINO</td>
						<td align="center">TOTAL</td>
				    	</tr>';
				$tbl .= '<tr>
				        <td>1RA</td>
						<td>'.$prifede.'</td>
						<td>'.$primade.'</td>
						<td>'.$prifefu.'</td>
						<td>'.$primafu.'</td>
						<td>'.$totpri.'</td>
				    	</tr>';
				$tbl .= '<tr>
				        <td>2RA</td>
						<td>'.$segfede.'</td>
						<td>'.$segmade.'</td>
						<td>'.$segfefu.'</td>
						<td>'.$segmafu.'</td>
						<td>'.$totseg.'</td>
				    	</tr>';
				$tbl .= '<tr>
				        <td>3RA</td>
						<td>'.$terfede.'</td>
						<td>'.$termade.'</td>
						<td>'.$terfefu.'</td>
						<td>'.$termafu.'</td>
						<td>'.$totter.'</td>
				    	</tr>';
				$tbl .= '<tr>
				        <td>TOTAL</td>
						<td>'.$totfede.'</td>
						<td>'.$totmade.'</td>
						<td>'.$totfefu.'</td>
						<td>'.$totmafu.'</td>
						<td>'.$total.'</td>
				    	</tr>';
			$tbl .= '</table>';

			$pdf->writeHTML($tbl, true, false, false, false, '');
		}
	}
}
else{
	// create new PDF document
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION2, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

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

	$pdf->Write(0, 'Kardex de uso de insumos', '', 0, 'C', true, 0, false, false, 0);

	$pdf->SetFont('helvetica', '', 9);

	$sql = "SELECT * FROM enfermera WHERE id_enfermera = ".$_SESSION["id_enf"]." ";
	$datos = $u->GetDatosSql($sql);
	$nombre = $datos[0]->nombre." ".$datos[0]->paterno." ".$datos[0]->materno;

	// PROCESO DE GENERACION DE REPOTE PDF
	if($tipo == "vacunas"){
		$esp = $_POST["vac"];
		$sql = "SELECT * FROM insumos WHERE id_insumo = ".$esp." ";
		$datos = $u->GetDatosSql($sql);

		$tbl = '<table cellspacing="0" cellpadding="3">';
		$tbl .= '<tr>
		        <td>Responsable: ' . $nombre . '</td>
		        <td>Establecimiento: Consultorio Carrera de Enfermería - UMSA</td>
		        <td>Red de Servicio: </td>
		        </tr>';
		$tbl .= '<tr>
		        <td>Fecha de inicio: ' . $inicio . '</td>
		        <td>Fecha final: ' . $final . '</td>
		        <td>Tipo Reporte: ' . $tipo . '</td>
		    	</tr>';
		$tbl .= '<tr>
		        <td>Clave: ' . $datos[0]->clave . '</td>
		        <td>Nombre Insumo: ' . $datos[0]->nombre . '</td>
		        <td>Tipo de insumo: ' . $datos[0]->tipo . '</td>
		    	</tr>';
		$tbl .= '</table>';
		$pdf->writeHTML($tbl, true, false, false, false, '');
	
		$sql = "SELECT * FROM ingresoinsumos AS ing, salidainsumos AS sal WHERE sal.fec_reg BETWEEN '".$inicio."' AND '".$final."' AND sal.id_ingreso = ing.id_ingreso AND ing.id_insumo = ".$esp." ";
		$datos = $u->GetDatosSql($sql);
		$tbl = '<table cellspacing="0" cellpadding="3" border="1">';
		$tbl .= '<tr>
		        <td align="center"><b>Fec. Reg.</b></td>
		        <td align="center"><b>Sal. Ant.</b></td>
		        <td align="center"><b>Cant. Disp.</b></td>
		        <td align="center"><b>Cant. Egre.</b></td>
		        <td align="center"><b>FA</b></td>
		        <td align="center"><b>FR</b></td>
		        <td align="center"><b>FM</b></td>
		        <td align="center"><b>FE</b></td>
		        <td align="center"><b>Saldo</b></td>
		    </tr>';
		foreach($datos as $key => $dato) {
		    $tbl .= '<tr>
		        <td>' . $dato->fec_reg . '</td>
		        <td>' . $dato->sal_ant . '</td>
		        <td>' . $dato->cant_disp . '</td>
		        <td>' . $dato->cant_egre . '</td>
		        <td>' . $dato->fa . '</td>
		        <td>' . $dato->fr . '</td>
		        <td>' . $dato->fm . '</td>
		        <td>' . $dato->fe . '</td>
		        <td>' . $dato->saldo . '</td>
		    </tr>';
		}
		$tbl .= '</table>';
		$pdf->writeHTML($tbl, true, false, false, false, '');
	}
	else{
		$esp = $_POST["jer"];
		$sql = "SELECT * FROM insumos WHERE id_insumo = ".$esp." ";
		$datos = $u->GetDatosSql($sql);

		$tbl = '<table cellspacing="0" cellpadding="3">';
		$tbl .= '<tr>
		        <td>Responsable: ' . $nombre . '</td>
		        <td>Establecimiento: Consultorio Carrera de Enfermería - UMSA</td>
		        <td>Red de Servicio: </td>
		        </tr>';
		$tbl .= '<tr>
		        <td>Fecha de inicio: ' . $inicio . '</td>
		        <td>Fecha final: ' . $final . '</td>
		        <td>Tipo Reporte: ' . $tipo . '</td>
		    	</tr>';
		$tbl .= '<tr>
		        <td>Clave: ' . $datos[0]->clave . '</td>
		        <td>Nombre Insumo: ' . $datos[0]->nombre . '</td>
		        <td>Tipo de insumo: ' . $datos[0]->tipo . '</td>
		    	</tr>';
		$tbl .= '</table>';
		$pdf->writeHTML($tbl, true, false, false, false, '');
	
		$sql = "SELECT * FROM ingresoinsumos AS ing, salidainsumos AS sal WHERE sal.fec_reg BETWEEN '".$inicio."' AND '".$final."' AND sal.id_ingreso = ing.id_ingreso AND ing.id_insumo = ".$esp." ";
		$datos = $u->GetDatosSql($sql);
		$tbl = '<table cellspacing="0" cellpadding="3" border="1">';
		$tbl .= '<tr>
		        <td align="center"><b>Fec. Reg.</b></td>
		        <td align="center"><b>Sal. Ant.</b></td>
		        <td align="center"><b>Cant. Disp.</b></td>
		        <td align="center"><b>Cant. Egre.</b></td>
		        <td align="center"><b>Cant. Per.</b></td>
		        <td align="center"><b>Saldo</b></td>
		    </tr>';
		foreach($datos as $key => $dato) {
		    $tbl .= '<tr>
		        <td>' . $dato->fec_reg . '</td>
		        <td>' . $dato->sal_ant . '</td>
		        <td>' . $dato->cant_disp . '</td>
		        <td>' . $dato->cant_egre . '</td>
		        <td>' . $dato->cant_per . '</td>
		        <td>' . $dato->saldo . '</td>
		    </tr>';
		}
		$tbl .= '</table>';
		$pdf->writeHTML($tbl, true, false, false, false, '');
	}
}

//Close and output PDF document
$pdf->Output('Reporte_Produccion_Servicios.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>