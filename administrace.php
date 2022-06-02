<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrace</title>
</head>
<body>
<?php
session_start();
if (!isset($_SESSION['uzivatel_id']))
{
    header('Location: prihlaseni.php');
    exit();
}

if (isset($_GET['odhlasit']))
{
    session_destroy();
    header('Location: prihlaseni.php');
    exit();
}
?>
<article>
    <div id="centrovac">
        <header>
            <h1>Administrace</h1>
        </header>
        <section>
            <p>Vítejte v administraci, jste přihlášeni jako <?= htmlspecialchars($_SESSION['uzivatel_jmeno']) ?></p>
            <?php
                if (!$_SESSION['uzivatel_admin'])
                    echo('Nemáte administrátorská oprávnění, požádejte administrátora webu, aby vám je přidělil.');
            ?>
            <h2><a href="editor.php">Editor článků</a></h2>
            <h2><a href="clanky.php">Seznam článků</a></h2>
            <h2><a href="administrace.php?odhlasit">Odhlásit</a></h2>
        </section>
        <div class="cistic"></div>
    </div>
</article>
</body>
</html>