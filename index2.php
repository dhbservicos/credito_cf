<?php	 
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/favicon.ico">
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
	<title>Atualização e Cadastro de Cupom Fiscal</title>
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.2.1/css/dataTables.bootstrap5.min.css">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/3.2.0/css/buttons.dataTables.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/3.2.0/css/buttons.bootstrap5.css">
	
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/autofill/2.7.0/css/autoFill.bootstrap5.min.css">
	<link rel="stylesheet" type="text/css" href="https://pn-ciamis.go.id/asset/DataTables/examples/resources/syntax/shCore.css">
	<link rel="stylesheet" type="text/css" href="https://pn-ciamis.go.id/asset/DataTables/examples/resources/demo.css">
	<style type="text/css" class="init">
	
	</style>

	<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.3.js"></script>
	<script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/2.2.1/js/dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/2.2.1/js/dataTables.bootstrap5.min.js"></script>
	
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/3.2.0/js/dataTables.buttons.js"></script>
  
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.bootstrap5.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.html5.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.print.js"></script>

	<script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
	<script type="text/javascript" language="javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
	<script type="text/javascript" language="javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
	
	<script type="text/javascript" language="javascript" src="https://pn-ciamis.go.id/asset/DataTables/examples/resources/syntax/shCore.js"></script>
	<script type="text/javascript" language="javascript" src="https://pn-ciamis.go.id/asset/DataTables/examples/resources/demo.js"></script>
<?php
if(isset($_GET['play']))
echo "<script>
$(document).ready(function() {
  // Abre o popup da página b.html assim que a página principal carregar
  window.open('b.html', 'popupWindow', 'width=600,height=400,resizable=yes,scrollbars=yes');
});
</script>";


?>	

</head>
<body class="dt-example">
	<div class="container">
	    
	    <div>Bom Dia, como vai vc?</div>
		<section>
			
		
			<table class="display nowrap w-100" width="100%" border="0">
			    <tr>
			        <td>
						<fieldset>
							<legend>Import And Export CSV file data</legend>
					</td>
			    </tr>
			    <tr>
			        <td>
						<form action="post.php<?php echo get_url($get_url_clean,$get_url_gmont,null,null,$get_url_mez,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa);?>" method="post" name="upload_excel" enctype="multipart/form-data">
						<input type="hidden" name="mount" value="<?php if(isset($_GET['mes'])) { echo $_GET['mes'];  } ?>" />
						<div class="row">
							<div  class="col-12">
								<div class="row">
									<label class="col-md-4 control-label" for="filebutton">Escolha a ação: </label>
									<div class="col-md-8">
										<input type="radio" name="radio" value="cadastro" checked> &nbsp; Cadastro</input> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
										<input type="radio" name="radio" value="atualiza"> &nbsp; Atualização</input>
									</div>
								</div>
								<div class="row">
									<label class="col-md-4 control-label" for="filebutton">Select File</label>
									<div class="col-md-8">
										<input type="file" name="file" id="file" class="input-large" required>
									</div>
								</div>
								<input type="hidden" name="sendf">
								<div class="row">
									<label class="col-md-4 control-label" for="singlebutton">Import data</label>
									<div class="col-md-8">
										<button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Upload</button>
									</div>
								</div>
							</div>
                        </div>
					</fieldset>
                </form>

					
					</td>
			    </tr>
			    <tr>
			        <td>
						<div class="row px-2">
							<div class="col-md-12"><br><br></div>
							<div class="col-md-2 col-sm-4 list-group-item">
							<select class="select_location">
								<option value="">Selecione</option>
								<option value="<?php echo get_url($get_url_clean,$get_url_gmont,$get_url_cpf,$get_url_cnpj,$get_url_mez,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,"2024",$get_url_doa);?>"<?php  if($get_url_ano == "2024") echo " selected";?>>Ano 24</option>
								<option value="<?php echo get_url($get_url_clean,$get_url_gmont,$get_url_cpf,$get_url_cnpj,$get_url_mez,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,"2025",$get_url_doa);?>"<?php  if($get_url_ano == "2025") echo " selected";?>>Ano 25</option>
							</select>
							</div>
							
							<div class="col-md-2 col-sm-4 list-group-item<?php if($get_url_nzero !== null)	echo " bg-info text-white"; ?>"><a <?php echo get_act("1","link",$get_url_nzero); ?>href="<?php if($get_url_nzero !== null)	echo get_url($get_url_clean,$get_url_gmont,$get_url_cpf,$get_url_cnpj,$get_url_mez,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,null,$get_url_ano,$get_url_doa);	else echo get_url($get_url_clean,$get_url_gmont,$get_url_cpf,$get_url_cnpj,$get_url_mez,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,true,$get_url_ano,$get_url_doa);?>"><input type="checkbox" id="link" name="zero"		value="zero"	<?php if($get_url_nzero	!== null)	echo "checked"; ?>> &nbsp; Non Zero</a>	</div>
							<div class="col-md-2 col-sm-4 list-group-item<?php if($get_url_rtorn !== null)	echo " bg-info text-white"; ?>"><a <?php echo get_act("1","link",$get_url_rtorn); ?>href="<?php if($get_url_rtorn !== null)	echo get_url($get_url_clean,$get_url_gmont,$get_url_cpf,$get_url_cnpj,$get_url_mez,$get_url_error,$get_url_valor,$get_url_credt,null,$get_url_nzero,$get_url_ano,$get_url_doa);	else echo get_url($get_url_clean,$get_url_gmont,$get_url_cpf,$get_url_cnpj,$get_url_mez,$get_url_error,$get_url_valor,$get_url_credt,true,$get_url_nzero,$get_url_ano,$get_url_doa);?>"><input type="checkbox" id="link" name="retorno"	value="retorno"	<?php if($get_url_rtorn	!== null)	echo "checked"; ?>> &nbsp; Retorno</a></div>
							<div class="col-md-2 col-sm-4 list-group-item<?php if($get_url_credt !== null)	echo " bg-info text-white"; ?>"><a <?php echo get_act("1","link",$get_url_credt); ?>href="<?php if($get_url_credt !== null)	echo get_url($get_url_clean,$get_url_gmont,$get_url_cpf,$get_url_cnpj,$get_url_mez,$get_url_error,$get_url_valor,null,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa);	else echo get_url($get_url_clean,$get_url_gmont,$get_url_cpf,$get_url_cnpj,$get_url_mez,$get_url_error,$get_url_valor,true,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa);?>"><input type="checkbox" id="link" name="credito"	value="credito"	<?php if($get_url_credt	!== null)	echo "checked"; ?>> &nbsp; Crédito</a></div>
							<div class="col-md-2 col-sm-6 list-group-item<?php if($get_url_valor !== null)	echo " bg-info text-white"; ?>"><a <?php echo get_act("1","link",$get_url_valor); ?>href="<?php if($get_url_valor !== null)	echo get_url($get_url_clean,$get_url_gmont,$get_url_cpf,$get_url_cnpj,$get_url_mez,$get_url_error,null,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa);	else echo get_url($get_url_clean,$get_url_gmont,$get_url_cpf,$get_url_cnpj,$get_url_mez,$get_url_error,true,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa);?>"><input type="checkbox" id="link" name="valor"		value="valor"	<?php if($get_url_valor	!== null)	echo "checked"; ?>> &nbsp; Valor</a></div>
							<div class="col-md-2 col-sm-6 list-group-item<?php if($get_url_error !== null)	echo " bg-info text-white"; ?>"><a <?php echo get_act("1","link",$get_url_error); ?>href="<?php if($get_url_error !== null)	echo get_url($get_url_clean,$get_url_gmont,$get_url_cpf,$get_url_cnpj,$get_url_mez,null,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa);	else echo get_url($get_url_clean,$get_url_gmont,$get_url_cpf,$get_url_cnpj,$get_url_mez,true,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa);?>"><input type="checkbox" id="link" name="error"		value="error"	<?php if($get_url_error	!== null)	echo "checked"; ?>> &nbsp; Error</a></div>	
						</div>
						<div class="row px-2">
							<div class="col-md-2 col-sm-4 list-group-item">
							<select class="select_doacao">
								<option value="<?php echo get_url($get_url_clean,$get_url_gmont,$get_url_cpf,$get_url_cnpj,$get_url_mez,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,null);?>">Selecione</option>
								<option value="<?php echo get_url($get_url_clean,$get_url_gmont,$get_url_cpf,$get_url_cnpj,$get_url_mez,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,"1");?>"<?php  if($get_url_doa == "1") echo " selected";?>>Cadastrado</option>
								<option value="<?php echo get_url($get_url_clean,$get_url_gmont,$get_url_cpf,$get_url_cnpj,$get_url_mez,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,"2");?>"<?php  if($get_url_doa == "2") echo " selected";?>>Doação</option>
								<option value="<?php echo get_url($get_url_clean,$get_url_gmont,$get_url_cpf,$get_url_cnpj,$get_url_mez,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,"3");?>"<?php  if($get_url_doa == "3") echo " selected";?>>Automático</option>
							</select>
							</div>
							
							<div class="col-md-2 col-sm-4 list-group-item<?php if($get_url_clean !== null)	echo " bg-info text-white"; ?>"><a <?php echo get_act("1","link",$get_url_clean); ?>href="<?php if($get_url_clean !== null)	echo get_url(null,$get_url_gmont,$get_url_cpf,$get_url_cnpj,$get_url_mez,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa);	else echo get_url(true,$get_url_gmont,$get_url_cpf,$get_url_cnpj,$get_url_mez,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa);?>"><input type="checkbox" id="link" name="clean"		value="clean"	<?php if($get_url_clean	!== null)	echo "checked"; ?>> &nbsp; Clean</a></div>
							<div class="col-md-2 col-sm-4 list-group-item<?php if($get_url_gmont !== null)	echo " bg-info text-white"; ?>"><a <?php echo get_act("1","link",$get_url_gmont); ?>href="<?php if($get_url_gmont !== null)	echo get_url($get_url_clean,null,$get_url_cpf,$get_url_cnpj,$get_url_mez,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa);	else echo get_url($get_url_clean,true,$get_url_cpf,$get_url_cnpj,$get_url_mez,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa);?>"><input type="checkbox" id="link" name="retorno"		value="retorno"	<?php if($get_url_gmont	!== null)	echo "checked"; ?>> &nbsp; Grl Mês</a></div>
							<div class="col-md-2 col-sm-4 list-group-item<?php if($get_url_credt !== null)	echo " bg-info text-white"; ?>"><a <?php echo get_act("1","link",$get_url_credt); ?>href="<?php if($get_url_credt !== null)	echo get_url($get_url_clean,$get_url_gmont,$get_url_cpf,$get_url_cnpj,$get_url_mez,$get_url_error,$get_url_valor,null,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa);	else echo get_url($get_url_clean,$get_url_gmont,$get_url_cpf,$get_url_cnpj,$get_url_mez,$get_url_error,$get_url_valor,true,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa);?>"><input type="checkbox" id="link" name="credito"		value="credito"	<?php if($get_url_credt	!== null)	echo "checked"; ?>> &nbsp; Crédito</a></div>
							<div class="col-md-2 col-sm-6 list-group-item<?php if($get_url_valor !== null)	echo " bg-info text-white"; ?>"><a <?php echo get_act("1","link",$get_url_valor); ?>href="<?php if($get_url_valor !== null)	echo get_url($get_url_clean,$get_url_gmont,$get_url_cpf,$get_url_cnpj,$get_url_mez,$get_url_error,null,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa);	else echo get_url($get_url_clean,$get_url_gmont,$get_url_cpf,$get_url_cnpj,$get_url_mez,$get_url_error,true,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa);?>"><input type="checkbox" id="link" name="valor"		value="valor"	<?php if($get_url_valor	!== null)	echo "checked"; ?>> &nbsp; Valor</a></div>
							<div class="col-md-2 col-sm-6 list-group-item<?php if($get_url_error !== null)	echo " bg-info text-white"; ?>"><a <?php echo get_act("1","link",$get_url_error); ?>href="<?php if($get_url_error !== null)	echo get_url($get_url_clean,$get_url_gmont,$get_url_cpf,$get_url_cnpj,$get_url_mez,null,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa);	else echo get_url($get_url_clean,$get_url_gmont,$get_url_cpf,$get_url_cnpj,$get_url_mez,true,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa);?>"><input type="checkbox" id="link" name="error"		value="error"	<?php if($get_url_error	!== null)	echo "checked"; ?>> &nbsp; Error</a></div>	
						</div>
							<div class="col-md-12"><br><br></div>
			        </td>
			    </tr>
			    <tr>
					<td>&nbsp;</td></tr>
			    <tr>
			        <td>
						<div class="row">
							<div  class="col-md-6"> 
								<div class="row px-2">
									<?php
										$meses = array(
											'01' => 'Janeiro',	'02' => 'Fevereiro','03' => 'Março',	'04' => 'Abril',	'05' => 'Maio',		'06' => 'Junho',
											'07' => 'Julho',	'08' => 'Agosto',	'09' => 'Setembro',	'10' => 'Outubro',	'11' => 'Novembro',	'12' => 'Dezembro');
										
										foreach ($meses as $num_mes => $mes) {
											echo " 
										<div class=\"list-group-item col-md-3".get_act($mes,"mes",$get_url_mez)."\"><a ".get_act($mes,"link",$get_url_mez)."href=\"";
											if(isset($_GET['mes'])) {
												if($mes == $_GET['mes']) {
													echo get_url($get_url_clean,$get_url_gmont,$get_url_cpf,$get_url_cnpj,null,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa);
												} else {
													echo get_url($get_url_clean,$get_url_gmont,$get_url_cpf,$get_url_cnpj,$mes,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa);
												}
											} else {
													echo get_url($get_url_clean,$get_url_gmont,$get_url_cpf,$get_url_cnpj,$mes,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa);
											}
											echo   "\"> " . $mes . "</a></div>";									
										}  ?>
								</div>
							</div>
							<div  class="col-md-6">
								<div class="row px-2">
								<?php 
									$i_ul = 1;
									$ano_user = $get_url_ano?$get_url_ano:"2024";
									if($get_url_ano !== null)
										$Sql_user = "SELECT DISTINCT(cpf_doador) FROM `csv_". $get_url_ano ."` where cpf_doador > 0 ";
									else 
										$Sql_user = "SELECT DISTINCT(cpf_doador) FROM `csv_2024` where cpf_doador > 0 ";
										
										$Sql_user .= "AND `data_insert` BETWEEN '" . 
										$ano_user."-".$mes_start."-01' AND '".$ano_user."-".$mes_end."-31' ";
									$Sql_user .= "ORDER BY `cpf_doador` ASC;";
									$result_user = mysqli_query($con, $Sql_user);
									while($row_user = mysqli_fetch_assoc($result_user)) {
										echo "<div class=\"list-group-item col-md-3 " . get_act($row_user['cpf_doador'],"cpf",$get_url_cpf) . "\"><a ".get_act($row_user['cpf_doador'],"link",$get_url_cpf)."href=\"";
										if(isset($_GET['cpf'])) {
											if($_GET['cpf'] !== $row_user['cpf_doador']) {
												echo get_url($get_url_clean,$get_url_gmont,$row_user['cpf_doador'],null,$get_url_mez,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa);
											} else {
												echo get_url($get_url_clean,$get_url_gmont,null,null,$get_url_mez,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa);
											}										
										} else {
											echo get_url($get_url_clean,$get_url_gmont,$row_user['cpf_doador'],null,$get_url_mez,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa);
										}
										echo  "\">" . $row_user['cpf_doador']."</a></div> 
									";
									} ?> 
								</div>
							</div>
						</div>					
			        </td>
			    </tr>
			    <tr>
			        <td>&nbsp;
			        </td>
			    </tr>
			</table>
			    
<?php

$S = array();
$Sql = "";
$Sqi = "";

if($get_url_ano !== null) $get_url_ano = $_GET['ano']; else $get_url_ano = "2024"; 
						$S[0] = "SELECT "; 							                                            // 0
						$S[1] = "csv_". $get_url_ano .".id, ";			 	                              // 1
if(($get_url_clean == null) && ($get_url_gmont == null)) 
						$S[2] = "count(*) as num, sum(credito) as credito, sum(valor) as valor, ";	// 2  
else 				$S[2] = "numero_nota as num, credito, valor, ";  					// 2
						
						$S[3] = "nome, `cpf_doador`, `cnpj_estabelecimento` ";			// 3
						$S[4] = "FROM `csv_".$get_url_ano."`, cadastro cad WHERE `csv_".$get_url_ano."`.cnpj_estabelecimento = cad.cnpj ";	// 4
if(($get_url_clean == null) && ($get_url_gmont == null)) 
						$S[5] = "AND `data_insert` BETWEEN '$get_url_ano-$mes_start-01' AND '$get_url_ano-$mes_end-31' ";
else						// 5
						$S[5] = "AND data_post = '".ref_mez($_GET['mes'])."' ";

if($get_url_cpf    !== null) { 	$S[6] = "AND `cpf_doador` = '$get_url_cpf' "; } else 		
if($get_url_cnpj   !== null) { 	$S[6] = "AND `cnpj_estabelecimento` = '$get_url_cnpj' "; } 				// 6

if($get_url_nzero  !== null) { 	$S[7] = "AND `credito` <> 0 "; } 								// 7
if($get_url_doa    !== null) { 	$S[8] = "AND `doacao` =  '$get_url_doa' "; } 
// 8
if(($get_url_clean == null) && ($get_url_gmont == null)) 
                        $S[9] = "group by `cpf_doador`, `cnpj_estabelecimento`";		// 9

if($get_url_cpf    !== null) {	$S[10] = "order by `cnpj_estabelecimento` ASC"; } else 
if($get_url_cnpj   !== null) {	$S[10] = "order by num DESC"; } else 
						$S[10] = "order by cnpj_estabelecimento ASC";					// 10
						$S[11] = "sum(credito) as credito, sum(valor) as valor ";

$Sql_a	= ['0','1','2','3','4','5','6','7','8','9','10'];
$Sql_b	= ['0','11',       '4','5','6','7','8'];


foreach ($Sql_a as $value) { if(isset($S[$value])) $Sql .= $S[$value]; }
foreach ($Sql_b as $value) { if(isset($S[$value])) $Sqi .= $S[$value]; }
	
if($get_url_error !== null) echo "
			<div class=\"demo-html col-12 bg-warning text-dark text-center\"><br><b>" . $Sql . "</b>&nbsp;<br><br></div><br><br>
			<div class=\"demo-html col-12 bg-warning text-dark text-center\"><br><b>" . $Sqi . "</b>&nbsp;<br><br></div><br><br>
			<div class=\"demo-html col-12 bg-warning text-dark text-center\"><br><b>" . $Sql_user . "</b>&nbsp;<br><br></div><br><br>
			";
	
    $result = mysqli_query($con, $Sql);  

    if (mysqli_num_rows($result) > 0) 
	{
		echo " 

		<table id=\"example\" class=\"display nowrap\" cellspacing=\"0\" width=\"100%\">
			<thead>
				<tr>
					<th>ID</th>";
if(($get_url_clean == null) && ($get_url_gmont == null)) { echo "\n\t\t\t\t\t<th>QTDE</th>"; } 
else { echo "\n\t\t\t\t\t<th>Nº Cupom</th>";  }
if($get_url_cpf == null) 	echo "\n\t\t\t\t\t<th>CPF Doador</th>";
if($get_url_cnpj == null) 	echo "\n\t\t\t\t\t<th>Estabelecimento</th>";

					echo "\n\t\t\t\t\t<th>Emitente</th>";
if($get_url_valor !== null)	echo "\n\t\t\t\t\t<th>Valor</th>";
if($get_url_credt !== null) echo "\n\t\t\t\t\t<th>Credito</th>"; 
if($get_url_rtorn !== null)	echo "\n\t\t\t\t\t<th>RPC</th>";
				echo " 
				</tr>
			</thead>
			
			<tbody>"; $i = 1;
			if($get_url_mez !== null) $get_mes = $get_url_mez; else $get_mes = null;
			while($row = mysqli_fetch_assoc($result))
			{
				// $credito = number_format(($row['credito'])/100, 2, ',', '.');
				echo " 
				<tr>
					<td>" . $i++ . "</td>
					<td>" . $row['num'] . "</td> ";
if($get_url_cpf 	== null) echo "<td><a href=\"".	get_url($get_url_clean,$get_url_gmont,$row['cpf_doador'],null,$get_mes,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa)."\">" . $row['cpf_doador']."</a></td>";
if($get_url_cnpj 	== null) echo "<td><a href=\"".	get_url($get_url_clean,$get_url_gmont,null,$row['cnpj_estabelecimento'],$get_mes,$get_url_error,$get_url_valor,$get_url_credt,$get_url_rtorn,$get_url_nzero,$get_url_ano,$get_url_doa)."\">" . $row['cnpj_estabelecimento']."</a></td>";
				echo " <td>" . $row['nome'] . "</td>";
if($get_url_valor !== null) echo "<td>" 	. number_format($row['valor'], 2, ',', '')."</td>";
if($get_url_credt !== null)	echo " <td>" 	. number_format($row['credito'], 2, ',', '')."</td>";
if($get_url_rtorn !== null) {
					echo " <td>";
						if($row['credito'] == 0) echo $row['credito']; else {						
							echo "" . number_format(($row['credito']/ $row['num']), 2, ',', '.');
							echo " - ";
							echo number_format(((($row['credito']/$row['num'])*100)/$row['credito']), 2, ',', '.') . "%";
						}
					echo "</td>";
					}
				echo "</tr>";
			}
			echo "<tfoot>
				<tr>
					<th>ID</th>";
if(($get_url_clean == null) || ($get_url_gmont == null)) 
					echo "\n\t\t\t\t\t<th>QTDE</th> "; Else echo "\n\t\t\t\t\t<th>Nº Cupom</th> "; 
if($get_url_cpf == null) 	echo "\n\t\t\t\t\t<th>CPF Doador</th>";
if($get_url_cnpj == null) 	echo "\n\t\t\t\t\t<th>Estabelecimento</th>";

					echo "\n\t\t\t\t\t<th>Emitente</th>";
if($get_url_valor !== null)	echo "\n\t\t\t\t\t<th>Valor</th>";
if($get_url_credt !== null) echo "\n\t\t\t\t\t<th>Credito</th>"; 
if($get_url_rtorn !== null)	echo "\n\t\t\t\t\t<th>RPC</th>";
				echo " 
				</tr>
			</tfoot>
				</tbody>
			</table>";
	}
?>
		</section>
	</div>
	<section>
		<div class="footer">
			<div class="gradient"></div>
			<div class="liner">
				<h2>Other examples</h2>
				<div class="epilogue">
					<p>Please refer to the <a href="http://www.datatables.net">DataTables documentation</a> for full information about its API properties and methods.<br>
					Additionally, there are a wide range of <a href="http://www.datatables.net/extensions">extensions</a> and <a href=
					"http://www.datatables.net/plug-ins">plug-ins</a> which extend the capabilities of DataTables.</p>
					<p class="copyright">DataTables designed and created by <a href="http://www.sprymedia.co.uk">SpryMedia Ltd</a> © 2007-2016<br>
					DataTables is licensed under the <a href="http://www.datatables.net/mit">MIT license</a>.</p>
				</div>
			</div>
		</div>
	</section>
	<script type="text/javascript" language="javascript" class="init">
	

$(document).ready(function() {
    $('#example').DataTable({
<?php	 
$nn = 0;
$ncv = 0;
$ncr = 0;
if(( $get_url_cpf == null ) && ( 	$get_url_cnpj == null )) $nn = 4; else
if(( $get_url_cpf !== null ) && ( 	$get_url_cnpj == null )) $nn = 3; else		
if(( $get_url_cpf == null ) && ( 	$get_url_cnpj !== null )) $nn = 3;
if(( $get_url_valor	!== null ) || ( $get_url_credt	!== null ))		{
echo "
		footerCallback: function (row, data, start, end, display) {
			let api = this.api();
	 
			let intVal = function (i) {
				return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
			};";

if( $get_url_valor !== null ) {
	$nn++; $ncv = $nn;
echo "
			Cupons = api.column(".$ncv.") .data() .reduce((a, b) => intVal(a) + intVal(b), 0);
			totalCp = Cupons / 100;
			const valorCupons = totalCp.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
			api.column(".$ncv.").footer().innerHTML = valorCupons;
		";
}

if( $get_url_credt	!== null )	{
	$nn++; $ncr = $nn;
echo "
			Credito = api.column(".$ncr.") .data() .reduce((a, b) => intVal(a) + intVal(b), 0);
			totalCr = Credito / 100;
			const valorCredito = totalCr.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
			api.column(".$ncr.").footer().innerHTML = valorCredito;
		";
}
if(( $get_url_valor !== null ) || ( $get_url_credt !== null )){  echo "},"; }
?> 
		"columnDefs": [
			{
				"render": function (data, type, row) {
					let value = parseFloat(data.toString().replace(',', '.'));
                    return 'R$ ' + value.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
				},
				"targets": <?php 
					if(( $get_url_valor !== null ) && ( $get_url_credt !== null )){  echo "["; } // else echo "'";
					if( $get_url_valor !== null ) {  echo $ncv; }
					if(( $get_url_valor !== null ) && ( $get_url_credt !== null )){  echo ", "; }
					if( $get_url_credt !== null ) {  echo $ncr; }
					if(( $get_url_valor !== null ) && ( $get_url_credt !== null )){  echo "]"; } // else echo "'";
				?> 
			}
		],
<?php } ?>		
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel',
            {
                extend: 'pdfHtml5',
                messageTop: 'This print was produced using the Print button for DataTables',
                orientation: 'portrait',
                pageSize: 'A4',
                customize: function (doc) {
                    doc.pageMargins = [12, 12, 12, 12];

                    // Create the header table
                    var headerTable = {
                        table: {
                            widths: [100, '*', 100], // Adjust widths as needed
                            body: [
                                [
                                    {
                                        text: 'INSTITUTO SEMEAR',
                                        style: 'tableHeader',
                                        colSpan: 3,
                                        bold: true,
                                        fontSize: 15,
                                        alignment: 'center' // Center the text
                                    }, {}, {}
                                ],
                                [
                                    {
                                        image: '', // Embed image as base64
                                        width: 100, // Set width and height for the image
                                        height: 100,
                                        alignment: 'center'
                                    },
                                    [
                                        {},
                                        {
                                            table: {
                                                body: [
                                                    ['Col1', 'Col2', 'Col3'],
                                                    ['1', '2', '3'],
                                                    ['1', '2', '3']
                                                ]
                                            },
                                            alignment: 'center'
                                        },
                                        {}
                                    ],
                                    {
                                        image: '', // Embed image as base64
                                        width: 100,
                                        height: 100,
                                        alignment: 'center'
                                    }
                                ],
                            ]
                        },
                        layout: 'noBorders', // Remove table borders
                        alignment: 'center', // Center the entire table
                        margin: [0, 0, 0, 10]  // Add some bottom margin
                    };

                    // Add the header table to the document content
                    doc.content.splice(0, 0, headerTable); // Insert at the beginning

                    // Style the table header (important: define styles *outside* customize function)
                    doc.styles.tableHeader = {
                        bold: true,
                        fontSize: 15,
                        color: 'black'
                    };

                    // Center the datatable content itself (if needed)
                    doc.content[1].alignment = 'center'; // Index 1 likely points to the datatable after the header is inserted. Adjust if needed.

                },
            },
            {
                extend: 'print',
                orientation: 'portrait',
                pageSize: 'A4',
                customize: function (win) {
                    $(win.document.body) .css('font-size', '10pt') .prepend( '<div style="text-align:left;font-size:18px"><br> <table><?php 
if($get_url_cpf !== null) 	echo "<tr><td>CPF do Parceiro: </td>    <td><b> &nbsp;$get_url_cpf</b></td>     </tr>"; else 
if($get_url_cnpj !== null) 	echo "<tr><td>Referente ao CNPJ: </td>  <td><b> &nbsp;$get_url_cnpj</b></td>    </tr>"; else 
                    echo "<tr><td colspan=\"2\">Relatório Geral de cupons e parceiros</td>  </tr>";
if($get_url_mez !== null)   echo "<tr><td>Referente ao periodo: </td>   <td><b> &nbsp;$get_url_mez / $get_url_ano</b><br></td>     </tr>";

					$resi = mysqli_query($con, $Sqi);
					$line = mysqli_fetch_assoc($resi);
					echo "<tr><td>Valor Total Cupons: </td><td><b> &nbsp;R$ "	.number_format($line['valor']/ 100, 2, ',', '.').	"</b><br></td>     </tr>";
					echo "<tr><td>Crédito Total Cupons: </td><td><b> &nbsp;R$ "	.number_format($line['credito']/ 100, 2, ',', '.').	"</b><br></td>     </tr>";
					echo "<tr><td colspan=\"2\">&nbsp;</td>     </tr>";
?></table></div>' );
                    $(win.document.body) .css('font-size', '10pt') .prepend( '<div style="text-align:center;"><h2>Instituto Semear</h2><br><br><br></div>' );

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');

                    // Cria a tabela para o cabeçalho de impressão
                    var headerTable = document.createElement('table');
                    headerTable.style.width = '100%'; // Largura total da página
                    // headerTable.style.height = '3428px'; // Largura total da página
                    headerTable.style.textAlign = 'center'; // Alinhamento centralizado
                    headerTable.style.borderCollapse = 'collapse'; // Evita espaçamento entre células

                    // Primeira linha com o título
                    var row1 = headerTable.insertRow();
                    var cell1 = row1.insertCell();
                    cell1.innerHTML = '&nbsp;'; // Título com tamanho de 24px
                    cell1.style.fontSize = '14px';
                    cell1.style.textAlign = 'center';
                    cell1.colSpan = 3; // Ocupa as três colunas

                    // Segunda linha com as imagens nas laterais
                    var row2 = headerTable.insertRow();

                    var cell2 = row2.insertCell();
                    var img1 = document.createElement('img');
                    img1.src = ''; // URL da primeira imagem
                    img1.style.width = '100px';
                    img1.style.height = '100px';
                    img1.style.display = 'block'; // Para evitar espaços em branco ao redor da imagem
                    img1.style.margin = '0 auto'; // Centralizar a imagem horizontalmente
                    cell2.appendChild(img1);
                    cell2.style.textAlign = 'center';
                    cell2.style.verticalAlign = 'middle';

                    var cell3 = row2.insertCell();
                    cell3.innerHTML = '<h1>INSTITUTO SEMEAR</h1>'; // Adicione conteúdo vazio ou customize conforme necessário
                    cell3.style.textAlign = 'center';
                    cell3.style.verticalAlign = 'middle';

                    var cell4 = row2.insertCell();
                    var img2 = document.createElement('img');
                    img2.src = ''; // URL da segunda imagem
                    img2.style.width = '100px';
                    img2.style.height = '100px';
                    img2.style.display = 'block'; // Para evitar espaços em branco ao redor da imagem
                    img2.style.margin = '0 auto'; // Centralizar a imagem horizontalmente
                    cell4.appendChild(img2);
                    cell4.style.textAlign = 'center';
                    cell4.style.verticalAlign = 'middle';

                    // Insere a tabela no cabeçalho da página de impressão
                    win.document.body.insertBefore(headerTable, win.document.body.firstChild);
                    
                    
                    // Cria o rodapé com as informações
                    var footerDiv = document.createElement('div');
                    footerDiv.style.width = '100%';
                    footerDiv.style.textAlign = 'left';
                    footerDiv.style.verticalAlign = 'bottom';
                    footerDiv.style.fontSize = '10pt';
                    footerDiv.style.marginTop = '50px'; // Adiciona uma margem superior ao rodapé
                    footerDiv.innerHTML = '<div style="align: left"><?php
                    echo "<table>";
                    echo "<tr><td><b>ID:</b></td><td>&nbsp;Linha de identificação</td></tr>";
if($get_url_clean == null)	echo "<tr><td><b>QTDE:</b></td><td>&nbsp;Quantidade de cupons refente ao CNPJ</td></tr>"; else
					echo "<tr><td><b>Nº Cupom:</b></td><td>&nbsp;Referente ao Número do Cupom Fiscal</td></tr>"; 


if($get_url_cpf !== null) 	echo "<tr><td><b>CPF:</b></td><td>&nbsp;Cadastro de Pessoa Física</td></tr>";
if($get_url_cnpj !== null) 	echo "<tr><td><b>CNPJ:</b></td><td>Cadastro Nacional de Pessoa Jurídica</td></tr>";

					echo "<tr><td><b>Emitente: </b></td><td>&nbsp;Razão Social da empresa</td></tr>";
if($get_url_valor !== null)	echo "<tr><td><b>Valor:</b></td><td>&nbsp;Somatório aproximado dos valores de todos os cupons gerados</td></tr>";
if($get_url_credt !== null) echo "<tr><td><b>Crédito:</b></td><td>&nbsp;Valor aproximado do total de créditos gerado pelos cupons</td></tr>"; 
if($get_url_rtorn !== null)	echo "<tr><td><b>RPC:</b></td><td>&nbsp;Retorno por Cupom( calculo médio: (credito/qtde)/100 )</td></tr>";

                    echo "</table></div>"; ?>';
                    
                    // Adiciona o rodapé ao corpo do documento
                    win.document.body.appendChild(footerDiv);
                    
                } }
        ]
    });
});

$('.select_location').on('change', function(){
   window.location = $(this).val();
});

$('.select_doacao').on('change', function(){
   window.location = $(this).val();
});
	</script>
</body>
</html>
