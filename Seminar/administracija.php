<!DOCTYPE HTML>
<html lang="en">

<head>
    <title>Projekt</title>
    <meta name="author" content="Luka Kečkeš" />
    <meta name="description" content="0246097905" />
    <link rel="apple-touch-icon" sizes="180x180" href="Slike/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="Slike/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="Slike/favicon-16x16.png">
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
            <h1>Administarcija</h1>
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
        <?php
        session_start();
        include 'connect.php';
        define('UPLPATH', 'Slike/');
        error_reporting(E_ERROR | E_PARSE);
        if (isset($_POST['prijava'])) {

            //Dohvaćanje varijabli iz forme
            $prijavaImeKorisnika = $_POST['username'];
            $prijavaLozinkaKorisnika = $_POST['lozinka'];

            //Upit koji povezuje korisničko ime sa bazom
            $sql = "SELECT korisnicko_ime, lozinka, razina FROM korisnik WHERE korisnicko_ime = ?";
            $stmt = mysqli_stmt_init($dbc);
            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, 's', $prijavaImeKorisnika);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
            }
            mysqli_stmt_bind_result($stmt, $imeKorisnika, $lozinkaKorisnika, $levelKorisnika);
            mysqli_stmt_fetch($stmt);

            //Provjera lozinke
            if (password_verify($_POST['lozinka'], $lozinkaKorisnika) && mysqli_stmt_num_rows($stmt) > 0) {

                $uspjesnaPrijava = true;

                // Provjera da li je admin
                if ($levelKorisnika == 1) {
                    $admin = true;
                } else {
                    $admin = false;
                }
            }
            //postavljanje session varijabli
            $_SESSION['$username'] = $imeKorisnika;
            $_SESSION['$level'] = $levelKorisnika;
        } else {
            $uspjesnaPrijava = false;
        }
        ?>
        <div class="Unospodataka">
            <form action="administracija.php" method="POST" enctype="multipart/form-data" class="prijava">
                <div>
                    <label for="content">Korisničko ime:</label>
                    <!-- Ispis poruke nakon provjere korisničkog imena u bazi -->
                    <div class="form-field">
                        <input type="text" name="username" id="username">
                        <span id="porukaUsername" class="bojaPoruke"></span>
                    </div>
                </div>
                <label for="lozinka">Lozinka:</label><br>
                <input type="password" name="lozinka" id="lozinka"><br>
                <span id="porukaLozinka" class="bojaPoruke"></span>
                <br>
                <button type="submit" value="prijava" name="prijava" id="prijava" class="gumb">Prijava</button>
            </form>
        </div>
        <script type="text/javascript">
            document.getElementById("prijava").onclick = function(event) {
                var slanjeForme = true;

                //Korisničko ime mora biti uneseno
                var poljeKime = document.getElementById("username");
                var kime = document.getElementById("username").value;
                if (kime.length == 0) {
                    slanjeForme = false;
                    poljeKime.style.border = "1px dashed red";
                    document.getElementById("porukaUsername").innerHTML = "<br class ='obavijesti'>Unesite korisnicko ime!<br>";
                } else {
                    poljeKime.style.border = "1px solid green";
                    document.getElementById("porukaUsername").innerHTML = "";
                }

                //Lozinka mora biti unesena
                var poljeLozinka = document.getElementById("lozinka");
                var lozinka = document.getElementById("lozinka").value;
                if (lozinka.length == 0) {
                    slanjeForme = false;
                    poljeLozinka.style.border = "1px dashed red";
                    document.getElementById("porukaLozinka").innerHTML = "<br class ='obavijesti'>Unesite lozinku!<br>";
                } else {
                    poljeLozinka.style.border = "1px solid green";
                    document.getElementById("porukaLozinka").innerHTML = "";
                }

                if (slanjeForme != true) {
                    event.preventDefault();
                }
            }
        </script>

        <?php
        // Pokaži stranicu ukoliko je korisnik uspješno prijavljen i administrator je
        if (($uspjesnaPrijava == true && $admin == true) || (isset($_SESSION['$username'])) && $_SESSION['$level'] == 1) {
            $query = "SELECT * FROM tablica";
            $result = mysqli_query($dbc, $query);
            while ($row = mysqli_fetch_array($result)) {
                echo '
                <div class="Unospodataka">
                    <form enctype="multipart/form-data" action="administracija.php" method="POST">
                        <div class="form-item">
                        <label for="title">Naslov vijesti</label>
                            <div class="form-field">
                                <input type="text" name="title" class="form-field-textual" 
                                value="' . $row['naslov'] . '">                    
                            </div>
                        </div>  
                        <div class="form-item">
                            <label for="about">Kratki sadržaj vijesti (do 50 znakova)</label>
                                <div class="form-field">
                                <textarea name="about" id="" cols="30" rows="10" class="form-field-textual">' . $row['sazetak'] . '</textarea>
                                </div>
                        </div>
                        <div class="form-item">
                            <label for="content">Sadržaj vijesti</label>
                                <div class="form-field">
                                    <textarea name="content" id="" cols="30" rows="10" class="form-field-textual">' . $row['tekst'] . '</textarea>
                                </div>
                        </div>
                        <div class="form-item">
                            <label for="image">Slika: </label>
                                <div class="form-field">
                                    <input type="file" accept="image/jpg,image/gif,image/jpeg" class="input-text" id="image" 
                                    value="' . $row['slika'] . '" name="image"/> <br><img src="' . UPLPATH .
                                $row['slika'] . '" width=100px>
                                </div>
                        </div>
                        <div class="form-item">
                            <label for="category">Kategorija vijesti</label>
                                <div class="form-field">
                                <select name="category" id="" class="form-field-textual" 
                                value="' . $row['kategorija'] . '">                    
                                        <option value="film">film</option>
                                        <option value="igra">igra</option>
                                    </select>
                                </div>
                        </div>
                        <br>
                        <div class="form-item">
                            <div class="form-field">
                            
                            <label>Spremiti u arhivu:
                                    <div class="form-field">';
                                    if ($row['arhiva'] == 0) {
                                        echo '<input type="checkbox" name="archive" id="archive"/> 
                                            Arhiviraj?';
                                    } else {
                                        echo '<input type="checkbox" name="archive" id="archive" 
                                            checked/> Arhiviraj?';
                                    }
                                    echo '</div>
                                </label>
                    
                            </div>
                        </div>
                        <br>
                        <div class="form-item">
                            <input type="hidden" name="id" class="form-field-textual" 
                            value="' . $row['id'] . '">            
                            <button type="reset" value="Poništi"  class="gumb gumb_cancel">Poništi</button>
                            <button type="submit" value="Prihvati" name="prihvati"  class="gumb gumb_accept">Prihvati</button>
                            <button type="submit" value="Izmjeni" name="update" class="gumb gumb_update">Izmjeni</button>
                            <button type="submit" name="delete" value="Izbriši" class="gumb gumb_delete"> Izbriši</button>
                        </div>
                        <br>
                        <hr>
                    </form>
                </div>';
            }
        } elseif ($uspjesnaPrijava == true && $admin == false) {
            echo '<p class ="obavijesti">Bok ' . $imeKorisnika . '! Uspješno ste prijavljeni, ali niste administrator.</p>';
        } elseif (isset($_SESSION['$username']) && $_SESSION['$level'] == 0) {
            echo '<p class ="obavijesti">Bok ' . $_SESSION['$username'] . '! Uspješno ste prijavljeni, ali niste administrator.</p>';
        } elseif ($uspjesnaPrijava == false) {
            echo '<br class ="obavijesti"><span class="login_msg">Logiraj se!</span><br>';
        }
        ?>
        <?php
        //Upiti
        //Delete
        if (isset($_POST['delete'])) {
            $id = $_POST['id'];
            $delete = "DELETE FROM tablica WHERE id=$id ";
            $result_delete = mysqli_query($dbc, $delete);
            mysqli_close($dbc);
        }

        //Update
        if (isset($_POST['update'])) {
            $picture = $_FILES['image']['name'];
            $title = $_POST['title'];
            $about = $_POST['about'];
            $content = $_POST['content'];
            $category = $_POST['category'];
            if (isset($_POST['archive'])) {
                $archive = 1;
            } else {
                $archive = 0;
            }
            $target_dir = 'Slike/' . $picture;
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir);

            $update = "INSERT INTO tablica (datum, naslov, sazetak, tekst, slika, kategorija, 
                            arhiva ) VALUES ('$date', '$title', '$about', '$content', '$picture', 
                            '$category', '$archive')";

            $result_update = mysqli_query($dbc, $update) or die('Error querying databese.');
            mysqli_close($dbc);
        }
        ?>
    </main>
    <footer>
        <hr>
        <p class="podaci">Luka Kečkeš | 0246097905 | lukakeckes.1999@gmail.com | 2022</p>
    </footer>
</body>