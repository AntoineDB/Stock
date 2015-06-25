$(function () {
    $('.date').datepicker({dateFormat: 'yy-mm-dd'});
});

function deco()
{
    location.href = "index.php";
}
function majbdd(nb, id)
{
    if (nb == "" || id == "")
        return;
    if (window.XMLHttpRequest)
    {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function ()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "./php/majbdd.php?nb=" + nb + "&id=" + id, true);
    xmlhttp.send();
}

function bdd_bor(nb, id, datedebut, datefin)
{
    if (nb == "" || id == "")
        return;
    if (window.XMLHttpRequest)
    {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function ()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "./php/majbdd.php?quantite=" + nb.value + "&id=" + id + "&datedebut=" + datedebut.value + "&datefin=" + datefin.value, true);
    xmlhttp.send();
}

function bdd_new(new_name, new_quantite, new_description)
{
    if (new_name == "" || new_quantite == "")
        return;
    if (window.XMLHttpRequest)
    {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function ()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "./php/majbdd.php?new_name=" + new_name.value + "&new_quantite=" + new_quantite.value + "&new_description=" + new_description.value, true);
    xmlhttp.send();
}

function bdd_update_obj(id, name, quantite, description)
{
    if (name == "" || quantite == "")
        return;
    if (window.XMLHttpRequest)
    {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function ()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "./php/majbdd.php?id=" + id + "&up_name=" + name.value + "&up_quantite=" + quantite.value + "&up_description=" + description.value, true);
    xmlhttp.send();
}

function bdd_delete_obj(id)
{
    if (window.XMLHttpRequest)
    {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function ()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "./php/majbdd.php?id=" + id + "&delete=true", true);
    xmlhttp.send();
}
function supprNotif(id)
{

    if (id == "")
        return;
    if (window.XMLHttpRequest)
    {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function ()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            document.getElementById("div"+id).innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "./php/supprnotif.php?id=" + id, true);
    xmlhttp.send();
}



function bdd_return(id, bool)
{
        console.log(bool);
    if (id == "")
        return;
    if (window.XMLHttpRequest)
    {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function ()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            document.getElementById("div"+id).innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "./php/rendre.php?bool=" + bool + "&id=" + id, true);+
    xmlhttp.send();
}



function majrendu(nb, id, i)
{
    if (nb == "" || id == "")
        return;
    if (window.XMLHttpRequest)
    {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function ()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            document.getElementById("ligne"+i).innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "./php/majrendu.php?nb=" + nb + "&id=" + id, true);
    xmlhttp.send();
}
