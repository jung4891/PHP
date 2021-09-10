<?php 
include $_SERVER['DOCUMENT_ROOT'].'/session.php';
include $_SERVER['DOCUMENT_ROOT'].'/checkSignSession.php';
if($_SESSION['USERLEVEL'] < 1){
    Header("Location:./home.php");
    exit;
}
header('Content-Type: text/html; charset=UTF-8');

$seq = $_GET['seq'];

$conn = mysqli_connect(
    '192.168.0.100',
    'durianit',
    'durian0529',
    'KIC_USER');
  
  $conn->query("SET NAMES 'UTF8'");
  $sql = "select * from USERS where SEQ={$seq}";
  $result = mysqli_query($conn, $sql);
  $idx = 0;
?>

<html>
<form name="cform" action='mac_addr_update.php' method='post' onSubmit='javascript:chkForm();return false;'>
	<table style="text-align:center;">
	<tr style="background-color:#E2E2E2;">
		<td width=50>
            <input type="hidden" name="seq" value="<?php echo $seq; ?>">
            No.
        </td>
        <td width=200>
			사용자ID
        </td>
        <td width=100>
			사용자이름
        </td>
        <td width=300>
			MAC 주소
        </td>        
    </tr>
<?php  while ($row = mysqli_fetch_array($result)){
        $idx++;    
?>
    <tr>
		<td>
           <?php echo  $idx ;?>
        </td>
        <td>
            <?php echo  $row['USERID'] ;?>
        </td>
        <td>
            <?php echo  $row['USERNAME'] ;?>
        </td>
        <td>
            <?php 
                $macAddr = explode(':',$row['MAC_ADDR']);
                for($i=0; $i < 6; $i++){
                    echo "<input type='text' class ='mac' id='MAC".($i+1)."' name='MAC".($i+1)."' value='{$macAddr[$i]}' onkeyup='MACPattern(this.id)'>"; 
                } 
            ?>
<!--             
            <input type='text' class ="mac" id='MAC1' name='MAC1' onkeyup="MACPattern(this.id)"> 
			<input type='text' class ="mac" id='MAC2' name='MAC2' onkeyup="MACPattern(this.id)"> 
			<input type='text' class ="mac" id='MAC3' name='MAC3' onkeyup="MACPattern(this.id)"> 
			<input type='text' class ="mac" id='MAC4' name='MAC4' onkeyup="MACPattern(this.id)"> 
			<input type='text' class ="mac" id='MAC5' name='MAC5' onkeyup="MACPattern(this.id)"> 
			<input type='text' class ="mac" id='MAC6' name='MAC6' onkeyup="MACPattern(this.id)">  -->
        </td>
    </tr>
<?php } ?>
    </table>
    <button >수정</button>
    <input type="button" value="창닫기" onclick="selfClose();" style="margin-top:100px;"></input>
</form>

<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script>
    function selfClose(){
        self.close();
    }
    function chkForm(){
        for(var i=1; i<6; i++){
			if($("#MAC"+i).val() == ''){
				alert("MAC 주소 "+i+"번째 칸이 비어있습니다.")
				return false;
			}
		}
		var updateConfirm = confirm("mac주소를 수정하시겠습니까?");
        if(updateConfirm == true){
            document.cform.submit();
        }
	}
    // mac 패턴 체크 (소문자,숫자만) 
	function MACPattern(id) {
		var regType1 = /^[a-z0-9+]{0,2}$/;
		if($("#"+id).val().length == 2){
			if (regType1.test($("#"+id).val()) == false) {
				$("#"+id).val('');
				alert('MAC 주소는 숫자,소문자(영문) 2글자를 입력해주세요.');
			}else{
				$("#"+id).next('.mac').focus();
			}
		}
	}
</script>
</html>