<?php
/**
* Very simple captcha solution.  I had a client who's
* server was not capable of generating images on the
* fly (GD), so I just generated my own images (digits
* 0-9) and use them.  Not the most secure Captcha, but
* better than nothing.
*
*/
class Captcha {
const CAPTCHA_IMAGE_DIR = "images/captcha/";
// Range of characters available for captcha
private static $available_captcha_chars = array(
'1', '2', '3', '4', '5', '6', '7', '8', '9', '0'
);
private static $captcha_image_map = array(
1 => '1',
2 => '2',
3 => '3',
4 => '4',
5 => '5',
6 => '6',
7 => '7',
8 => '8',
9 => '9',
0 => '0',
);
/**
* This is the key used to store the catcha in the $_SESSION.
*
* @var string
*/
private static $session_catcha_name = "captcha_code";
/**
* Generate the random code and place it in the session
*
* @param int $number_of_captcha_chars
* @return void
*/
public static function generateCaptchaCode($number_of_captcha_chars = 4) {
// reset code
$captcha_code = '';
$available_captcha_chars = self::$available_captcha_chars;
$rand_max = count($available_captcha_chars) - 1;
// loop through and generate the code letter by letter
for ($i = 0; $i <$number_of_captcha_chars; $i++) {
// get random index
$char_index = rand(0, $rand_max);
// append char to captcha string
$captcha_code .= $available_captcha_chars[$char_index];
}
// Set the current catcha code into the session
$_SESSION[self::$session_catcha_name] = $captcha_code;
return $captcha_code;
}
/**
* For a given captcha code, returns its html
* image representation
*
* @param string $captcha_code
* @return string
*/
public static function getHTMLCaptcha ($captcha_code) {

$HTML_output = "<div>\n";
for ($i=0;$i<strlen($captcha_code);$i++) {
$HTML_output .=
"\t<img src='"
.self::CAPTCHA_IMAGE_DIR
.self::$captcha_image_map[$captcha_code[$i]]
.".gif'>\n";
}
$HTML_output .= '</div><input type="hidden" name="captcha_recode" id="captcha_recode" value="'.$captcha_code.'">';

return $HTML_output;
}

/**
* Verifiy that the given captcha matches that
* in the session
*
* @param string $supplied_captcha
* @return boolean
*/
public static function validateCaptcha($supplied_captcha) {
return strtoupper($supplied_captcha)==$_SESSION[self::$session_catcha_name];
}
}
?>
