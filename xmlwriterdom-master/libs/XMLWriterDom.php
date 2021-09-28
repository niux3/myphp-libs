<?php

class XMLWriterDom extends \DomDocument{

    protected $XMLSource = null;
    protected $XMLDestination = null;
    protected $root = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function createSimpleElement($el, $txt = "", $attributes = []){
        $node = $this->createElement($el);
        $this->writeAttributes($node, $attributes);

        if(!empty(trim($txt))){
            $txt = $this->createTextNode($txt);
            $node->appendChild($txt);
        }

        return $node;
    }


    public function wrapBuildTree($data, $txtElementWrapper, $attributes = []){
        $wrap = $this->createElement($txtElementWrapper);
        $this->writeAttributes($wrap, $attributes);

        foreach ($data as $key => $value) {
            $attributes = [];
            if(strstr($key, '?')){
                list($key, $queryString) = explode('?', $key);
                parse_str($queryString, $attributes);
            }
            $item = $this->typeNode($key, $value, $attributes);

            $wrap->appendChild($item);
        }

        return $wrap;
    }

    public function buildTree($root, $data, $attributes = []){
        foreach ($data as $key => $value) {
            $attributes = [];
            if(strstr($key, '?')){
                list($key, $queryString) = explode('?', $key);
                parse_str($queryString, $attributes);
            }
            $wrap = $this->createElement($key);
            $this->writeAttributes($wrap, $attributes);

            $item = $this->typeNode($key, $value, $attributes);

            $node = $wrap->appendChild($item);
            $root->appendChild($node);
        }
    }

    protected function writeAttributes($wrap, $attributes){
        if(!empty($attributes)){
            foreach ($attributes as $attrKey => $attrValue) {
                $wrap->setAttribute($attrKey, $attrValue);
            }
        }

        return $wrap;
    }

    protected function typeNode($key, $value, $attributes){
        if(is_array($value)){
            $node = $this->wrapBuildTree($value, $key, $attributes);
        }

        if(is_string($value)){
            $node = $this->createSimpleElement($key, $value, $attributes);
        }

        return $node;
    }

    /**
     * display xml
     * @return string [xml state]
     */
    public function display(){
        return $this->saveXML();
    }

    /**
     * write xml file
     * @param string $path
     * @return void
     */
    public function save($path = null, $option = 0){
        $path = !is_null($this->XMLDestination)? $this->XMLDestination : $path;
        $this->save($path, $options);
    }
    
    /**
     * where is xml file
     * @param string $value
     * @return $this
     */
    public function setXMLSource($value){
        if(!is_string($value)){
            throw new \Exception(sprintf("this args (%s) must be a string", $value));
        }
        $this->XMLSource = $value;
        $this->getXML();

        return $this;
    }

    /**
     * where does put xml file
     * @param string $value
     * @return $this
     */
    public function setXMLDestination($value){
        if(!is_string($value)){
            throw new \Exception(sprintf("this args (%s) must be a string", $value));
        }
        $this->XMLDestination = $value;

        return $this;
    }

    public function getRoot(){
        return $this->root;
    }

    /**
     * search xml file and set attribute root
     * @return $this
     */
    protected function getXML(){
        if(strstr($this->XMLSource, 'http') && !strstr(get_headers($this->XMLSource)[0], '200')){
            throw new \Exception(sprintf("%s isn't found", $this->XMLSource));
        }else if(!file_get_contents($this->XMLSource)){
            throw new \Exception(sprintf("%s doesn't exist", $this->XMLSource));
        }
        $this->load($this->XMLSource);
        $this->root = $this->documentElement;

        return $this;
    }

}
?>
