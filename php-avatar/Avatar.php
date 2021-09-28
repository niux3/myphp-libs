<?php
    class Avatar{

        private $image;
        const BLOCK = 5;

        public function __construct($string, $size = 400){
            $togenerate = ceil(self::BLOCK / 2);

            $hash = md5($string);
            $hashsize = self::BLOCK * $togenerate;
            $hash = str_pad($hash, $hashsize, $hash);
            $hash_split = str_split($hash);

            $color = substr($hash, 0, 6);
            $blocksize = $size / self::BLOCK;

            $image = imagecreate($size, $size);
            $color = imagecolorallocate($image, hexdec(substr($color,0,2)), hexdec(substr($color,2,2)), hexdec(substr($color,4,2)));
            $bg = imagecolorallocate($image, 255, 255, 255);

            for($i = 0; $i < self::BLOCK; $i++){
                for($j = 0; $j < self::BLOCK; $j++){
                    if($i < $togenerate){
                        $pixel = hexdec($hash_split[($i * 5) + $j]) % 2 == 0;
                    }else{
                        $pixel = hexdec($hash_split[((4 - $i) * 5) + $j]) % 2 == 0;
                    }

                    $pixelColor = $bg;
                    if($pixel){
                        $pixelColor = $color;
                    }
                    imagefilledrectangle($image, $i * $blocksize, $j * $blocksize, ($i + 1) * $blocksize, ($j + 1) * $blocksize, $pixelColor);
                }
            }

            ob_start();
            imagepng($image);
            $image_data = ob_get_contents();
            ob_end_clean ();

            $this->image = $image_data;
        }

        public function display(){
            header('Content-type: image/png');
            echo($this->image);
        }

        public function base64(){
            return 'data:image/png;base64,' . base64_encode($this->image);
        }

        public function save($filename){
            if(file_put_contents($filename, $this->image)){
                return $filename;
            }
        }

    }
