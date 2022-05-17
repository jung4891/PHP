<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/mobile/mail_header_mobile.php";
 ?>
<style media="screen">
.option-container{
  display:grid;
  grid-template-rows: repeat(3, 50px);
  color:#1C1C1C;
  font-size: 14px;
  font-weight: bold;
}

.option-li{
  display:grid;
  grid-template-columns: 50px 1fr 50px;
  /* border-bottom: 1px solid #DEDEDE; */

}

.option-li div{
  display: flex;
  align-items: center
}

.img-icon{
  justify-content:center;
}

</style>
<div class="option-container">
  <div class="option-li" id="my_info">
    <div class="img-icon">
      <img src="/misc/img/mobile/user.svg" style="width:25px;">
    </div>
    <div class="font-div">
      계정 설정
    </div>
    <div class="">
      <img src="/misc/img/mobile/right-arrow.svg" style="width:25px;">
    </div>
  </div>

  <div class="option-li" id="mailbox_setting">
    <div class="img-icon">
      <img src="/misc/img/mobile/mailbox_setting.svg" style="width:25px;">
    </div>
    <div class="">
      메일함 설정
    </div>
    <div class="">
      <img src="/misc/img/mobile/right-arrow.svg" style="width:25px;">
    </div>
  </div>

  <div class="option-li" id="address_setting">
    <div class="img-icon">
      <img src="/misc/img/mobile/address.svg" style="width:25px;">
    </div>
    <div class="">
      주소록 관리
    </div>
    <div class="">
      <img src="/misc/img/mobile/right-arrow.svg" style="width:25px;">
    </div>
  </div>

</div>
<script type="text/javascript">
  $(document).on("click", ".option-li", function(){
    var id = $(this).attr("id");
    switch (id) {
      case "my_info":
        location.href = "<?php echo site_url(); ?>/option/user";
        break;

      case "address_setting":
        location.href = "<?php echo site_url(); ?>/option/address_book";
        break;

      case "mailbox_setting":
        location.href = "<?php echo site_url(); ?>/option/mailbox";
        break;
    }
  })

</script>
