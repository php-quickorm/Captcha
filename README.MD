# PHP Captcha Library
## What is it
A library implemented by PHP to generate captcha easily.
## Requirements
- PHP 5 +
- PHP GD
- composer
> Please assure that you have installed php-gd, and install it via `apt install php7.0-gd` or `apt install php5-gd` is recommended.
## Installation
Here are two ways to install:
- Using composer:
    ```
    composer require php-quickorm/captcha
    ```

- or download the `Captcha.php` and `arial.ttf` to your project and import it by `require "Captcha.php";`

## Usage

The captcha has three levels, and the first is the easiest.

### Simple
image.php
```php
$captcha = new Captcha();
$_SESSION['code'] = $captcha->getCode();
$captcha->render();
```

index.html
```html
<img src="image.php">
```
### Advanced Options

```php
// The Captcha has three levels, and the first is the easiest.
$level = 3; 
// Case Sensitive
$caseSensitive = false;


$captcha = new Captcha($level, $caseSensitive);

// Get the code
$code = $captcha->getCode();

// Get the php-gd image resource
$im = $captcha->getImageResource();

// Check the code if correct
$captcha->check("AbcD");

// Send HTTP response as a image
$captcha->render();
```

Here is a demo: https://github.com/php-quickorm/Captcha/tree/master/demo

