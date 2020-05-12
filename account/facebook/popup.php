<?

/**
 * @var CMain $APPLICATION
 */
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');

CJSCore::Init(["popup", "window", "fx"]);
$url = "https://diamondstar.plus/koorochka/test.php";
?>

<a href="javascript:void(0)" onclick="BX.util.popup('<?=htmlspecialcharsbx(CUtil::JSEscape($url))?>', 580, 400)">BX.util.popup</a>

<a class="DiamondWidgetPersonal.toggle();">DiamondWidgetPersonal.toggle();</a>

<script>

  //modalPageLarge("#modal4", "/account/become.parcipient.preview.php",{});
  modalPageLarge("#modal3", "/account/facebook/modal.test.php",{
      data: "test",
      mode: "ajax"
  });
  $("#modal3").modal("show");

</script>



<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');?>