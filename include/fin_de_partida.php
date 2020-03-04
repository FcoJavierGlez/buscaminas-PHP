<?php
    /**
     * 
     */

    $mensajePerdida = array(
        "Eres un loser", 
        "Parece que has explotado,<br/> ¿quieres una tirita?", 
        "Morir puede ser perjudicial para la salud",
        "¿Nunca te dijeron que no jugaras con petardos?",
        "No desesperes, algún día lo conseguirás...<br/> ¿O tal vez no...?",
        "¿Qué haces que no estás estudiando?<br/> A ver, cuéntame...",
        "Bah, hasta mi abuela juega mejor que tú"
    );
    
    $mensajeGanada = array(
        "Eres el fucker", 
        "¡¡Qué crack!!", 
        "Oh sí, tú sí que sabes como poner a una máquina...", 
        "Me casaría contigo,<br/> pero solo soy una máquina",
        "Te daría una palmadita en la espalda<br/> pero tengo cosas más importantes que hacer...",
        "Esto se te da demasiado bien...<br/> ¿jugamos al teto?",
        "Fantastico, has ganado...<br/> ¿jugamos al póker?"
    );

    if ($_SESSION['partidaPerdida']) {
        echo "<div class='mensaje'><h3>".$mensajePerdida[rand(0,sizeof($mensajePerdida)-1)]."</h3></div>";
        echo "<form action=".$_SERVER['PHP_SELF']." method=\"post\">";
        echo "<input type=\"submit\" value=\"Nuevo juego\" name=\"salir\">";
        echo "</form>";
    }
        
    elseif ($_SESSION['partidaGanada']) {
        echo "<div class='mensaje'><h3>".$mensajeGanada[rand(0,sizeof($mensajeGanada)-1)]."</h3></div>";
        echo "<form action=".$_SERVER['PHP_SELF']." method=\"post\">";
        echo "<input type=\"submit\" value=\"Nuevo juego\" value=\"Enviar\" name=\"salir\">";
        echo "</form>";
    }
?>