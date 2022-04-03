# gbs-m183 - Implement application security

## file structure

```php
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Name</title>
</head>
<body>
    <?php
        // get data from fields
        $dataName = (isset($_POST["dataName"])
                    && !empty($_POST["dataName"])
                    && filter_var($_POST['dataName'], 513)) ? $_POST["dataName"] : "";

        $gotCorrectData = false;
        $errorFields = array();

        if (isset($_POST["Submit"]) && !empty($_POST["Submit"])) {
            // handle post request
            $gotCorrectData = true;

            // validate fields
            if (!isset($_POST["dataName"])
                || empty($_POST["dataName"])
                || !filter_var($_POST['dataName'], 513)
                || trim($_POST["dataName"]) == "") {

                $gotCorrectData = false;
                $errorFields[] = "dataName";
            }

            if ($gotCorrectData) {
                // show that everything is correct
    ?>
    <h1>Success</h1>
    <p>Data:</p>

    <?php
                $dataName = htmlspecialchars($dataName);
                echo "<b>dataName:</b> $dataName<br />";
            } else {
                // echo errors if they exist
                echo "<p><b>Errors</b></p>";
                echo "<ul><li>";
                echo implode("</li><li>", $errorFields);
                echo "</li></ul>";
            }
        }
        if (!$gotCorrectData) {
            // form not submitted (gets shown on first load)
    ?>

        <h1>Title of application</h1>

        <form method="post">
            dataName
            <input type="text" name="dataName" value="<?php echo htmlspecialchars($dataName); ?>" /><br />
            <input type="submit" name="Submit" value="Send button text" />
        </form>

    <?php
        }
    ?>

</body>
```

## validation example

```php
!isset($_POST["Email"])
```

```php
empty($_POST["Email"])
```

```php
trim($_POST["Email"]) == ""
```

```php
!preg_match('/^[a-zA-Z0-9_\-.]+@[a-zA-Z0-9\-.]+\.[a-zA-Z]{2,6}$/', $_POST["Email"])
```

```php
$AnredeArr = array('Hr.', 'Fr.');
        $tmpIo = false;
        if (!isset($_POST["Anrede"]) || empty($_POST["Anrede"]) || !filter_var($_POST['Anrede'], 513)) {
            $ok = false;
            $fehlerfelder[] = "Anrede";
        } else {
            // Anrede ist gesetzt und ist ein String
            foreach ($AnredeArr as $anr) {
                if (strcmp($anr, $_POST["Anrede"])) {
                    $tmpIo = true;
                }
            }
            if (!$tmpIo) {
                // Anrede enthält weder Hr. noch Fr.
                $ok = false;
                $fehlerfelder[] = "Anrede";
            }
```

---

Validate array

```php
$Sektion = (isset($_POST["Sektion"])
            && !empty($_POST["Sektion"])
            && is_array($_POST["Sektion"]))
            ? $_POST["Sektion"] : array();
```

## regex

Start: ^
End: $

| Character classes | Description                  |
| ----------------- | ---------------------------- |
| .                 | any character except newline |
| \w\d\s            | word, digit, whitespace      |
| \W\D\S            | not word, digit, whitespace  |
| [abc]             | any of a, b, or c            |
| [^abc]            | not a, b, or c               |
| [a-g]             | character between a & g      |

| Anchor | Description               |
| ------ | ------------------------- |
| ^abc$  | start / end of the string |
| \b \B  | word, not-word boundary   |

| Escaped Charactors | Description                    |
| ------------------ | ------------------------------ |
| `\. \* \\`         | escaped special characters     |
| \t \n \r           | tab, linefeed, carriage return |

| Anchor | Description               |
| ------ | ------------------------- |
| ^abc$  | start / end of the string |
| \b \B  | word, not-word boundary   |

| Quantifiers & Alternation | Description               |
| ------------------------- | ------------------------- |
| a{1,3}                    | between one & three       |
| ab I cd                   | match ab or cd            |
| a{5}a{2,}                 | exactly five, two or more |

### mail

```
'/([^@ \t\r\n]+)@([^@ \t\r\n]+)\.([^@ \t\r\n]+)/'
```

### mail with one dot

```
'/[a-zA-Z0-9_\-.]+@[a-zA-Z0-9\-]+\.[a-zA-Z]{2,6}/'
```

### swiss phone

```
'/(\+41)\s?(\d{2})\s?(\d{3})\s?(\d{2})\s?(\d{2})/'
```

### swiss phone 2

```
'/(\b(0041 | 0) | \B\+41)(\s?\(0\))?(\s)?[1-9]{2}(\s)?[0-9]{3}(\s)?[0-9]{2}(\s)?[0-9]{2}\b/'
```

## form fields

### text

```html
<label for="fname">First name:</label><br />
<input type="text" id="fname" name="fname" /><br />
<label for="lname">Last name:</label><br />
<input type="text" id="lname" name="lname" />
```

```php
Vorname
<input type="text" name="Vorname" value="<?php echo htmlspecialchars($Vorname);?>" />
```

### radio

```html
<input type="radio" id="html" name="fav_language" value="HTML" />
<label for="html">HTML</label><br />
<input type="radio" id="css" name="fav_language" value="CSS" />
<label for="css">CSS</label><br />
<input type="radio" id="javascript" name="fav_language" value="JavaScript" />
<label for="javascript">JavaScript</label>
```

```php
<input type="radio" name="Anrede" value="Hr."
    <?php if ($Anrede == "Hr.") {
        echo "checked=\"checked\" ";
    } ?>
/>Herr

<input type="radio" name="Anrede" value="Fr."
    <?php
        if ($Anrede == "Fr.") {
            echo "checked=\"checked\" ";
        }
    ?>
/>Frau <br />
```

### checkboxes

```html
<input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" />
<label for="vehicle1"> I have a bike</label><br />
<input type="checkbox" id="vehicle2" name="vehicle2" value="Car" />
<label for="vehicle2"> I have a car</label><br />
<input type="checkbox" id="vehicle3" name="vehicle3" value="Boat" />
<label for="vehicle3"> I have a boat</label>
```

```php
<input type="checkbox" name="AGB" value="ok"
    <?php
        if ($AGB != "") {
            echo "checked=\"checked\" ";
        }
    ?>
/> Ich akzeptiere die AGB.<br />
```

### multiple select

```php
<select name="section[]" size="4" multiple="multiple">
    <option value="first"
        <?php
            if (in_array("first", $Sektion)) {
                echo " selected=\"selected\"";
            }
        ?>
    >First</option>

    <option value="second"
        <?php
            if (in_array("second", $Sektion)) {
                echo " selected=\"selected\"";
            }
        ?>
    >Second</option>

    <option value="third"
        <?php
            if (in_array("third", $Sektion)) {
                echo " selected=\"selected\"";
        } ?>
    >Third</option>
</select>
```

### textarea

```php
<textarea cols="70" rows="10" name="Kommentare"><?php echo htmlspecialchars($Kommentare);?></textarea>
```

### submit

Send to file

```html
<form action="/action_page.php">
  <input type="submit" value="Submit" />
</form>
```

Send to own file

```html
<form method="POST">
  <input type="submit" value="Submit" />
</form>
```

## full example

```php
<html>

<head>
    <title>Bestellformular</title>
</head>

<body>
    <?php
    //
    // Die Daten werden in Variable gefüllt:
    //
    $Anrede = (isset($_POST["Anrede"]) && !empty($_POST["Anrede"]) && filter_var($_POST['Anrede'], 513)) ? $_POST["Anrede"] : "";
    $Vorname = (isset($_POST["Vorname"]) && !empty($_POST["Vorname"]) && filter_var($_POST['Vorname'], 513)) ? $_POST["Vorname"] : "";
    $Nachname = (isset($_POST["Nachname"]) && !empty($_POST["Nachname"]) && filter_var($_POST['Nachname'], 513)) ? $_POST["Nachname"] : "";
    $Email = (isset($_POST["Email"]) && !empty($_POST["Email"]) && filter_var($_POST['Email'], 513)) ? $_POST["Email"] : "";
    $Anzahl = (isset($_POST["Anzahl"]) && !empty($_POST["Anzahl"])) ? $_POST["Anzahl"] : "";
    $Promo = (isset($_POST["Promo"]) && !empty($_POST["Promo"]) && filter_var($_POST['Promo'], 513)) ? $_POST["Promo"] : "";
    $Sektion = (isset($_POST["Sektion"]) && !empty($_POST["Sektion"]) && is_array($_POST["Sektion"])) ? $_POST["Sektion"] : array();
    $Kommentare = (isset($_POST["Kommentare"]) && !empty($_POST["Kommentare"]) && filter_var($_POST['Kommentare'], 513)) ? $_POST["Kommentare"] : "";
    $AGB = (isset($_POST["AGB"]) && !empty($_POST["AGB"]) && filter_var($_POST['AGB'], 513)) ? $_POST["AGB"] : "";
    $ok = false;
    $fehlerfelder = array();
    if (isset($_POST["Submit"]) && !empty($_POST["Submit"])) {
        //
        // Das Formular wurde ausgefüllt zum Server geschickt.
        //
        $ok = true;
        //
        // Die Eingabewerte werden überprüft:
        //
        $AnredeArr = array('Hr.', 'Fr.');
        $tmpIo = false;
        if (!isset($_POST["Anrede"]) || empty($_POST["Anrede"]) || !filter_var($_POST['Anrede'], 513)) {
            $ok = false;
            $fehlerfelder[] = "Anrede";
        } else {
            // Anrede ist gesetzt und ist ein String
            foreach ($AnredeArr as $anr) {
                if (strcmp($anr, $_POST["Anrede"])) {
                    $tmpIo = true;
                }
            }
            if (!$tmpIo) {
                // Anrede enthält weder Hr. noch Fr.
                $ok = false;
                $fehlerfelder[] = "Anrede";
            }
        }

        if (!isset($_POST["Vorname"]) || empty($_POST["Vorname"]) || !filter_var($_POST['Vorname'], 513) || trim($_POST["Vorname"]) == "") {
            $ok = false;
            $fehlerfelder[] = "Vorname";
        }
        if (!isset($_POST["Nachname"]) || empty($_POST["Nachname"]) || !filter_var($_POST['Nachname'], 513) || trim($_POST["Nachname"]) == "") {
            $ok = false;
            $fehlerfelder[] = "Nachname";
        }
        if (
            !isset($_POST["Email"]) || empty($_POST["Email"]) || trim($_POST["Email"]) == "" ||
            !preg_match('/^[a-zA-Z0-9_\-.]+@[a-zA-Z0-9\-.]+\.[a-zA-Z]{2,6}$/', $_POST["Email"])
        ) {
            $ok = false;
            $fehlerfelder[] = "E-Mail";
        }
        if (!isset($_POST["Promo"]) || empty($_POST["Promo"]) || !filter_var($_POST['Promo'], 513) || trim($_POST["Promo"]) == "") {
            $ok = false;
            $fehlerfelder[] = "Promo";
        }
        if (!isset($_POST["Anzahl"]) || empty($_POST["Anzahl"]) || !filter_var($_POST['Anzahl'], 513) || $_POST["Anzahl"] == "0") {
            $ok = false;
            $fehlerfelder[] = "Anzahl Karten";
        }
        if (!isset($_POST["Sektion"]) || empty($_POST["Sektion"]) || !is_array($_POST["Sektion"])) {
            $ok = false;
            $fehlerfelder[] = "Sektion";
        }
        if (!isset($_POST["Kommentare"]) || empty($_POST["Kommentare"]) || !filter_var($_POST['Kommentare'], 513) || trim($_POST["Kommentare"]) == "") {
            $ok = false;
            $fehlerfelder[] = "Kommentare";
        }
        if (!isset($_POST["AGB"]) || empty($_POST["AGB"]) || !filter_var($_POST['AGB'], 513)) {
            $ok = false;
            $fehlerfelder[] = "AGB";
        }

        if ($ok) {
            //
            // Alle Werte aus dem Formular sind i.O. Sie werden anstelle des Formulars ausgegeben:
            //
    ?>
            <h1>Bestätigung</h1>
            <p>Ihre Bestellung für WM-Tickets wurde mit den folgenden Daten angenommen:</p>
        <?php
            $Anrede = htmlspecialchars($Anrede);
            $Vorname = htmlspecialchars($Vorname);
            $Nachname = htmlspecialchars($Nachname);
            $Email = htmlspecialchars($Email);
            $Promo = htmlspecialchars($Promo);
            $Anzahl = htmlspecialchars($Anzahl);
            $Sektion = htmlspecialchars(implode(" ", $Sektion));
            $Kommentare = nl2br(htmlspecialchars($Kommentare));
            $AGB = htmlspecialchars($AGB);
            echo "<b>Anrede:</b> $Anrede<br />";
            echo "<b>Vorname:</b> $Vorname<br />";
            echo "<b>Nachname:</b> $Nachname<br />";
            echo "<b>E-Mail:</b> $Email<br />";
            echo "<b>Promo:</b> $Promo<br />";
            echo "<b>Anzahl Karten:</b> $Anzahl<br />";
            echo "<b>Sektion:</b> $Sektion<br />";
            echo "<b>Kommentare:</b> $Kommentare<br />";
            echo "<b>AGB:</b> $AGB<br />";
        } else {
            //
            // Nicht alle Werte aus dem Formular sind i.O. Die Mängel ausgegeben:
            //
            echo "<p><b>Formular unvollst&auml;ndig</b></p>";
            echo "<ul><li>";
            echo implode("</li><li>", $fehlerfelder);
            echo "</li></ul>";
        }
    } // zu if (isset($_POST["Submit"]) && !empty($_POST["Submit"]) ) ...

    if (!$ok) {
        //
        // Das Formular wird entweder leer oder mit Vorgabewerten ausgegeben:
        //
        ?>
        <h1>WM-Ticketservice</h1>
        <form method="post">
            <input type="radio" name="Anrede" value="Hr." <?php
                                                            if ($Anrede == "Hr.") {
                                                                echo "checked=\"checked\" ";
                                                            }
                                                            ?> />Herr
            <input type="radio" name="Anrede" value="Fr." <?php
                                                            if ($Anrede == "Fr.") {
                                                                echo "checked=\"checked\" ";
                                                            }
                                                            ?> />Frau <br />
            Vorname <input type="text" name="Vorname" value="<?php
                                                                echo htmlspecialchars($Vorname);
                                                                ?>" /><br />
            Nachname <input type="text" name="Nachname" value="<?php
                                                                echo htmlspecialchars($Nachname);
                                                                ?>" /><br />
            E-Mail-Adresse <input type="text" name="Email" value="<?php
                                                                    echo htmlspecialchars($Email);
                                                                    ?>" /><br />
            Promo-Code <input type="password" name="Promo" value="<?php
                                                                    echo htmlspecialchars($Promo);
                                                                    ?>" /><br />
            Anzahl Karten
            <select name="Anzahl">
                <option value="0">Bitte w&auml;hlen</option>
                <option value="1" <?php
                                    if ($Anzahl == "1") {
                                        echo " selected=\"selected\"";
                                    }
                                    ?>>1</option>
                <option value="2" <?php
                                    if ($Anzahl == "2") {
                                        echo " selected=\"selected\"";
                                    }
                                    ?>>2</option>
                <option value="3" <?php
                                    if ($Anzahl == "3") {
                                        echo " selected=\"selected\"";
                                    }
                                    ?>>3</option>
                <option value="4" <?php
                                    if ($Anzahl == "4") {
                                        echo " selected=\"selected\"";
                                    }
                                    ?>>4</option>
            </select><br />
            Gew&uuml;nschte Sektion im Stadion
            <select name="Sektion[]" size="4" multiple="multiple">
                <option value="nord" <?php
                                        if (in_array("nord", $Sektion)) {
                                            echo " selected=\"selected\"";
                                        }
                                        ?>>Nordkurve</option>
                <option value="sued" <?php
                                        if (in_array("sued", $Sektion)) {
                                            echo " selected=\"selected\"";
                                        }
                                        ?>>S&uuml;dkurve</option>
                <option value="haupt" <?php
                                        if (in_array("haupt", $Sektion)) {
                                            echo " selected=\"selected\"";
                                        }
                                        ?>>Haupttrib&uuml;ne</option>
                <option value="gegen" <?php
                                        if (in_array("gegen", $Sektion)) {
                                            echo " selected=\"selected\"";
                                        }
                                        ?>>Gegentrib&uuml;ne</option>
            </select><br />
            Kommentare/Anmerkungen
            <textarea cols="70" rows="10" name="Kommentare"><?php
                                                            echo htmlspecialchars($Kommentare);
                                                            ?></textarea><br />
            <input type="checkbox" name="AGB" value="ok" <?php
                                                            if ($AGB != "") {
                                                                echo "checked=\"checked\" ";
                                                            }
                                                            ?> />
            Ich akzeptiere die AGB.<br />
            <input type="submit" name="Submit" value="Bestellung aufgeben" />
        </form>
    <?php
    }
    ?>
</body>

</html>
```

## Certificate

### Resolve ip

1. Move to: C:\Windows\System32\drivers\etc
2. Get ip address (ipconfig)
3. Add hostname to the hosts file

Example:

```
192.168.210.122 www.name.m183
```

Now both pings should work

```
ping 192.168.210.122
ping www.name.m183
```

### Create certificate

1. Add bat file

```
cd c:\xampp\apache
makecert.bat
```

2. Check if certificate got created

```
überprüfen: C:\xampp\apache\conf
\ssl.crt\server.crt
```

3. Add certificate

```
certmgr.msc
```

"Zertifikate - Aktueller Benutzer" -> rightclick on "Eigene Zertifikate" -> "Alle Aufgaben" -> "Importieren"

4. Stop and start XAMPP

5. Access url: https://www.name.m183/

## Private & public key

### Symetric (secret key)

The same key is used to encrypt and decrypt data. There is only one key and it must be kept secret.
be kept secret. The difficulty with this method is that the key must be brought to the 2
distant locations of the sender and the receiver.

### Asymetric (public key)

Here, data is encrypted with one key
and decrypted with the other. During key generation, the two keys are
both keys are calculated together. The public key is published in many places, the private key remains secret here as well.

## Break password

| Length  | Possibilities       | Duration      | _1000_        | _10^12_      |
| ------- | ------------------- | ------------- | ------------- | ------------ |
| 10 Bit  | 2^10 = 10^3         | 0.000001s     |
| 20 Bit  | 2^20 = 10^6         | 0.001s        |
| 56 Bit  | 2^56 = 7.2 x 10^16  | 2.3 a (Jahre) | 20 h          |
| 128 Bit | 2^128 = 3.4 x 10^38 | 11 x 10^21 a  | 11 x 10^18 a  | 40 x 109 a   |
| 256 Bit | 2^256 = 1.2 x 10^77 | 3.7 x 10^60 a | 3.7 x 10^57 a | 3.7 x 1048 a |
