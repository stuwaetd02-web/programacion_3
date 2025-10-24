<?php
$mensaje_enviado = false;

if (isset($_POST['enviar'])) {
  $nombre = htmlspecialchars($_POST['nombre']);
  $email = htmlspecialchars($_POST['email']);
  $mensaje = htmlspecialchars($_POST['mensaje']);

  // Aquí podrías enviar el correo o guardar en BD
  // mail($email_destino, "Nuevo mensaje de $nombre", $mensaje, "From: $email");

  $mensaje_enviado = true;
}
?>
<!DOCTYPE html>
<html lang="es-ES">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contacto | Milon</title>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/contacto.css">
</head>
<body>
  <!-- ======= HEADER ======= -->
  <header>
    <img src="../images/logo.png" alt="Logo Milon">
    <nav>
      <a href="../index.php">Inicio</a>
      <a href="entrenamientos.php">Entrenamientos</a>
      <a href="planes.php">Planes</a>
      <a href="noticias.php">Noticias</a>
      <a href="contacto.php" class="activo">Contacto</a>
    </nav>
  </header>

  <!-- ======= SECCIÓN DE CONTACTO ======= -->
  <section class="contacto-container">
    <h1>Contáctanos</h1>
    <p>¿Tienes dudas, sugerencias o deseas conocer más sobre Milon?  
    Completa el formulario y te responderemos pronto.</p>

    <?php if ($mensaje_enviado): ?>
      <div class="alerta-exito">
        ¡Gracias <strong><?php echo $nombre; ?></strong>! Tu mensaje ha sido enviado correctamente.
      </div>
    <?php endif; ?>

    <form action="" method="POST" class="form-contacto">
      <div class="campo">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
      </div>

      <div class="campo">
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" required>
      </div>

      <div class="campo">
        <label for="mensaje">Mensaje:</label>
        <textarea id="mensaje" name="mensaje" rows="5" required></textarea>
      </div>

      <button type="submit" name="enviar" class="btn-cyber">Enviar mensaje</button>
    </form>
  </section>

  <!-- ======= FOOTER ======= -->
  <footer>
    © 2025 <span>Milon</span> Software Deportivo — Todos los derechos reservados.
  </footer>
</body>
</html>
