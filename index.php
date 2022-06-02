<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            $_SESSION['uzivatel_admin'] = 0;
            header('Location: administrace.php');
            exit();
        }
    }
}
?>
</body>
</html>