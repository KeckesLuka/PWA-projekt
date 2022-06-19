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
        <?php
            include 'connect.php';
            if (isset($_POST['title'])) {
                $title = $_POST['title'];
            }
            if (isset($_POST['content'])) {
                $content = $_POST['content'];
            }
            if (isset($_POST['about'])) {
                $about = $_POST['about'];
            }
            if (isset($_POST['category'])) {
                $category = $_POST['category'];
            }
            if (isset($_POST['archive'])) {
                $archive = 1;
            } else {
                $archive = 0;
            }
            $date = date('d.m.Y.');

            $picture = ($_FILES['pphoto']['name']);
            $target_dir = 'Slike/' . $picture;

            move_uploaded_file($_FILES['pphoto']['tmp_name'], $target_dir);
            $query = "INSERT INTO tablica (datum, naslov, sazetak, tekst, slika, kategorija, 
            arhiva ) VALUES ('$date', '$title', '$about', '$content', '$picture', 
            '$category', '$archive')";
            $result = mysqli_query($dbc, $query) or die('Error querying databese.');
            mysqli_close($dbc);

        ?>
        <section role="main">
            <div class="row">
                <div class="col-12">
                    <h2 class="category">
                        <?php
                        echo $category;
                        ?></h2>
                </div>
                <div class="col-lg-4  col-md-6 col-sm-12">
                    <h1 class="title">
                        <?php
                        echo $title;
                        ?></h1>
                    <div class="slika">
                        <?php
                        echo "<img src='Slike/$picture'";
                        ?>
                    </div>
                    <div class="about">
                        <p>
                            <?php
                            echo $about;
                            ?>
                        </p>
                    </div>
                    <div class="sadrzaj">
                        <p>
                            <?php
                            echo $content;
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <hr>
        <p class="podaci">Luka Kečkeš | 0246097905 | lukakeckes.1999@gmail.com | 2022</p>
    </footer>

</body>

</html>