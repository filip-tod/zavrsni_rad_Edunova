<?php

class Igrac
{
    public static function readOne($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        SELECT a.sifra, b.ime_kluba, a.ime, a.prezime, a.rings_count
        FROM igrac a inner join nba_team b
        on a.nba_team =b.sifra 
        where a.sifra=:sifra
        
        ');
        $izraz->execute([
            'sifra'=>$sifra
        ]);
        return $izraz->fetchAll(); 
    }

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

    public static function create($p) //$p kao parametri - napisano skraćeno
    {
        $veza = DB::getInstance();
        $veza->beginTransaction();
        $izraz = $veza->prepare('
        select sifra from nba_team 
        
        ');
        $izraz->execute([
            'sifra'=>$p['nba_team']
        ]);
        $sifraNba = $izraz->fetchColumn();
        
        $izraz = $veza->prepare('
        insert into igrac (nba_team,ime,prezime,rings_count)
        values (:nba_team,:ime,:prezime,:rings_count);
           
        ');
        $izraz->execute([
            'nba_team'=>$sifraNba,
            'ime'=>$p['ime'],
            'prezime'=>$p['prezime'],
            'rings_count'=>$p['rings_count']
        ]);
        $sifraIgrac = $veza->lastInsertId();
        $veza->commit();
        return $sifraIgrac;
    }

    
    

    public static function update($p, $sifra)
    {
        $veza = DB::getInstance();
        $veza->beginTransaction();

        $izraz = $veza->prepare('
        
           select nba_team from igrac where nba_team=:sifra
        
        ');
        $izraz->execute([
            'sifra'=>$p['sifra']
        ]);

        $izraz = $veza->prepare('
            update nba_team set
            ime_kluba=:ime_kluba,
            trener=:trener,
            championships_won=:prezime,
            stadion=:stadion,
            where sifra=:sifra
        ');
        $izraz->execute([
            'ime_kluba'=>$p['sifra'],
            'trener'=>$p['ime'],
            'championships_won'=>$p['prezime'],
            'stadion'=>$p['rigs_count'],
            'sifra'=>$p['sifra']
        ]);

        $izraz = $veza->prepare([

        ]);


        $veza->commit();

    }

    public static function delete($sifra)
    {
        $veza = DB::getInstance();
        $veza->beginTransaction();

        $izraz = $veza->prepare('
        
           select sifra from nba_team where 
        
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

