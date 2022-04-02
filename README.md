# gbs-m183 - Implement application security

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
comming soon

### swiss phone 
```
'/(\+41)\s?(\d{2})\s?(\d{3})\s?(\d{2})\s?(\d{2})/'
```

### swiss phone 2
```
/(\b(0041 | 0) | \B\+41)(\s?\(0\))?(\s)?[1-9]{2}(\s)?[0-9]{3}(\s)?[0-9]{2}(\s)?[0-9]{2}\b/
```

## form fields

### text

```html
<label for="fname">First name:</label><br />
<input type="text" id="fname" name="fname" /><br />
<label for="lname">Last name:</label><br />
<input type="text" id="lname" name="lname" />
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

### checkboxe

```html
<input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" />
<label for="vehicle1"> I have a bike</label><br />
<input type="checkbox" id="vehicle2" name="vehicle2" value="Car" />
<label for="vehicle2"> I have a car</label><br />
<input type="checkbox" id="vehicle3" name="vehicle3" value="Boat" />
<label for="vehicle3"> I have a boat</label>
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
