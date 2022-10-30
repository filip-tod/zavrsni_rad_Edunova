<?php

class KosaricaController extends AutorizacijaController

{

    private $phtmlDir = 'privatno' . 
        DIRECTORY_SEPARATOR . 'kosarica' .
        DIRECTORY_SEPARATOR;

    private $entitet=null;
    private $poruka='';

    public function index()
    {
        $this->view->render($this->phtmlDir . 'index',[
            'entiteti'=>Kosarica::read()
        ]);
    }
## NOVI
    public function novi()
    {
        $novi = Kosarica::create([   
            'oprema'=>null,
            'ukupna_tezina_proizvoda'=>'',
            'ukupna_cijena_proizvoda'=>'',
            'datum_isporuke'=>'', 
            'kolicina_opreme'=>''           
        ]);
        header('location: ' . App::config('url') 
                . 'kosarica/promjena/' . $novi);
    }
## PROMJENA
    public function promjena($sifra)
    {
        $opreme=$this->ucitajOpreme();
       

        if(!isset($_POST['cijena'])){
            $e = Kosarica::readOne($sifra);
            if($e==null){
                header('location: ' . App::config('url') . 'kosarica');
            }
           
            $this->view->render($this->phtmlDir . 'detalji',[
                'e' => $e,
                'opreme'=>$opreme,
                'poruka' => 'Unesite podatke'
            ]);
            
            return;
        }
        

        $this->entitet = (object) $_POST;
        $this->entitet->sifra=$sifra;
      
        
             Kosarica::update((array)$this->entitet);
            header('location: ' . App::config('url') . 'kosarica');
            
            return
        

        $this->detalji($this->entitet,$opreme,$this->poruka);
    }

## DETALJI
private function detalji($e,$opreme,$poruka)
{
    $this->view->render($this->phtmlDir . 'detalji',[
        'e'=>$e,
        'opreme'=>$opreme,
        'poruka'=>$poruka
    ]);
} 
## UČITAJ NBA_TEAM
private function ucitajOpreme()
{
    $opreme = [];
    $n = new stdClass();
    $n->sifra=0;
    $n->cijena='cijena';
    $n->boja='boja';
    $n->velicina='velicina';
    $n->vrsta_proizvoda='vrsta proizvoda';
    $opreme[]=$n;
    foreach(Oprema::read() as $oprema){
        $opreme[]=$oprema;
    }
    return $opreme;
}


## KONTROLA
  
## BRISANJE
public function brisanje($sifra)
{
    Kosarica::delete($sifra);
    header('location: ' . App::config('url') . 'kosarica');
}



}
