<?php
$username=$_POST["uname"];
$passwd = $_POST["psw"];

$dir    = './pdfs';
$l = -1;
$r = -1;
$files= scandir($dir,1);

$max = sizeof ($files);
$x = rand (0,$max);
$y = rand (0,$max);
while ($x = $y)
    $y = rand (0,$max);

function checkpass ()
{
    global $username;
    global $passwd;
    $res = false;
    switch ($username)
    {
        case "mwj1": if ($passwd == "bollocks")
            $res = true;
            break;
        case "tlgleave":  if ($passwd = "dpac1473")
            $res = true;
            break;
        case "floyd78":  if ($passwd = "dpac8372")
            $res = true;
            break;
        case "psbenyin":  if ($passwd = "dpac3254")
            $res = true;
            break;
        case "Felix.Ikuomola":  if ($passwd = "dpac2314")
            $res = true;
            break;
        case "Stephanie.Mo":  if ($passwd = "dpac2357")
            $res = true;
            break;
        case "Alistair.Jones":  if ($passwd = "dpac2364")
            $res = true;
            break;
        case "E.Okoturo":  if ($passwd = "dpac3674")
            $res = true;
            break;
        case "L.Abdul-Kadir":  if ($passwd = "dpac2114")
            $res = true;
            break;
        case "Alzahrah.Alshayeb":  if ($passwd = "dpac2346")
            $res = true;
            break;
        case "liam.dougherty":  if ($passwd = "dpac3426")
            $res = true;
            break;
        case "rawais":  if ($passwd = "dpac3685")
            $res = true;
            break;
        default: $res = false;
        break;
    }
echo ("<div id='user' style='display:none'>" . $username . "</div>");
    return ($res);
}
function getpicture1($side)
{
    global $files;
    global $max;
    global $l;
    global $r;
    $x = rand (0,$max-3);
    if ($side == "l")
    $l = $x;
    else 
    $r = $x;

    if ($side == "r" and $l == $r)
        $x = rand (0,$max-3);
    
    return ( $files[$x]);
}
echo ("<html>");
function getfile ($val)
{
    global $files;
    return $files[$val];

}
if (checkpass() == true) : ?>
    <div style="display:block" id="bettworse"><table width="100%"><tr><td><button onclick="setbut('a')">A is Better</button></td>
    <td><button onclick="setbut('b')">B is Better</button></td></tr></table></div>
<div style="display:none" id="rationale">
</b>How confident are you?</b>  <i>Unsure</i> <input id="conf" type="range" > <i>Very confident</i>
</input>
<br>
<table width="50%"><tr><td>
Positives about a:</td><td> <textarea id="apos" rows=3 cols=40></textarea></td><td>
Negatives about a:</td><td> <textarea id="aneg" rows=3 cols=40></textarea></td></tr>
<tr><td>
Positives about b: </td><td><textarea id="bpos" rows=3 cols=40></textarea></td><td>
Negatives about b:</td><td> <textarea id="bneg" rows=3 cols=40></textarea></td></tr></table>
<p>
<button onclick="nextpair()">Submit answer</button>
</div>
<div id="pictures">
<table width=100% height=100%><tr><td><object data="./pdfs/<?=getpicture1("l")?>" type="application/pdf" width="100%" height="100%">   <p><b>Example fallback content</b>: This browser does not support PDFs. Please download the PDF to view it: <a href="/pdf/sample-3pp.pdf">Download PDF</a></object></td><td><object data="./pdfs/<?=getpicture1("r")?>" type="application/pdf" width="100%" height="100%">  <p><b>Example fallback content</b>: This browser does not support PDFs. Please download the PDF to view it: <a href="/pdf/sample-3pp.pdf">Download PDF</a></object></td></tr></table></object>
</div>
</object>

<script>
var buttonval = "";
function setbut(val)
{
buttonval = val;
document.getElementById ("rationale").style.display="block";
document.getElementById ("bettworse").style.display="none";
}

function nextpair()
{

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
       // Typical action to be performed when the document is ready:
        location.reload();
    }
};
bestfile = "";
worstfile = "";
    bestfile = "<?=getfile($l)?>";
    worstfile = "<?=getfile($r)?>";
getstring = "writeresult.php?selectbest=" + bestfile + "&selectworst=" + worstfile + "&apos=" + encodeURIComponent (document.getElementById ("apos").value) + "&bpos=" + encodeURIComponent(document.getElementById("bpos").value) + "&aneg=" + encodeURIComponent(document.getElementById("aneg").value) + "&bneg=" + encodeURIComponent(document.getElementById("bneg").value)+ "&conf=" + document.getElementById ("conf").value + "&user=" + document.getElementById("user").innerText  + "&butval=" + buttonval;
xhttp.open("GET",getstring, true); 


xhttp.send();

document.getElementById("rationale").style.display="none";
document.getElementById ("bettworse").style.display= "block";

}
</script>
</html>
<?php else:
echo ("Sorry - invalid password");
echo ("</html>");
endif;
?>
