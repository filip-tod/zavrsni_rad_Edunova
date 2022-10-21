<?php

class OpremaController extends AutorizacijaController
{

    private $phtmlDir = 'privatno' . 
        DIRECTORY_SEPARATOR . 'oprema' .
        DIRECTORY_SEPARATOR;

    private $entitet=null;
    private $poruka='';

    public function index()
    {
        $this->view->render($this->phtmlDir . 'index',[
            'entiteti'=>Oprema::read()
        ]);
    }

    public function novi()
    {
        $noviOprema = Oprema::create([   
            'velicina'=>'',
            'boja'=>'',
            'igrac'=>null,
            'cijena'=>'',
            'tezina_proizvoda'=>'',
            'vrsta_proizvoda'=>''
            
        ]);
        header('location: ' . App::config('url') 
                . 'oprema/promjena/' . $noviOprema);
    }

    public function brisanje($sifra)
    {
        Oprema::delete($sifra);
        header('location: ' . App::config('url') . 'oprema');
    }


}