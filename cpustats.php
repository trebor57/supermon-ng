<?php
include("session.inc");
include("authusers.php");
include("common.inc");
?>
<html>
<head>
<title>CPU and System Status</title>
<link rel="stylesheet" type="text/css" href="supermon-ng.css">
</head>
<body class="cpustats">
<?php
    if (isset($_SESSION['sm61loggedin']) && $_SESSION['sm61loggedin'] === true && get_user_auth("CSTATUSER")) {
        echo "<pre>";

        $commands_to_run = [
            "/usr/bin/date",
            "export TERM=vt100 && sudo $USERFILES/sbin/ssinfo - ",
            "/usr/bin/ip a",
            "$USERFILES/sbin/din",
            "/usr/bin/df -hT",
            "export TERM=vt100 && sudo /usr/bin/top -b -n1"
        ];

        foreach ($commands_to_run as $cmd) {
            echo "Command: " . htmlspecialchars($cmd) . "\n";
            echo "-----------------------------------------------------------------\n";
            ob_start();
            passthru($cmd);
            $output = ob_get_clean();
            echo htmlspecialchars($output);
            echo "\n\n";
        }
        echo "</pre>";

    } else {
        echo ("<br><h3>ERROR: You Must login to use this function!</h3>");
    }
?>
</body>
</html>
