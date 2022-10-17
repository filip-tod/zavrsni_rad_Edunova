<?php

class oprema
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
}