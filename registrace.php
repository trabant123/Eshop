<!DOCTYPE html>
<html lang="cs-cz">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="styl.css" type="text/css" />
    <title>Registrace</title>
</head>

<body>
<?php
session_start();
require('Db.php');
Db::connect('127.0.0.1', 'ners_db', 'root', '');

if ($_POST)
{
    if ($_POST['rok'] != date('Y'))
        $zprava = 'Chybně vyplněný antispam.';
    else if ($_POST['heslo'] != $_POST['heslo_znovu'])
        $zprava = 'Hesla nesouhlasí';
    else
    {
        $existuje = Db::querySingle('
            SELECT COUNT(*)
            FROM uzivatele
            WHERE jmeno=?
            LIMIT 1
        ', $_POST['jmeno']);
        if ($existuje)
            $zprava = 'Uživatel s touto přezdívkou je již v databázi obsažen.';
        else
        {
            $heslo = password_hash($_POST['heslo'], PASSWORD_DEFAULT);
            Db::query('
                INSERT INTO uzivatele (jmeno, heslo)
                VALUES (?, ?)
            ', $_POST['jmeno'], $heslo);
            $_SESSION['uzivatel_id'] = Db::getLastId();
            $_SESSION['uzivatel_jmeno'] = $_POST['jmeno'];
            header('Location: administrace.php');
            exit();
        }
    }
}
?>
    <article>
        <div id="centrovac">
            <header>
                <h1>Registrace</h1>
            </header>
            <section>
                <?php
                    if (isset($zprava))
                        echo('<p>' . $zprava . '</p>');
                ?>

                <form method="post">
                    Jméno<br />
                    <input type="text" name="jmeno" /><br />
                    Heslo<br />
                    <input type="password" name="heslo" /><br />
                    Heslo znovu<br />
                    <input type="password" name="heslo_znovu" /><br />
                    Zadejte aktuální rok (antispam)<br />
                    <input type="text" name="rok" /><br />
                    <input type="submit" value="Registrovat" />
                </form>
            </section>
            <div class="cistic"></div>
        </div>
    </article>
</body>
</html>