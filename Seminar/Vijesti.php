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
            <h1 class="title">Vijesti</h1>
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
        include 'connect.php';
        define('UPLPATH', 'Slike/');

        $vijesti = $_GET['id'];
        $query = "SELECT * FROM tablica WHERE id=\"" . $vijesti . "\" ";
        $result = mysqli_query($dbc, $query);

        $i = 0;
        while ($row = mysqli_fetch_array($result)) {
            echo '<div class="Unospodataka"> <h2>' . $row['kategorija'] . '</h2>';
            echo '<hr>';
            echo '<section class="vijesti">';
            echo '<h3 class="vijesti_tekst">' . $row['naslov'] . '</h3>';
            echo '<p class="vijesti_tekst datum">Datum: ' . $row['datum'] . '</p><br>';
            echo '<img src="' . UPLPATH . $row['slika'] . '">';
            echo '<p class="vijesti_tekst">' . $row['tekst'] . '</p>';
            echo '</section></div>';
        }


        ?>
    </main>
    <footer>
        <hr>
        <p class="podaci">Luka Kečkeš | 0246097905 | lukakeckes.1999@gmail.com | 2022</p>
    </footer>
</body>