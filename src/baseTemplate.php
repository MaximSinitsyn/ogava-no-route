<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <!--meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"-->
    <meta name="viewport" content="width=1240">

    <?php
    $Render_Data_HEAD = new Render_Data('head.twig', $jsonData);
    $Render_Data_HEAD->render('MAIN');
    ?>

    <?php if (file_exists("css/external.css")) { ?>
        <link rel="stylesheet" href="/css/external.css" type="text/css" />
    <?php } ?>
    <?php if (file_exists("css/style.css")) { ?>
        <link rel="stylesheet" href="/css/style.css" type="text/css" />
    <?php } ?>

    <noscript>
        <style>
            .noScript {
                display: none;
            }
        </style>
    </noscript>

    <style>
        .body__container
        html,
        body {
            min-width: 1240px;
        }
    </style>
</head>
<body class="body">
<div class="body__container">
    <?php
        if ($page == 'base') {
            $Render_Data = new Render_Data('base.twig', 'base');
        } else {
            $Render_Data = new Render_Data($jsonData . '.twig', $jsonData, $uri);
        }

        $Render_Data->render('MAIN');
    ?>
</div>

<?php
$Render_Data_Modals = new Render_Data('modals.twig', $jsonData);
$Render_Data_Modals->render('MAIN');
?>

<?php if (file_exists("js/external.js")) { ?>
    <script src="/js/external.js"></script>
<?php } ?>
<?php if (file_exists("js/bundle.js")) { ?>
    <script src="/js/bundle.js"></script>
<?php } ?>

<?php
$Render_Data_SCRIPTS = new Render_Data('scripts.twig', $jsonData);
$Render_Data_SCRIPTS->render('MAIN');
?>
</body>
</html>
