<?php
    include 'connectDB.php';

    $sql = "create TABLE prodReview (";
    $sql .= "prodReviewID int unsigned auto_increment COMMENT '리뷰의 고유 번호',";
    $sql .= "myMemberID int unsigned COMMENT '리뷰를 작성한 회원번호',";
    $sql .= "content tinytext COMMENT '리뷰 내용',";
    $sql .= "regTime datetime not null COMMENT '리뷰 작성 날짜',";
    $sql .= "PRIMARY KEY(prodReviewID))";
    $sql .= "CHARSET=utf8 COMMENT='상품 리뷰';";

    $result = $mysqli->query($sql);

    if ( $result ) {
        echo "테이블 생성 완료";

    } else {
        echo "테이블 생성 실패";
    }
?>
