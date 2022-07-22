<?php
require_once $this->input->server('DOCUMENT_ROOT')."/include/KISA_SEED_CBC.php";
$misc = base_url().'misc/';
$img = $misc.'img/';
$id = $this->phpsession->get( 'id', 'stc' );
$customerid = $this->phpsession->get( 'customerid', 'stc' );
$name = $this->phpsession->get( 'name', 'stc' );
$lv = $this->phpsession->get( 'lv', 'stc' );
$email = $this->phpsession->get( 'email', 'stc' ); //김수성 수정-161228//이메일발송용


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<style>
        html,body{
            height:297mm;
            width:210mm;
        }
		.work_text_table {
		   border-collapse: collapse;
		   table-layout: fixed;
		   border-right: 1px;
		   border-left: 1px;
		   border-color: black;
		   color: black;
		   font-size: 10.0pt;
		   font-weight: 700;
		   font-style: normal;
		   text-decoration: none;
		   font-family: "맑은 고딕", monospace;
		}

		.work_text_table td {
		   word-break: break-all;
		   border: 0.5pt solid windowtext;
		   padding-left: 10px;
		   padding-right: 10px;
		   word-break:break-word;
		}

		#work_text {
		   padding-left: 10px;
		   padding-right: 10px;
		}

		.work_text_table th {
		   word-break: break-all;
		   border: 0.5pt solid windowtext;
		}

		.footer-space {
		   height: 35px;
		   width: 101%;
		}

		.header-space {
		   height: 25px;
		   width: 101%;
		}

		.footer {
		   position: fixed;
		   bottom: 0;
		   right: 0;
		   margin-right: 10px;
		}

		.header {
		   position: fixed;
		   top: 0;
		   right: 0;
		}

		.footer,
		.footer-space,
		.header,
		.header-space {
		   background-color: white;
		   border-color: white;
		}

	   @media print {
		   table tr:not(.borderNone){outline:#000 solid thin\9;} td:not(.borderNone){outline:#000 solid thin\9;} #cover{-webkit-print-color-adjust: exact;}
	   }

	   @page {
		   margin: 2mm
	   }

	   .endline{page-break-before:always}
    </style>
    
	<title><?php echo $this->config->item('site_title');?></title>
	<link href="/misc/css/print_doc.css" type="text/css" rel="stylesheet">
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<script src="/misc/js/m_script.js"></script>
	<script type="text/javascript" src="/misc/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="/misc/js/jquery.min.js"></script>
	<script type="text/javascript" src="/misc/js/jquery-1.8.3.min"></script>
	<script type="text/javascript" src="/misc/js/common.js"></script>
	<script type="text/javascript" src="/misc/js/jquery.validate.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<table id ="cover" class="borderNone" border=0.5 cellpadding=0 cellspacing=0 height=1100 style='border-collapse:collapse;table-layout:fixed;width:100%;background-image:url("<?php echo $misc?>img/cover/<?php echo $_GET['cover']; ?>");background-size:100%;'>
  <tr class="borderNone">
    <td colspan=2 class="borderNone"></td>
    <td class="borderNone"></td>
  </tr>
</table>
<div>야호</div>

<script>
	customer_sign();

    function customer_sign() {
        alert("고객사 서명이 들어갈 위치를 클릭해 주세요.");
        document.onmousedown = function () {
            if (event.button == 0) {
                var evt = window.event ? window.event : e; // 이벤트 받기 (파폭, IE 처리)

                var img = document.createElement('img'); // 이미지 객채 생성

                img.src = "<?php echo $misc; ?>img/test_sign.png" // 이미지 경로 설정 (랜덤)
                img.style.position = 'absolute';
                img.style.top = evt.clientY + document.documentElement.scrollTop + "px"
                img.style.left = evt.clientX + document.documentElement.scrollLeft + "px"
                img.style.width = '60px';
                img.style.height = '60px';
                document.body.appendChild(img);
                alert("1.이미지 위 마우스 오른쪽 클릭 = 이미지 삭제 \n2.마우스 왼쪽 클릭 = 이미지 위치 재선택 \n3.이미지 위가운데 클릭 저장")

                img.onmousedown = function () {
                    if (event.button == "2") {
                        document.body.removeChild(event.srcElement);
                    }else if (event.button == "1" || event.button == "4"){
						opener.document.cform.customer_coordinate.value = img.style.top+","+img.style.left;
                        alert("저장되었습니다.");
                        self.close();
                        return false;
                    }
                }

            }
        }
    }

</script>
   
</html>
