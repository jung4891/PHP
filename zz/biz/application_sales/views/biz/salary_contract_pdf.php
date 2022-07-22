<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title></title>
		<style media="screen">
			body { font-family: "Malgun Gothic", "굴림", "Gulim", "Arial"; }
			/* .contents {page-break-after: always;} */
			p {word-break: keep-all; font-size:17px;}
			.sub1 {padding-left:20px;}
			.sub2 {padding-left:1cm;}
			.personal_tbl p {font-size: 13px;}
<?php if($view_val['approval_doc_status'] == '002') { ?>
			.stamp {
	      position: static;
        background:url('/misc/upload/user_sign/<?php echo $contract_user_data['sign_changename']; ?>');
	      background-size:contain;
	      /* background-position: right bottom; */
	      background-repeat:no-repeat;
	      padding-top:30px;
	      padding-bottom:30px;
	      padding-right:70px;
	      padding-left:0px;
	    }
			.durianStamp {
	      position: static;
        background:url('/misc/img/duit_stamp.png');
	      background-size:contain;
	      /* background-position: right bottom; */
	      background-repeat:no-repeat;
	      padding-top:1.5cm;
	      padding-bottom:0.5cm;
	      padding-right:2cm;
	      /* padding-left:10px; */
	    }
<?php } ?>
		</style>
		<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
	</head>
	<body>
		<div class="book">
			<div class="page">
				<div class="subpage">
					<div class="contents">
						<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:2px solid black;height:2cm">
							<col width="65%">
							<col width="15%">
							<col width="20%">
							<tr>
								<td rowspan="4" align="center" style="font-weight: bold;font-size:30px;border-right:1px solid black;">고용 및 연봉계약서</td>
								<td align="center" style="background-color:#DFDFDF;border-bottom:1px solid black;padding-bottom:1mm;padding-top:1mm;">작성부서</td>
								<td align="center" style="border-bottom:1px solid black;padding-bottom:1mm;padding-top:1mm;"><?php echo $view_val['writer_group']; ?></td>
							</tr>
							<tr>
								<td align="center" style="background-color:#DFDFDF;border-bottom:1px solid black;padding-bottom:1mm;padding-top:1mm;">작&nbsp;&nbsp;성&nbsp;&nbsp;자</td>
								<td align="center" style="border-bottom:1px solid black;padding-bottom:1mm;padding-top:1mm;"><?php echo $view_val['writer_name']; ?></td>
							</tr>
							<tr>
								<td align="center" style="background-color:#DFDFDF;border-bottom:1px solid black;padding-bottom:1mm;padding-top:1mm;">문서분량</td>
								<td align="center" style="border-bottom:1px solid black;padding-bottom:1mm;padding-top:1mm;">6페이지</td>
							</tr>
							<tr>
								<td align="center" style="background-color:#DFDFDF;padding-bottom:1mm;padding-top:1mm;">작성일자</td>
								<td align="center" style="padding-bottom:1mm;padding-top:1mm;"><?php echo date('Y년 m월 d일', strtotime($view_val['write_date'])); ?></td>
							</tr>
						</table>
						<div width="100%;" style="margin-top:0.9cm;">
							<p style="word-break:keep-all">㈜두리안정보기술(이하 “갑”이라 한다)와 <span style="letter-spacing:0.4em;"><?php echo $contract_user_data['user_name']; ?></span>(이하 “을”이라한다)는 고용 및 연봉계약을 체결함에 있어 다음과 같이 합의하고 상호신의의 원칙하에 성실히 이행, 준수할 것을 서약하고 서명 날인한다.</p>
						</div>
						<div width="100%;" style="margin-top:0.5cm;text-align:center">
							<p style="word-break:keep-all">- 다&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;음 -</p>
						</div>
						<div width="100%;" style="margin-top:0.5cm;">
							<p style="word-break:keep-all;font-weight:bold;">1. 계약기간</p>
							<p class="sub1" style="word-break:keep-all;">1-1. 근로계약기간은 기간의 정함이 없고, 연봉계약기간은 <?php echo $salary_contract_data['contract_year']; ?>년 01월 01일 부터 <?php echo $salary_contract_data['contract_year']; ?>년 12월 31일까지 12개월로 하되 12개월 뒤 계약을 갱신할 수 있다.</p>
							<p class="sub1" style="word-break:keep-all;">1-2. 연봉계약일자는 일정상 01월 01일 이후에 계약이 이루어져도 01월 01일부터 소급하여 적용할 수있다(예, 20년 1월 급여는 21년과 동일하게 지급하고 2월 계약이 이루어지면 1월 증감분을 2월 급여에 반영한다.)</p>
						</div>
						<div width="100%;" style="margin-top:0.9cm;">
							<p style="word-break:keep-all;font-weight:bold;">2. 담당업무 및 직위</p>
							<p style="word-break:keep-all;">“을”은 ”갑“의 지시에 따라 해당 업무를 수행한다.</p>
						</div>
						<div width="100%;" style="margin-top:0.9cm;">
							<p style="word-break:keep-all;font-weight:bold;">3. 신의 성실 의무</p>
							<p style="word-break:keep-all;">“을”은 신의를 바탕으로 본 계약에 약정된 내용과 직무를 성실히 수행하여야 하며, “갑”의 제 규정 및 규칙을 준수하여야 한다.</p>
						</div>
						<div width="100%;" style="margin-top:0.9cm;">
							<p style="word-break:keep-all;font-weight:bold;">4. 근로시간과 휴게시간</p>
							<p class="sub1" style="word-break:keep-all;">4-1. 본 연봉계약은 52시간 포괄임금정책이 적용되어 2020.01.01.부터 시행된다.</p>
							<p class="sub1" style="word-break:keep-all;">4-2. 내근자는 09:00 ~ 18:00까지 근무시간을 기준으로 정산되고 외근자 및 출장자는 측정 시간이 불가하여 09:00~18:00까지 근무한 것 으로 적용한다.</p>
							<p class="sub1" style="word-break:keep-all;">4-3. 근로시간은 휴게시간을 제하고 1일 8시간, 1주일 40시간을 기준으로 하되, 1주에 52시간을 초과할수 없으며, 만일 초과 사유가 발생 시 대표이사의 승인을 사전에 득하여야 한다. 업무의 형편상 필요로 하는 때에는 연장근로 및 휴일 근무를 하여야 한다.</p>
							<p class="sub1" style="word-break:keep-all;">4-4. 기존 기술지원부 주말근무수당 정책은 현행대로 유지한다.</p>
							<p class="sub1" style="word-break:keep-all;">4-5. 휴게시간은 일 1시간으로 한다.</p>
							<p class="sub1" style="word-break:keep-all;">4-6. 시업시각 및 종업시각은 “갑”이 정하는 바에 따른다.</p>
						</div>
						<div width="100%;" style="margin-top:0.9cm;">
							<p style="word-break:keep-all;font-weight:bold;">5. 휴일</p>
							<p class="sub1" style="word-break:keep-all;">5-1. 1주간 소정근로일을 개근한 자에게 주에 평균 1회 이상 유급으로 주휴일을 부여한다.</p>
							<p class="sub1" style="word-break:keep-all;">5-2. “갑”은 “을”에게 “갑”의 규정에 따라 추가로 유급휴일을 줄 수 있다.</p>
						</div>
						<div width="100%;" style="margin-top:0.9cm;">
							<p style="word-break:keep-all;font-weight:bold;">6. 휴가</p>
							<p class="sub1" style="word-break:keep-all;">6-1. “갑”은 “을”에게 “갑”의 규정이 정하는 바에 따라 유급휴가를 준다.</p>
							<p class="sub1" style="word-break:keep-all;">6-2. 유급휴가는 1년간 80% 이상 출근한 근로자에게 유급휴가를 준다.<br>단, 계속근로기간이 1년 미만인 근로자 또는 1년간 80%미만 출근한 근로자에게 1개월 개근 시 1일의 유급휴가를 준다.</p>
							<p class="sub1" style="word-break:keep-all;">6-3. 연월차 및 유급휴가는 휴가사용을 원칙으로 하며, 연차 사용에 대한 촉진을 하였음에도 미 사용 시에는 현금으로 보상하지 않는다.</p>
							<p class="sub1" style="word-break:keep-all;">6-4. “갑”은 “을”이 경조사를 당한 때에는 “갑”의 규정에 따라 유급 경조휴가를 준다.</p>
							<p class="sub1" style="word-break:keep-all;">6-5. “갑”은 “을”이 업무외 부상 또는 질병으로 정상적인 업무수행이 불가능할 때에는 “갑”의 규정에 따라 유급 병가를 준다.</p>
							<p class="sub1" style="word-break:keep-all;">6-6. “갑”은 “을”이 “갑”의 규정으로 정한 공가에 해당하는 사유로 근무할 수 없게 된 때에는 그 필요한 기간 동안을 유급 공가로 준다.</p>
						</div>
						<div width="100%;" style="margin-top:0.9cm;">
							<p style="word-break:keep-all;font-weight:bold;">7. 연봉 및 급여지급일</p>
							<p class="sub1" style="word-break:keep-all;">7-1. 계약기간 중의 연봉금액은 <span style="border-bottom:1px solid black;"><?php echo number_format($salary_contract_data['salary']); ?></span> 원(퇴직금별도)으로 한다.</p>
							<p class="sub1" style="word-break:keep-all;">7-2. 인턴기간은 입사일로부터 6개월 이내이며, 인턴기간동안은 수습기간으로 총 급여의 85%만 지급한다. 단, “갑”이 판단하여 “을”의 근무능력이 우수하다고 판단 시 70% ~ 100% 까지 조정 할 수 있다.</p>
							<p class="sub1" style="word-break:keep-all;">7-3. 지급액은 법정 근로시간에 대한 것으로 한다.</p>
							<p class="sub1" style="word-break:keep-all;">7-4. 연봉의 지급은 연봉총액을 12개월로 균분하여 급여지급일에 지급함을 원칙으로 한다.</p>
							<p class="sub1" style="word-break:keep-all;">7-5. 회사의 급여지급일은 원칙적으로 매월 말일로 한다.</p>
							<p class="sub1" style="word-break:keep-all;">7-6. 연봉금액의 조정은 재계약시 종전 계약기간의 근무성적을 참고하여 증감 조정한다. 단, “을”의 업무실적이 뛰어날 경우 계약 기간 도중이라도 상향 조정할 수 있다.</p>
							<p class="sub1" style="word-break:keep-all;">7-7. 시간외 근로시간(야간 및 휴일근로시간)수당은 사전에 대표이사에게 승인을 받은 연장 근무만 인정한다.</p>
							<p class="sub1" style="word-break:keep-all;">7-8. 사내규정에 의거하여 자격증수당이 지급된다. 단, 연봉계약금에 포함되지 않으며, 연봉계약 전 필요서류를 제출한 자에게만 해당된다.</p>
						</div>
						<div width="100%;" style="margin-top:0.9cm;">
							<p style="word-break:keep-all;font-weight:bold;">8. 퇴직금 정산</p>
							<p class="sub1" style="word-break:keep-all;">8-1. 퇴직금은 회사규정을 준용(퇴직연금 확정기여형(DC)가입)한다.</p>
							<p class="sub1" style="word-break:keep-all;">8-2. 최초 계약기간 도중에 퇴직하였을 경우에는 퇴직금을 지급하지 아니한다.</p>
						</div>
						<div width="100%;" style="margin-top:0.9cm;">
							<p style="word-break:keep-all;font-weight:bold;">9. 계약해지</p>
							<p class="sub1" style="word-break:keep-all;">9-1. 다음 각 호에 해당하는 사유가 발생할 경우, “갑”은 최고절차 없이 본 계약을 해지할 수 있다.</p>
							<p class="sub1" style="word-break:keep-all;">9-1-1. 본 계약서의 계약기간이 만료된 경우</p>
							<p class="sub1" style="word-break:keep-all;">9-1-2. 계약 당시“을”이 제출한 이력 사항에 허위가 발견되었거나 부정한 방법에 의해 입사 한 사실이 발견되는 경우.</p>
							<p class="sub1" style="word-break:keep-all;">9-1-3. “을”이 고의 또는 과실로 회사에 중대한 손해를 입혔다고 인정되는 경우.</p>
							<p class="sub1" style="word-break:keep-all;">9-1-4. 기타 “을”이 회사 사규에 의한 해고사유에 해당되는 행위를 범하였거나, 형사상 처벌을 받은 경우.</p>
							<p class="sub1" style="word-break:keep-all;">9-2. 다음 각 호에 해당하는 사유가 발생할 경우, “갑”은 최소 30일전에 “을”에게 통보함으로써 본 계약을 해지할 수 있다.</p>
							<p class="sub1" style="word-break:keep-all;">9-2-1. 회사의 경영정책변경에 의해 본 계약의 지속적인 이행이 불가능한 경우</p>
							<p class="sub1" style="word-break:keep-all;">9-2-2. “을”이 “갑”의 규정 및 규칙을 위반할 경우.</p>
							<p class="sub1" style="word-break:keep-all;">9-2-3. 본 계약에 약정된 사항을 성실히 수행하지 아니한다고 인정되는 경우</p>
							<p class="sub1" style="word-break:keep-all;">9-2-4. 인사고과에 의해 근무능력이 현저히 부족하여 업무를 수행하기 어렵다고 판단되는 경우.</p>
						</div>
						<div width="100%;" style="margin-top:0.9cm;">
							<p style="word-break:keep-all;font-weight:bold;">10. 손해배상</p>
							<p class="sub1" style="word-break:keep-all;">10-1. 9-1-3항의 고의 또는 과실에 의해 회사에 중대한 손해를 입혔을 경우, “을”은 ”갑“에 대하여 손해배상책임이 있다.</p>
							<p class="sub1" style="word-break:keep-all;">10-2. 회사는 예측하기 어려운 손해발생에 대비하여 직원에 대하여 보증보험을 들 수 있다.</p>
						</div>
						<div width="100%;" style="margin-top:0.9cm;">
							<p style="word-break:keep-all;font-weight:bold;">11. 계약서 보관</p>
							<p style="word-break:keep-all;">“갑”과 “을”은 본 계약을 성실히 이행할 것을 다짐하면서 본 계약서에 서명 날인한 후 각각 1부씩 보관한다.</p>
						</div>
						<div width="100%;" style="margin-top:0.9cm;">
							<p style="word-break:keep-all;font-weight:bold;">12. 기 타</p>
							<p class="sub1" style="word-break:keep-all;">12-1. 본 계약의 내용에 명시되지 아니한 사항은 관계법령이나 관례 또는 “갑”의 사규에 따른다.</p>
							<p class="sub1" style="word-break:keep-all;">12-2. “을”은 본 계약에 명시된 연봉금액을 타인에게 누설하지 아니하며, 타인이 본인의 연봉금액을 인지할 수 있는 어떠한 행위를 해서는 안된다.</p>
							<p class="sub1" style="word-break:keep-all;">12-3. 본 계약과 관련하여 “갑”, “을” 상호간의 이의가 발생하였을 때에는 상호합의로 해결한다.</p>
						</div>
						<div width="100%" style="text-align:right;margin-top:1cm">
      <?php if($view_val['approval_doc_status'] == '002') { ?>
              <span><?php echo date('Y년 m월 d일', strtotime($view_val['completion_date'])); ?></span>
      <?php } else { ?>
              <span><?php echo date('Y년 m월 d일'); ?></span>
      <?php } ?>
						</div>
						<div width="100%" style="text-align:right;margin-top:1cm">
							<table style="width:400px;float:right;">
								<col width="25%">
								<col width="75%">
								<col width="20%">
								<tr>
									<td align="center" height="70">"갑"</td>
									<td align="center">(주)두리안정보기술</td>
									<td align="center"><span class="durianStamp">(인)<span></td>
								</tr>
								<tr>
									<td align="center" height="70">"을"</td>
									<td align="center"><span><?php echo $contract_user_data['user_name']; ?></span></td>
									<td align="center"><span class="stamp">(인)</span></td>
								</tr>
								<tr>
									<td align="center" height="70">생년월일</td>
									<td align="center"><span><?php if($contract_user_data['user_birthday']!=''){echo date('Ymd', strtotime($contract_user_data['user_birthday']));} ?></span></td>
								</tr>
							</table>
						</div>
					</div>
					<div class="contents" style="page-break-before:always;">
						<p>[별지서식 제1호]</p>
						<div width="100%;" style="margin-top:2cm;text-align:center;">
								<p style="word-break:keep-all;font-size:35px;border-bottom:thin solid black;width:280px;margin:0 auto;">비밀유지 서약서</p>
						</div>
						<div width="100%;" style="margin-top:2cm;">
							<p style="word-break:keep-all;">
								<span>■ 성&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;명 : </span><span><?php echo $contract_user_data['user_name']; ?></span>
							</p>
							<p style="word-break:keep-all;">
								<span>■ 생&nbsp;&nbsp;년&nbsp;&nbsp;월&nbsp;&nbsp;&nbsp;일 : </span><span><?php if($contract_user_data['user_birthday'] != ''){echo date('Ymd', strtotime($contract_user_data['user_birthday']));} ?></span>
							</p>
							<p style="word-break:keep-all;">
								<span>■ 소속&nbsp; 및&nbsp; 직책 : </span><span><?php echo $contract_user_data['user_group'].' '.$contract_user_data['user_duty']; ?></span>
							</p>
						</div>
						<div width="100%;" style="margin-top:1.5cm;">
							<p style="word-break:keep-all;">상기 본인은 주식회사두리안정보기술에서 근무함에 있어 아래의 사항을 준수 할 것을 서약합니다.</p>
						</div>
						<div width="100%;" style="margin-top:1.5cm;">
							<p class="sub2" style="word-break:keep-all;">1. 회사의 영업비밀과 개발비민, 생산비밀, 관리비밀 등 산업재산권 제반규정에 준하는 사항들에 대하여 허락 없이 공개 또는 누설하지 않을 것을 서약합니다.</p>
						</div>
						<div width="100%;" style="margin-top:1cm;">
							<p class="sub2" style="word-break:keep-all;">2. 본인이 알거나 소유하고 있는 회사의 지적, 물적 재산을 회사의 승낙 없이 부정하게 사용하거나 반출하지 않을 것임을 서약 합니다.</p>
						</div>
						<div width="100%;" style="margin-top:1cm;">
							<p class="sub2" style="word-break:keep-all;">3. 재직 중은 물론 퇴직 후에도 3년간 회사의 영업비밀을 이용하여 창업하거나 경쟁회사에 전직 또는 동업을 하는 것과 같이 자신을 위하거나 또는 경쟁업자 및 기타 제 3자를 위하여 사용하지 않을 것임을 서약합니다.</p>
						</div>
						<div width="100%;" style="margin-top:1cm;">
							<p class="sub2" style="word-break:keep-all;">4. 만일 본인이 상기 3개 사항을 위반 할 시에는 관계 제 법규에 의거 엄중 처벌 될 것을 알고 서약합니다.</p>
						</div>
						<div width="100%;" style="margin-top:2cm;text-align:center">
							<p class="sub2" style="word-break:keep-all;">
          <?php if($view_val['approval_doc_status'] == '002') { ?>
                  <span><?php echo date('Y년 m월 d일', strtotime($view_val['completion_date'])); ?></span>
          <?php } else { ?>
                  <span><?php echo date('Y년 m월 d일'); ?></span>
          <?php } ?>
              </p>
						</div>
						<div width="100%;" style="margin-top:2cm;text-align:center">
							<p class="sub2" style="word-break:keep-all;">서약자 서명 : <span><?php echo $contract_user_data['user_name']; ?></span><span class="stamp">(인)</span></p>
						</div>
						<div width="100%;" style="margin-top:2cm;text-align:center">
							<p class="sub2" style="word-break:keep-all;">(주)두리안정보기술 대표이사 귀중</p>
						</div>
					</div>
					<div class="contents" style="page-break-before:always;">
						<p>[별지서식 제2호]</p>
						<div width="100%;" style="margin-top:1.1cm;text-align:center;">
								<p style="word-break:keep-all;font-size:35px;border-bottom:thin solid black;width:360px;margin:0 auto;">개인정보 제공 동의서</p>
						</div>
						<div style="padding-left:1.2mm; padding-right:2mm;margin-top:0.5cm;border:thin solid black;">
							<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:thin solid black;margin-top:1cm">
								<colgroup>
									<col width="10%">
									<col width="15%">
									<col width="10%">
									<col width="15%">
									<col width="12%">
									<col width="13%">
									<col width="12%">
									<col width="13%">
								</colgroup>
								<tr>
									<td align="center" style="border-right:thin solid black;">부서</td>
									<td align="center" style="border-right:thin solid black;"><span><?php echo $contract_user_data['user_group']; ?></span></td>
									<td align="center" style="border-right:thin solid black;">성명</td>
									<td align="center" style="border-right:thin solid black;"><span><?php echo $contract_user_data['user_name']; ?></span></td>
									<td align="center" style="border-right:thin solid black;">생년월일</td>
									<td align="center" style="border-right:thin solid black;"><span><?php if($contract_user_data['user_birthday'] != ''){echo date('Ymd', strtotime($contract_user_data['user_birthday']));} ?></span></td>
									<td align="center" style="border-right:thin solid black;">연락처</td>
									<td align="center"><span><?php echo $contract_user_data['user_tel']; ?></span></td>
								</tr>
							</table>
							<div width="100%;" style="margin-top:1cm;">
								<p style="word-break:keep-all;">1. 본인은 ㈜두리안정보기술 (이하 ‘회사’라 함)에 재직근로자로서 인적자원관리상 개인정보 제공이 필요하다는 것을 이해하고 있으며, 이를 위해 “개인정보보호법”등 규정 등에 따라 아래의 개인정보를 수집·이용하는 것에 동의합니다.</p>
							</div>
							<div width="100%" style="margin-top:0.3cm">
								<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:2px solid black;" class="personal_tbl">
									<colgroup>
										<col width="32%">
										<col width="32%">
										<col width="36%">
									</colgroup>
									<tr>
										<td align="center" style="border-right:2px solid black;border-bottom:2px solid black;">개인정보 항목</td>
										<td align="center" style="border-right:2px solid black;border-bottom:2px solid black;">수집·이용 목적</td>
										<td align="center" style="border-right:2px solid black;border-bottom:2px solid black;">보유기간</td>
									</tr>
									<tr>
										<td style="padding-left:2mm;border-right:2px solid black;">
											<p style="word-break:keep-all;">가. 성명, 가족사항</p>
											<p style="word-break:keep-all;">나. 주소, 이메일, 연락처</p>
											<p style="word-break:keep-all;">다. 학력, 근무경력, 자격증</p>
											<p style="word-break:keep-all;">라. 기타 근무와 관련된 개인정보</p>
										</td>
										<td style="padding-left:2mm;border-right:2px solid black;">
											<p style="word-break:keep-all;">가. 채용 전형</p>
											<p style="word-break:keep-all;">나. 근로관계에 근거하여 소득세법, 근로기준법, 시회보험법령, 기타 관련법령에서 부과하는 의무 이행</p>
											<p style="word-break:keep-all;">다. 인사이동, 상벌, 주요 근로조건 결정, 기타 인적자원관리</p>
										</td>
										<td style="padding-left:2mm;border-right:2px solid black;">
											<p style="word-break:keep-all;">보유기간은 개별 개인정보의 수집부터 삭제까지를 생애주기로 하고, 개별 법령의 규정에 명시되니 자료의 보존기간으로 함. 개별법령에서 보유기간이 명시되어 있지 않은 경우에는 표준개인정보보호지침의 개인정보파일 보유기간 책정 기준표에서 정한 기간으로 책정함</p>
										</td>
									</tr>
								</table>
							</div>
							<div width="100%;" style="margin-top:0.9cm;text-align:right;">
								<p style="word-break:keep-all;font-weight:bold;">개인정보의 수집․이용에 (☑동의함 □동의하지 않음)</p>
							</div>
							<div width="100%;" style="margin-top:1cm;">
								<p style="word-break:keep-all;">2. 본인은 상기 개인정보에 대한 동의와 별도로 아래의 민감 정보와 고유 식별 정보를 수집․이용하는 것에 동의합니다.</p>
							</div>
							<div width="100%" style="margin-top:0.3cm">
								<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:2px solid black;" class="personal_tbl">
									<colgroup>
										<col width="32%">
										<col width="32%">
										<col width="36%">
									</colgroup>
									<tr>
										<td align="center" style="border-right:2px solid black;border-bottom:2px solid black;">민감 정보의 항목</td>
										<td align="center" style="border-right:2px solid black;border-bottom:2px solid black;">수집·이용 목적</td>
										<td align="center" style="border-right:2px solid black;border-bottom:2px solid black;">보유기간</td>
									</tr>
									<tr>
										<td style="padding-left:2mm;border-right:2px solid black;">
											<p style="word-break:keep-all;">가. 신체장애</p>
											<p style="word-break:keep-all;">나. 국가보훈대상</p>
											<p style="word-break:keep-all;">다. 병력</p>
											<p style="word-break:keep-all;">마. 기타 인적자원관리에 필요한 민감정보</p>
										</td>
										<td style="padding-left:2mm;border-right:2px solid black;">
											<p style="word-break:keep-all;">가. 우선채용대상자격 및 정부지원금(장려금 등)</p>
											<p style="word-break:keep-all;">나. 인사이동, 업무적합성 판단, 기타 인적자원관리</p>
										</td>
										<td style="padding-left:2mm;border-right:2px solid black;">
											<p style="word-break:keep-all;">보유기간은 특별히 영구 또는 장기간 보유해야할 사정이 없는 한 상기 개인정보를 보유하는 기간 동안으로 함.</p>
										</td>
									</tr>
								</table>
							</div>
							<div width="100%;" style="margin-top:0.9cm;text-align:right;">
								<p style="word-break:keep-all;font-weight:bold;">민감정보의 수집․이용에 대해 (☑동의함 □동의하지 않음)</p>
							</div>
							<div width="100%" style="margin-top:0.3cm">
								<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:2px solid black;" class="personal_tbl">
									<colgroup>
										<col width="32%">
										<col width="32%">
										<col width="36%">
									</colgroup>
									<tr>
										<td align="center" style="border-right:2px solid black;border-bottom:2px solid black;">고유식별정보의 항목</td>
										<td align="center" style="border-right:2px solid black;border-bottom:2px solid black;">수집·이용 목적</td>
										<td align="center" style="border-right:2px solid black;border-bottom:2px solid black;">보유기간</td>
									</tr>
									<tr>
										<td style="padding-left:2mm;border-right:2px solid black;">
											<p style="word-break:keep-all;">가. 주민등록번호(외국인의 경우 외국인등록번호)</p>
											<p style="word-break:keep-all;">나. 운전면허번호(운전면허가 필요한 업무자에 한함)</p>
										</td>
										<td style="padding-left:2mm;border-right:2px solid black;">
											<p style="word-break:keep-all;">가. 개인정보 식별</p>
											<p style="word-break:keep-all;">나. 업무자격확인(운전면허번호를 요구하는 경우에 한함)</p>
										</td>
										<td style="padding-left:2mm;border-right:2px solid black;">
											<p style="word-break:keep-all;">보유기간은 특별히 영구 또는 장기간 보유해야할 사정이 없는 한 상기 개인정보를 보유하는 기간 동안으로 함.</p>
										</td>
									</tr>
								</table>
							</div>
							<div width="100%;" style="margin-top:0.9cm;text-align:right;">
								<p style="word-break:keep-all;font-weight:bold;">고유 식별 정보의 수집․이용에 대해 (☑동의함 □동의하지 않음)</p>
							</div>
						</div>


						<div style="padding-left:2mm; padding-right:2mm;margin-top:0.2cm;border:thin solid black;page-break-before: always">

							<div width="100%;" style="margin-top:1cm;">
								<p style="word-break:keep-all;">3. 본인은 회사가 아래와 같이 개인정보를 제3자에게 제공하거나 위탁하는 것에 동의합니다.</p>
							</div>
							<div width="100%" style="margin-top:0.3cm">
								<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:2px solid black;" class="personal_tbl">
									<colgroup>
										<col width="24%">
										<col width="24%">
										<col width="24%">
										<col width="28%">
									</colgroup>
									<tr>
										<td align="center" style="border-right:2px solid black;border-bottom:2px solid black;">제공받는자</td>
										<td align="center" style="border-right:2px solid black;border-bottom:2px solid black;">제공하는 항목</td>
										<td align="center" style="border-right:2px solid black;border-bottom:2px solid black;">이용 목적</td>
										<td align="center" style="border-right:2px solid black;border-bottom:2px solid black;">정보보유 및 이용기간</td>
									</tr>
									<tr>
										<td style="padding-left:2mm;border-right:2px solid black;">
											<p style="word-break:keep-all;">가. 사업장 도급 또는 위탁 사업자(고객사)</p>
											<p style="word-break:keep-all;">나. 원청 관계사</p>
											<p style="word-break:keep-all;">다. 취급위탁 사업자</p>
											<p style="word-break:keep-all;">라. 기타 회사업무에 대해 자문 받는 기관</p>
										</td>
										<td style="padding-left:2mm;border-right:2px solid black;">
											<p style="word-break:keep-all;">가. 성명, 주민번호, 가족사항</p>
											<p style="word-break:keep-all;">나. 주소, 이메일, 휴대전화 번호 등 연락처</p>
											<p style="word-break:keep-all;">다. 학력, 근무경력</p>
											<p style="word-break:keep-all;">라. 기타 인사 및 급여정보와 관련된 개인정보</p>
										</td>
										<td style="padding-left:2mm;border-right:2px solid black;">
											<p style="word-break:keep-all;">가. 고객사와의 업무협조</p>
											<p style="word-break:keep-all;">나. 원청사와의 업무협조</p>
											<p style="word-break:keep-all;">다. 급여, 인사관리, 채용업무 등 취급위탁 업무 수행</p>
											<p style="word-break:keep-all;">라. 기타 자문기관과 업무협조</p>
										</td>
										<td style="padding-left:2mm;border-right:2px solid black;">
											<p style="word-break:keep-all;">제3자는 제공한 정보는 제3자에 대한 정보제공 제공·이용목적이 달성되면 즉시 파기함</p>
										</td>
									</tr>
								</table>
							</div>
							<div width="100%;" style="margin-top:1cm;text-align:right;">
								<p style="word-break:keep-all;font-weight:bold;">개인정보의 제3자 제공 및 위탁에 대해 (☑동의함 □동의하지 않음)</p>
							</div>
							<div width="100%;" style="margin-top:1cm;">
								<p style="word-break:keep-all;">4. 본인이 서명날인한 동의서의 복사본은 다양한 자료수집의 편의를 위해서 원본과 동일하게 유효하다는 것을 인정합니다.</p>
							</div>
							<div width="100%;" style="margin-top:1cm;">
								<p style="word-break:keep-all;">5. 본인은 위 1~3항에 따르는 개인정보의 수집·제공·이용에 대한 동의를 거부할 권리가 있다는 사실 및 동의 거부시 개인정보 부정확에 따른 채용, 인사이동, 업무지연 등 불이익을 받을 수 있다는 사실을 충분히 설명 받고 숙지하였으며, 그 불이익에 대한 책임은 본인에게 있음을 확인합니다.</p>
							</div>
							<div width="100%;" style="margin-top:1cm;">
								<p style="word-break:keep-all;">6. 본인은 업무 수행 중 취득한 타인의 개인정보를 제공의 범위를 범어난 제3자에게 제공하지 않겠으며, 제공의 범위를 벗어난 유출행위에 대한 책임은 본인에게 있음을 확인합니다. </p>
							</div>
							<div width="100%;" style="margin-top:4cm;text-align:center">
								<p class="sub2" style="word-break:keep-all;">
          <?php if($view_val['approval_doc_status'] == '002') { ?>
                  <span><?php echo date('Y년 m월 d일', strtotime($view_val['completion_date'])); ?></span>
          <?php } else { ?>
                  <span><?php echo date('Y년 m월 d일'); ?></span>
          <?php } ?>
                </p>
							</div>
							<div width="100%;" style="margin-top:2cm;text-align:center">
								<p class="sub2" style="word-break:keep-all;">동의자 서명 : <span><?php echo $contract_user_data['user_name']; ?></span><span class="stamp">(인)</span></p>
							</div>
							<div width="100%;" style="margin-top:4.2cm;text-align:center">
								<p class="sub2" style="word-break:keep-all;">(주)두리안정보기술 대표이사 귀중</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
