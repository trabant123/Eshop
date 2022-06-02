<!DOCTYPE html>
<html lang="cs-cz">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="styl.css" type="text/css" />
    <title>Přihlášení do administrace</title>
</head>

<body>
<?php
session_start();
require('Db.php');
Db::connect('127.0.0.1', 'ners_db', 'root', '');

if (isset($_SESSION['uzivatel_id']))
{
    header('Location: administrace.php');
    exit();
}

if ($_POST)
{
    $uzivatel = Db::queryOne('
        SELECT uzivatele_id, heslo
        FROM uzivatele
        WHERE jmeno=?
    ', $_POST['jmeno']);
    if (!$uzivatel || !password_verify($_POST['heslo'], $uzivatel['heslo']))
        $zprava = 'Neplatné uživatelské jméno nebo heslo';
    else
    {
        $_SESSION['uzivatel_id'] = $uzivatel['uzivatele_id'];
        $_SESSION['uzivatel_jmeno'] = $_POST['jmeno'];

        header('Location: administrace.php');
        exit();
    }
}
?>
    <article>
        <div id="centrovac">
            <header>
                <h1>Přihlášení do administrace</h1>
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
                    <input type="submit" value="Přihlásit" />
                </form>

                <p>Pokud ještě nemáte účet, <a href="registrace.php">zaregistrujte se</a>.</p>
            </section>
            <div class="cistic"></div>
        </div>
    </article>
</body>
</html>