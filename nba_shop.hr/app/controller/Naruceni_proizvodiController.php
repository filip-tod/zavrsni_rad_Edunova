<?php

class Naruceni_proizvodiController extends AutorizacijaController
{

    private $phtmlDir = 'privatno' . 
        DIRECTORY_SEPARATOR . 'naruceni_proizvodi' .
        DIRECTORY_SEPARATOR;

    private $entitet=null;
    private $poruka='';

    public function index()
    {
        $this->view->render($this->phtmlDir . 'index',[
            'entiteti'=>Naruceni_proizvodi::read()
        ]);
    }

    public function novi()
    {
        $noviNaruceni = Naruceni_proizvodi::create([   
            'kosarica'=>1,
            'kupac'=>1
            
        ]);
        header('location: ' . App::config('url') 
                . 'naruceni_proizvodi/promjena/' . $noviNaruceni);
    }

    public function promjena($sifra)
    {
    
        $this->entitet = (object) $_POST;
        $this->entitet->sifra=$sifra;
    
        if($this->kontrola()){
            Naruceni_proizvodi::update((array)$this->entitet);
            header('location: ' . App::config('url') . 'naruceni_proizvodi');
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
}