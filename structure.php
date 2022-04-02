<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Example Site</title>
</head>

<body>
    <?php
    $Vorname = (isset($_POST["Vorname"]) && !empty($_POST["Vorname"]) && filter_var($_POST['Vorname'], 513)) ? $_POST["Vorname"] : "";
    $ok = false;
    $fehlerfelder = array();

    if (isset($_POST["Submit"]) && !empty($_POST["Submit"])) {
        // if submitted
        $ok = true;

        if (!isset($_POST["Vorname"]) || empty($_POST["Vorname"]) || !filter_var($_POST['Vorname'], 513) || trim($_POST["Vorname"]) == "") {
            $ok = false;
            $fehlerfelder[] = "Vorname";
        }

        if ($ok) {
    ?>
            <h1>Success</h1>
            <p>Ihre Bestellung für WM-Tickets wurde mit den folgenden Daten angenommen:</p>
        <?php
            $Vorname = htmlspecialchars($Vorname);
            echo "<b>Vorname:</b> $Vorname<br />";
        } else {
            echo "<p><b>Formular unvollst&auml;ndig</b></p>";
            echo "<ul><li>";
            echo implode("</li><li>", $fehlerfelder);
            echo "</li></ul>";
        }
    }

    if (!$ok) {
        ?>

        <h1>WM-Ticketservice</h1>

        <form method="post">
            Vorname <input type="text" name="Vorname" value="<?php echo htmlspecialchars($Vorname); ?>" /><br />
            <input type="submit" name="Submit" value="Bestellung aufgeben" />
        </form>
    <?php
    }
    ?>
</body>

</html>