<?php
	require_once("../dbconfig.php");
	
	/* 페이징 시작 */
	//페이지 get 변수가 있다면 받아오고, 없다면 1페이지를 보여준다.
	if(isset($_GET['page'])) {
		$page = $_GET['page'];
	} else {
		$page = 1;
	}
	/* 검색 시작 */
	if(isset($_GET['searchColumn'])) {
		$searchColumn = $_GET['searchColumn'];

		@$subString .= '&amp;searchColumn=' . $searchColumn;
	}
	if(isset($_GET['searchText'])) {
		$searchText = $_GET['searchText'];
		$subString .= '&amp;searchText=' . $searchText;
	}
	
	if(isset($searchColumn) && isset($searchText)) {
		$searchSql = ' where ' . $searchColumn . ' like "%' . $searchText . '%"' . 'and' .$_GET['customer'];
	} else {
		$searchSql = ' where customer =' . '"' . $_GET['customer'] . '"' ;
	}
	
	/* 검색 끝 */
	
	$sql = 'select count(*) as cnt from device' . $searchSql;
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
	
	$allPost = $row['cnt']; //전체 게시글의 수
	if(empty($allPost)) {
		$emptyData = '<tr><td class="textCenter" colspan="5">글이 존재하지 않습니다.</td></tr>';
	} else {

		$onePage = 15; // 한 페이지에 보여줄 게시글의 수.
		$allPage = ceil($allPost / $onePage); //전체 페이지의 수
		
		if($page < 1 && $page > $allPage) {
?>
			<script>
				alert("존재하지 않는 페이지입니다.");
				history.back();
			</script>
<?php
			exit;
		}
	
		$oneSection = 10; //한번에 보여줄 총 페이지 개수(1 ~ 10, 11 ~ 20 ...)
		$currentSection = ceil($page / $oneSection); //현재 섹션
		$allSection = ceil($allPage / $oneSection); //전체 섹션의 수
		
		$firstPage = ($currentSection * $oneSection) - ($oneSection - 1); //현재 섹션의 처음 페이지
		
		if($currentSection == $allSection) {
			$lastPage = $allPage; //현재 섹션이 마지막 섹션이라면 $allPage가 마지막 페이지가 된다.
		} else {
			$lastPage = $currentSection * $oneSection; //현재 섹션의 마지막 페이지
		}
		
		$prevPage = (($currentSection - 1) * $oneSection); //이전 페이지, 11~20일 때 이전을 누르면 10 페이지로 이동.
		$nextPage = (($currentSection + 1) * $oneSection) - ($oneSection - 1); //다음 페이지, 11~20일 때 다음을 누르면 21 페이지로 이동.
		
		$paging = '<ul>'; // 페이징을 저장할 변수
		
		//첫 페이지가 아니라면 처음 버튼을 생성
		if($page != 1) { 
			$paging .= '<li class="page page_start"><a href="./index.php?page=1' . @$subString . '">처음</a></li>';
		}
		//첫 섹션이 아니라면 이전 버튼을 생성
		if($currentSection != 1) { 
			$paging .= '<li class="page page_prev"><a href="./index.php?page=' . $prevPage . $subString . '">이전</a></li>';
		}
		
		for($i = $firstPage; $i <= $lastPage; $i++) {
			if($i == $page) {
				$paging .= '<li class="page current">' . $i . '</li>';
			} else {
				$paging .= '<li class="page"><a href="./search_device.php?page=' . $i . @$subString . '">' . $i . '</a></li>';
			}
		}
		
		//마지막 섹션이 아니라면 다음 버튼을 생성
		if($currentSection != $allSection) { 
			$paging .= '<li class="page page_next"><a href="./search_device.php?page=' . $nextPage . $subString . '">다음</a></li>';
		}
		
		//마지막 페이지가 아니라면 끝 버튼을 생성
		if($page != $allPage) { 
			$paging .= '<li class="page page_end"><a href="./search_device.php?page=' . $allPage . @$subString . '">끝</a></li>';
		}
		$paging .= '</ul>';
		
		/* 페이징 끝 */
		
		
		$currentLimit = ($onePage * $page) - $onePage; //몇 번째의 글부터 가져오는지
		$sqlLimit = ' limit ' . $currentLimit . ', ' . $onePage; //limit sql 구문
		
		$sql = 'select * from device' . $searchSql . ' order by b_no desc' . $sqlLimit; //원하는 개수만큼 가져온다. (0번째부터 20번째까지
		$result = $db->query($sql);
	}
?>
<!DOCTYPE html>
<html>
<head>


	<meta charset="utf-8" />
	<title>기술지원보고서| Durianit IT&ICT</title>
	<link rel="stylesheet" href="./css/normalize.css" />
	<link rel="stylesheet" href="./css/board.css" />
</head>
<body>
</table>
	<article class="boardArticle">

                <h2>장비</h2>
		<div id="boardList">
			<table>

				<thead>
					<tr>
						<th scope="col" class="no">번호</th>
						<th scope="col" class="title">고객명</th>
						<th scope="col" class="author">장비명</th>
						<th scope="col" class="date">버전</th>
						<th scope="col" class="date">서버</th>
						<th scope="col" class="date">라이선스</th>
						<th scope="col" class="date">체크</th>
					</tr>
				</thead>
				<tbody>
						<?php
						if(isset($emptyData)) {
							echo $emptyData;
						} else {
							while($row = $result->fetch_assoc())
							{
						?>
						<tr>

			<form name="myform">
							<td class="no"><?php echo $row['b_no']?></td>
<!--							<td class="dev_id">
							<input type="hidden" name="dev_id"  value="<?php echo $row['dev_id']?>"><?php echo $row['dev_id']?></input>
							</td>
-->							<td class="title">
							<input type="hidden" name="customer"  value="<?php echo $row['customer']?>"><?php echo $row['customer']?></input>
							</td>
							<td class="author">
							<input type="hidden" name="produce"  value="<?php echo $row['produce']?>"><?php echo $row['produce']?></td>
							<td class="date"><?php echo $row['hardware']?></td>
							<td class="date"><?php echo $row['version']?></td>
							<td class="date"><?php echo $row['license']?></td>
							<td class="date2"><input type='checkbox' name="check" value='선택' ></td>
<script>
function submitCharge(){
len = document.getElementsByName('check').length;
total_dev_id="";
id_check="_";
total_dev_name="";
name_check=", ";
for(i = 0; i<len-1;i++){

	if(document.getElementsByName('check')[i+1].checked){
	
	total_dev_name += document.getElementsByName('produce')[i].value + name_check;
	}

}
opener.document.form1.produce.value=total_dev_name.substr(0,(total_dev_name.length-2));
self.close();
}
</script>
						</tr>
						<?php
							}
						}
						?>

							<tr class="date2"><input type='submit' name="check" value='선택' onclick="submitCharge();"></tr>
</form>
				</tbody>
			</table>
			<div class="paging">
				<?php 

if($allPost!=0)

echo $paging;


?>
			</div>
			<div class="searchBox">
				<form action="./search_device.php" method="get">
					<select name="searchColumn">
						<option <?php echo $searchColumn=='produce'?'selected="selected"':null?> value="produce">장비명</option>
						<option <?php echo $searchColumn=='version'?'selected="selected"':null?> value="version">버전</option>
					</select>
					<input type="text" name="searchText" value="<?php echo isset($searchText)?$searchText:null?>">
					<button type="submit">검색</button>
				</form>
			</div>
		</div>
	</article>
</body>
</html>
