<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

    <form id="mform" action="<?php echo site_url(); ?>/ttest/ttest_c/test_f" method="get" onsubmit="chkForm() return false;">
      <input type="text" name="serial_num" value="<?php echo $serial_num ?>">
      <input type="button" name="" value="검색" onclick="chkForm();">
    </form>

    <table>
      <?php foreach($user_list as $u) { ?>
        <tr>
          <td><?php echo $u['user_name']; ?></td>
        </tr>
      <?php } ?>
    </table>

  </body>

  <script type="text/javascript">
    function chkForm() {
      document.getElementById('mform').submit();
    }
  </script>
</html>
