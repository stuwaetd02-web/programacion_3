<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../includes/conexion.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

$rol = $_SESSION['rol'] ?? '';
$empresa_id = $_SESSION['empresa_id'] ?? null;
$soloConfiguracion = ($empresa_id == 8800);

// Mostrar logo si hay empresa seleccionada distinta de 8800
$logoEmpresa = '';
if ($empresa_id && $empresa_id != 8800) {
    $stmt = $conn->prepare("SELECT logo FROM empresas WHERE id = ?");
    $stmt->execute([$empresa_id]);
    $empresa = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($empresa && $empresa['logo']) {
        $logoEmpresa = $empresa['logo'];
    }
}
?>
<!-- DEBUG: empresa_id = <?= htmlspecialchars($empresa_id) ?> -->

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="css/dashboard.css">
  <link rel="icon" type="image/svg+xml" href="icon/favicon.svg">
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;800&display=swap" rel="stylesheet">
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      document.querySelectorAll(".submenu > a").forEach(item => {
        item.addEventListener("click", e => {
          const hasSubmenu = item.nextElementSibling && item.nextElementSibling.classList.contains('submenu-items');
          if (hasSubmenu) {
            e.preventDefault();
            const submenu = item.nextElementSibling;
            submenu.style.display = submenu.style.display === "flex" ? "none" : "flex";
          }
        });
      });
    });
  </script>
</head>
<body>

<header>
  <div>
    Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>
  </div>
  <div>
    <a href="../logout.php">Cerrar sesión</a>
  </div>
</header>

<div class="contenedor">

  <nav>
    <?php if (!$soloConfiguracion && $logoEmpresa): ?>
      <div class="logo-empresa">
        <img src="../<?= htmlspecialchars($logoEmpresa) ?>" alt="Logo Empresa">
      </div>
    <?php endif; ?>

    <?php if (!$soloConfiguracion): ?>
      <!-- Menú visible solo cuando empresa_id != 8800 -->

      <div class="link-solo"><a href="../modulos/administrativo/inicio.php" target="contenido">🏠 Inicio</a></div>
      <div class="link-solo"><a href="../modulos/administrativo/politicas.php?ts=<?= time() ?>" target="contenido">📋 Políticas empresariales</a></div>

      <?php if (in_array($rol, ['admin', 'supervisor'])): ?>
        <div class="submenu">
          <a href="#">👩‍👩‍👦 Gestión de Empleados ▾</a>
          <div class="submenu-items">
            <a href="../modulos/administrativo/crear_empleado.php" target="contenido">➕ Crear Empleado</a>
            <a href="../modulos/administrativo/listar_empleado.php" target="contenido">📋 Listar Empleados</a>
            <a href="../modulos/administrativo/documentos_empleados.php" target="contenido">🗂 Documentos</a>
          </div>
        </div>
      <?php endif; ?>

      <?php if (in_array($rol, ['admin', 'supervisor'])): ?>
        <div class="submenu">
          <a href="#">📝 Registros ▾</a>
          <div class="submenu-items">
            <a href="../modulos/administrativo/contratos.php" target="contenido">📄 Contratos</a>
            <a href="../modulos/administrativo/otro_si.php" target="contenido">✍️ Otro SI</a>
            <a href="../modulos/administrativo/examenes.php" target="contenido">🧪 Exámenes médicos</a>
            <a href="../modulos/administrativo/nomina.php" target="contenido">💵 Nómina</a>
            <a href="../modulos/administrativo/planilla.php" target="contenido">📄 Planilla de Aportes</a>
            <a href="../modulos/administrativo/incapacidades.php" target="contenido">🩺 Incapacidades</a>
            <a href="../modulos/administrativo/ausentismo.php" target="contenido">⛔ Ausentismos</a>
            <a href="../modulos/administrativo/desempeno.php" target="contenido">🥇 Desempeño</a>
            <a href="../modulos/administrativo/disciplina.php" target="contenido">⚖️ Disciplinario</a>
            <a href="../modulos/administrativo/accidentes_laborales.php" target="contenido">🆘 Accidentes</a>
            <a href="../modulos/administrativo/retiros.php" target="contenido">🏁 Retiros</a>
          </div>
        </div>
      <?php endif; ?>

      <?php if (in_array($rol, ['admin', 'supervisor'])): ?>
        <div class="submenu">
          <a href="#">📨 Solicitudes ▾</a>
          <div class="submenu-items">
            <a href="../modulos/administrativo/horas_extra.php" target="contenido">🕒 Horas Extra</a>
            <a href="../modulos/administrativo/capacitaciones.php" target="contenido">🎓 Capacitaciones</a>
            <a href="../modulos/administrativo/permisos.php" target="contenido">📝 Permisos</a>
            <a href="../modulos/administrativo/vacaciones.php" target="contenido">✈️ Vacaciones</a>
            <a href="../modulos/administrativo/comisiones.php" target="contenido">💸 Comisiones</a>
            <a href="../modulos/administrativo/prestamo.php" target="contenido">💰 Préstamos</a>
            <a href="../modulos/administrativo/deducciones.php" target="contenido">📉 Deducciones</a>
            <a href="../modulos/administrativo/certificados.php" target="contenido">📝 Certificaciones</a>
          </div>
        </div>
      <?php endif; ?>

      <div class="link-solo"><a href="../modulos/administrativo/reportes.php" target="contenido">📊 Reportes</a></div>
    <?php endif; ?>

    <!-- Siempre mostrar Configuración para admin -->
    <?php if ($rol === 'admin'): ?>
      <div class="submenu">
        <a href="#">⚙️ Configuración ▾</a>
        <div class="submenu-items">
          <a href="../modulos/administrativo/admin.php" target="contenido">👥 Gestión de Usuarios</a>
          <a href="../modulos/administrativo/crear_empresa.php" target="contenido">🏢 Crear Empresa</a>
          <a href="../modulos/administrativo/manual.php" target="contenido">📘 Manual de funcionamiento</a>
          <a href="../modulos/administrativo/seleccionar_empresa.php" target="contenido">🔄 Seleccionar Empresa</a>
        </div>
      </div>
    <?php endif; ?>
  </nav>

  <iframe name="contenido" src="../modulos/administrativo/inicio.php" class="contenido-principal"></iframe>

</div>

</body>
</html>
