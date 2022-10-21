<?php

class Oprema
{

    public static function readOne($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        select b.ime , b.prezime , c.ime_kluba , a.velicina ,a.boja , a.cijena 
         from oprema a 
        inner join igrac b 
        on a.igrac  = b.sifra left join nba_team c
        on b.nba_team = c.sifra 
        where a.sifra=:sifra
        
        ');
        $izraz->execute([
            'sifra'=>$sifra
        ]);
        return $izraz->fetch(); 
    }

    // CRUD - R
    public static function read()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        select b.ime , b.prezime , c.ime_kluba , a.velicina ,a.boja , a.cijena 
        from oprema a 
       inner join igrac b 
       on a.igrac  = b.sifra left join nba_team c
       on b.nba_team = c.sifra  
        order by 4,3
        
        ');
        $izraz->execute(); // OVO MORA BITI OBAVEZNO
        return $izraz->fetchAll(); // vraća indeksni niz objekata tipa stdClass
    }

    // CRUD - C

    // select c.ime_kluba , b.ime , b.prezime , a.vrsta_proizvoda  from oprema a
    //  inner join igrac b 
    // on a.igrac = b.sifra  
    // left join nba_team c
    //  on b.nba_team = c.sifra ;

    public static function update($p)
    {
        $veza = DB::getInstance();
        $veza->beginTransaction();

        $izraz = $veza->prepare('
        
           select nba_team from igrac where sifra=:sifra
        
        ');
        $izraz->execute([
            'sifra'=>$p['sifra']
        ]);

        $izraz = $veza->prepare('
           select igrac from oprema where sifra=:sifra
        ');
        $izraz->execute([
          'sifra'=>$p['sifra']
        ]);
        $izraz->execute([
            'velicina'=>$p['velicina'],
            'boja'=>$p['boja'],
            'igrac'=>'sifra',
            'cijena'=>$p['cijena'],
            'tezina_proizvoda'=>$p['tezina_proizvoda'],
            'vrsta_proizvoda'=>$p['vrsta_proizvoda']
        ]);


        $veza->commit();

    }
}
