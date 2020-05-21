<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

Test
<script>

    setTimeout(function () {
        alert("Add script to header");

        var script = document.createElement('script');
        script.src = "https://vk.com/js/api/openapi.js";
        document.getElementsByTagName('head')[0].appendChild(script);

        script = document.createElement('script');
        script.src = "https://diamondstar.plus/local/templates/diamond.lite/js/jquery-latest.min.js";
        document.getElementsByTagName('head')[0].appendChild(script);




    }, 6000);

</script>
</body>
</html>