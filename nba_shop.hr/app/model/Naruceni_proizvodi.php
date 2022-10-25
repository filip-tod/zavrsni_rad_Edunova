<?php

class Naruceni_proizvodi
{

    public static function readOne($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        select a.sifra, b.ime , b.prezime , b.email , c.datum_isporuke , c.ukupna_tezina_proizvoda , c.ukupna_cijena_proizvoda 
        from 
        naruceni_proizvodi a 
        inner join kupac b 
        on a.kupac = b.sifra 
        inner join kosarica c 
        on a.kosarica = c.sifra
        where a.sifra =:sifra 

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
        
        select b.ime , b.prezime , c.datum_isporuke , c.ukupna_cijena_proizvoda , c.kolicina_opreme
        from naruceni_proizvodi a inner join kupac b 
        on a.kupac = b.sifra 
        inner join kosarica c on a.kosarica = c.sifra
        
        ');
        $izraz->execute(); // OVO MORA BITI OBAVEZNO
        return $izraz->fetchAll(); // vraća indeksni niz objekata tipa stdClass
    }

    // CRUD - C
    public static function create($p) //$p kao parametri - napisano skraćeno
    {
        $veza = DB::getInstance();
        $veza->beginTransaction();
        $izraz = $veza->prepare('
        insert into naruceni_proizvodi (kosarica,kupac)
        values (:kosarica,:kupac);
           
        ');
        $izraz->execute([
            'kosarica'=>$p['kosarica'],
            'kupac'=>$p['kupac']
        ]);
    
        return $veza->commit();
         
    }

    public static function update($p)
    {
        $veza = DB::getInstance();
        $veza->beginTransaction();
        $izraz = $veza->prepare('
            update naruceni_proizvodi set
            kosarica=:kosarica,
            kupac=:kupac
        ');
        $izraz->execute([
            'kosarica'=>$p['kosarica'],
            'kupac'=>$p['kupac']

        ]);

        $veza->commit();

    }

    public static function delete($sifra)
    {
        $veza = DB::getInstance();
        $veza->beginTransaction();

        $izraz = $veza->prepare('
        
           select kosarica from naruceni_proizvodi where sifra=:sifra
        
        ');
        $izraz->execute([
            'sifra'=>$sifra
        ]);
        $sifraKosarica = $izraz->fetchColumn();

        $izraz = $veza->prepare('
            delete from naruceni_proizvodi where sifra=:sifra
        ');
        $izraz->execute([
            'sifra'=>$sifra
        ]);

        $izraz = $veza->prepare('
            delete from kosarica where sifra=:sifra
        ');
        $izraz->execute([
            'sifra'=>$sifraKosarica
        ]);

        $izraz = $veza->prepare('
        
        select kupac from naruceni_proizvodi where sifra=:sifra
     ');
     $izraz->execute([
         'sifra'=>$sifra
     ]);
     $sifrakupac = $izraz->fetchColumn();

     $izraz = $veza->prepare('
         delete from naruceni_proizvodi where sifra=:sifra
     ');
     $izraz->execute([
         'sifra'=>$sifra
     ]);

     $izraz = $veza->prepare('
         delete from kosarica where sifra=:sifra
     ');
     $izraz->execute([
         'sifra'=>$sifrakupac
     ]);


        $veza->commit();
    }



}