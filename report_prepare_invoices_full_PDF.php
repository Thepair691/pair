<?php
session_start(); 	
ini_set('max_execution_time',6000); 
set_time_limit (6000);
ini_set('memory_limit', '-1');
include ("db.php") ;
include ("phpmkrfn.php");
require_once('./mpdf/mpdf.php');
ob_start();
$conn = phpmkr_db_connect(HOST, USER, PASS,DB);

$var=array_merge($_POST,$_GET);
extract($var);

print_r($_REQUEST);


$list = "IN ('".implode("','", $_REQUEST['checkbox_row'])."')";
		function check_name($dates,$st){
		$sql_brn="SELECT *  FROM  tb_typebrn where tb_typebrn.int_type ='".$dates."' ";
		$query=mysql_query($sql_brn);
		$row=mysql_fetch_array($query);
		
		if($st=='1'){
			if($dates=='SC'){
				return "�ٹ������� : 245 ��� 247 �.�ѵ�Ҹ����� �.����� �.���ͧ������� �.������� 11000 ";
			}else{
				return $row[brn_name] ." : ". $row[brn_add1] ;	
			}
		}else if($st=='2'){
			if($dates=='SC'){
				return "02-950-5000";	
			}else{
				return $row[brn_tel];	
			}
		}else if($st=='3'){
			if($dates=='SC'){
				return "02-950-5000 ��� 1309";	
			}else{
				return $row[tel_fax];	
			}
		}else if($st=='0'){
			if($dates=='SC'){
				return "SC";	
			}else{
				return $row[newtop_brn_code];	
			}
		}
	}
	function year_Date($date){
			$tmp_dates = split("/",$date); 
			$year=$tmp_dates[2]+543;
			return  $year_new=substr($year,2,2);
	}
	function getNameMonthFull($Month){
		if($Month == "1" || $Month == "01"){
			$strName = "���Ҥ�";
		}else if($Month == "2" || $Month == "02"){
			$strName = "����Ҿѹ��";
		}else if($Month == "3" || $Month == "03"){
			$strName = "�չҤ�";
		}else if($Month == "4" || $Month == "04"){
			$strName = "����¹";
		}else if($Month == "5" || $Month == "05"){
			$strName = "����Ҥ�";
		}else if($Month == "6" || $Month == "06"){
			$strName = "�Զع�¹";
		}else if($Month == "7" || $Month == "07"){
			$strName = "�á�Ҥ�";	
		}else if($Month == "8" || $Month == "08"){
			$strName = "�ԧ�Ҥ�";
		}else if($Month == "9" || $Month == "09"){
			$strName = "�ѹ��¹";
		}else if($Month == "10"){
			$strName = "���Ҥ�";
		}else if($Month == "11"){
			$strName = "��Ȩԡ�¹";
		}else if($Month == "12"){
			$strName = "�ѹ�Ҥ�";
		}
		
		return $strName;
	}
	
	function getNameMonthfornumber($Month){
			if($Month == "1" || $Month == "01"){
			$strName = "�.�.";
		}else if($Month == "2" || $Month == "02"){
			$strName = "�.�.";
		}else if($Month == "3" || $Month == "03"){
			$strName = "��.�.";
		}else if($Month == "4" || $Month == "04"){
			$strName = "��.�.";
		}else if($Month == "5" || $Month == "05"){
			$strName = "�.�.";
		}else if($Month == "6" || $Month == "06"){
			$strName = "��.�";
		}else if($Month == "7" || $Month == "07"){
			$strName = "�.�.";	
		}else if($Month == "8" || $Month == "08"){
			$strName = "�.�.";
		}else if($Month == "9" || $Month == "09"){
			$strName = "�.�.";
		}else if($Month == "10"){
			$strName = "�.�.";
		}else if($Month == "11"){
			$strName = "�.�.";
		}else if($Month == "12"){
			$strName = "�.�.";
		}
		return $strName;
	}
	function SHOW_DMY($date){ //�������¹ 2 �.�. 2558	
			$d=explode("/",$date);
			$date=$d[0];
			$month=getNameMonthFull($d[1]);
			$year=$d[2]+543;
			return $date." ".$month." ".$year;		
	}
	function SHOW_DMY_MY($date){ //�������¹ 2 �.�. 2558	
			$d=explode("-",$date);
			$date=$d[2];
			$month=getNameMonthfornumber($d[1]);
			$year=$d[0]+543;
			$year_new=substr($year,2,2);
			return $date." ".$month." ".$year_new;		
	}
	function ConvertDate($date){
			$tmp_dates = split("/",$date); 
			return $tmp_dates[2]."-".$tmp_dates[1]."-".$tmp_dates[0] ;
	}
	function show_Date($date){
		$tmp_dates = split("-",$date); 
		return $tmp_dates[2]."/".$tmp_dates[1]."/".$tmp_dates[0] ;
	}
	function convert($number){ 
		$txtnum1 = array('�ٹ��','˹��','�ͧ','���','���','���','ˡ','��','Ỵ','���','�Ժ'); 
		$txtnum2 = array('','�Ժ','����','�ѹ','����','�ʹ','��ҹ','�Ժ','����','�ѹ','����','�ʹ','��ҹ'); 
		$number = str_replace(",","",$number); 
		$number = str_replace(" ","",$number); 
		$number = str_replace("�ҷ","",$number); 
		$number = explode(".",$number); 
		if(sizeof($number)>2){ 
			return '�ȹ������µ�ǹШ��'; 
			exit; 
		} 
		$strlen = strlen($number[0]); 
		$convert = ''; 
		for($i=0;$i<$strlen;$i++){ 
			$n = substr($number[0], $i,1); 
			if($n!=0){ 
				if($i==($strlen-1) AND $n==1){ $convert .= '���'; } 
				elseif($i==($strlen-2) AND $n==2){  $convert .= '���'; } 
				elseif($i==($strlen-2) AND $n==1){ $convert .= ''; } 
				else{ $convert .= $txtnum1[$n]; } 
				$convert .= $txtnum2[$strlen-$i-1]; 
			} 
		} 
	
		$convert .= '�ҷ'; 
		if($number[1]=='0' OR $number[1]=='00' OR 
		$number[1]==''){ 
		$convert .= '��ǹ'; 
		}else{ 
		$strlen = strlen($number[1]); 
		for($i=0;$i<$strlen;$i++){ 
		$n = substr($number[1], $i,1); 
			if($n!=0){ 
			if($i==($strlen-1) AND $n==1){$convert 
			.= '���';} 
			elseif($i==($strlen-2) AND 
			$n==2){$convert .= '���';} 
			elseif($i==($strlen-2) AND 
			$n==1){$convert .= '';} 
			else{ $convert .= $txtnum1[$n];} 
			$convert .= $txtnum2[$strlen-$i-1]; 
			} 
		} 
		$convert .= 'ʵҧ��'; 
		} 
	return $convert; 
	}
	$sql_cus = "SELECT * FROM  tb_cst_credit_gs  WHERE  tb_cst_credit_gs.cst_credit_id = '".$icomp_id."' ";
					$result_cus = mysql_query($sql_cus);
					$row_cus = mysql_fetch_array($result_cus);
					$tax = $row_cus[withholding_tax];


	$sql_pre_inv = "SELECT
										tb_pre_inv.pre_inv_id,
										tb_pre_inv.icomp_id,
										tb_pre_inv.brn_id,
										tb_pre_inv.inv_date,
					DATE_FORMAT(tb_pre_inv.inv_date , '%d/%m/%Y') As inv_date_show,
										tb_pre_inv.rgn_no,
										tb_pre_inv.job_gsj,
										tb_pre_inv.job_rep,
										tb_pre_inv.wry_amt,
										tb_pre_inv.detail_pre_inv,
										tb_pre_inv.ip_user_name,
										tb_pre_inv.insert_date_user_name,
										tb_pre_inv.run_brn_id,
										tb_pre_inv.run_year,
										tb_pre_inv.run_no,
										tb_pre_inv.run_pre_inv,
										tb_pre_inv.can_check,
										tb_pre_inv.tb_pre_inv_run_date_id
										FROM
										tb_pre_inv
										WHERE run_pre_inv $list
	
									";
				
				$result_pre_inv = mysql_query($sql_pre_inv);
				$num_pre_inv = mysql_num_rows($result_pre_inv);
			echo $sql_pre_inv;
				$i=0;
				while($row_pre_inv=mysql_fetch_array($result_pre_inv)){
					
					$wry_amt+=+$row_pre_inv[wry_amt]; 
					$inv_date_show[$i]=$row_pre_inv[inv_date];
					$inv_date[$i]=$row_pre_inv[inv_date_show];
					$brn[$i]  = $row_pre_inv[run_brn_id];
					$rgn_no_show[$i]=$row_pre_inv[rgn_no]; 
					$job_gsj_show[$i]=$row_pre_inv[job_gsj]; 
					$job_rep_show[$i]=$row_pre_inv[job_rep]; 
					$wry_amt_show[$i]=$row_pre_inv[wry_amt]; 
					$detail_pre_inv[$i]=$row_pre_inv[detail_pre_inv]; 
					$not_vat[$i] = $row_pre_inv[wry_amt]*100/107;
					$diff_vat[$i] = $row_pre_inv[wry_amt] -  $not_vat[$i] ;
					$cal_withholding_tax[$i] =  (($not_vat[$i] * $tax )/ 100);
					$total[$i] = $wry_amt_show[$i] - $cal_withholding_tax[$i];
					
					$i++;
				}
	
$header = " 
<body>
<table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\" >
<tr>
				<td width=\"5%\">&nbsp;</td>
				<td width=\"80%\">&nbsp;</td>
				<td width=\"5%\">&nbsp;</td>
				</tr>
				<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				</tr>
				<tr>
				<td>&nbsp;</td>
				<td align=\"center\"><span style=\"font-size: 20px; font-weight: bold;\">����ѷ ��µ�ҹ������ ����˹�����µ�� �ӡѴ</span></td>
				<td>&nbsp;</td>
				</tr>
				<tr>
				<td>&nbsp;</td>
				<td align=\"center\"><span style=\"font-size: 18px\">TOYOTA NONTHABURI TOYOTA' S DEALER CO.,LTD.</span></td>
				<td>&nbsp;</td>
				</tr>
				<tr>
				<td>&nbsp;</td>
				<td align=\"center\"><span style=\"font-size: 18px\">".check_name($brn_id,'1')."</span></td>
				<td>&nbsp;</td>
				</tr>
				<tr>
				<td>&nbsp;</td>
				<td align=\"center\"><span style=\"font-size: 18px\">�������١˹�� �ҹ��������� GS �� 02-097-9555  ��� 1327 (�Ե��쪭���) / FAX : 02-097-9555<br /> ��� 1309, Mobile: 086-377-0882</span></td>
				<td>&nbsp;</td>
				</tr>
				<tr>
				<td>&nbsp;</td>
				<td align=\"center\">&nbsp;</td>
				<td>&nbsp;</td>
				</tr>
				<tr>
				<td>&nbsp;</td>
				<td align=\"center\"><span style=\"font-weight: bold; font-size: 18px;\">���ػ��˹���ҧ���</span></td>
				<td>&nbsp;</td>
				</tr>

				<tr>
				<td>&nbsp;</td>
				<td align=\"center\">&nbsp;</td>
				<td>&nbsp;</td>
				</tr>
				<?  
					
				?>
				<tr>
				<td>&nbsp;</td>
				<td align=\"center\">
					<table width=\"800\" border=\"0\" align=\"left\" cellpadding=\"2\" cellspacing=\"2\">
						<tr>
							<td width=\"15%\">�����١���</td>
							<td>".$row_cus[cst_credit_name]."</td>
						</tr>
						<tr>
							<td>�������</td>
							<td>".$row_cus[cst_credit_address]."</td>
						</tr>
						<tr>
							<td>��</td>
							<td>".$row_cus[cst_credit_tel]."</td>
						</tr>
						<tr>
							<td colspan=\"2\">�Ţ��Шӵ�Ǽ�����������ҡ�&nbsp;&nbsp;".$row_cus[cst_Tax]."</td>
						</tr>
					</table>
				</td>
				<td>&nbsp;</td>
				</tr>
				<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				</tr>
				<tr>
				<td>&nbsp;</td>";

				$footer = " <td>&nbsp;</td>
							</tr>
							<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							</tr>
							<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							</tr>
							<tr>
							<td>&nbsp;</td>
							<td>
								<table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">
								<tr>
									<td width=\"46%\">����Ѻ�ҧ���........................................</td>
									<td width=\"19%\">&nbsp;</td>
									<td width=\"35%\">����ҧ���.................................................</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>��˹�����...........................................</td>
									<td>&nbsp;</td>
									<td>�ѹ���.......................................................</td>
								</tr>
								</table>
							</td>
							<td>&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr >
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
				  </tr>
				 
				
				</div>
				  ";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<title>Untitled Document</title>

<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	font-family: cordiaUPC;
	font-size: 12px;
	page-break-before: always;
}
	.border_all{ border:1px dashed #6C6C6C;}
	.border_all_Tnone{ border:1px dashed #6C6C6C; border-top:none;}
	.border_all_Bnone{ border:1px dashed #6C6C6C; border-bottom:none;}
	.border_TR{ border-top:1px dashed #6C6C6C;border-right:1px dashed #6C6C6C;}
	.border_TL{ border-top:1px dashed #6C6C6C;border-left:1px dashed #6C6C6C;}
	.border_BR{ border-bottom:1px dashed #6C6C6C;border-right:1px dashed #6C6C6C;}
	.border_BL{ border-bottom:1px dashed #6C6C6C; border-left:1px dashed #6C6C6C;}
	.border_t{ border-top:1px dashed #6C6C6C;}
	.border_b{ border-bottom:1px dashed #6C6C6C;}
	.border_r{ border-right:1px dashed #6C6C6C;}
	.border_l{ border-left:1px dashed #6C6C6C;}
</style>
</head>

<? 

echo   $num_page = ceil($num_pre_inv/20); 
 

for($z = 1 ;  $z <= $num_page; $z++){
	
	if($z == 1){
		$s = 0;
		$e = 20 ;
	}else{
		$s = $e;
		$e += 20 ;
	}

?>

 <?=$header?>

    <td>
		<table width="800" border="1" align="left" cellpadding="2" cellspacing="0">
		<tr>
			<td   align="center" style="font-weight: bold" >�ѹ���</td>
			<td   align="center" style="font-weight: bold" >����¹ö</td>
			<td   align="center" style="font-weight: bold" >���觫���</td>
			<td   align="center" style="font-weight: bold" >���˹��</td>
			<td   align="center" style="font-weight: bold" >�ӹǹ<br>�Թ��͹ VAT</td>
			<td   align="center" style="font-weight: bold" >����<br>��Ť������</td>
			<td   align="center" style="font-weight: bold" >�ӹǹ <br> �Թ��� VAT</td>
			<td   align="center" style="font-weight: bold" >�ѵ������</td>
			<td   align="center" style="font-weight: bold" >�ѡ <br>� ������</td>
			<td   align="center" style="font-weight: bold" >�ӹǹ�Թ <br>�����·�����</td>
		</tr>
	<? for($i  = $s; $i <= $e; $i++){ ?> 
			<tr>
			<td align="center"><?=($brn[$i] == "")? "&nbsp;" : SHOW_DMY_MY($inv_date_show[$i])?></td>
			<td align="center" ><?=$rgn_no_show[$i]?></td>
			<td align="center"><?=$job_gsj_show[$i]?></td>
			<td align="center"><?=$job_rep_show[$i]?></td>
			<td align="right"><?=($brn[$i] == "")? "&nbsp;" : number_format($not_vat[$i],2)?></td>
			<td align="right" ><?=($brn[$i] == "")? "&nbsp;" : number_format($diff_vat[$i],2)?></td>
			<td align="right" ><? if($wry_amt_show[$i]!=''){ echo number_format($wry_amt_show[$i],2);}?></td>
			<td align="center" ><?=($brn[$i] == "")? "&nbsp;" :$tax."%"?></td>
			<td align='right' ><?=($brn[$i] == "")? "&nbsp;" : number_format($cal_withholding_tax[$i],2)?></td>
			<td align='right'><?=($brn[$i] == "")? "&nbsp;" :number_format($total[$i],2)?></td>
			</tr>
		<? 
	$all_not_vat += $not_vat[$i];
	$all_diff_vat += $diff_vat[$i];
	$all_cal_withholding_tax += $cal_withholding_tax[$i];
	$all_total += $total[$i];
		
	}  
	
	?>
		<tr>
			<td align="center" colspan="6"><?=convert(number_format($all_total,2))?></td>

			<td align='right' ><?=number_format($wry_amt,2)?></td>
			<td align="center" ><?=$tax?>%</td>
			<td align='right'><?=number_format($all_cal_withholding_tax,2)?></td>
			<td align='right'><?= number_format($all_total,2)?></td>
		</tr>
		</table>
	</td>
   <?= $footer?>
</table>
<? 


} 	


?>
</body>
</html>
<?Php 
$html = ob_get_contents();
ob_end_clean();
// $html='<style>@page { margin: 0px; }</style> ';
$pdf = new mPDF('th', 'A4', '0', ''); //��õ�駤�ҡ�д�ɶ�ҵ�ͧ����ǵ�� �� A4 ����Ѻ ��ҵ�ͧ����ǹ͹��ҡѺ A4-L
$pdf = new mPDF('th',    // mode - default ''
 'A4',    // format - A4, for example, default ''
 0,     // font size - default 0
 '',    // default font family
 10,    // margin_left
 10,    // margin right
 10,     // margin top
 0,    // margin bottom
 0,     // margin header
 0,     // margin footer
 'P');  // L - landscape, P - portrait
$pdf->SetAutoFont();
$pdf->SetDisplayMode('fullpage');
//$pdf -> SetMargins(0,0,10);///////SetMargins (float lm, float tm, float rm)
//$pdf -> SetRightMargin(0);
//$pdf -> SetTopMargin(10);
//$pdf -> SetLeftMargin(0);
//$pdf ->SetAutoPageBreak(true,0);
$pdf->WriteHTML($html,0);
$pdf->Output(); 
?>    