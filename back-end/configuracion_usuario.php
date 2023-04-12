<?php
// Recoger datos del formulario
$tipo = $_POST['tipo'];

if ($tipo === "configuracion") {
  // Recoger datos del formulario para configuración
  $nombre = $_POST['nombre'];
  $direccion = $_POST['direccion'];
  $telefono = $_POST['telefono'];

  // Imprimir los datos recogidos para configuración
  echo "Nombre: " . $nombre . "<br>";
  echo "Dirección: " . $direccion . "<br>";
  echo "Teléfono: " . $telefono . "<br>";
} else {
  // Recoger datos del formulario para cambiar contraseña
  $contraAntigua = $_POST['contraAntigua'];
  $contraNueva = $_POST['contraNueva'];

  // Imprimir los datos recogidos para cambiar contraseña
  echo "Contraseña Antigua: " . $contraAntigua . "<br>";
  echo "Contraseña Nueva: " . $contraNueva . "<br>";
}
?>