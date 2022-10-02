<?php

class Igrac
{
    public static function readOne($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        SELECT a.rings_count, b.ime_kluba, a.ime , a.prezime  
        FROM igrac a inner join nba_team b
        on a.nba_team =b.sifra 
        where a.sifra=:sifra
        
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
        
        SELECT a.rings_count, b.ime_kluba, a.ime , a.prezime  
        FROM igrac a inner join nba_team b
        on a.nba_team =b.sifra 
        group by a.rings_count, b.ime_kluba, a.ime , a.prezime
        
        ');
        $izraz->execute(); // OVO MORA BITI OBAVEZNO
        return $izraz->fetchAll(); // vraća indeksni niz objekata tipa stdClass
    }

    public static function create($p) //$p kao parametri - napisano skraćeno
    {
        $veza = DB::getInstance();
        $veza->beginTransaction();
        $izraz = $veza->prepare('
            insert into igrac (ime,prezime,rings_count)
            values (:ime,:prezime,:rings_count);
        ');
        $izraz->execute([
            'ime'=>$p['ime'],
            'prezime'=>$p['prezime'],
            'rings_count'=>$p['rings_count']
        
        ]);
        $sifraNba = $veza->lastInsertId();
        $izraz = $veza->prepare('
            insert into nba_team (sifra)
            values (sifra);
        ');
        $izraz->execute([
            'sifra'=>$sifraNba,
            'ime'=>$p['ime'],
            'prezime'=>$p['prezime'],
            'rings_count'=>$p['rings_count'],
        ]);
        $sifraCreate = $veza->lastInsertId();
        $veza->commit();
        return $sifraCreate;
    }

    public static function update($igrac)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            update igrac set
                nba_team=:nba_team
                ime=:ime,
                prezime=:prezime,
                rings_count=:rings_count
                    where sifra=:sifra
        
        ');
        $izraz->execute($igrac);
    }

    public static function delete($sifra)
    {
        $veza = DB::getInstance();
        $veza->beginTransaction();

        $izraz = $veza->prepare('
        
           select nba_team from igrac where sifra=:sifra
        
        ');
        $izraz->execute([
            'sifra'=>$sifra
        ]);
        $sifra = $izraz->fetchColumn();

        $izraz = $veza->prepare('
            delete from igrac where sifra=:sifra
        ');
        $izraz->execute([
            'sifra'=>$sifra
        ]);

    

        $veza->commit();
    }
}

