
# php.class.Captcha v1.0

*original archived repository - [php.class.Captcha](https://github.com/donvercety/php.class.Captcha)*

*Lightweight PHP Captcha library. Easy to use, flexible.*  
*Version 1.0*  
*Using: [Monaco Font][1]*  
*Using: [Image Processing and Generation][4]*

![Captcha](http://prikachi.com/images/111/8545111A.png)

**Simple usage:**

The class provides two simple public static methods methods. One to generate the captcha image `Captcha::make()`, and one to check the validity of the given code compared to the generated captcha `Captcha::check()` A simple example is shown below.
```php
<?php
session_start();
require("../Captcha.php");

if (isset($_GET["check"])) {
    $isok = (Captcha::check($_GET["check"])) ? TRUE : FALSE;
    
    header("Content-Type: application/json");
    echo json_encode(["isok" => $isok]);

} else {
    try {
		Captcha::make();
    }
    catch (\Exception $ex) {
        var_dump($ex->getMessage());
    } 
}
```

**note!** we need to have php session started [`session_start()`][2] in order to be able to check the generated captcha code.

**note!** need to have [`php5-gd`][5] installed on your system

For a complete example check the [`example`][3] folder

[1]:https://github.com/todylu/monaco.ttf
[2]:http://php.net/manual/en/function.session-start.php
[3]:https://github.com/donvercety/php.class.Captcha/tree/master/example
[4]:http://php.net/manual/en/book.image.php
[5]:http://www.cyberciti.biz/faq/ubuntu-linux-install-or-add-php-gd-support-to-apache/
