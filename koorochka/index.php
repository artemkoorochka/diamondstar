<?
/**
 * @var CMain $APPLICATION
 */
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle("");
?>

    <video preload="auto"
           data-setup="{}"
           webkit-playsinline=""
           onended="pageVideoPlay(this)"
           onclick="pageVideoPlay(this)"
           autoplay=""
           poster="/images/video/poster.gif"
           src="/images/video/home.mp4"
           style="height: 868px; width: auto;">

    </video>

<script>
    function pageVideoPlay(t) {
        t.play();
    }
</script>
<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
?>