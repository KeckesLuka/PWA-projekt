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
            <h1>Registracija</h1>
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
        <section role="main">
        <div class="Unospodataka">
<form enctype="multipart/form-data" action="registracija.php" method="POST" class="registracija">
                <div>
                    <label for="ime">Ime: </label>
                    <div class="form-field">
                        <input type="text" name="ime" id="ime">
                    </div>
                    <span id="porukaIme" class="bojaPoruke"></span>
                </div>
                <br>
                <div>
                    <label for="about">Prezime: </label>
                    <div class="form-field">
                        <input type="text" name="prezime" id="prezime">
                    </div>
                    <span id="porukaPrezime" class="bojaPoruke"></span>
                </div>
                <br>
                <div>
                    <label for="content">Korisničko ime:</label>
                    <!-- Ispis poruke nakon provjere korisničkog imena u bazi -->
                    <div class="form-field">
                        <input type="text" name="username" id="username">
                        <span id="porukaUsername" class="bojaPoruke"></span>
                    </div>
                </div>
                <br>
                <div>
                    <label for="lozinka">Lozinka: </label>
                    <div class="form-field">
                        <input type="password" name="pass" id="pass">
                    </div>
                    <span id="porukaPass" class="bojaPoruke"></span>
                </div>
                <br>
                <div>
                    <label for="lozinka_ponovno">Ponovite lozinku: </label>
                    <div class="form-field">
                        <input type="password" name="passRep" id="passRep">
                    </div>
                    <span id="porukaPassRep" class="bojaPoruke"></span>
                </div>
                <br>
                <div>
                    <button class="gumb_registracija gumb" type="submit" value="Registracija" id="registracija" name="registracija">Registracija</button>
                </div>
                <br>
            </form>
        </div>

        </section>
        <?php
        if (isset($_POST['registracija'])) {
            include 'connect.php';
            //Dohvaćanje varijabli iz forme
            $ime = $_POST['ime'];
            $prezime = $_POST['prezime'];
            $username = $_POST['username'];
            $lozinka = $_POST['pass'];
            $hashed_password = password_hash($lozinka, CRYPT_BLOWFISH);
            $razina = 0;
            $registriranKorisnik = '';
            $msg = '';

            //Provjera postoji li u bazi već korisnik s tim korisničkim imenom
            $sql = "SELECT korisnicko_ime FROM korisnik WHERE korisnicko_ime = ?";
            $stmt = mysqli_stmt_init($dbc);
            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, 's', $username);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
            }
            if (mysqli_stmt_num_rows($stmt) > 0) {
                echo "<p class ='obavijesti'>Korisničko ime već postoji!</p>";
                // $msg='Korisničko ime već postoji!';
            } else {
                // Ako ne postoji korisnik s tim korisničkim imenom - Registracija korisnika u bazi pazeći na SQL injection

                $sql = "INSERT INTO korisnik (ime, prezime,korisnicko_ime, lozinka, razina)VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($dbc);
                if (mysqli_stmt_prepare($stmt, $sql)) {

                    mysqli_stmt_bind_param($stmt, 'ssssd', $ime, $prezime, $username, $hashed_password, $razina);
                    mysqli_stmt_execute($stmt);

                    $registriranKorisnik = true;

                    if ($registriranKorisnik == true) {
                        echo '<p class ="obavijesti">Korisnik je uspješno registriran!</p>';
                    } else {
                        echo '<p class ="obavijesti">Došlo je do greške, pokušajte ponovno!';
                    }
                }
            }
            mysqli_close($dbc);
        }
        ?>

    </main>
    <script type="text/javascript">
        document.getElementById("registracija").onclick = function(event) {

            var slanjeForme = true;

            // Ime korisnika mora biti uneseno
            var poljeIme = document.getElementById("ime");
            var ime = document.getElementById("ime").value;
            if (ime.length == 0) {
                slanjeForme = false;
                poljeIme.style.border = "1px dashed red";
                document.getElementById("porukaIme").innerHTML = "<br>Unesite ime!<br>";
            } else {
                poljeIme.style.border = "1px solid green";
                document.getElementById("porukaIme").innerHTML = "";
            }

            // Prezime korisnika mora biti uneseno
            var poljePrezime = document.getElementById("prezime");
            var prezime = document.getElementById("prezime").value;
            if (prezime.length == 0) {
                slanjeForme = false;
                poljePrezime.style.border = "1px dashed red";
                document.getElementById("porukaPrezime").innerHTML = "<br>Unesite prezime!<br>";
            } else {
                poljePrezime.style.border = "1px solid green";
                document.getElementById("porukaPrezime").innerHTML = "";
            }

            // Korisničko ime mora biti uneseno
            var poljeUsername = document.getElementById("username");
            var username = document.getElementById("username").value;
            if (username.length == 0) {
                slanjeForme = false;
                poljeUsername.style.border = "1px dashed red";
                document.getElementById("porukaUsername").innerHTML = "<br>Unesite korisničko ime!<br>";
            } else {
                poljeUsername.style.border = "1px solid green";
                document.getElementById("porukaUsername").innerHTML = "";
            }

            // Provjera podudaranja lozinki
            var poljePass = document.getElementById("pass");
            var pass = document.getElementById("pass").value;
            var poljePassRep = document.getElementById("passRep");
            var passRep = document.getElementById("passRep").value;
            if (pass.length == 0 || passRep.length == 0 || pass != passRep) {
                slanjeForme = false;
                poljePass.style.border = "1px dashed red";
                poljePassRep.style.border = "1px dashed red";
                document.getElementById("porukaPass").innerHTML = "<br>Lozinke nisu iste!<br>";
                document.getElementById("porukaPassRep").innerHTML = "<br>Lozinke nisu iste!<br>";
            } else {
                poljePass.style.border = "1px solid green";
                poljePassRep.style.border = "1px solid green";
                document.getElementById("porukaPass").innerHTML = "";
                document.getElementById("porukaPassRep").innerHTML = "";
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