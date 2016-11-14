<!DOCTYPE html>
<html>
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>SIIKLI</title>
    </head>
    
    <body>
        <div class="sovellus">
            <h1>Työajanseuranta</h1>
            <form action="/siikli/src/code.php" method="post">
                <!-- <div class="floatLeft">Nimi:<input type="text" name="nimi" class="floatRight"><br></div> -->
                <div class="floatLeft">Jere<input type="checkbox" name="jere" value="jere" class="floatRight"/></div>
                <div class="floatLeft">Elias<input type="checkbox" name="elias" value="elias" class="floatRight"/></div>
                <div class="floatLeft">Noora<input type="checkbox" name="noora" value="noora" class="floatRight"/></div>
                <div class="floatLeft">Sami<input type="checkbox" name="sami" value="sami" class="floatRight"/></div>
                <div class="floatLeft">Otso<input type="checkbox" name="otso" value="otso" class="floatRight"/></div>
                <div class="floatLeft">Aloitusaika: <input type="time"  name="aAika" class="floatRight"></div>
                <div class="floatLeft">Lopetusaika: <input type="time" name="lAika" class="floatRight"></div>
                <div class="floatLeft">Päivämäärä: <input type="date" name="pvm" class="floatRight"></div>
                <div class="floatLeft">Selitys (vapaaehtoinen): <input type="text" name="selitys" class="floatRight"></div>
                <input type="submit">
            </form>
        </div>
        <div class="sovellus">
            <form action="/siikli/src/ideat.php" method="post">
                <div class="floatLeft">Kirjoita innovaatio&trade; ja innovoija&trade;: <input type="text" name="idea" class="floatRight">
                    <select name="ideoija" method="post">
                        <option value="jere">Jere</option>
                        <option value="elias">Elias</option>
                        <option value="noora">Noora</option>
                        <option value="sami">Sami</option>
                        <option value="otso">Otso</option>
                        <option value="kaikki">Kaikki/Anonyymi</option>
                    </select>
                </div>
                <input type="submit">
            </form>
        </div>
    </body>
    
    <style>
        .floatLeft {
            float: left;
            width: 100%;
        }
        
        .floatRight {
            float: right;
        }
        
        .sovellus {
            border: solid;
            border-color: black;
            padding: 5pt;
            max-width: 420pt;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 10pt;
            overflow: auto;
        }
        
        h1 {
            margin-top: 0pt;
            text-align: center;
        }
    </style>
    
</html>