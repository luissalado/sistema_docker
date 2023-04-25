<?php
// Posibles colores para combinaciones
$colores = array(
    "Yellow" => "#ffff00",
    "Black" => "#000000",
    "Green" => "#00ff00",
    "Red"=>"#ff0000",
    "Cyan"=>"#00ffff",
    "White"=>"#ffffff",
    "Purple"=>"#ff00ff",
    "Blue"=>"#0000ff"
);

// Sortea una nueva combinación
function nuevoSecreto($colores) {
    $secreto = array();
    for($i=0;$i<4;$i++)
        $secreto[$i] = $colores[array_rand($colores)];
    return $secreto;
}

// Calcula resultados de un intento
function calculaResultado($intento, $secreto) {
    $heridos = 0;
    $muertos = 0;
    for($i=0; $i<4; $i++) {
        if($intento[$i] == $secreto[$i]) {
            $muertos++;
            continue;
        }
        if(in_array($intento[$i], $secreto))
            $heridos++;
    }
    return "Acertados: $muertos   Descolocados: $heridos";
}


// Inicializa la sesión
session_start();
// Si existen datos en la sesión continúa el juego, si no crea nueva combinación
$secreto = isset($_SESSION["secreto"])? $_SESSION["secreto"] : nuevoSecreto($colores);
// Guarda el secreto en la sesión (solo tiene efecto con nueva combinación)
$_SESSION["secreto"] = $secreto;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MasterMind</title>
</head>
<body>
<datalist id="presets">
    <?php
    // Crea lista de colores para desplegable de colores del formulario
    foreach ($colores as $name => $color) {
        print("<option value='$color'>$name</option>");
    }
    ?>
</datalist>
<?php
if(!empty($_POST)) {

    $intento = $_POST['intento'];
    echo "
    <br>
    <div>
    <i>Intento</i>
    <form action='' method='post'>
    ";
    for($i=0; $i<4; $i++)
        print("<input disabled type='color' value='$intento[$i]'>");

    echo "
    </form>
    </div>
    <br>
    <div>
    <i>Resultado</i><br>
    <i>";
    print(calculaResultado($intento, $secreto));
    echo "
    </i>
    </div>";
}
?>
<br>
<div>
<i>Jugada</i>
<form action="" method="post">
    <?php
    for($i=0; $i<4; $i++) {
        print("<input type='color' list='presets' name='intento[$i]' value='");
        if(isset($intento)) print($intento[$i]);
        print("'>");
    }
    ?>
    <input type="submit" value="Intentar">
</form>
</div>
<div>
    <form action="reiniciar.php">
        <input type="submit" value="Reiniciar">
    </form>
</div>
</body>
</html>