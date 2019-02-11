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
    private $im;
    private $level;
    private $code;

    /**
     * Captcha constructor.
     * @param int $level
     */
    public function __construct($level = 2)
    {
        $this->level = $level;

        // load the truetype font
        $this->font = realpath('./arial.ttf');

        // create image
        $this->im = imagecreate(200, 77);
        imagecolorallocate($this->im, 255, 255, 255);

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
        return $this->im;
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

        imagepng($this->im);
        imagedestroy($this->im);
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
            imagettftext($this->im, $fontSize, rand(-35, 35), 35 * $i, 55, imagecolorallocate($this->im, rand(0, 240), rand(0, 240), rand(0, 240)), $this->font, $char);
        }

        $this->code = $output;
    }

    /**
     * add line to image if level > 2
     */
    private function addLines()
    {

        $lines = rand(1, 3);
        for ($i = 0; $i < $lines; $i++) {
            imageline($this->im, rand(0, 200), rand(0, -77), rand(0, 200), rand(77, 144), imagecolorallocate($this->im, rand(0, 240), rand(0, 240), rand(0, 240)));
        }

        for ($i = 0; $i < 5 - $lines; $i++) {
            imageline($this->im, rand(0, -200), rand(0, 77), rand(200, 400), rand(0, 77), imagecolorallocate($this->im, rand(0, 240), rand(0, 240), rand(0, 240)));
        }
    }
}
