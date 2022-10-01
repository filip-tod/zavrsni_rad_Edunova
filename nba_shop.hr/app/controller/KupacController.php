<?php

class KupacController extends AutorizacijaController

{

    private $phtmlDir = 'privatno' . 
        DIRECTORY_SEPARATOR . 'kupac' .
        DIRECTORY_SEPARATOR;

    private $entitet=null;
    private $poruka='';

    public function index()
    {
        $this->view->render($this->phtmlDir . 'index',[
            'entiteti'=>Kupac::read()
        ]);
    }

    public function novi()
    {
        $noviKupac = Kupac::create([
            'ime'=>'',
            'prezime'=>'',
            'email'=>''
        ]);
        header('location: ' . App::config('url') 
                . 'kupac/promjena/' . $noviKupac);
    }
    
    public function promjena($sifra)
    {
        if(!isset($_POST['ime'])){

            $e = Kupac::readOne($sifra);
            if($e==null){
                header('location: ' . App::config('url') . 'kupac');
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
            Kupac::update((array)$this->entitet);
            header('location: ' . App::config('url') . 'kupac');
            return;
        }

        $this->view->render($this->phtmlDir . 'detalji',[
            'e'=>$this->entitet,
            'poruka'=>$this->poruka
        ]);
    }

    private function kontrola()
    {
        return $this->kontrolaIme() && $this->kontrolaPrezime();
    }

    private function kontrolaIme()
    {
        if(strlen($this->entitet->ime)===0){
            $this->poruka = 'Ime obavezno';
            return false;
        }
        return true;
    }

    private function kontrolaPrezime()
    {
        if(strlen($this->entitet->prezime)===0){
            $this->poruka = 'Prezime obavezno';
            return false;
        }
        return true;
    }

    public function brisanje($sifra)
    {
        Kupac::delete($sifra);
        header('location: ' . App::config('url') . 'kupac');
    }

}