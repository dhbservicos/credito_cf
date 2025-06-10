<?php
include('connection.php');
$con = getdb();

if(isset($_GET['cpf'])) 	$get_url_cpf = $_GET['cpf'];		else 	{ $get_url_cpf = null;		}
if(isset($_GET['cnpj'])) 	$get_url_cnpj = $_GET['cnpj']; 		else 	{ $get_url_cnpj = null;		}
if(isset($_GET['clean'])) 	$get_url_clean = true; 			else 	{ $get_url_clean = null;	}

if(isset($_GET['mes'])) 	$get_url_mez = $_GET['mes']; 		else 	{ $get_url_mez 	 = null;	}
if(isset($_GET['gmont'])) 	$get_url_gmont = true;		 	else 	{ $get_url_gmont = null;	}
if(isset($_GET['error'])) 	$get_url_error = $_GET['error']; 	else 	{ $get_url_error = null;	}
if(isset($_GET['zero']))	$get_url_nzero = $_GET['zero'];		else 	{ $get_url_nzero = null;	}
if(isset($_GET['valor'])) 	$get_url_valor = $_GET['valor']; 	else 	{ $get_url_valor = null;	}
if(isset($_GET['credito']))	$get_url_credt = $_GET['credito'];	else 	{ $get_url_credt = null;	}
if(isset($_GET['retorno']))	$get_url_rtorn = $_GET['retorno'];	else 	{ $get_url_rtorn = null;	}
if(isset($_GET['ano']))		$get_url_ano = $_GET['ano'];		else 	{ $get_url_ano 	 = null;	}
if(isset($_GET['doa']))		$get_url_doa = $_GET['doa'];		else 	{ $get_url_doa 	 = null;	}

$dtmes = ref_mez($get_url_mez);
if(is_array($dtmes)) { $mes_start = $dtmes[0]; $mes_end = $dtmes[1]; } else { $mes_start = $dtmes; $mes_end = $dtmes; }

if(($get_url_cpf == null) || ($get_url_mez == null)) { unset($_GET['clean']); $get_url_clean = null; }
if(($get_url_cpf !== null) || ($get_url_mez == null)) { unset($_GET['gmont']); $get_url_gmont = null; }

$error_n = 0;
$error_d = null;

if(isset($_POST["Import"]))
{
	ini_set("display_errors",'1');
	$meses = array(
	'01' => 'Janeiro',	'02' => 'Fevereiro','03' => 'Março',	'04' => 'Abril',	'05' => 'Maio',		'06' => 'Junho',
	'07' => 'Julho',	'08' => 'Agosto',	'09' => 'Setembro',	'10' => 'Outubro',	'11' => 'Novembro',	'12' => 'Dezembro');
	if(isset($_POST['mount'])) { $post_mes = "_" . array_search($_POST['mount'],$meses); } else { $post_mes = null; }
	$filename=$_FILES["file"]["tmp_name"];
	if($_FILES["file"]["size"] > 0)
	{
		$file = fopen($filename, "r");
		$bine = bin2hex(fread($file, 2));
		echo $bine;
		if ($bine == '4efa')
		{

			while (($getData = fgetcsv($file, 10000, ";")) !== FALSE)
			{
				if(is_numeric($getData[0])) {
					$sql = "INSERT into csv".$post_mes." ( numero_nota, cpf_doador, cnpj_estabelecimento ) values (
					'".$getData[0]."', '".preg_replace('/\D/','',$getData[4])."', '".preg_replace('/\D/','',$getData[8])."')";
					$result = mysqli_query($con, $sql);
					if(!isset($result))
					{
						$error_d .= " + \n\"Nota: " . preg_replace('/\D/','',$getData[0]) . " CPF: " . preg_replace('/\D/','',$getData[4]) . "\\n\"";		
						$error_n++;
					}
				}
			}
				if($error_n > 0) {
					echo "<script type=\"text/javascript\"> alert(\"Estas Notas nao foram encontradas.\\n\"";
					echo $error_d . "); window.location = 'index.php". get_url($get_url_clean,null,null,$get_url_mez,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa) ."' </script>";
					exit;
				}
			echo "<script type=\"text/javascript\"> window.location = 'index.php" . get_url($get_url_clean,null,null,$get_url_mez,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa) . "' </script>";
		}
		else if ($bine == "fffe")
		{
			if(isset($_POST["radio"]) && ($_POST["radio"] === "atualiza")) {
				
				while (($getData = fgetcsv($file, 10000, "\t")) !== FALSE)
				{
					$sql = "select
					case
						WHen count(*) <> 1 then ':0'
						When nome is null then ':1'
						else ':2'
						END as Result
						from cadastro
					where 
					cnpj = '". preg_replace('/\D/','',$getData[0])	."'";
					$result = mysqli_query($con, $sql);
					
					echo $sql . "\n<br>";
					$sqlb = Null;
					if(isset($result))
					{
						$row = mysqli_fetch_assoc($result);
						if($row['Result'] == ":0") {
							$sqlb = "INSERT into cadastro ( cnpj, nome ) values ('" .
							preg_replace('/\D/','',$getData[0])	. "', '" .
							preg_replace("/[^A-Za-z0-9.!?[:space:]]/","",$getData[1]) . "')";
						} else
						if($row['Result'] == ":1") {
							$sqlb = "UPDATE cadastro SET nome = '" .
							preg_replace("/[^A-Za-z0-9.!?[:space:]]/","",$getData[1]) . "' WHERE cnpj = '" .
							preg_replace('/\D/','',$getData[0])	. "'";
						}

						if($sqlb !== Null) { if(mysqli_query($con, $sqlb)) { echo $sqlb . "\n<br>";} }
					}
				}
			} else 
			if(isset($_POST["radio"]) && ($_POST["radio"] === "cadastro")) 
			{
			$i = 1;
				while (($getData = fgetcsv($file, 10000, "\t")) !== FALSE)
				{
					if(is_numeric(intval($getData[0])) && is_numeric(preg_replace('/\D/','',$getData[2])))
					{
						$sql_a = " select id from csv".$post_mes." where numero_nota = '".preg_replace('/\D/','',$getData[2])."' and cnpj_estabelecimento = '".preg_replace('/\D/','',$getData[0])."'";
						$result = mysqli_query($con, $sql_a);
						$row = mysqli_fetch_assoc($result);
						if(!is_null($row['id']))
						{
							$sql_b = "
							UPDATE csv".$post_mes."
							SET valor 					= '" . preg_replace('/\D/','',$getData[4])	. "',
								credito 				= '" . preg_replace('/\D/','',$getData[6])	. "'
							WHERE numero_nota 			= '" . preg_replace('/\D/','',$getData[2])	. "'
							AND cnpj_estabelecimento 	= '" . preg_replace('/\D/','',$getData[0])	. "'
							AND id 						= '" . $row['id'] ."'";
							
							if(!mysqli_query($con, $sql_b)) {
								$error_d .= " + \\n\n\"Nota: " . preg_replace('/\D/','',$getData[2]) . " CNPJ: " . preg_replace('/\D/','',$getData[0]) . "\"";		
								$error_n++;
							} else {
								echo $i   . " A:" . $sql_a . "<br>\n";
								echo $i++ . " B:" . $sql_b . "<br>\n";
							}
						
						} else {
								echo $i++ . " A:" . $sql_a . "<br>\n";
							$error_d .= " + \n\"Nota: " . preg_replace('/\D/','',$getData[2]) . " CNPJ: " . preg_replace('/\D/','',$getData[0]) . "\\n\"";		
							$error_n++;
						}
					}
					unset($sql_a);
					unset($sql_b);
				}
				if($error_n > 0) {
					echo "<script type=\"text/javascript\"> alert(\"Estas Notas nao foram encontradas.\\n\"";
					echo $error_d . "); window.location = 'index.php". get_url($get_url_clean,null,null,$get_url_mez,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa) ."' </script>";
					exit;
				}
			}
		} else {
			echo "<script type=\"text/javascript\"> alert(\"Invalid File:Error Invalid CSV.<br>Insert Type CSV: " . $bine . "\"); window.location = \"index.php\"</script>";	exit;
		}
		echo "<script type=\"text/javascript\"> window.location = 'index.php" . get_url($get_url_clean,null,null,$get_url_mez,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa) . "' </script>";
		fclose($file);
	}
}

function get_url($get_url_clean,$get_url_gmont,$get_url_cpf,$get_url_cnpj,$get_url_mez,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa){
	$get_url = "?";
	$z = 0;
	
	if($get_url_cpf   !== null)	{ $get_url .= "cpf=".$get_url_cpf."";	$z++;} else 
	if($get_url_cnpj  !== null)	{ $get_url .= "cnpj=".$get_url_cnpj."";	$z++;}
	
	
	if($get_url_mez   !== null)	{ if($z > 0)  $get_url .= "&"; $get_url .= "mes=". 	$get_url_mez; 	$z++;}
	if($get_url_clean !== null)	{ if($z > 0)  $get_url .= "&"; $get_url .= "clean";			$z++;}
	if($get_url_gmont !== null)	{ if($z > 0)  $get_url .= "&"; $get_url .= "gmont";			$z++;}
	if($get_url_doa	  !== null)	{ if($z > 0)  $get_url .= "&"; $get_url .= "doa=".	$get_url_doa;	$z++;}
	if($get_url_error !== null)	{ if($z > 0)  $get_url .= "&"; $get_url .= "error=".	$get_url_error;	$z++;}
	if($get_url_valor !== null)	{ if($z > 0)  $get_url .= "&"; $get_url .= "valor=".	$get_url_valor; $z++;}
	if($get_url_credt !== null)	{ if($z > 0)  $get_url .= "&"; $get_url .= "credito=".	$get_url_credt;	$z++;}
	if($get_url_rtorn !== null)	{ if($z > 0)  $get_url .= "&"; $get_url .= "retorno=".	$get_url_rtorn;	$z++;}
	if($get_url_nzero !== null)	{ if($z > 0)  $get_url .= "&"; $get_url .= "zero=".	$get_url_nzero;	$z++;}
	if($get_url_ano	  !== null)	{ if($z > 0)  $get_url .= "&"; $get_url .= "ano=".	$get_url_ano;	$z++;}
	return $get_url;	
}
	

function clean_str($key) {
    $string = array("'", "\"", "!", "@", "#", "$", "%", "¨", "&", "*", "(", ")", "_", "+", "-", ".", ",", "\\", "|", "?", "/");
    return str_replace($string, "", $key);
}

function ref_mes($ref){
		$meses = array(
	'01' => 'Janeiro',	'02' => 'Fevereiro','03' => 'Março',	'04' => 'Abril',	'05' => 'Maio',		'06' => 'Junho',
	'07' => 'Julho',	'08' => 'Agosto',	'09' => 'Setembro',	'10' => 'Outubro',	'11' => 'Novembro',	'12' => 'Dezembro');
	if($ref == 1) {
		if(isset($_GET['mes'])) { return array_search($_GET['mes'],$meses); } else { return "01"; }
	}

}

function ref_mez($ref){
	$meses = array(
	'01' => 'Janeiro',	'02' => 'Fevereiro','03' => 'Março',	'04' => 'Abril',	'05' => 'Maio',		'06' => 'Junho',
	'07' => 'Julho',	'08' => 'Agosto',	'09' => 'Setembro',	'10' => 'Outubro',	'11' => 'Novembro',	'12' => 'Dezembro');
	if(isset($_GET['mes'])) { return array_search($ref,$meses); } else { return array("01","12"); }
}

function get_year_records(){
    $con = getdb();
	
if(isset($_GET['cpf'])) 	{ $get_url_cpf = $_GET['cpf'];		$get_url_cnpj = null;	}	else 
if(isset($_GET['cnpj'])) 	{ $get_url_cnpj = $_GET['cnpj'];	$get_url_cpf = null;	}	else {$get_url_cpf = null; $get_url_cnpj = null;}

if(isset($_GET['mes'])) 	$get_url_mez = $_GET['mes']; 		else 	{ $get_url_mez = null;		}
if(isset($_GET['zero'])) 	$get_url_nzero = $_GET['zero']; 	else 	{ $get_url_nzero = null;	}
if(isset($_GET['error'])) 	$get_url_error = $_GET['error']; 	else 	{ $get_url_error = null;	}
if(isset($_GET['valor'])) 	$get_url_valor = $_GET['valor']; 	else 	{ $get_url_valor = null	;	}
if(isset($_GET['credito']))	$get_url_credt = $_GET['credito'];	else 	{ $get_url_credt = null;	}
if(isset($_GET['retorno']))	$get_url_rtorn = $_GET['retorno'];	else 	{ $get_url_rtorn = null;	}
	

	
    $Sql = "SELECT csv". ref_mes(1).".id, ";
	if($get_url_clean !== null) $Sql .= "count(*) as num, sum(`credito`) as credito, "; else $Sql .= "numero_nota as num, credito, ";
	$Sql .= "nome, `cpf_doador`, `cnpj_estabelecimento`, ";
	if($get_url_valor !== null) $Sql .= ", sum(`valor`) as valor ";
    $Sql .= "FROM
	`csv". ref_mes(1) ."`, cadastro cad
WHERE
	`csv". ref_mes(1)."`.cnpj_estabelecimento = cad.cnpj ";
	if($get_url_cpf !== null) { $Sql .= "AND `cpf_doador` = '".$get_url_cpf."' "; } else 
	if($get_url_cnpj !== null) { $Sql .= "AND `cnpj_estabelecimento` = '".$get_url_cnpj."' "; } 
	if($get_url_nzero !== null) { $Sql .= "AND `credito` <> 0 "; } 
	$Sql .= "
group by
	`cpf_doador`, `cnpj_estabelecimento`";
	

	if($get_url_cpf !== null) { $Sql .= "order by `credito` DESC"; } else 
	if($get_url_cnpj !== null) { $Sql .= "order by num DESC"; } 
	
	if($get_url_error !== null) echo "<div class=\"row\"><div class=\"col-12 bg-warning text-dark text-center\"><br><b>" . $Sql . "</b>&nbsp;<br><br></div></div><br><br>";
	
    $result = mysqli_query($con, $Sql);  

    if (mysqli_num_rows($result) > 0) 
	{
		echo " 
	<div class='table-responsive w-100'>
		<table id='example' class='table table-striped table-bordered display nowrap' style='width:100%!important'>
			<thead>
				<tr>
					<th>ID</th>
					<th>QTDE</th> ";
if($get_url_cpf == null) 	echo "\n\t\t\t\t\t<th>CPF Doador</th>";
if($get_url_cnpj == null) 	echo "\n\t\t\t\t\t<th>Estabelecimento</th>";

					echo "\n\t\t\t\t\t<th>Emitente</th>";
if($get_url_get_url_valor !== null)	echo "\n\t\t\t\t\t<th>Valor</th>";
if($get_url_credt !== null) echo "\n\t\t\t\t\t<th>Credito</th>"; 
if($get_url_rtorn !== null)	echo "\n\t\t\t\t\t<th>Retorno por cupom</th>";
				echo "</tr>
			</thead>
			<tbody>"; $i = 1;
			if($get_mez !== null) $get_url_mes = $get_mez; else $get_url_mes = null;
			while($row = mysqli_fetch_assoc($result))
			{
				echo " 
				<tr>
					<td>" . $i++ . "</td>
					<td>" . $row['num'] . "</td> ";
if($get_url_cpf 	== null) echo "<td><a href=\"".	get_url($get_url_clean,$row['cpf_doador'],null,$get_url_get_mes,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa)."\">" . $row['cpf_doador']."</a></td>";
if($get_url_cnpj 	== null) echo "<td><a href=\"".	get_url($get_url_clean,null,$row['cnpj_estabelecimento'],$get_url_get_mes,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa)."\">" . $row['cnpj_estabelecimento']."</a></td>";
				echo " <td>" . $row['nome'] . "</td>";
if($get_url_valor !== null) echo "<td> R$ " 	. number_format($row['valor']/ 100, 2, ',', '.')."</td>";
if($get_url_credt !== null)	echo " <td> R$ " 	. number_format($row['credito']/ 100, 2, ',', '.')."</td>";
if($get_url_rtorn !== null) {
					echo " <td>";
						if($row['credito'] == 0) echo $row['credito']; else {						
							echo "R$ " . number_format(($row['credito']/ $row['num'])/100, 2, ',', '.');
							echo " - ";
							echo number_format(((($row['credito']/$row['num'])*100)/$row['credito']), 2, ',', '.') . "%";
						}
					echo "</td>";
					}
				echo "</tr>";
			}
			echo " 
			</tbody>
		</table>
	</div>";
	} else {
		echo "you have no recent pending orders";
	}
}

function get_all_records(){
    $con = getdb();
	
if(isset($_GET['cpf'])) 	{ $get_url_cpf = $_GET['cpf'];		$get_url_cnpj = null;	}	else 
if(isset($_GET['cnpj'])) 	{ $get_url_cnpj = $_GET['cnpj'];	$get_url_cpf = null;	}	else {$get_url_cpf = null; $get_url_cnpj = null;}

if(isset($_GET['mes'])) 	$get_url_mez = $_GET['mes']; 		else 	{ $get_url_mez = null;		}
if(isset($_GET['zero'])) 	$get_url_nzero = $_GET['zero']; 	else 	{ $get_url_nzero = null;	}
if(isset($_GET['error'])) 	$get_url_error = $_GET['error']; 	else 	{ $get_url_error = null;	}
if(isset($_GET['valor'])) 	$get_url_valor = $_GET['valor']; 	else 	{ $get_url_valor = null	;	}
if(isset($_GET['credito']))	$get_url_credt = $_GET['credito'];	else 	{ $get_url_credt = null;	}
if(isset($_GET['retorno']))	$get_url_rtorn = $_GET['retorno'];	else 	{ $get_url_rtorn = null;	}
		
    $Sql = "SELECT csv". ref_mes(1).".id, ";
	if($get_url_clean == null) $Sql .= "count(*) as num, sum(`credito`) as credito, "; else $Sql .= "numero_nota as num, credito, ";
	$Sql .= "nome, `cpf_doador`, `cnpj_estabelecimento`, ";
	if($get_url_valor !== null) $Sql .= ", sum(`valor`) as valor ";
    $Sql .= "FROM
	`csv". ref_mes(1) ."`, cadastro cad
WHERE
	`csv". ref_mes(1)."`.cnpj_estabelecimento = cad.cnpj ";
	if($get_url_cpf !== null) { $Sql .= "AND `cpf_doador` = '".$get_url_cpf."' "; } else 
	if($get_url_cnpj !== null) { $Sql .= "AND `cnpj_estabelecimento` = '".$get_url_cnpj."' "; } 
	if($get_url_nzero !== null) { $Sql .= "AND `credito` <> 0 "; } 
	$Sql .= "
group by
	`cpf_doador`, `cnpj_estabelecimento`";
	

	if($get_url_cpf !== null) { $Sql .= "order by `credito` DESC"; } else 
	if($get_url_cnpj !== null) { $Sql .= "order by num DESC"; } 	
	
	if($get_url_error !== null) echo "<div class=\"row\"><div class=\"col-12 bg-warning text-dark text-center\"><br><b>" . $Sql . "</b>&nbsp;<br><br></div></div><br><br>";
	
    $result = mysqli_query($con, $Sql);  

    if (mysqli_num_rows($result) > 0) 
	{
		echo " 
	<div class='table-responsive w-100'>
		<table id='example' class='table table-striped table-bordered display nowrap' style='width:100%!important'>
			<thead>
				<tr>
					<th>ID</th>
					<th>QTDE</th> ";
if($get_url_cpf == null) 	echo "\n\t\t\t\t\t<th>CPF Doador</th>";
if($get_url_cnpj == null) 	echo "\n\t\t\t\t\t<th>Estabelecimento</th>";

					echo "\n\t\t\t\t\t<th>Emitente</th>";
if($get_url_valor !== null)	echo "\n\t\t\t\t\t<th>Valor</th>";
if($get_url_credt !== null) echo "\n\t\t\t\t\t<th>Credito</th>"; 
if($get_url_rtorn !== null)	echo "\n\t\t\t\t\t<th>Retorno por cupom</th>";
				echo "</tr>
			</thead>
			<tbody>"; $i = 1;
			if($get_url_mez !== null) $get_mes = $get_url_mez; else $get_mes = null;
			while($row = mysqli_fetch_assoc($result))
			{
				
				echo " 
				<tr>
					<td>" . $i++ . "</td>
					<td>" . $row['num'] . "</td> ";
if($get_url_cpf 	== null) echo "<td><a href=\"".	get_url($get_url_clean,$row['cpf_doador'],null,$get_url_mes,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero)."\">" . $row['cpf_doador']."</a></td>";
if($get_url_cnpj 	== null) echo "<td><a href=\"".	get_url($get_url_clean,null,$row['cnpj_estabelecimento'],$get_url_get_mes,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero)."\">" . $row['cnpj_estabelecimento']."</a></td>";
				echo " <td>" . $row['nome'] . "</td>";
if($get_url_valor !== null) echo "<td> R$ " 	. number_format($row['valor']/ 100, 2, ',', '.')."</td>";
if($get_url_credt !== null)	echo " <td> R$ " 	. number_format($row['credito']/ 100, 2, ',', '.')."</td>";
if($get_url_rtorn !== null) {
					echo " <td>";
						if($row['credito'] == 0) echo $row['credito']; else {						
							echo "R$ " . number_format(($row['credito']/ $row['num'])/100, 2, ',', '.');
							echo " - ";
							echo number_format(((($row['credito']/$row['num'])*100)/$row['credito']), 2, ',', '.') . "%";
						}
					echo "</td>";
					}
				echo "</tr>";
			}
			echo " 
			</tbody>
		</table>
	</div>";
	} else {
		echo "you have no recent pending orders";
	}
}

function get_act($var,$get,$val){

	switch ($get) {
		case "cpf": if($var == $val){ return ' bg-success text-white'; } break;
		case "mes": if($var == $val){ return ' bg-success text-white'; } break;
		case "link": if($var == $val){ return 'class="text-white" '; }  break;
		default: return null;
	}
}
?>
