<?php

class Kosarica
{


//read one
    public static function readOne($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        SELECT * from kosarica where sifra=:sifra 

        
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
        
        select * 
        from kosarica a left join oprema b on a.oprema =b.sifra 
        
        ');
        $izraz->execute(); 
        return $izraz->fetchAll(); 
    }
//create
public static function create($p)
{

    $veza = DB::getInstance();
    $izraz = $veza->prepare('
    
    insert into kosarica
        (oprema,ukupna_tezina_proizvoda,ukupna_cijena_proizvoda,datum_isporuke,kolicina_opreme)
        values
        (:oprema,:ukupna_tezina_proizvoda,:ukupna_cijena_proizvoda,:datum_isporuke,:kolicina_opreme);
    
    ');
    $izraz->execute($p);
    return $veza->lastInsertId();
}




    public static function update($p)
    {
        $veza = DB::getInstance();
         $izraz = $veza->prepare('
            update kosarica set
            oprema=:oprema,
            ukupna_tezina_proizvoda=:ukupna_tezina_proizvoda,
            ukupna_cijena_proizvoda=:ukupna_cijena_proizvoda,
            datum_isporuke=:datum_isporuke,
            kolicina_opreme=:kolicina_opreme
            where sifra=:sifra
            ');
            $izraz->execute($p); 

    }

    public static function delete($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
           delete from kosarica where sifra=:sifra 
        
        ');
        $izraz->execute([
            'sifra'=>$sifra
        ]);
    }
}