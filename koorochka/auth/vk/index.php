<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://vk.com/js/api/openapi.js?136" type="text/javascript"></script>
</head>
<body>
<script type="text/javascript">
    VK.init({
        apiId: 5643587
    });
</script>
<div id="vk_auth"></div>
<script type="text/javascript">
    VK.Widgets.Auth('vk_auth', {
        onAuth: function () {
            alert("onAuth");
        }
    });
</script>
</body>
</html>