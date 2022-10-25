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
        $igrac=$this->ucitajIgrac();
       

        if(!isset($_POST['velicina'])){

            $e = Oprema::readOne($sifra);
            if($e==null){
                header('location: ' . App::config('url') . 'oprema');
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
            Oprema::update((array)$this->entitet);
            header('location: ' . App::config('url') . 'oprema');
            return;
        }

        $this->view->render($this->phtmlDir . 'detalji',[
            'e'=>$this->entitet,
            'poruka'=>$this->poruka
        ]); 
        $this->detalji($this->entitet,$igrac,$this->poruka);
    }

    ## DETALJI
private function detalji($oprema,$e,$poruka)
{
    $this->view->render($this->phtmlDir . 'detalji',[
        'e'=>$e,
        'oprema'=>$oprema,
        'poruka'=>$poruka
    ]);
} 
## UČITAJ NBA_TEAM
private function ucitajIgrac()
{
    $igraci = [];
    $n = new stdClass();
    $n->sifra=0;
    $n->naziv='Odaberi ekipu';
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
   