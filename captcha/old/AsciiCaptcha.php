<?php
    function debug($x){
        echo '<pre>';
        print_r($x);
        echo '</pre>';
    }
    class AsciiCaptcha {

        private $noiseChars = array( ' ', "=", "-", ":" );
        private $asciiFonts = array();
        public $countChars = 4;
        const salt = 'P!th0n!$B€tt€|2';


        public function __construct(){
            $path_chars = './chars';
            $files = array_values(array_filter(scandir($path_chars), function($i){ return $i !== "." && $i !== ".."; }));
            $file = $files[array_rand($files)];
            require_once $path_chars.'/'.$file;
            $cls = str_replace('.php', '', $file);

            $this->asciiFonts = $cls::get();
        }

        public static function getSalt(){
            return AsciiCaptcha::salt;
        }

        public function getCaptcha() {
    	    $chars = array();
    	    $captchaChars = array_rand( $this->asciiFonts, $this->countChars );
    	    for ($idx = 0; $idx < sizeof( $captchaChars ); $idx++) {
    	       $capChar = $captchaChars[$idx];
    	       $chars[ $capChar ] = $this->asciiFonts[ $capChar ];
    	    }

    	    $chars = $this->addNoise( $chars );
            $result = [
                'token' => hash('sha256', implode(array_keys($chars), '').AsciiCaptcha::salt),
                'captcha' => $chars
            ];
    	    return $result;
    	}

    	private function addNoise( $captchaStrings ) {
    	    $result = array();
    	    foreach( $captchaStrings as $capChar => $ascii ) {
        		for ($idx = 0; $idx < strlen( $ascii ); $idx++) {
        		    if ( $ascii[$idx] == ' ' ) {
            			$noiseChar = array_rand( $this->noiseChars, 1 );
            			$ascii[$idx] = $this->noiseChars[$noiseChar];
        		    }
        		}

        		$ascii = str_replace ( chr(13), '  ', $ascii );
        		$result[ $capChar ] = $ascii;
    	    }

    	    return $result;
    	}
    }
