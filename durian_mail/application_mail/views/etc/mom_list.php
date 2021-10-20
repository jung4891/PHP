<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_header.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mail_side.php";
 ?>
<div id="main_contents">
  <table border="1" width="1000">
    <thead>
      <tr>
        <th>번호</th>
        <th>제목</th>
        <th>작성자</th>
        <th>그룹</th>
        <th>참석자</th>
        <th>작성일</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $cnt = 0;
        foreach($biz_mom as $row) {
       ?>
          <tr>
            <td ><?php echo $row->seq; ?></td>
            <td class = "modal_open" style="cursor:pointer;color:blue;" >
                <?php echo $row->title; ?></td>
            <td><?php echo $row->user_name; ?></td>
            <td><?php echo $row->user_group; ?></td>
            <td><?php echo $name_arr[$cnt]; ?></td>
            <td><?php echo $row->insert_day; ?></td>
          </tr>
      <?php
          $cnt++;
        }
       ?>
       <div class="modal">
         <div class="modal_content" title="클릭하면 창이 닫힙니다.">
           모달창 연습페이지<br> modal_content란입니다.
         </div>
       </div>
    </tbody>
  </table>

</div>

<style media="screen">
.modal{ position:absolute; width:100%; height:100%; background: rgba(0,0,0,0.7); top:0; left:0;
        display:none; }
.modal_content{
  width:400px; height:200px;
  background:#fff; border-radius:10px;
  position:relative; top:50%; left:50%;
  margin-top:-100px; margin-left:-200px;
  text-align:center;
  box-sizing:border-box; padding:74px 0;
  line-height:23px; cursor:pointer;
}
</style>

<script type="text/javascript">
$(function(){
  $(".modal_open").click(function(){
    $(".modal").fadeIn();
  });
  $(".modal_content").click(function(){
    $(".modal").fadeOut();
  });
});
</script>

<?php
include $this->input->server('DOCUMENT_ROOT')."/include/mail_footer.php";
 ?>
