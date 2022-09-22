<?php

$dev=$_SERVER['SERVER_ADDR']=='127.0.0.1';

if($dev){
return [

    'url'=>'http://nba_shop.hr/',
    'nazivApp'=>'nba_shop',
    'baza'=>[
        'server'=>'localhost',
        'baza'=>'DEV nba_shop',
        'korisnik'=>'root',
        'lozinka'=>'root'
    ]    
];
}else{
    // PRODUKCIJA
    return [
        'dev'=>$dev,
        'url'=>'https://filip-tod.com.hr/',
        'nazivApp'=>'nba_shop',
        'baza'=>[
            'server'=>'localhost',
            'baza'=>'filip_edunovapp25',
            'korisnik'=>'filip_edunova',
            'lozinka'=>'TK.;MXdWfx1H'
        ]
    ];
}
?>