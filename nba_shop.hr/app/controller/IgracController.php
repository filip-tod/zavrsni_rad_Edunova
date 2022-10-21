<?php

class IgracController extends AutorizacijaController

{

    private $phtmlDir = 'privatno' . 
        DIRECTORY_SEPARATOR . 'igrac' .
        DIRECTORY_SEPARATOR;

    private $entitet=null;
    private $poruka='';

    public function index()
    {
        $this->view->render($this->phtmlDir . 'index',[
            'entiteti'=>Igrac::read()
        ]);
    }

    public function novi()
    {
        $noviIgrac = Igrac::create([   
            'nba_team'=>false,
            'ime'=>'',
            'prezime'=>'',
            'rings_count'=>''
            
        ]);
        header('location: ' . App::config('url') 
                . 'igrac/promjena/' . $noviIgrac);
    }

    public function brisanje($sifra)
    {
        Igrac::delete($sifra);
        header('location: ' . App::config('url') . 'igrac');
    }

    public function promjena($sifra)
    {
        if(!isset($_POST['naziv'])){

            $e = Igrac::readOne($sifra);
            if($e==null){
                header('location: ' . App::config('url') . 'igrac');
            }

            $this->view->render($this->phtmlDir . 'update',[
                'e' => $e,
                'poruka' => 'Promjenite podatke'
            ]);
            return;
        }

        $this->entitet = (object) $_POST;
        $this->entitet->sifra=$sifra;
    
    //     if($this->kontrola()){
    //         Igrac::update((array)$this->entitet);
    //         header('location: ' . App::config('url') . 'igrac');
    //         return;
    //     }

        $this->view->render($this->phtmlDir . 'detalji',[
            'e'=>$this->entitet,
            'poruka'=>$this->poruka
        ]);
    }

    // private function kontrola()
    // {
    //     return $this->kontrolaIme() && $this->KontrolaPrezime() && $this->KontrolaRingsCount();
    // }

    // private function kontrolaIme()
    // {
    //     if(strlen($this->entitet->ime)===0){
    //         $this->poruka = 'Ime igrača obavezno !!';
    //         return false;
    //     }
    //     return true;
    // }

    // private function kontrolaPrezime()
    // {
    //     if(strlen($this->entitet->stadion)===0){
    //         $this->poruka = 'Prezime Obavezno';
    //         return false;
    //     }
    //     return true;
    // }

    // private function kontrolaRingsCount()
    // {
    //     if(strlen($this->entitet->ringsCount)===0){
    //         $this->poruka = 'obavezan broj prstena';
    //         return false;
    //     }
    //     return true;
    // }



}