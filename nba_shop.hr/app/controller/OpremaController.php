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
            'igrac'=>1,
            'cijena'=>'',
            'tezina_proizvoda'=>'',
            'vrsta_proizvoda'=>''
            
        ]);
        header('location: ' . App::config('url') 
                . 'oprema/promjena/' . $noviOprema);
    }

    public function promjena($sifra)
    {
    
        $this->entitet = (object) $_POST;
        $this->entitet->sifra=$sifra;
    
        if($this->kontrola()){
            Oprema::update((array)$this->entitet);
            header('location: ' . App::config('url') . 'oprema');
            return;
        }

        $this->view->render($this->phtmlDir . 'detalji',[
            'e'=>$this->entitet,
            'poruka'=>$this->poruka
        ]);
    }

    private function kontrola()
    {
      
    }
    // public function brisanje($sifra)
    // {
    //     Oprema::delete($sifra);
    //     header('location: ' . App::config('url') . 'oprema');
    // }


}