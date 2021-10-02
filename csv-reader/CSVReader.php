<?php
    class CSVReader{
        const OPEN_FILE_MODE = "r";

        // Must be greater than the longest line (in characters) to be found in the CSV file (allowing for trailing line-end characters). Otherwise the line is split in chunks of length characters, unless the split would occur inside an enclosure.
        const LENGTH = 0;

        //path to csv file
        private $file = null;

        // ressource csv file
        private $ressource = null;

        // The optional delimiter parameter sets the field delimiter (one character only).
        private $separator = null;

        // The optional enclosure parameter sets the field enclosure character (one character only).
        private $enclosure = null;

        // The optional escape parameter sets the escape character (at most one character). An empty string ("") disables the proprietary escape mechanism.
        private $escape = null;

        //index
        private $first_record = null;

        //données sous forme de tableau associatif
        private $data = null;

        private static $instance = null;


        private function __construct($separator, $enclosure, $escape){
            if(!is_string($separator)) throw new Exception(sprintf('the separator (%s%s) must be string', __CLASS__, __METHOD__));
            if(!is_string($enclosure)) throw new Exception(sprintf('the enclosure (%s%s) must be string', __CLASS__, __METHOD__));
            if(!is_string($escape)) throw new Exception(sprintf('the escape (%s%s) must be string', __CLASS__, __METHOD__));
            $this->separator = $separator;
            $this->enclosure = $enclosure;
            $this->escape = $escape;


        }


        public static function initialize($separator = ",", $enclosure = '"', $escape = "\\"){
            if(is_null(self::$instance)) {
                self::$instance = new CSVReader($separator, $enclosure, $escape);
            }

            return self::$instance;
        }


        public function set_file($value, $first_record = 0, $offset = null){
            // if(!file_exists($value) || trim(strtolower(@end(explode('.', $value)))) !== 'csv')
            //     throw new Exception(sprintf("can't access or the value (%s) must be a csv file", $value));
            if(!is_integer($first_record))
                throw new Exception(sprintf("first record (%s) must be an integer", $first_record));
            if(!is_integer($offset) && !is_null($offset))
                throw new Exception(sprintf("offset (%s) must be an integer", $offset));

            $this->file = $value;
            $this->get_data($first_record, $offset);

            return $this;

        }


        public function set_separator($value){
            if(!is_string($value))
                throw new Exception(sprintf('this attribute (%s) must be string (%s)', 'separator', $value));

            $this->separator = $value;
            return $this;
        }


        public function set_enclosure($value){
            if(!is_string($value))
                throw new Exception(sprintf('this attribute (%s) must be string (%s)', 'enclosure', $value));

            $this->enclosure = $value;
            return $this;
        }


        public function set_escape($value){
            if(!is_string($value))
                throw new Exception(sprintf('this attribute (%s) must be string (%s)', 'escape', $value));

            $this->escape = $value;
            return $this;
        }


        public function __get($attribute){
            switch ($attribute) {
                case 'fields':
                case 'data':
                    return $this->$attribute;

                default:
                    throw new Exception(sprintf("this attribute (%s) doesn't exist or you can't access it", $attribute));
                    break;
            }
        }


        private function get_data($first_record, $offset){
            $raw_data = $this->get_raw_data();

            if(empty($raw_data)){
                throw new Exception(sprintf("can't get data from file %s", $this->file));
            }
            $fields = array_shift($raw_data);

            $this->set_fields($fields);
            $slugifyFields = $this->slugify($this->fields);
            $data = [];
            for($index = 0, $len = count($raw_data); $index < $len; $index++){
                if($row = @array_combine($slugifyFields, $raw_data[$index])){
                    $data[] = json_decode (json_encode($row), false);
                }else{
                    throw new Exception(sprintf("integrity of row is not correct : %s", $index));
                }
            }

            if(!fclose($this->ressource)){
                throw new Exception(sprintf("can't close the file %s", $this->file));
            }

            $this->data = array_slice($data, $first_record, !is_null($offset)? $offset : count($data));

            return $this;
        }


        private function get_raw_data(){
            $records = [];
            if(!($this->ressource = fopen($this->file,self::OPEN_FILE_MODE))){
                throw new Exception(sprintf("can't open file %s", $this->file));
            }
            while($row = fgetcsv($this->ressource,self::LENGTH,$this->separator, $this->enclosure, $this->escape)){
                $records[] = $row;
            }
            return $records;
        }

        private function set_fields($array){
            $this->fields = $array;
        }


        private function slugify($array){
            return array_map(function($item){
                return strtolower(\App\Libs\utilities\Utilities::slug($item));
            }, $array);
        }
    }
