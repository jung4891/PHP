<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";

if(count($expiration30)== 0 && count($expiration15) == 0){
    echo "<script>alert('두리안 유지관리계약의 만기 일정이 없습니다.')</script>";
}else{
    $txt = "<table table border=0 cellpadding=0 cellspacing=0 width=730 style='border-collapse:collapse;table-layout:fixed;width:550pt'>
    <tr>
    <th style='height:22.5pt;width:60pt;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>고객사</th>
    <th style='height:22.5pt;width:60pt;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>사업명</th>
    <th style='height:22.5pt;width:60pt;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>유지보수기간</th>
    <th style='height:22.5pt;width:60pt;text-align:center;vertical-align:middle;border:.5pt solid windowtext;background:#D9D9D9;'>만료경과일</th></tr>";
    foreach($expiration30 as $exp30){
     $txt .= "<tr height=15 style='mso-height-source:userset;height:11.25pt'>
     <td style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>{$exp30['customer_companyname']}</td>
     <td style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>{$exp30['project_name']}</td>
     <td style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>{$exp30['maintain_start']}~{$exp30['maintain_end']}</td>
     <td style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>만료 30일 전</td></tr>";
    }

    foreach($expiration15 as $exp15){
      $txt .= "<tr height=15 style='mso-height-source:userset;height:11.25pt'>
      <td style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>{$exp15['customer_companyname']}</td>
      <td style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>{$exp15['project_name']}</td>
      <td style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>{$exp15['maintain_start']}~{$exp15['maintain_end']}</td>
     <td style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>만료 15일 전</td></tr>";
    }

    foreach($after_expiration as $after_exp){
      $txt .= "<tr height=15 style='mso-height-source:userset;height:11.25pt'>
      <td style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>{$after_exp['customer_companyname']}</td>
      <td style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>{$after_exp['project_name']}</td>
      <td style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>{$after_exp['maintain_start']}~{$after_exp['maintain_end']}</td>
        <td style='text-align:center;vertical-align:middle;border:.5pt solid windowtext;'>만료일 경과</td></tr>";
    }
    $txt .= '</table>';

    //메일 제목 작성
    $subject = "두리안 유지관리계약의 만기 일정을 안내해드립니다.";
    $subject = "=?EUC-KR?B?".base64_encode(iconv("UTF-8","EUC-KR",$subject))."?=\r\n";

    //메일 본문 작성
    $html_code = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
    <html xmlns='http://www.w3.org/1999/xhtml'>
    <head>
        <title>두리안정보기술센터-Tech Center</title>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    </head>
    <body>
            아래의 유지관리계약의 만기 일정을 안내해드립니다.
            <br><br>
            $txt
    </body>
    </html>";

    // echo $html_code;
    $to = 'sale@durianit.co.kr';
    $message = $html_code;

    $headers = "From: =?utf-8?B?".base64_encode("support@durianit.co.kr")."?= <support@durianit.co.kr> \n";
    $headers .= 'Cc: sylim@durianit.co.kr' . "\r\n";
    $headers .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= "Content-Transfer-Encoding: base64\r\n";
    $headers .= 'Message-ID: <>';

    // echo $html_code;

    //메일 보내기
    $result = mail($to, $subject,chunk_split(base64_encode($message)), $headers);

    if($result){
        echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/sales/maintain/maintain_list';</script>";
    } else {
        echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.')</script>";
    }
    $headers = "";
}
?>
