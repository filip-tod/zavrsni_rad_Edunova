<?php

class Nba_teamController extends AutorizacijaController

{

    private $phtmlDir = 'privatno' . 
        DIRECTORY_SEPARATOR . 'nba_team' .
        DIRECTORY_SEPARATOR;

    private $entitet=null;
    private $poruka='';

    public function index()
    {
        $this->view->render($this->phtmlDir . 'index',[
            'entiteti'=>Nba_team::read()
        ]);
    }

    // public function novi()
    // {
    //     $noviKupac = Nba_team::create([
    //         'ime'=>'',
    //         'prezime'=>'',
    //         'email'=>''
    //     ]);
    //     header('location: ' . App::config('url') 
    //             . 'kupac/promjena/' . $noviKupac);
    // }
    
    public function promjena($sifra)
    {
        if(!isset($_POST['ime_kluba'])){

            $e = Nba_team::readOne($sifra);
            if($e==null){
                header('location: ' . App::config('url') . 'nba_team');
            }

            $this->view->render($this->phtmlDir . 'detalji',[
                'e' => $e,
                'poruka' => 'Unesite podatke'
            ]);
            return;
        }

        $this->entitet = (object) $_POST;
        $this->entitet->sifra=$sifra;
    
        if($this->kontrola()){
            Nba_team::update((array)$this->entitet);
            header('location: ' . App::config('url') . 'nba_team');
            return;
        }

        $this->view->render($this->phtmlDir . 'detalji',[
            'e'=>$this->entitet,
            'poruka'=>$this->poruka
        ]);
    }

    private function kontrola()
    {
        return $this->kontrolaIme_kluba() && $this->KontrolaStadion() && $this->KontrolaChampionships_won();
    }

    private function kontrolaIme_kluba()
    {
        if(strlen($this->entitet->ime_kluba)===0){
            $this->poruka = 'Ime kluba obavezno';
            return false;
        }
        return true;
    }

    private function kontrolaStadion()
    {
        if(strlen($this->entitet->stadion)===0){
            $this->poruka = 'Ime stadiona obavezno';
            return false;
        }
        return true;
    }

    private function kontrolaChampionships_won()
    {
        if(strlen($this->entitet->championships_won)===0){
            $this->poruka = 'obavezan broj prstena';
            return false;
        }
        return true;
    }


}