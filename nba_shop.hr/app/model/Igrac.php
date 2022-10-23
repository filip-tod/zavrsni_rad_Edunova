<?php

class Igrac
{
    public static function readOne($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        SELECT a.sifra, a.nba_team, a.ime, a.prezime, a.rings_count
        FROM igrac a 
        left join nba_team b
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
        insert into igrac (nba_team,ime,prezime,rings_count)
        values (:nba_team,:ime,:prezime,:rings_count);
           
        ');
        $izraz->execute([
            'nba_team'=>$p['nba_team'],
            'ime'=>$p['ime'],
            'prezime'=>$p['prezime'],
            'rings_count'=>$p['rings_count']
        ]);
    
        return $veza->commit();
         
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
        $izraz->execute([
            'nba_team'=>$p['nba_team'],
            'ime'=>$p['ime'],
            'prezime'=>$p['prezime'],
            'rings_count'=>$p['rigs_count']

        ]);

        $veza->commit();

    }

    public static function delete($sifra)
    {
        $veza = DB::getInstance();
        $veza->beginTransaction();
        $izraz = $veza->prepare('
        delete from igrac where sifra=:sifra
    ');
    $izraz->execute([
        'sifra'=>$sifra
    ]);

    $veza->commit();
}
}

