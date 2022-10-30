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

    public function promjena($sifra)
    {
        $igraci=$this->ucitajIgraci();
       

        if(!isset($_POST['ime'])){

            $e = Oprema::readOne($sifra);
            if($e==null){
                header('location: ' . App::config('url') . 'oprema');
            }

            $this->view->render($this->phtmlDir . 'detalji',[
                'e' => $e,
                'igraci'=>$igraci,
                'poruka' => 'Unesite podatke'
            ]);
            return;
        }


        $this->entitet = (object) $_POST;
        $this->entitet->sifra=$sifra;
    
        
            Oprema::update((array)$this->entitet);
            header('location: ' . App::config('url') . 'oprema');
            return;
    
        $this->detalji($this->entitet,$igraci,$this->poruka);
    }

    ## DETALJI
private function detalji($igraci,$e,$poruka)
{
    $this->view->render($this->phtmlDir . 'detalji',[
        'e'=>$e,
        'igraci'=> $igraci,
        'poruka'=>$poruka
    ]);
} 
## UČITAJ NBA_TEAM
private function ucitajIgraci()
{
    $igraci = [];
    $n = new stdClass();
    $n->sifra=0;
    $n->ime='Odaberi ime i ';
    $n->prezime='prezime igrača';
    $igraci[]=$n;
    foreach(Igrac::read() as $igrac){
        $igraci[]=$igrac;
    }
    return $igraci;
}


## KONTROLA
    private function kontrola()
    {
      
    }
## BRISANJE
public function brisanje($sifra)
{
    Oprema::delete($sifra);
    header('location: ' . App::config('url') . 'Oprema');
}

      
    }
   