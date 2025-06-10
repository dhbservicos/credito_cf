<?php

include('connection.php');
$con = getdb();

if(isset($_GET['cpf'])) 	$get_url_cpf = $_GET['cpf'];		else 	{ $get_url_cpf = null;		}
if(isset($_GET['cnpj'])) 	$get_url_cnpj = $_GET['cnpj']; 		else 	{ $get_url_cnpj = null;		}

if(isset($_GET['mes'])) 	$get_url_mez = $_GET['mes']; 		else 	{ $get_url_mez = null;		}
if(isset($_GET['zero']))	$get_url_nzero = $_GET['zero'];		else 	{ $get_url_nzero = null;	}
if(isset($_GET['error'])) 	$get_url_error = $_GET['error']; 	else 	{ $get_url_error = null;	}
if(isset($_GET['valor'])) 	$get_url_valor = $_GET['valor']; 	else 	{ $get_url_valor = null;	}
if(isset($_GET['credito']))	$get_url_credt = $_GET['credito'];	else 	{ $get_url_credt = null;	}
if(isset($_GET['retorno']))	$get_url_rtorn = $_GET['retorno'];	else 	{ $get_url_rtorn = null;	}
if(isset($_GET['ano']))		$get_url_ano = $_GET['ano'];		else 	{ $get_url_ano = null;	}

$error_n = 0;
$error_d = null;


if(isset($_POST["Import"]))
	{
//    header('Content-Type: application/json');
	ini_set("display_errors",'1');
	$timer_start = time();
	
	$arquivo = $_FILES['file'];
	$nomeArquivo = $arquivo['name'];
	$caminhoTemporario = $arquivo['tmp_name'];
	$caminhoDestino = './uploads/' . date("Ymd-his") . "_" . $nomeArquivo ;
	$erro = $arquivo['error'];
	
	if ($erro !== UPLOAD_ERR_OK) exit; 
	if (!move_uploaded_file($caminhoTemporario, $caminhoDestino)) exit; 
	
	$filename=$caminhoDestino;
	$fcount = count(file($filename)) - 1;
	
	$sql_res_file_a = "SELECT id FROM `csv_arquivos` Where nome = '".$nomeArquivo."'";
	$result_file_a = mysqli_query($con, $sql_res_file_a);
	$row_file_a = mysqli_fetch_assoc($result_file_a);
	
	if(!isset($row_file_a['id'])) {
		$sql = "INSERT into `csv_arquivos` ( nome, hash, quantidade ) values ('".$nomeArquivo."', '".hash_file('sha256', $caminhoDestino)."', '".$fcount."')";
		$result = mysqli_query($con, $sql);
		
		$sql_res_file_a = "SELECT id FROM `csv_arquivos` Where nome = '".$nomeArquivo."'";
		$result_file_a = mysqli_query($con, $sql_res_file_a);
		$row_file_a = mysqli_fetch_assoc($result_file_a);
	}
	
	$meses = array(
	'01' => 'Janeiro',	'02' => 'Fevereiro','03' => 'Março',	'04' => 'Abril',	'05' => 'Maio',		'06' => 'Junho',
	'07' => 'Julho',	'08' => 'Agosto',	'09' => 'Setembro',	'10' => 'Outubro',	'11' => 'Novembro',	'12' => 'Dezembro');
	if(isset($_POST['mount'])) { $post_mes = "_" . array_search($_POST['mount'],$meses); } else { $post_mes = null; }
	if($_FILES["file"]["size"] > 0)
	{
		$file = fopen($filename, "r");
		$bine = bin2hex(fread($file, 2));
		// echo $bine ."<hr>";
		if ($bine == '4efa')
		{
			$n = 0;
			$i = $fcount;
			//$buffer = str_repeat("\xE2\x80\x8B", 4096);
			if(!fgetcsv($file, 10000)) exit; 

			while (($getData = fgetcsv($file, 10000, ";")) !== FALSE)
			{
				if(is_numeric($getData[0])) 
				{
					$cupom_f = preg_replace("/[^A-Z_]/",'',$getData[7]);
					if( $cupom_f == 'DOACAO_AUTOMATICA') $doacao_cupom = 3; else 
					if( $cupom_f == 'DOACAO') $doacao_cupom = 2; else $doacao_cupom = 1;
	
				    $data_inc_dta = explode("/",$getData[2]);
				    $data_inc_ano = $data_inc_dta[2];
				    $data_inc_mes = $data_inc_dta[1];
				    $data_inc_dia = $data_inc_dta[0];
				    $data_inc_fmt = $data_inc_ano . "-" . $data_inc_mes . "-" . $data_inc_dia;
				    
				    $sql = "
				    select
				        case
				            When count(*) <> 1 then ':0'
				            When cpf_doador is null then ':1'
				            else ':2'
					    END as Result
					from
					    csv_".$data_inc_ano."
					where
					    cnpj_estabelecimento = '".$getData[8]."'
					AND
					    numero_nota = '".$getData[0]."'";


					$result = mysqli_query($con, $sql);

					$sqlb = Null;
					if(isset($result))
					{
						$row = mysqli_fetch_assoc($result);
						$valor_pd = preg_replace('/\D/','',$getData[1])/100;
						if($row['Result'] == ":0") {
        					$sql = "INSERT into csv_".$data_inc_ano." (
								numero_nota,
									data_post,
										data_insert,
											cpf_doador,
												valor,
												doacao,
													cnpj_estabelecimento,
														id_file ) values (
								'".$getData[0]."',
									'".$data_inc_mes."',
										'".$data_inc_fmt."',
											'".preg_replace('/\D/','',$getData[4])."',
											'". $valor_pd . "',
												'".$doacao_cupom."',
													'".preg_replace('/\D/','',$getData[8])."',
														'".$row_file_a['id']."')";
        					if(mysqli_query($con, $sql)) $i--; else echo $sql . "<br>\n";
							$n++;
						}
					} else {	
						$error_d .= " + \n\"Nota: " . preg_replace('/\D/','',$getData[0]) . " CPF: " . preg_replace('/\D/','',$getData[4]) . "\\n\"";		
						$error_n++;
					}
				}
			
				if(($n % 100) == 0) {
					ob_flush();
					flush();
					$timer_end = time() - $timer_start;
					echo "\nN: " . $n . " | I: " . $i . " | F: " .  $fcount . " | G: " . $getData[2] . " T: " . $timer_end ." \n<br>";
					
				}
			}
		}
		else if ($bine == "fffe")
		{
				if(fgetcsv($file, 10000)) echo $bine . "<br>";
			if(isset($_POST["radio"]) && ($_POST["radio"] === "atualiza"))
			{
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
						if($sqlb !== Null) { echo $sqlb . "<br>\n"; if(!mysqli_query($con, $sqlb)) { echo " error <br>\n"; } }
					}
				}
			} else 
			if(isset($_POST["radio"]) && ($_POST["radio"] === "cadastro")) 
			{
				$sqlQryArr = array();
				$r = 0;
				$n = 0;
				$i = 0;
				$l = 0;
				$c = $fcount;
				
				//$buffer = str_repeat("\xE2\x80\x8B", 4096);
				echo "Query: Qry: <br>\nLines: I: ".$c."<br>\nError: Err: <br>\nTime: Tme: Start:" . $timer_start ." <br>\n";
				fgetcsv($file, 10000, "\t");
				ob_start();
				echo "<table border=1>";
				while (($getData = fgetcsv($file, 10000, "\t")) !== false)
				{
					$l++;
					echo "<tr><td>".$l."</td><td>"
					. preg_replace('/\D/', '', $getData[0]) . "</td><td>"
					. preg_replace("/[^A-Za-z0-9.!?[:space:]]/","",$getData[1]) . "</td><td>"
					. preg_replace('/\D/', '', $getData[2]) . "</td><td>"
					. preg_replace("/[^0-9,]/", "", $getData[4]) . "</td><td>"
					. preg_replace('/[^0-9,]/', '', $getData[6]) . "</td>";
					
				    $csv_cnpj 	 = preg_replace('/\D/', '', $getData[0]);
					$numeroNota  = preg_replace('/\D/', '', $getData[2]);
					$dataInc 	 = preg_replace('/\D/', '', $getData[3]);
					$csv_valor   = preg_replace('/\D/', '', $getData[4]) / 100;
					$csv_credito = preg_replace('/\D/', '', $getData[6]) / 100;
					//$dInsert 	 = preg_replace('/\D/', '', $getData[3]);
					$dataIns	 = substr($dataInc, 4, 4). "-" . substr($dataInc, 2, 2) ."-" . substr($dataInc, 0, 2);

					if (is_numeric($csv_cnpj) && is_numeric($numeroNota))
					{						
						$anoTabela = substr($dataInc, 4, 4);
						$query = "
							SELECT *
							FROM csv_".$anoTabela."
							WHERE numero_nota = '".$numeroNota."'
							AND cnpj_estabelecimento = '".$csv_cnpj."'";
							
						if($result = mysqli_query($con, $query)) 
							if($result->num_rows == 1) {
								
								$row = mysqli_fetch_assoc($result);
								 echo "</tr><tr>
								 
								 <td>". $row['id'] . "</td>
								 <td>". $row['cnpj_estabelecimento'] . "</td>
								 <td>". $row['cpf_doador'] . "</td>
								 <td>". $row['numero_nota'] . "</td>
								 <td>". $row['valor'] . "</td>
								 <td>". $row['credito'] . "</td>
								 
								 \n";
								$csv_valor = preg_replace('/\D/', '', $getData[4]) / 100;
								$csv_credito = preg_replace('/\D/', '', $getData[6]) / 100;
								// preg_replace("/[^0-9.,]/","",$getData[6])
								if(isset($row['id']) && $row['id'] > 0) {
									$updateQuery = "
										UPDATE
											csv_".$anoTabela."
										SET
											valor = '".$csv_valor."',
											credito = '".$csv_credito."'
										WHERE
											id = '".$row['id']."'";
									if(mysqli_query($con, $updateQuery)) $n++; else echo $updateQuery . "<br>\n";
								}  else {
									$sqlQuery = "INSERT into csv_nocredt (
										cnpj_estabelecimento, 
										numero_nota, 
										valor, 
										credito,
										id_file ) values (
									'".$csv_cnpj."',
									'".$numeroNota."',
									'".$csv_valor."',
									'".$csv_credito."',
									'".$row_file_a['id']."')";
									if(mysqli_query($con, $sqlQuery)) $sqlQryArr[] = $sqlQuery; $r++;
								}
							} else
							if($result->num_rows > 1) {
								while($row = $result->fetch_assoc()) {
								 echo "</tr><tr>
								 
								 <td>". $row['id'] . "</td>
								 <td>". $row['cnpj_estabelecimento'] . "</td>
								 <td>". $row['cpf_doador'] . "</td>
								 <td>". $row['numero_nota'] . "</td>
								 <td>". $row['valor'] . "</td>
								 <td>". $row['credito'] . "</td>
								 
								 \n";
									
									
									
									$query_res2 = "
										SELECT id, numero_nota, cpf_doador
										FROM csv_".$anoTabela."
										WHERE id = '".$row['id']."'
										and valor = '".str_replace(",", ".", $row['valor'])."'";
									echo "</tr><tr><td colspan=6>" . $query_res2 . "</td>\n";
									$row1a = mysqli_query($con, $query_res2);
									$row2 = $row1a->fetch_assoc();
									
									if(isset($row['id']) && $row['id'] > 0 && ($row['valor'] == $csv_valor)) {
										$updateQuery = "
											UPDATE
												csv_".$anoTabela."
											SET
												credito 	= '".$csv_credito."'
											WHERE
												numero_nota = '".$row2['numero_nota']."' and
												cpf_doador 	= '".$row2['cpf_doador']."'  and
												valor 		= '".$row['valor']."' 		 and
												id 			= '".$row2['id']."'";
										if(mysqli_query($con, $updateQuery)) $n++; else 
										echo "</tr><tr><td colspan=6>".$query_res2 . "</td>\n";
										echo "</tr><tr><td colspan=6>".$updateQuery . "</td>\n";
									}  else {
										$sqlQuery = "INSERT into csv_nocredt (
											cnpj_estabelecimento, 
											numero_nota, 
											valor, 
											credito,
											id_file ) values (
										'".$csv_cnpj."',
										'".$numeroNota."',
										'".$csv_valor."',
										'".$csv_credito."',
										'".$row_file_a['id']."')";
										if(mysqli_query($con, $sqlQuery)) 
											$sqlQryArr[] = $sqlQuery; $r++;
									}
								}
								
							}
					}
					if($i > 99) {
						ob_flush();
						flush();
						$timer_end = time() - $timer_start;
						// echo "I: " . $i . " | Qry: " . $n . " | Err: " .  $r . " Tme: " . $timer_end ." <br>\n";
						$i = 0;						
					} else $i++;
				echo "</tr>\n";
				}
				echo "</table>\n";
				ob_end_flush();
				echo "<hr>";
				if(count($sqlQryArr) > 0) foreach ($sqlQryArr as $sqlEcho) { echo $sqlEcho . "<br>"; };
			}
		} else {
		}
		fclose($file);
	}
	echo "<hr>";
	echo "
	<!-- meta http-equiv=\"refresh\" content=\"2; url=index.php" . get_url($get_url_cpf,$get_url_cnpj,$get_url_mez,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano) . "&play\" / --><br>
	<h3>Fim da atualização, refaça o procedimento para validar se todos os cupons estão atualizados</h3><br>
	<a href=\"index.php" . get_url($get_url_cpf,$get_url_cnpj,$get_url_mez,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano) . "\">Retorno Index</a>";
}

function processBatch($con, $anoTabela, $dataBatch) {  }

function get_url($get_url_cpf,$get_url_cnpj,$get_url_mez,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano){
	$get_url = "?";
	$z = 0;
	
	if($get_url_cpf   !== null)	{ $get_url .= "cpf=".$get_url_cpf."";	$z++;} else 
	if($get_url_cnpj  !== null)	{ $get_url .= "cnpj=".$get_url_cnpj."";	$z++;}
	
	if($get_url_mez   !== null)	{ if($z > 0)  $get_url .= "&"; $get_url .= "mes=". 		$get_url_mez; 	$z++;}
	if($get_url_error !== null)	{ if($z > 0)  $get_url .= "&"; $get_url .= "error=".	$get_url_error;	$z++;}
	if($get_url_valor !== null)	{ if($z > 0)  $get_url .= "&"; $get_url .= "valor=".	$get_url_valor; $z++;}
	if($get_url_credt !== null)	{ if($z > 0)  $get_url .= "&"; $get_url .= "credito=".	$get_url_credt;	$z++;}
	if($get_url_rtorn !== null)	{ if($z > 0)  $get_url .= "&"; $get_url .= "retorno=".	$get_url_rtorn;	$z++;}
	if($get_url_nzero !== null)	{ if($z > 0)  $get_url .= "&"; $get_url .= "zero=".		$get_url_nzero;	$z++;}
	if($get_url_ano	  !== null)	{ if($z > 0)  $get_url .= "&"; $get_url .= "ano=".		$get_url_ano;	$z++;}
	return $get_url;	
}
?>