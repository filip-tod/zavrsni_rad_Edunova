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
            'nba_team'=>1,
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
        $nba_team=$this->ucitajNba_team();
       

        if(!isset($_POST['ime'])){

            $e = Igrac::readOne($sifra);
            if($e==null){
                header('location: ' . App::config('url') . 'igrac');
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
            if($this->entitet->nba_team==0){
                $this->entitet->nba_team=null;

            Igrac::update((array)$this->entitet);
            header('location: ' . App::config('url') . 'igrac');
            return;
        }

        $this->view->render($this->phtmlDir . 'detalji',[
            'e'=>$this->entitet,
            'poruka'=>$this->poruka
        ]); 
        $this->detalji($this->entitet,$nba_team,$this->poruka);
    }

## DETALJI
private function detalji($nba_team,$e,$poruka)
{
    $this->view->render($this->phtmlDir . 'detalji',[
        'e'=>$e,
        'nba_team'=>$nba_team,
        'poruka'=>$poruka
    ]);
} 
## UČITAJ NBA_TEAM
private function ucitajNba_team()
{
    $lista = [];
    $s = new stdClass();
    $s->sifra=0;
    $s->ime_kluba='odaberi ekipu';
    $lista[]=$s;
    foreach(Nba_team::read() as $p){
        $lista[]=$p;
    }
    return $lista;
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



    
        

