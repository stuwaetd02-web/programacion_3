<?php
session_start();
require 'includes/conexion.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Buscar en la tabla usuarios
    $sql = "SELECT u.*, e.nombre AS empresa_nombre
            FROM usuarios u
            LEFT JOIN empresas e ON u.empresa_id = e.id
            WHERE u.correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $validaPassword = password_verify($contrasena, $user['contrasena_hash']) || $contrasena === $user['dni'];

        if (!$validaPassword) {
            die("Contraseña incorrecta.");
        }

        $_SESSION['usuario_id']     = $user['id'];
        $_SESSION['usuario']        = $user['correo'];
        $_SESSION['nombre']         = $user['nombre'];
        $_SESSION['apellido']       = $user['apellido'];
        $_SESSION['dni']            = $user['dni'];
        $_SESSION['rol']            = $user['rol'];
        $_SESSION['empresa_id']     = $user['empresa_id'];
        $_SESSION['empresa_nombre'] = $user['empresa_nombre'];
        $_SESSION['Estado']         = $user['Estado'];

        switch ($user['rol']) {
            case 'admin':
            case 'admin_global':
                header("Location: main/dashboard.php");
                break;
            case 'admin_empresa':
            case 'supervisor':
                $empresaFolder = strtolower(str_replace(' ', '_', $user['empresa_nombre']));
                header("Location: modulos/empresas/{$empresaFolder}/dashboard.php");
                break;
            case 'medico':
                header("Location: main/medicboard.php");
                break;
            case 'paciente':
                $empresaFolder = strtolower(str_replace(' ', '_', $user['empresa_nombre']));
                header("Location: modulos/empresas/{$empresaFolder}/pacientes/dashboard.php");
                break;
            default:
                die("Rol desconocido.");
        }
        exit;
    }

    // Buscar en tabla medicos
    $sqlMedico = "SELECT m.*, e.nombre AS empresa_nombre
              FROM medicos m
              LEFT JOIN empresas e ON m.empresa_id = e.id
              WHERE m.email = ?";
    $stmt = $conn->prepare($sqlMedico);
    $stmt->execute([$email]);
    $medico = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($medico) {
        $validaPassword = password_verify($contrasena, $medico['contrasena_hash']) || $contrasena === $medico['dni'];

        if (!$validaPassword) {
            die("Contraseña incorrecta.");
        }

        $_SESSION['usuario_id']     = $medico['id'];
        $_SESSION['empleado_id']    = $medico['id']; // NECESARIO para registrar pacientes
        $_SESSION['usuario']        = $medico['email'];
        $_SESSION['nombre']         = $medico['nombre'];
        $_SESSION['apellido']       = $medico['apellido'];
        $_SESSION['dni']            = $medico['dni'];
        $_SESSION['rol']            = 'medico';
        $_SESSION['empresa_id']     = $medico['empresa_id'];
        $_SESSION['empresa_nombre'] = $medico['empresa_nombre'];
        $_SESSION['Estado']         = $medico['estado'];
        $_SESSION['permisos']       = $medico['permisos'];

        header("Location: main/medicboard.php");
        exit;
    }

    // Buscar en tabla empleados
    $sqlEmpleado = "SELECT * FROM empleados WHERE email = ?";
    $stmt = $conn->prepare($sqlEmpleado);
    $stmt->execute([$email]);
    $empleado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($empleado) {
        $validaPassword = password_verify($contrasena, $empleado['contrasena_hash']) || $contrasena === $empleado['dni'];

        if (!$validaPassword) {
            die("Contraseña incorrecta.");
        }

        $_SESSION['usuario_id']     = $empleado['id'];
        $_SESSION['usuario']        = $empleado['email'];
        $_SESSION['nombre']         = $empleado['nombre'];
        $_SESSION['apellido']       = $empleado['apellido'];
        $_SESSION['dni']            = $empleado['dni'];
        $_SESSION['rol']            = 'empleado';
        $_SESSION['empresa_id']     = $empleado['empresa_id'];
        $_SESSION['Estado']         = $empleado['estado'];

        header("Location: main/regularboard.php");
        exit;
    }

    die("Usuario no encontrado.");
}
?>
