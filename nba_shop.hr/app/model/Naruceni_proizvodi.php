<?php

class Naruceni_proizvodi
{

    public static function readOne($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        select b.ime , b.prezime , c.datum_isporuke , c.ukupna_cijena_proizvoda , c.kolicina_opreme
        from naruceni_proizvodi a inner join kupac b 
        on a.kupac = b.sifra 
        inner join kosarica c on a.kosarica = c.sifra left join oprema d  on c.oprema =d.sifra 
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
        
        select b.ime , b.prezime , c.datum_isporuke , c.ukupna_cijena_proizvoda , c.kolicina_opreme
        from naruceni_proizvodi a inner join kupac b 
        on a.kupac = b.sifra 
        inner join kosarica c on a.kosarica = c.sifra left join oprema d  on c.oprema =d.sifra 
        
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


}