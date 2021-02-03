nbAdherent = document.getElementById("nbAdherent");
cotisation = document.getElementById("cotisation");
montant = document.getElementById("montant");
datedebut = document.getElementById("datedebut");
datefin = document.getElementById("datefin");
duree = document.getElementById("duree");

cotisation.addEventListener("blur", function() {
    montant.value = nbAdherent.value * cotisation.value;
});

nbAdherent.addEventListener("blur", function(){
    montant.value = nbAdherent.value * cotisation.value;
});

var date_diff_indays = function(date1, date2) 
{
    dt1 = new Date(date1);
    dt2 = new Date(date2);
    return Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate()) ) /(1000 * 60 * 60 * 24));
}

datedebut.addEventListener("blur", function() {
    if(date_diff_indays(datedebut.value,datefin.value) > 0)
    {
        duree.value = date_diff_indays(datedebut.value,datefin.value)+ " jours";
    }
    else
    {
        duree.value = "";
    }
});

datefin.addEventListener("blur", function(){
    if(date_diff_indays(datedebut.value,datefin.value) > 0)
    {
        duree.value = date_diff_indays(datedebut.value,datefin.value)+ " jours";
    }
    else
    {
        duree.value = "";
    }
});




