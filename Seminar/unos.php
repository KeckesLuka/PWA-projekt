<!DOCTYPE HTML>
<html lang="en">

<head>
    <title>Projekt</title>
    <meta name="author" content="Luka Kečkeš" />
    <meta name="description" content="0246097905" />
    <link rel="apple-touch-icon" sizes="180x180" href="slike/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="slike/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="slike/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="stylesheet" type="text/css" href="Style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Exo:ital,wght@1,200&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alegreya+SC&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome-free-5.15.1-web/css/all.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8" />
</head>

<body>
    <a id="vrh"></a>
    <header>
        <hr>
        <div class="container">
            <h1>Unos</h1>
            <nav>
                <a href="indeks.html"> Naslovnica </a>
                <a href="unos.php"> Unos </a>
                <a href="kategorija.php?id=film"> Film </a>
                <a href="kategorija.php?id=igra"> Igra </a>
                <a href="registracija.php"> Registracija </a>
                <a href="administracija.php"> Administarcija </a>
            </nav>
        </div>
    </header>
    <main>
        <div class="Unospodataka">
            <h1>Unos podataka</h1>
            <form enctype="multipart/form-data" action="skripta.php" method="POST">
                <div class="form-item">
                    <label for="title">Naslov vijesti</label>
                    <div class="form-field">
                        <input type="text" name="title" class="form-field-textual">
                    </div>
                    <span id="porukaTitle" class="bojaPoruke"></span>
                </div>
                <div class="form-item">
                    <label for="about">Kratki sadržaj vijesti (do 50 znakova)</label>
                    <div class="form-field">
                        <textarea name="about" id="" cols="30" rows="10" class="form_field-textual"></textarea>
                    </div>
                    <span id="porukaAbout" class="bojaPoruke"></span>
                </div>
                <div class="form-item">
                    <label for="content">Sadržaj vijesti</label>
                    <div class="form-field">
                        <textarea name="content" id="" cols="30" rows="10" class="form-field-textual"></textarea>
                    </div>
                    <span id="porukaContent" class="bojaPoruke"></span>
                </div>
                <div class="form-item">
                    <label for="pphoto">Slika: </label>
                    <div class="form-field">
                        <input type="file" accept="image/gif, image/jpg" class="input-text" name="pphoto" id="pphoto" />
                    </div>
                    <span id="porukaSlika" class="bojaPoruke"></span>
                </div>
                <div class="form-item">
                    <label for="category">Kategorija vijesti</label>
                    <div class="form-field">
                        <select name="category" id="" class="form-field-textual">
                            <option value="film">Film</option>
                            <option value="igra">Igra</option>
                        </select>
                    </div>
                    <span id="porukaKategorija" class="bojaPoruke"></span>
                </div>
                <div class="form-item">
                    <label>Spremiti u arhivu:
                        <div class="form-field">
                            <input type="checkbox" name="archive">
                        </div>
                    </label>
                </div>
                <div class="form-item">
                    <button type="reset" name="ponisti" value="Poništi">Poništi</button>
                    <button type="submit" name="prihvati" value="slanje">Prihvati</button>
                </div>
            </form>
        </div>

    </main>
    <script type="text/javascript">
        // Provjera forme prije slanja
        document.getElementById("slanje").onclick = function(event) {

            var slanjeForme = true;

            // Naslov vjesti (5-30 znakova)
            var poljeTitle = document.getElementById("title");
            var title = document.getElementById("title").value;

            if (title.length < 5 || title.length > 30) {

                slanjeForme = false;
                poljeTitle.style.border = "1px dashed red";
                document.getElementById("porukaTitle").innerHTML = "Naslov vijesti mora imati između 5 i 30 znakova!<br>";

            } else {
                poljeTitle.style.border = "1px solid green";
                document.getElementById("porukaTitle").innerHTML = "";
            }

            // Kratki sadržaj (10-100 znakova)
            var poljeAbout = document.getElementById("about");
            var about = document.getElementById("about").value;

            if (about.length < 10 || about.length > 100) {

                slanjeForme = false;
                poljeAbout.style.border = "1px dashed red";
                document.getElementById("porukaAbout").innerHTML = "Kratki sadržaj mora imati između 10 i 100 znakova!<br>";

            } else {
                poljeAbout.style.border = "1px solid green";
                document.getElementById("porukaAbout").innerHTML = "";
            }

            // Sadržaj mora biti unesen
            var poljeContent = document.getElementById("content");
            var content = document.getElementById("content").value;

            if (content.length == 0) {

                slanjeForme = false;
                poljeContent.style.border = "1px dashed red";
                document.getElementById("porukaContent").innerHTML = "Sadržaj mora biti unesen!<br>";

            } else {
                poljeContent.style.border = "1px solid green";
                document.getElementById("porukaContent").innerHTML = "";
            }

            // Slika mora biti unesena
            var poljeSlika = document.getElementById("pphoto");
            var pphoto = document.getElementById("pphoto").value;

            if (pphoto.length == 0) {

                slanjeForme = false;
                poljeSlika.style.border = "1px dashed red";
                document.getElementById("porukaSlika").innerHTML = "Slika mora biti unesena!<br>";

            } else {
                poljeSlika.style.border = "1px solid green";
                document.getElementById("porukaSlika").innerHTML = "";
            }

            // Kategorija mora biti odabrana
            var poljeCategory = document.getElementById("category");

            if (document.getElementById("category").selectedIndex == 0) {
                slanjeForme = false;
                poljeCategory.style.border = "1px dashed red";

                document.getElementById("porukaKategorija").innerHTML = "Kategorija mora biti odabrana!<br>";
            } else {

                poljeCategory.style.border = "1px solid green";
                document.getElementById("porukaKategorija").innerHTML = "";
            }

            if (slanjeForme != true) {
                event.preventDefault();
            }

        };
    </script>
    <footer>
        <hr>
        <p class="podaci">Luka Kečkeš | 0246097905 | lukakeckes.1999@gmail.com | 2022</p>
    </footer>

</body>

</html>