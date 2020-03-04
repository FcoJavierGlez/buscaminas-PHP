<?php
    /**
     * Buscaminas
     * 
     * @author Fco Javier González Sabariego
     */

    session_start();

    include "include/constantes.php";
    include "include/funciones.php";

    if (isset($_POST['salir'])) {
        session_unset();
        session_destroy();
        session_start();
        session_regenerate_id();
    }

    if (!isset($_SESSION['tablero'])) {
        $_SESSION['tablero'] = array();
        $_SESSION['tableroVisible'] = array();
        $_SESSION['banderin'] = false;
        $_SESSION['partidaGanada'] = false;
        $_SESSION['partidaPerdida'] = false;
        /* generaTablero(); */
        generaTableroVisible();
    }

    if (isset($_GET['banderin'])) {
        if (isset($_GET['check'])==1) 
            $_SESSION['banderin'] = true;
        else $_SESSION['banderin'] = false;
    }

    /* if ($_SESSION['partidaGanada'] || $_SESSION['partidaPerdida'])
        $_SESSION['banderin'] = false; */

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/buscaminas.css">
    <title>Buscaminas</title>
</head>
<body>
    <header>
        <h1>Buscaminas</h1>
        <h2>Autor: Fco Javier González Sabariego</h2>
    </header>
    <nav></nav>
    <main>
        <?php 
            if (!isset($_GET['fila'])) {
                /* imprimeTableroDev(); */
                echo "<div class=\"cuerpo\">";
                echo "<div class=\"tablero\">";
                imprimeTableroDeJuego();
                echo "</div>";
                if (totalCasillasVisibles()!=0 && !($_SESSION['partidaGanada'] || $_SESSION['partidaPerdida']))
                    checkBox($_SESSION['banderin']);
                echo "</div>";
            } else {
                if (totalCasillasVisibles()==0)
                    generaTableroLogico($_GET['fila'],$_GET['columna']);
                /* imprimeTableroDev(); */
                actualizaTablero($_GET['fila'],$_GET['columna']);
                echo "<div class=\"cuerpo\">";
                echo "<div class=\"tablero\">";
                imprimeTableroDeJuego();
                include "include/fin_de_partida.php";
                echo "</div>";
                if (totalCasillasVisibles()!=0 && !($_SESSION['partidaGanada'] || $_SESSION['partidaPerdida']))
                    checkBox($_SESSION['banderin']);
                echo "</div>";
                //include "include/fin_de_partida.php";
            }
            /* echo "<form action=".$_SERVER['PHP_SELF']." method=\"post\">";
            echo "<input type=\"submit\" value=\"Nuevo juego\" name=\"salir\">";
            echo "</form>"; */
        ?>
    </main>
    <aside></aside>
    <footer>
        <small>Redes sociales del autor:</small><br/>
        <a href="https://twitter.com/Fco_Javier_Glez" target="_blank"><img src="images/twitter.png" height="65" alt="Icono Twitter"></a>
        <a href="https://www.linkedin.com/in/francisco-javier-gonz%C3%A1lez-sabariego-51052a175/" target="_blank"><img src="../images/linkedin.png" height="65" alt="Icono Linkedin"></a>
        <a href="https://github.com/FcoJavierGlez" target="_blank"><img src="../images/github.png" height="65" alt="Icono Github"></a>
    </footer>
</body>
</html>