<?php
/**
 * Copyright (c) 2019. PHP-QuickORM Captcha
 * Author: Rytia Leung
 * Email: Rytia@Outlook.com
 * Github: github.com/php-quickorm/captcha
 */

class Captcha
{
    private $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZaabcdefghijklmnopqrstuvwxyz1234567890";
    private $font;
    private $imageResource;
    private $level;
    private $code;
    private $caseSensitive;

    /**
     * Captcha constructor.
     * @param int $level
     * @param boolean $caseSensitive
     */
    public function __construct($level = 2, $caseSensitive = false)
    {
        $this->level = $level;
        $this->caseSensitive = $caseSensitive;

        // load the TrueType font
        $this->font = __DIR__.'/arial.ttf';

        // create image
        $this->imageResource = imagecreate(200, 77);
        imagecolorallocate($this->imageResource, 255, 255, 255);

        // generate
        $this->generate();

        // add lines
        if ($this->level == 3) {
            $this->addLines();
        }
    }

    /**
     * @return resource
     */
    public function getImageResource()
    {
        return $this->imageResource;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * send http response with the captcha image
     */
    public function render()
    {
        header('Content-Type: image/png');

        imagepng($this->imageResource);
        imagedestroy($this->imageResource);
    }

    /**
     * generate the code and image
     */
    private function generate()
    {
        $output = '';
        $length = strlen($this->str);


        for ($i = 1; $i < 5; $i++) {
            // get random char
            $char = $this->str[rand(0, $length - 1)];
            $output .= $char;

            // get font size
            $fontSize = ($this->level > 1) ? rand(20, 48) : 28;
            imagettftext($this->imageResource, $fontSize, rand(-35, 35), 35 * $i, 55, imagecolorallocate($this->imageResource, rand(0, 240), rand(0, 240), rand(0, 240)), $this->font, $char);
        }

        $this->code =  ($this->caseSensitive) ? $output : strtolower($output);
    }

    /**
     * @param $str
     * @return bool
     * check the code
     */
    public function check($str){
        if (!$this->caseSensitive){
            return strtolower($str) == strtolower($this->code);
        }
        else{
            return $str == $this->code;
        }
    }

    /**
     * add line to image if level > 2
     */
    private function addLines()
    {

        $lines = rand(1, 3);
        for ($i = 0; $i < $lines; $i++) {
            imageline($this->imageResource, rand(0, 200), rand(0, -77), rand(0, 200), rand(77, 144), imagecolorallocate($this->imageResource, rand(0, 240), rand(0, 240), rand(0, 240)));
        }

        for ($i = 0; $i < 5 - $lines; $i++) {
            imageline($this->imageResource, rand(0, -200), rand(0, 77), rand(200, 400), rand(0, 77), imagecolorallocate($this->imageResource, rand(0, 240), rand(0, 240), rand(0, 240)));
        }
    }
}
