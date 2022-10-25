
     $( '#uvjet' ).autocomplete({
        source: function(req,res){
           $.ajax({
               url: url + 'nba_team/trazi?term=' + req.term + 
                    '&igrac=' + igrac,
               success:function(odgovor){
                   res(JSON.parse(odgovor));
                //console.log(odgovor);
            }
           }); 
        },
        minLength: 2,
        select:function(dogadaj,ui){
            console.log(ui.item);
            spremi(ui.item);
        }
    }).autocomplete( 'instance' )._renderItem = function( ul, item ) {
        return $( '<li>' )
          .append( '<div>' + item.ime + ' ' + item.prezime + '<div>')
          .appendTo( ul );
      };

function spremi(igrac){
    $.ajax({
        url: url + 'igrac/dodajigrac?igrac=' + nba_team + 
             '&nba_team=' + nba_team.sifra,
        success:function(odgovor){
           $('#podaci').append(
            '<tr>' + 
                '<td>' +
                    nba_team.ime_kluba  +
                '</td>' + 
                '<td>' +
                    '<a class="brisiPolaznika" href="#" id="p_' + igrac.sifra +  '">' +
                    ' <i style="color: red;" ' +
                    ' class="step fi-page-delete size-36"></i>' +
                    '</a>' +
                '</td>' + 
            '</tr>'
           );
           definirajBrisanje();
     }
    }); 
}

definirajBrisanje();