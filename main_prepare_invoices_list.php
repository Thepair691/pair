<?php
session_start(); 	
ini_set('max_execution_time',6000); 
set_time_limit (6000);
ini_set('memory_limit', '-1');
date_default_timezone_set("Asia/Bangkok");
include ("db.php") ;
include ("phpmkrfn.php");
$conn = phpmkr_db_connect(HOST, USER, PASS,DB);
$vars = array_merge($_POST,$_GET);
extract($vars);
echo "pair5555";

function check_name($dates,$st){
		$sql_brn="SELECT *  FROM  tb_typebrn where tb_typebrn.int_type ='".$dates."' ";
		$query=mysql_query($sql_brn);
		$row=mysql_fetch_array($query);
		if($st=='1'){
			if($dates=='99'){
				return "ปูนซิเมนต์ : 245 และ 247 ถ.รัตนาธิเบศร์ ต.กระสอ อ.เมืองนนทบุรี จ.นนทบุรี 11000 ";
			}else{
				return $row[brn_name] ." : ". $row[brn_add1] ;	
			}
		}else if($st=='2'){
			if($dates=='99'){
				return "02-950-5000";	
			}else{
				return $row[brn_tel];	
			}
		}else if($st=='3'){
			if($dates=='99'){
				return "02-950-5000 ต่อ 1309";	
			}else{
				return $row[tel_fax];	
			}
		}else if($st=='0'){
			if($dates=='99'){
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
			$strName = "มกราคม";
		}else if($Month == "2" || $Month == "02"){
			$strName = "กุมภาพันธ์";
		}else if($Month == "3" || $Month == "03"){
			$strName = "มีนาคม";
		}else if($Month == "4" || $Month == "04"){
			$strName = "เมษายน";
		}else if($Month == "5" || $Month == "05"){
			$strName = "พฤษภาคม";
		}else if($Month == "6" || $Month == "06"){
			$strName = "มิถุนายน";
		}else if($Month == "7" || $Month == "07"){
			$strName = "กรกฏาคม";	
		}else if($Month == "8" || $Month == "08"){
			$strName = "สิงหาคม";
		}else if($Month == "9" || $Month == "09"){
			$strName = "กันยายน";
		}else if($Month == "10"){
			$strName = "ตุลาคม";
		}else if($Month == "11"){
			$strName = "พฤศจิกายน";
		}else if($Month == "12"){
			$strName = "ธันวาคม";
		}
		
		return $strName;
	}
	
	function getNameMonthfornumber($Month){
			if($Month == "1" || $Month == "01"){
			$strName = "ม.ค.";
		}else if($Month == "2" || $Month == "02"){
			$strName = "ก.พ.";
		}else if($Month == "3" || $Month == "03"){
			$strName = "มี.ค.";
		}else if($Month == "4" || $Month == "04"){
			$strName = "เม.ษ.";
		}else if($Month == "5" || $Month == "05"){
			$strName = "พ.ค.";
		}else if($Month == "6" || $Month == "06"){
			$strName = "มิ.ย";
		}else if($Month == "7" || $Month == "07"){
			$strName = "ก.ค.";	
		}else if($Month == "8" || $Month == "08"){
			$strName = "ส.ค.";
		}else if($Month == "9" || $Month == "09"){
			$strName = "ก.ย.";
		}else if($Month == "10"){
			$strName = "ต.ค.";
		}else if($Month == "11"){
			$strName = "พ.ย.";
		}else if($Month == "12"){
			$strName = "ธ.ค.";
		}
		return $strName;
	}
	function SHOW_DMY($date){ //การเปลี่ยน 2 พ.ย. 2558	
			$d=explode("/",$date);
			$date=$d[0];
			$month=getNameMonthFull($d[1]);
			$year=$d[2]+543;
			return $date." ".$month." ".$year;		
	}
	function SHOW_DMY_MY($date){ //การเปลี่ยน 2 พ.ย. 2558	
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
		$txtnum1 = array('ศูนย์','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ'); 
		$txtnum2 = array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน'); 
		$number = str_replace(",","",$number); 
		$number = str_replace(" ","",$number); 
		$number = str_replace("บาท","",$number); 
		$number = explode(".",$number); 
		if(sizeof($number)>2){ 
			return 'ทศนิยมหลายตัวนะจ๊ะ'; 
			exit; 
		} 
		$strlen = strlen($number[0]); 
		$convert = ''; 
		for($i=0;$i<$strlen;$i++){ 
			$n = substr($number[0], $i,1); 
			if($n!=0){ 
				if($i==($strlen-1) AND $n==1){ $convert .= 'เอ็ด'; } 
				elseif($i==($strlen-2) AND $n==2){  $convert .= 'ยี่'; } 
				elseif($i==($strlen-2) AND $n==1){ $convert .= ''; } 
				else{ $convert .= $txtnum1[$n]; } 
				$convert .= $txtnum2[$strlen-$i-1]; 
			} 
		} 
	
		$convert .= 'บาท'; 
		if($number[1]=='0' OR $number[1]=='00' OR 
		$number[1]==''){ 
		$convert .= 'ถ้วน'; 
		}else{ 
		$strlen = strlen($number[1]); 
		for($i=0;$i<$strlen;$i++){ 
		$n = substr($number[1], $i,1); 
			if($n!=0){ 
			if($i==($strlen-1) AND $n==1){$convert 
			.= 'เอ็ด';} 
			elseif($i==($strlen-2) AND 
			$n==2){$convert .= 'ยี่';} 
			elseif($i==($strlen-2) AND 
			$n==1){$convert .= '';} 
			else{ $convert .= $txtnum1[$n];} 
			$convert .= $txtnum2[$strlen-$i-1]; 
			} 
		} 
		$convert .= 'สตางค์'; 
		} 
	return $convert; 
	}

    if(1==1){
		
	}
	if($status == "sent"){


		
		$sql_chk ="SELECT
		tb_pre_inv.run_pre_inv, 
		tb_pre_inv.sent_status,
		tb_pre_inv.tb_pre_inv_filename0,
		tb_pre_inv.tb_pre_inv_filename1,
		tb_pre_inv.tb_pre_inv_filename2,
		tb_pre_inv.tb_pre_inv_filename3,
		tb_pre_inv.tb_pre_inv_filename4
		FROM
		tncc_db.tb_pre_inv
		WHERE
		tb_pre_inv_run_date_id = '$tb_pre_inv_run_date_id'

		
		";
		
		$result = mysql_query($sql_chk);
		$num = mysql_num_rows($result);
		$arr = mysql_fetch_assoc($result);	
		if($arr[run_pre_inv] != "" && ( $arr[tb_pre_inv_filename0] != "" ||$arr[tb_pre_inv_filename1] != "" ||$arr[tb_pre_inv_filename2] != "" ||$arr[tb_pre_inv_filename3] != "" ||$arr[tb_pre_inv_filename4] != "" ) ){
			$update = " UPDATE tb_pre_inv_run_date SET

			tb_pre_inv_run_date.sent_status = 'Y',
			tb_pre_inv_run_date.sent_ip_user_name = '".$_SERVER['REMOTE_ADDR']."',
			tb_pre_inv_run_date.sent_user_name = '".$_SESSION['username']."',
			tb_pre_inv_run_date.sent_fn_time = '".date('Y-m-d H:i:s')."'
			WHERE
			tb_pre_inv_run_date.run_date_pre_inv = '$run_id'
			AND icomp_id = '$icomp_id'
			AND run_date_brn_id = '$run_brn_id'
			";
			$update_2 = " UPDATE tb_pre_inv SET

			tb_pre_inv.sent_status = 'Y',
			tb_pre_inv.sent_ip_user_name = '".$_SERVER['REMOTE_ADDR']."',
			tb_pre_inv.sent_user_name = '".$_SESSION['username']."',
			tb_pre_inv.sent_fn_time = '".date('Y-m-d H:i:s')."'
			WHERE
			tb_pre_inv.run_pre_inv = '$run_id'
			AND tb_pre_inv.icomp_id = '$icomp_id'
			AND tb_pre_inv.brn_id = '$run_brn_id' ";
		if(mysql_query($update)){
		
			if(mysql_query($update_2)){
				echo 1;
			} else {
				echo $update_2;
			}
				echo 1;
		} else {
			echo $update ." 1 ";
		}
		} else {
			if($arr[run_pre_inv] == ""){
				echo 3;
			}else if( $arr[tb_pre_inv_filename0] == "" ||$arr[tb_pre_inv_filename1] == "" ||$arr[tb_pre_inv_filename2] == "" ||$arr[tb_pre_inv_filename3] == "" ||$arr[tb_pre_inv_filename4] == "" ){
				echo 5;
			}
		}
	exit;
	}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<title>Untitled Document</title>
<script type="text/javascript" src="js/jquery-1.4.2.js"></script>
<script>

$(function(){
	 var h=$(document).height();
	 parent.windowHeight(h+10);	
});
</script>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	font-family: "MS Sans Serif";
	font-size:14px;
}
</style>
</head>
<body>
<?   //การหาเลข run		
if($type=='s_add'){
						$sql_run = "SELECT
									tb_pre_inv_run.run_pre_inv_id,
									tb_pre_inv_run.run_year,
									tb_pre_inv_run.run_no
									FROM
									tb_pre_inv_run
									WHERE
									tb_pre_inv_run.run_year = '".date('Y')."' 
									AND tb_pre_inv_run.run_int_type = '".$brn_id."'
									";
						$query_run=mysql_query($sql_run);
						$num_run=mysql_num_rows($query_run);
						$record_run=mysql_fetch_array($query_run);
						if($num_run=="" || $num_run<=0){
							$sql_check="INSERT INTO tb_pre_inv_run SET	";
							$where=" ";
							$number_no=1;
						}else{
							$sql_check="update tb_pre_inv_run SET	";
							$where=" where tb_pre_inv_run.run_year='".date('Y')."' AND tb_pre_inv_run.run_int_type  = '".$brn_id."' ";
							$number_no=$record_run[run_no]+1;
						}   
							$sql_check.=" tb_pre_inv_run.run_year='".date('Y')."', ";
							$sql_check.=" tb_pre_inv_run.run_no='".$number_no."', ";
							$sql_check.=" tb_pre_inv_run.run_int_type='".$brn_id."' ";
							$sql_check.=" $where";
						//echo 	$type."-->".$sql_check;
						$query_check=mysql_query($sql_check);
						$number_no_NEW=sprintf("%04d",$number_no);	
					
					
						$run_date_pre_inv = check_name($brn_id,0).year_Date($srec_date)."/".$number_no_NEW;
						$sql_in = "INSERT INTO tb_pre_inv_run_date SET 
									tb_pre_inv_run_date.run_date_brn_id = '".$brn_id."' ,
									tb_pre_inv_run_date.run_date_year = '".date('Y')."' ,
									tb_pre_inv_run_date.run_date_no = '".$number_no_NEW."',
									tb_pre_inv_run_date.run_date_pre_inv = '".$run_date_pre_inv."' ,
									tb_pre_inv_run_date.icomp_id = '".$icomp_id."' ,
									tb_pre_inv_run_date.inv_date = '".ConvertDate($srec_date)."' 
									";	
						$query_in=mysql_query($sql_in);
						
}
?>
 <form action="report_prepare_invoices_full_PDF.php" target="_blank" method='POST'>
	 <input type="hidden" name="srec_date" value="<?=$srec_date ?>">
	 <input type="hidden" name="brn_id" value="<?=$brn_id ?>">
	 <input type="hidden" name="icomp_id" value="<?=$icomp_id ?>">

<center><input type="button" id='print_all' onclick="submit_btn()" value="พิมพ์รวม"></center>
<table width="90%" border="1" align="center">

  <tr>
    <td width="4%" align="center" bgcolor="#F0F0F0" style="font-weight: bold">ลำดับ</td>
    <td width="9%" align="center" bgcolor="#F0F0F0" style="font-weight: bold">เลขที่ใบวางบิล</td>
    <td width="7%" align="center" bgcolor="#F0F0F0" style="font-weight: bold">สาขา</td>
    <td width="9%" align="center" bgcolor="#F0F0F0" style="font-weight: bold">วันที่</td>
    <td width="40%" align="center" bgcolor="#F0F0F0" style="font-weight: bold">ชื่อบริษัท</td>
    <td width="6%" align="center" bgcolor="#F0F0F0" style="font-weight: bold">พิมพ์   <input type="checkbox" name="select-all" id="select-all" ></td>
    <td width="8%" align="center" bgcolor="#F0F0F0" style="font-weight: bold">เพิ่ม JOB/รายละเอียดบิล</td>
    <td width="5%" align="center" bgcolor="#F0F0F0" style="font-weight: bold">ยกเลิก</td>
	<td width="10%" align="center" bgcolor="#F0F0F0" style="font-weight: bold">ส่งงานไปยังแผนกลูกหนี้</td>
  </tr>
  <?
  $sql="SELECT
				tb_pre_inv_run_date.tb_pre_inv_run_date_id,
				tb_pre_inv_run_date.run_date_brn_id,
				tb_pre_inv_run_date.run_date_year,
				tb_pre_inv_run_date.run_date_no,
				tb_pre_inv_run_date.run_date_pre_inv,
				tb_pre_inv_run_date.icomp_id,
				tb_pre_inv_run_date.inv_date,
				tb_cst_credit_gs.cst_credit_name,
				tb_pre_inv_run_date.can_checkinv,
				tb_pre_inv_run_date.sent_status,
				DATE_FORMAT(tb_pre_inv_run_date.sent_fn_time, '%d/%m/%Y-%H:%i:%s') AS sent_fn_time
				FROM
				tb_pre_inv_run_date
				LEFT JOIN tb_cst_credit_gs ON tb_pre_inv_run_date.icomp_id = tb_cst_credit_gs.cst_credit_id
				WHERE 1  ";
	if($icomp_id!=''){			
		$sql .=" AND tb_pre_inv_run_date.icomp_id = '".$icomp_id."'  ";		
	}
	if($brn_id!=''){			
	 	$sql .=" AND tb_pre_inv_run_date.run_date_brn_id = '".$brn_id."'  ";	
	}
	if($srec_date!=''){			
	 	$sql .=" AND tb_pre_inv_run_date.inv_date BETWEEN  '".ConvertDate($srec_date)."' AND '".ConvertDate($srec_date)."'   ";			
	}

	$query=mysql_query($sql);
	$i=0;
	while($row=mysql_fetch_assoc($query)){
$i++;
  ?>
  <tr>
    <td align="center"><?=$i;?>&nbsp;</td>
    <td><?=$row['run_date_pre_inv'];?></td>
    <td align="center"><?=$run_date_brn_id=check_name($row['run_date_brn_id'],0);?></td>
    <td align="center"><?=$inv_date=show_Date($row['inv_date']);?></td>
    <td><?=$row['cst_credit_name'];?></td>
    <td align="center"><img src="icon/pp.png" width="30" height="29" onclick="parent.print_date('<?=$row['tb_pre_inv_run_date_id'];?>','<?=$row['inv_date'];?>',<?=$row['icomp_id']?>,'<?=$row['run_date_pre_inv'];?>','<?=$run_date_brn_id;?>')" /><input type="checkbox" name="checkbox_row[]"  value='<?=$row['run_date_pre_inv']?>'></td>
    <td align="center"><input type="button" name="button" id="button3" value="<?= ($row[sent_status] == "Y")?   "รายละเอียด JOB ": "เพิ่ม JOB" ?>" onclick="parent.add_inv('<?=$row['tb_pre_inv_run_date_id'];?>','<?=$row['inv_date'];?>',<?=$row['icomp_id']?>,'<?=$row['run_date_pre_inv'];?>','<?=$run_date_brn_id;?>','<?=$row['run_date_no'];?>','<?=year_Date(show_Date($row['inv_date']));?>','<?= $row[sent_status];?>');" /></td>
    <td align="center"><? if($row['can_checkinv']=='1'){ ?> <img src="icon/can01.png" width="40" height="20" /> <? } ?></td>
	<td align="center"><? if($row[sent_status] != "Y" && $row[can_checkinv] != '1'){ ?>
	<input type="button" name="button_sent" value="ส่งงาน"  onclick="sent_fn('<?= $row[run_date_pre_inv]; ?>','<?=$row[icomp_id]?>','<?=$row[run_date_brn_id]?>','<?=$row[tb_pre_inv_run_date_id];?>')"   >
	<? }else { ?>
		<?= ($row[can_checkinv] != '1')?  $row[sent_fn_time] :  "" ?>
	<? } ?>
	
	</td>
  </tr>
 <?
}
 ?>



</table> 
</form>
</body>
<script>
	var icomp_id =  '<?=$icomp_id?>';


	
	
	if(icomp_id == "" ){
	
		$("#print_all").hide();
		$(":checkbox").hide();
	}else{

		$("#print_all").show();
		$(":checkbox").show();
		
		
	}
	function submit_btn() {
	var num = 0;
		$("input[type='checkbox']:checked").each(function (index, element) {
			num++;
		});
		
		if(num == 0){
			alert("ยังไม่ได้เลือก เลขที่ใบวางบิลที่จะพิมพ์");
			return false;
		}else{
			$("Form").submit();
		}
	// 

	}
	
function sent_fn(run_id,icomp_id,run_brn_id,tb_pre_inv_run_date_id){

	var ok = confirm("ต้องการส่งงาน ใช่ หรือ ไม่");
	if(ok){
		
		var param = "status=sent&run_id="+run_id;
			param += "&icomp_id="+icomp_id;
			param += "&run_brn_id="+run_brn_id;
			param += "&tb_pre_inv_run_date_id="+tb_pre_inv_run_date_id;
		$.ajax({
			type: "post",
			url: "?",
			data: param,
			
			success: function (data) {
	
				if(data == 3){
					alert("ไม่พบ JOB อยู่ในเลขที่ใบวางบิลนี้ ")
				}else if(data == 5){
					alert("ไม่พบการแนบเอกสารค่ะ ")
				} else {
					alert("ส่งงานให้แผนก ลูกหนี้ เรียบร้อย")
					//location.reload('?$type=SendFin');
					parent.select_date('s_do');
				}
				
				
			}
		});
	}
}
$('#select-all').click(function(event) {   
            if(this.checked) {
            
                $(':checkbox').each(function() {
                    this.checked = true;    
                             
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;   
                                  
                });
            }
        });
</script>
</html>