<?

include($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");


?>

<div class="modal-header">

    <button type="button" class="close global-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title text-uppercase">MODAL TEST</h4>


</div>
<div class="modal-body padding-0">


    <iframe src="modal.frame.php" frameborder="0" style="
display: block;       /* iframes are inline by default */
    background: #000;
    border: none;         /* Reset default border */
    height: 100vh;        /* Viewport-relative units */
    width: 100vw;
"></iframe>


</div>




