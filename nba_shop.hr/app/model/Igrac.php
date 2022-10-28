<?php

class Igrac
{


//read one
    public static function readOne($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        SELECT * from igrac
        where sifra=:sifra 

        
        ');
        $izraz->execute([
            'sifra'=>$sifra
        ]);
        return $izraz->fetch(); 
    }
// read
    public static function read()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        SELECT  a.rings_count, b.ime_kluba, a.ime , a.prezime  
        FROM igrac a left join nba_team b
        on a.nba_team =b.sifra 
        
        ');
        $izraz->execute(); // OVO MORA BITI OBAVEZNO
        return $izraz->fetchAll(); // vraća indeksni niz objekata tipa stdClass
    }
//create
public static function create($p)
{

    $veza = DB::getInstance();
    $izraz = $veza->prepare('
    
    insert into igrac
        (nba_team,ime,prezime,
        rings_count)
        values
        (:nba_team,:ime,:prezime,
        :rings_count);
    
    ');
    $izraz->execute($p);
    return $veza->lastInsertId();
}




    public static function update($p)
    {
        $veza = DB::getInstance();
        $veza->beginTransaction();
        $izraz = $veza->prepare('
            update igrac set
            nba_team=:nba_team,
            ime=:ime,
            prezime=:prezima,
            rings_count=:rings_count,
            where sifra=:sifra
            ');
            $izraz->execute($p);

    }

    public static function delete($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
           delete from igrac where sifra=:sifra 
        
        ');
        $izraz->execute([
            'sifra'=>$sifra
        ]);
    }

 
}
