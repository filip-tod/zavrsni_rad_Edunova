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
        $noviIgrac = Igrac::create([   
            'nba_team'=>null,
            'ime'=>'',
            'prezime'=>'',
            'rings_count'=>''
            
        ]);
        header('location: ' . App::config('url') 
                . 'igrac/promjena/' . $noviIgrac);
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

            $this->view->render($this->phtmlDir . 'detalji',[
                'e' => $e,
                'nba_teams'=>$nba_teams,
                'poruka' => 'Unesite podatke'
            ]);
            return;
        }
        

        $this->entitet = (object) $_POST;
        $this->entitet->sifra=$sifra;
    
             Igrac::update((array)$this->entitet);
            header('location: ' . App::config('url') . 'igrac');
            return;
        

        $this->detalji($this->entitet,$nba_teams,$this->poruka);
    }

## DETALJI
private function detalji($nba_teams,$e,$poruka)
{
    $this->view->render($this->phtmlDir . 'detalji',[
        'e'=>$e,
        'nba_teams'=>$nba_teams,
        'poruka'=>$poruka
    ]);
} 
## UČITAJ NBA_TEAM
private function ucitajNba_team()
{
    $nba_teams = [];
    $n = new stdClass();
    $n->sifra=0;
    $n->ime_kluba='odaberi klub';
    $nba_teams[]=$n;
    foreach(Nba_team::read() as $nba_team){
        $nba_teams[]=$nba_team;
    }
    return $nba_teams;
}


## KONTROLA

## BRISANJE
public function brisanje($sifra)
{
    Igrac::delete($sifra);
    header('location: ' . App::config('url') . 'igrac');
}



}



    
        

