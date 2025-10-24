<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Milon - Gestión Deportiva</title>
  <link rel="stylesheet" href="css/index.css">
  <link rel="icon" type="image/svg+xml" href="main/icon/favicon.svg">
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<body>
  <div class="login-container">

    <!-- Logo SVG animado -->
    <div class="logo-container">
      <svg width="80" height="80" viewBox="0 0 100 100">
        <circle cx="50" cy="50" r="40" stroke="#00ff88" stroke-width="4" fill="none" />
        <path d="M 30 50 L 45 50 L 50 40 L 55 60 L 70 60" 
              stroke="#00ffaa" stroke-width="3" fill="none" 
              stroke-linecap="round" stroke-linejoin="round">
          <animate attributeName="stroke-dasharray" values="5,5;20,5;5,5" dur="1.5s" repeatCount="indefinite"/>
        </path>
      </svg>
    </div>

    <h2>Iniciar sesión en Milon</h2>
    <form action="login.php" method="POST" novalidate>

      <!-- Correo -->
      <div class="form-group">
        <label for="usuario">Correo electrónico <small>(milon@milon.com)</small></label>
        <input type="email" name="usuario" id="usuario" placeholder="ejemplo@dominio.com" required>
      </div>

      <!-- Contraseña -->
      <div class="form-group">
        <label for="contrasena">Contraseña <small>(milon)</small></label>
        <div class="password-container">
          <input type="password" name="contrasena" id="contrasena" placeholder="Ingresa tu contraseña" required>
          <span class="toggle-password" onclick="togglePassword()">👁️</span>
        </div>
      </div>

      <!-- Botón -->
      <div class="form-group">
        <button type="submit">Ingresar</button>
      </div>
    </form>
  </div>

  <!-- Sonido -->
  <audio id="login-sound" src="media/login_sound.mp3" preload="auto"></audio>

  <!-- Scripts -->
  <script>
    function togglePassword() {
      const passInput = document.getElementById("contrasena");
      const toggle = document.querySelector(".toggle-password");
      if (passInput.type === "password") {
        passInput.type = "text";
        toggle.textContent = "🙈";
      } else {
        passInput.type = "password";
        toggle.textContent = "👁️";
      }
    }

    document.querySelector("form").addEventListener("submit", function () {
      const audio = document.getElementById("login-sound");
      if (audio) audio.play();
    });
  </script>
</body>
</html>
