<?php
    /**
     * @author Fco Javier González Sabariego
     */

    /**
     * Genera el array del tablero
     */
    /* function generaTablero() {
        for ($i=0; $i<NF; $i++) 
            for ($j=0; $j<NC; $j++) {
                $_SESSION['tablero'][$i][$j] = 0;
                $_SESSION['tableroVisible'][$i][$j] = 0;
            }
        for ($m=0; $m<NM; $m++) { 
            do {
                $f = rand(0,7);
                $c = rand(0,7);
            } while ($_SESSION['tablero'][$f][$c]==-1);

            $_SESSION['tablero'][$f][$c]=-1;

            for ($i=max($f-1,0); $i<=min($f+1,NF-1); $i++) { 
                for ($j=max($c-1,0); $j<=min($c+1,NC-1); $j++) 
                    if ($_SESSION['tablero'][$i][$j]!=-1) 
                        $_SESSION['tablero'][$i][$j]++;
            }
        }
    } */

    //---------//

    /**
     * Genera el tablero de las casillas visibles para el jugador
     */
    function generaTableroVisible() {
        for ($i=0; $i<NF; $i++) 
            for ($j=0; $j<NC; $j++) 
                $_SESSION['tableroVisible'][$i][$j] = 0;
    }

    /**
     * Se crea el tablero lógico de juego, tras el primer click, pasándole como parámetros
     * las coordenadas de la primera casilla pulsada.
     */
    function generaTableroLogico($fila, $columna) {
        for ($i=0; $i<NF; $i++) 
            for ($j=0; $j<NC; $j++) 
                $_SESSION['tablero'][$i][$j] = 0;
        
        for ($m=0; $m<NM; $m++) { 
            do {
                $f = rand(0,NF-1);
                $c = rand(0,NC-1);
            } while ($_SESSION['tablero'][$f][$c]==-1 || coordenadaDenegada($fila, $columna, $f, $c));

            $_SESSION['tablero'][$f][$c]=-1;

            for ($i=max($f-1,0); $i<=min($f+1,NF-1); $i++) { 
                for ($j=max($c-1,0); $j<=min($c+1,NC-1); $j++) 
                    if ($_SESSION['tablero'][$i][$j]!=-1) 
                        $_SESSION['tablero'][$i][$j]++;
            }
        }
    }

    /**
     * Recuento del número de casillas visibles dentro del tablero.
     */
    function totalCasillasVisibles() {
        $contador = 0;
        for ($i=0; $i<NF; $i++) 
            for ($j=0; $j<NC; $j++) 
                if ($_SESSION['tableroVisible'][$i][$j] == 1)
                    $contador++;
        return $contador;
    }

    /**
     * Recibe las coordenadas del primer click, y las coordenadas aleatorias de una mina, si las coordenadas
     * aleatorias de la mina coinciden con las coordenadas del primer click en un rango de [-1+1] tanto en fila
     * como en columna, entonces devolverá falso denegando la coordenada como válida.
     */
    function coordenadaDenegada($fila, $columna, $f, $c) {
        for ($i=max($fila-1,0); $i<=min($fila+1,NF-1); $i++) { 
            for ($j=max($columna-1,0); $j<=min($columna+1,NC-1); $j++) 
                if ($i==$f && $j==$c) 
                    return true;
        }
        return false;
    }

    //---------//

    /**
     * Imprime el tablero numérico para las fases de desarrollo y mantenimiento.
     */
    function imprimeTableroDev() {
        echo "<table>";
            for ($i=0; $i<sizeof($_SESSION['tablero'][0]); $i++) { 
                echo "<tr>";
                for ($j=0; $j<sizeof($_SESSION['tablero'][0]); $j++) 
                    echo "<td class="."c".$_SESSION['tablero'][$i][$j].">".$_SESSION['tablero'][$i][$j]."</td>";
                echo "</tr>";
            }
        echo "</table>";
    }

    /**
     * Imprime el tablero de juego
     */
    function imprimeTableroDeJuego() {
        echo "<table>";
        for ($i=0; $i<sizeof($_SESSION['tableroVisible'][0]); $i++) { 
            echo "<tr>";
            for ($j=0; $j<sizeof($_SESSION['tableroVisible'][0]); $j++) { 
                if ($_SESSION['tableroVisible'][$i][$j]==0)
                    if ($_SESSION['partidaGanada'] || $_SESSION['partidaPerdida']) echo "<td></td>";
                    else echo "<td><a href=".$_SERVER['PHP_SELF']."?fila=$i&columna=$j"."></a></td>";
                elseif($_SESSION['tableroVisible'][$i][$j]==2)
                    if ($_SESSION['partidaGanada'] || $_SESSION['partidaPerdida']) echo "<td><img src=\"images/flag.png\" alt=\"Banderin\" height=\"35\"></td>";
                    else echo "<td><a href=".$_SERVER['PHP_SELF']."?fila=$i&columna=$j"." class=\"banderin\"><img src=\"images/flag.png\" alt=\"Banderin\" width=\"38\"></a></td>";
                else {
                    if ($_SESSION['tablero'][$i][$j]==-1) echo "<td class="."c".$_SESSION['tablero'][$i][$j]."><img src=\"images/mina.png\" alt=\"Mina\" height=\"35\"></td>";
                    elseif ($_SESSION['tablero'][$i][$j]==0) echo "<td class="."c".$_SESSION['tablero'][$i][$j]."></td>";
                    else echo "<td class="."c".$_SESSION['tablero'][$i][$j].">".$_SESSION['tablero'][$i][$j]."</td>";
                }
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    /**
     * Actualiza el tablero una vez se ha pulsado una casilla
     */
    function actualizaTablero($fila, $columna) {
        if ($_SESSION['banderin'] && !($_SESSION['partidaGanada'] || $_SESSION['partidaPerdida'])) {
            if (recuentoBanderas()<NM) {
                if ($_SESSION['tableroVisible'][$fila][$columna] == 0) 
                    $_SESSION['tableroVisible'][$fila][$columna] = 2;
                elseif ($_SESSION['tableroVisible'][$fila][$columna] == 2)
                    $_SESSION['tableroVisible'][$fila][$columna] = 0;
            } else
                if ($_SESSION['tableroVisible'][$fila][$columna] == 2)
                    $_SESSION['tableroVisible'][$fila][$columna] = 0;
        } else {
            if ($_SESSION['tableroVisible'][$fila][$columna] != 2) {
                $_SESSION['tableroVisible'][$fila][$columna] = 1;
                if ($_SESSION['tablero'][$fila][$columna] == -1) {
                    $_SESSION['partidaPerdida'] = true;
                    revelaMinas();
                } 
                elseif ($_SESSION['tablero'][$fila][$columna] == 0) 
                    revelaTablero($fila, $columna);
            }
        }
        ganador();
    }

    /**
     * Muestra la ubicación de todas las minas una vez se ha perdido la partida
     */
    function revelaMinas() {
        for ($i=0; $i<NF; $i++) 
            for ($j=0; $j<NC; $j++) 
                if ($_SESSION['tablero'][$i][$j] == -1)
                    $_SESSION['tableroVisible'][$i][$j] = 1;
    }

    /**
     * Revela todas las casillas alrededor de la casilla vacía que acabamos de pulsar y todas las casillas que,
     * a su vez, haya alrededor de éstas siempre y cuando estén vacías. En el momento en el que revela una casilla 
     * numerada detiene el proceso de seguir revelando las que tiene alrededor.
     */
    function revelaTablero($f, $c) {
        for ($i=max($f-1,0); $i<=min($f+1,NF-1); $i++) { 
            for ($j=max($c-1,0); $j<=min($c+1,NC-1); $j++) {
                if (($i==$f && $j==$c) || $_SESSION['tableroVisible'][$i][$j]==1) continue;
                if ($_SESSION['tablero'][$i][$j]==0) {
                    $_SESSION['tableroVisible'][$i][$j]=1;
                    revelaTablero($i, $j);
                }
                else $_SESSION['tableroVisible'][$i][$j]=1;
            }
        }
    }

    /**
     * Determina si se ha ganado la partida
     */
    function ganador() {
        $contador = 0;
        for ($i=0; $i<NF; $i++) 
            for ($j=0; $j<NC; $j++) 
                $contador += ($_SESSION['tableroVisible'][$i][$j]==2 && $_SESSION['tablero'][$i][$j]==-1) ? 1 : 0;
        $_SESSION['partidaGanada'] = ($contador==NM);
    }

    function recuentoMinas($tablero) {
        $total=0;
        for ($i=0; $i<NF; $i++) { 
          for ($j=0; $j<NC; $j++)
              $total += ($tablero[$i][$j]==-1) ? 1 : 0;
        }
        return $total;
    }

    function recuentoBanderas() {
        $total=0;
        for ($i=0; $i<NF; $i++) { 
          for ($j=0; $j<NC; $j++)
              $total += ($_SESSION['tableroVisible'][$i][$j]==2) ? 1 : 0;
        }
        return $total;
    }

    function checkBox($booleano) {
        echo "<div class='bandera'>";
        echo "<form action=".$_SERVER['PHP_SELF']." value=\"\" method=\"get\">";
        echo ($booleano) ?  "<h3 class=\"aviso\">Tienes activado añadir o quitar señales</h3>" : "<h3></h3>";
        echo ($booleano) ?  "<input type=\"checkbox\" name=\"check\" value=\"1\" checked>Activar: \"Añadir/quitar señal\" " 
            : "<input type=\"checkbox\" name=\"check\" value=\"\">Activar: \"Añadir/quitar señal\" ";
        echo "<input type=\"submit\" name=\"banderin\" value=\"Aceptar\">";
        echo "</form>";
        echo "</div>";
    }
?>