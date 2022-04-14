<head>
    <?php
        $config = require('config.php');
        require('connect.php');
        require('src/SessionHandler.inc.php');

        // Session Data
        session_start();
        // end[session].


        echo '<script async src="https://www.googletagmanager.com/gtag/js?id="' . $config['global']['GOOGLE_ANALYTICS_ID'] . '></script>';

        echo "
            <script>
              window.dataLayer = window.dataLayer || [];
              function gtag(){dataLayer.push(arguments);}
              gtag('js', new Date());

              gtag('config', '" . $config['global']['GOOGLE_ANALYTICS_ID'] ."');
            </script>
        ";
    ?>

    <!-- jQuery 3.4.1  -->
    <script src="js/jquery-3.4.1.min.js"></script>

    <!-- Bootstrap 4.3.1 -->
    <script src="js/bootstrap.bundle.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 5.9.0 -->
    <link href="fontawesome5.9.0/css/all.css" rel="stylesheet">

    <!-- Emojione Textarea -->
    <link rel="stylesheet" href="css/emojionearea.min.css">
    <script type="text/javascript" src="js/emojionearea.min.js"></script>

    <!-- Meta -->
    <meta http-equiv="content-type" content="text/html; charset=utf-8"></meta>
</head>
