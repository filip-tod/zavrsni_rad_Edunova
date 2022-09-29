<?php

class kupac
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

    public static function create($e)
    {

        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            insert into 
            kupac(ime,prezime,email)
            values (:ime,:prezime,:email);
        
        ');
        $izraz->execute($e);
    }

    public static function update($e)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            update smjer set
                ime=:ime,
                prezime=:prezime,
                email=:email,
                    where sifra=:sifra
        
        ');
        $izraz->execute($e);
        
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