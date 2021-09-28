<?php
    header('Content-Type: text/xml; charset=utf-8');
    require_once './libs/XMLWriterDom.php';
    $xml = new XMLWriterDom();
    $xml->preserveWhiteSpace = false;
    $xml->formatOutput = true;
    $xml->load('./data.xml');

    $root = $xml->documentElement;
    $dom = [
        [
            "title" => "Rear Window",
            "director" => "Alfred Hitchcock",
            "year" => '1954',
        ],
        [
            "title" => "Full Metal Jacket",
            "director" => "Stanley Kubrick",
            "year" => '1987',
            "actors" => [
                'joker' => [
                    'firstname' => 'Matthew',
                    'lastname' => 'Modine'
                ],
                'cowboy' => [
                    'firstname' => 'Arliss',
                    'lastname' => 'Howard'
                ],
                'baleine' => [
                    'firstname' => 'Vincent',
                    'lastname' => "D'Onofrio"
                ],
            ]
        ],
        [
            "title" => "Mean Streets",
            "director" => "Martin Scorsese",
            "year" => '1973'
        ],
    ];
    foreach($dom as $key => $value){
        $node = $xml->wrapBuildTree($value,'movie');
        $root->appendChild($node);
    }
    echo $xml->display();
?>
