<?php
// Posibles colores para combinaciones
$colores = array(
    "Yellow" => "#ffff00",
    "Black" => "#000000",
    "Green" => "#00ff00",
    "Red" => "#ff0000",
    "Cyan" => "#00ffff",
    "White" => "#ffffff",
    "Purple" => "#ff00ff",
    "Blue" => "#0000ff"
);

// Sortea una nueva combinación
function nuevoSecreto($colores) {
    $secreto = array();
    for($i = 0; $i < 4; $i++)
        $secreto[$i] = $colores[array_rand($colores)];
    return $secreto;
}

// Calcula resultados de un intento
function calculaResultado($intento, $secreto) {
    $heridos = 0;
    $muertos = 0;
    for($i = 0; $i < 4; $i++) {
        if($intento[$i] == $secreto[$i]) {
            $muertos++;
            continue;
        }
        if(in_array($intento[$i], $secreto))
            $heridos++;
    }
    return "Acertados: $muertos   Descolocados: $heridos";
}

// Función para contar los intentos
function contarIntentos() {
    if (!isset($_SESSION['intentos'])) {
        $_SESSION['intentos'] = 1;
    } else {
        $_SESSION['intentos']++;
    }
    echo "<div>Intentos: ".$_SESSION['intentos']."</div>";
}

// Inicializa la sesión
session_start();
// Si existen datos en la sesión continúa el juego, si no crea nueva combinación
$secreto = isset($_SESSION["secreto"]) ? $_SESSION["secreto"] : nuevoSecreto($colores);
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
        echo "<option value='$color'>$name</option>";
    }
    ?>
</datalist>
<?php
if(!empty($_POST)) {

    $intento = array();
    for($i = 0; $i < 4; $i++) {
        $intento[$i] = $_POST["intento$i"];
    }

    contarIntentos();
    echo "
    <br>
    <div>
    <i>Intento</i>
    <form action='' method='post'>
    ";
    for($i = 0; $i < 4; $i++)
        echo "<input disabled type='color' value='$intento[$i]'>";

    echo "
    </form>
    </div>
    <br>
    <div>
    <i>Resultado</i><br>
    <i>";
    echo calculaResultado($intento, $secreto);
    echo "
    </i>
    </div>";
}
?>
<br>
<div>
<i>Jugada</i>
<form action="" method="post
