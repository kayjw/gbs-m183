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

TODO: SELECT (MULTIPLE CHECK)
RADIO
-> VALIDATION UND DARSTELLUNG

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
