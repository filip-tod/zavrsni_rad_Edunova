<?php

class Oprema
{

    public static function readOne($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        select * from oprema 
        where 
        sifra=:sifra
        
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
        
        select a.sifra, b.ime , b.prezime , c.ime_kluba , a.velicina ,a.boja , a.cijena 
        from oprema a 
       inner join igrac b 
       on a.igrac  = b.sifra left join nba_team c
       on b.nba_team = c.sifra  
        order by 4,3
        
        ');
        $izraz->execute(); // OVO MORA BITI OBAVEZNO
        return $izraz->fetchAll(); // vraća indeksni niz objekata tipa stdClass
    }

    public static function create($p) //$p kao parametri - napisano skraćeno
    {
        $veza = DB::getInstance();
        $veza->beginTransaction();
        $izraz = $veza->prepare('
        insert into oprema (velicina,boja,igrac,cijena,tezina_proizvoda,vrsta_proizvoda)
        values (:velicina,:boja,:igrac,:cijena,:tezina_proizvoda,:vrsta_proizvoda);
           
        ');
        $izraz->execute([
            'velicina'=>$p['velicina'],
            'boja'=>$p['boja'],
            'igrac'=>$p['igrac'],
            'cijena'=>$p['cijena'],
            'tezina_proizvoda'=>$p['tezina_proizvoda'],
            'vrsta_proizvoda'=>$p['vrsta_proizvoda']
        ]);
    
        return $veza->commit();
         
    }

    public static function update($p)
    {
        $veza = DB::getInstance();
        $veza->beginTransaction();
        $izraz = $veza->prepare('
        update oprema set
        velicina=:velicina,
        boja=:boja,
        igrac=:igrac,
        cijena=:cijena,
        tezina_proizvoda=:tezina_proizvoda,
        vrsta_proizvoda=:vrsta_proizvoda,
        where sifra=:sifra
    ');
    $izraz->execute([
        'velicina'=>$p['velicina'],
        'boja'=>$p['boja'],
        'cijena'=>$p['cijena'],
        'tezina_proizvoda'=>$p['tezina_proizvoda'],
        'vrsta_proizvoda'=>$p['vrsta_proizvoda']
    ]);
    
        return $veza->commit();
         
    }

    public static function delete($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
           delete from oprema where sifra=:sifra 
        
        ');
        $izraz->execute([
            'sifra'=>$sifra
        ]);
        
    }
    
}
