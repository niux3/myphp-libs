<?php
    header('Content-Type: text/xml; charset=utf-8');
    require_once './libs/XMLWriterDom.php';
    $xml = new XMLWriterDom();
    $xml->preserveWhiteSpace = false;
    $xml->formatOutput = true;
    $xml->load('./data.xml');

    $root = $xml->documentElement;
    $dom = [
        "os" => [
            'gnu_linux' => [
                'arch?test=false' => '',
                'debian?paying=false' => [
                    'lenny' => '2009',
                    'Squeeze' => '2011',
                    'Wheezy' => '2013',
                    'Jessie' => '2015',
                    'Stretch' => '2017',
                    'fork' => [
                        'ubuntu' => [
                            'HardyHeron' => '2008',
                            'lucidlynx?best=true' => '2010',
                            'PrecisePangolin' => '2012',
                            'fork' => [
                                'elementary_os' => [
                                    'Luna' => '2013',
                                    'Loki' => '2015',
                                ]
                            ]
                        ]
                    ]
                ],
                'slakware' => [
                    'thirteen' => '2009',
                    'fourteen' => '2012',
                    'fork' => [
                        'suse?best=true&t=i+love+you' => [
                            'six' => '2000',
                            'eight' => '2001',
                        ]
                    ]
                ],
                'redhat?test=false' => '',
            ],
            'windows?state=bad&virus=true&t=i+hate+this+one' => [
                'version_9x' => [
                    'ninetyfive' => '1995',
                    'ninetyeight' => '1998',
                    'ninetyeightse' => '1998',
                ],
                'nt' => [
                    'nt97' => '1997',
                    'nt4' => '2000',
                    'xp' => '2001',
                    'vista' => '2007',
                    'seven' => '2009',
                    'eight' => '2009',
                    'ten' => '2014',
                ]
            ]
        ]
    ];
    $xml->buildTree($root, $dom);
    echo $xml->saveXML();
?>
