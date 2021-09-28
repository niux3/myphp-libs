<?php
    class Captcha{
        private $chars = [];
        private $salt = 'Py7h0n!$|3€77€|2'; //ouais PHP, je te trolle la gueule !
        private $max_chars = 6;
        private $response = [];


        public function __construct(){
            // $this->chars = array_merge(range('a', 'z'), range('A', 'Z'), range('0', '9'));
            $this->chars = range('1', '9');
        }


        public function getCaptcha($img_destination){
            $result = [];
            for ($i = 0; $i < $this->max_chars; $i++){
                $k = array_rand($this->chars);
                $result[] = $this->chars[$k];
            }
            $this->response['code'] = implode($result, '');
            $this->response['token'] = hash('sha256', sprintf('%s%s',implode($result, ''), $this->salt));

            $this->getImage($this->response['code'], $img_destination);
            return $this->response;
        }


        public function check($value){
            $result_check = $_SESSION['token'] === hash('sha256', sprintf('%s%s', $value, $this->salt)) && $value === $_SESSION['code'];
            unset($_SESSION['code']);
            unset($_SESSION['token']);
            return $result_check;
        }


        public function getImage($code, $img_destination){
            $w = 110;
            $h = 50;
            $step = 3;
            $im = imagecreatetruecolor($w, $h);
            $white = imagecolorallocate($im, 255, 255, 255);
            $grey = imagecolorallocate($im, 128, 128, 128);
            $black = imagecolorallocate($im, 0, 0, 0);
            imagecolortransparent($im, $white);
            imagefilledrectangle($im, 0, 0, $w - 1,$h - 1, $white);
            $font = './font.ttf';
            for($i = $step; $i < $h; $i += $step){
                ImageLine($im, 0, $i, $w, $i, $grey);
            }

            imagettftext($im, 20, 0, 6, 34, $black, $font, $code);

            imagepng($im, $img_destination);
        }
    }
