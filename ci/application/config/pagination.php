<?php

// Pagiantion : 페이지 이동을 위한 링크를 뜻함

$config = array();
$config['base_url'] = "/index.php/topic/pagination";   // base_url() : ci/index.php
// 이부분 역시 "index.php/~~" or "/topic~~" 이렇게 하면 계속 주소가 덧붙여지게됨

// $config['total_rows'] = 100;  // 페이징할 전체 레코드 수
// $config['per_page'] = 5;         // 한 페이지에 보여지는 데이터의 개수
$config['num_links'] = 1;        // 선택된 페이지번호 좌우로 몇개의 숫자링크를 보여줄지 설정
$config['first_link'] = '<< &nbsp&nbsp';
$config['first_tag_open'] = '<span style="letter-spacing:0px;">';
$config['first_tag_close'] = '</span>';
$config['last_link'] = ' >>';
$config['last_tag_open'] = '<span style="letter-spacing:0px;">';
$config['last_tag_close'] = '</span>';
$config['next_link'] = '';
$config['prev_link'] = '';
$config['cur_tag_open'] = '<span style="color:red;">';    // 현재페이지"링크의 여는태그
$config['cur_tag_close'] = '</span>';
$config['num_tag_open'] = '<span>';     // 링크숫자 링크의 여는태그
$config['num_tag_close'] = '</span>';

// $config['uri_segment'] = 3;   // 페이지번호는 Pagination함수가 자동으로 결정함. 직접 지정시 사용
// $this->pagination->initialize($config);

 ?>
