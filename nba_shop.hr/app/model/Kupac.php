<?php

class Kupac
{
    public static function readOne($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            select * from kupac where sifra=:sifra
        
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
        
            select * from kupac order by ime, prezime
        
        ');
        $izraz->execute(); // OVO MORA BITI OBAVEZNO
        return $izraz->fetchAll(); // vraća indeksni niz objekata tipa stdClass
    }

    public static function create($kupac)
    {

        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            insert into 
            kupac(ime,prezime,email)
            values (:ime,:prezime,:email);
        
        ');
        $izraz->execute($kupac);
        return $veza->lastInsertId();
    }

    public static function update($kupac)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            update kupac set
                ime=:ime,
                prezime=:prezime,
                email=:email
                    where sifra=:sifra
        
        ');
        $izraz->execute($kupac);
    }

    public static function delete($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            delete from kupac where sifra=:sifra
        
        ');
        $izraz->execute([
            'sifra'=>$sifra
        ]);
    }

}