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
## NOVI
    public function novi()
    {
        $novi = Igrac::create([   
            'nba_team'=>1,
            'ime'=>'',
            'prezime'=>'',
            'rings_count'=>''
            
        ]);
        header('location: ' . App::config('url') 
                . 'igrac/promjena/' . $novi);
    }
## PROMJENA
    public function promjena($sifra)
    {
        $nba_teams=$this->ucitajNba_team();
       

        if(!isset($_POST['ime'])){
            $e = Igrac::readOne($sifra);
            if($e==null){
                header('location: ' . App::config('url') . 'igrac');
            }
            $this->detalji($e,$nba_teams,'popuni podatke');
    
            return;
        }
        

        $this->entitet = (object) $_POST;
        $this->entitet->sifra=$sifra;
    
        if($this->kontrola()){
            if($this->entitet->nba_team==0){
                $this->entitet->nba_team=null;
            }
            Igrac::update((array)$this->entitet);
            header('location: ' . App::config('url') . 'igrac');
            return;
        }

        $this->detalji($this->entitet,$nba_teams,$this->poruka);
    }

## DETALJI
private function detalji($nba_teams,$e,$poruka)
    {
        $this->view->render($this->phtmlDir . 'detalji',[
            'e'=>$e,
            'nba_teams'=>$nba_teams,
            'poruka'=>$poruka,
            'css'=>'<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">',
            'js'=>'<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>'
       
          
        ]);
    }
## UČITAJ NBA_TEAM
private function ucitajNba_team()
{
    $nba_teams = [];
    $s = new stdClass();
    $s->sifra=0;
    $s->ime_kluba='odaberi ekipu';
    $nba_teams[]=$s;
    foreach(Nba_team::read() as $nba_team){
        $nba_teams[]=$nba_team;
    }
    return $nba_teams;
}


## KONTROLA
    private function kontrola()
    {
      
    }
## BRISANJE
public function brisanje($sifra)
{
    Igrac::delete($sifra);
    header('location: ' . App::config('url') . 'igrac');
}



}



    
        

