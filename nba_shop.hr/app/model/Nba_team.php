<?php

class Nba_team
{
    public static function readOne($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            select * from nba_team where sifra=:sifra
        
        ');
        $izraz->execute([
            'sifra'=>$sifra
        ]);
        return $izraz->fetch(); 
    }

    public static function read()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        select * from nba_team order by ime_kluba, championships_won
        
        ');
        $izraz->execute(); // OVO MORA BITI OBAVEZNO
        return $izraz->fetchAll(); // vraća indeksni niz objekata tipa stdClass
    }

    // public static function create($nba_team)
    // {

    //     $veza = DB::getInstance();
    //     $izraz = $veza->prepare('
        
    //         insert into 
    //         kupac(ime,prezime,email)
    //         values (:ime,:prezime,:email);
        
    //     ');
    //     $izraz->execute($kupac);
    //     return $veza->lastInsertId();
    // }

    public static function update($nba_team)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            update nba_team set
                ime_kluba=:ime_kluba,
                trener=:trener,
                championships_won=:championships_won,
                stadion=:stadion
                    where sifra=:sifra
        
        ');
        $izraz->execute($nba_team);
    }

    // public static function delete($sifra)
    // {
    //     $veza = DB::getInstance();
    //     $izraz = $veza->prepare('
        
    //         delete from kupac where sifra=:sifra
        
    //     ');
    //     $izraz->execute([
    //         'sifra'=>$sifra
    //     ]);
    // }

}