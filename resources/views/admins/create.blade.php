<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear Administrador - Escuela Gabriela Mistral</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #e0f7fa 0%, #ffffff 100%);
      color: #2c3e50;
    }

    /* SIDEBAR */
    .sidebar {
      position: fixed;
      left: 0;
      top: 0;
      width: 230px;
      height: 100vh;
      background: white;
      box-shadow: 2px 0 8px rgba(0,0,0,0.05);
      overflow-y: auto;
    }

    .sidebar-header {
      padding: 20px 15px;
      border-bottom: 1px solid #f0f0f0;
      text-align: center;
    }

    .sidebar-logo {
      width: 40px;
      height: 40px;
      background: linear-gradient(135deg, #00BCD4 0%, #00ACC1 100%);
      border-radius: 10px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.1rem;
      margin-bottom: 6px;
    }

    .sidebar-brand h2 {
      font-size: 0.9rem;
      font-weight: 700;
      color: #2c3e50;
    }

    .sidebar-brand p {
      font-size: 0.65rem;
      color: #95a5a6;
    }

    .sidebar-nav {
      padding: 10px 0;
    }

    .nav-item {
      display: flex;
      align-items: center;
      padding: 10px 15px;
      color: #7f8c8d;
      text-decoration: none;
      font-size: 0.8rem;
      transition: all 0.2s;
    }

    .nav-item i {
      width: 16px;
      font-size: 0.9rem;
      margin-right: 10px;
    }

    .nav-item:hover, .nav-item.active {
      background: #f8f9fc;
      color: #00BCD4;
    }

    /* MAIN CONTENT */
    .main-content {
      margin-left: 230px;
      padding: 30px;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .content-wrapper {
      width: 100%;
      max-width: 550px;
    }

    /* HEADER */
    .page-header {
      text-align: center;
      margin-bottom: 20px;
    }

    .page-icon {
      width: 50px;
      height: 50px;
      background: linear-gradient(135deg, #00BCD4, #00ACC1);
      border-radius: 12px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.3rem;
      margin-bottom: 10px;
    }

    .page-header h1 {
      font-size: 1.2rem;
      font-weight: 700;
      margin-bottom: 4px;
    }

    .page-header p {
      font-size: 0.75rem;
      color: #7f8c8d;
    }

    .header-divider {
      width: 50px;
      height: 3px;
      background: linear-gradient(135deg, #00BCD4, #00ACC1);
      margin: 10px auto 0;
      border-radius: 2px;
    }

    /* FORM CARD */
    .form-card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.07);
      overflow: hidden;
    }

    .form-card-header {
      background: linear-gradient(135deg, #00BCD4, #00ACC1);
      padding: 15px 20px;
      color: white;
    }

    .form-card-header h2 {
      font-size: 1rem;
      font-weight: 700;
    }

    .form-card-header p {
      font-size: 0.7rem;
    }

    .form-card-body {
      padding: 20px;
    }

    .form-section {
      margin-bottom: 18px;
    }

    .section-title {
      font-size: 0.9rem;
      font-weight: 600;
      margin-bottom: 12px;
      color: #2c3e50;
      border-bottom: 2px solid #e0f7fa;
      padding-bottom: 5px;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .section-title i {
      color: #00BCD4;
    }

    .form-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 12px;
    }

    .form-group label {
      font-size: 0.75rem;
      font-weight: 600;
      margin-bottom: 4px;
      display: block;
    }

    .form-control {
      width: 100%;
      padding: 8px 8px 8px 30px;
      border: 2px solid #e0f7fa;
      border-radius: 6px;
      font-size: 0.8rem;
      background: #f1f8fb;
      transition: all 0.3s;
    }

    .form-control:focus {
      border-color: #00BCD4;
      background: white;
    }

    .input-icon {
      position: absolute;
      left: 8px;
      top: 50%;
      transform: translateY(-50%);
      color: #00BCD4;
      font-size: 0.8rem;
    }

    .input-wrapper {
      position: relative;
    }

    .toggle-password {
      position: absolute;
      right: 8px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #95a5a6;
      cursor: pointer;
    }

    .form-hint {
      font-size: 0.65rem;
      color: #7f8c8d;
      margin-top: 3px;
    }

    .info-box {
      background: rgba(0, 188, 212, 0.08);
      border: 1px solid #e0f7fa;
      border-radius: 8px;
      padding: 10px;
      font-size: 0.75rem;
    }

    .permissions-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 8px;
      background: #f1f8fb;
      border-radius: 8px;
      padding: 10px;
    }

    .permission-item {
      display: flex;
      align-items: center;
      gap: 5px;
      background: white;
      border: 1px solid #e0f7fa;
      border-radius: 6px;
      padding: 6px;
      font-size: 0.75rem;
    }

    .form-actions {
      display: flex;
      gap: 8px;
      margin-top: 20px;
    }

    .btn {
      flex: 1;
      padding: 8px;
      border-radius: 6px;
      font-size: 0.8rem;
      font-weight: 600;
      cursor: pointer;
      border: none;
    }

    .btn-primary {
      background: linear-gradient(135deg, #00BCD4, #00ACC1);
      color: white;
    }

    .btn-secondary {
      background: white;
      border: 2px solid #e0f7fa;
      color: #5a6c7d;
    }

    .alert {
      background: #e0f7fa;
      border: 1px solid #80deea;
      border-radius: 8px;
      padding: 10px;
      margin-top: 15px;
      font-size: 0.7rem;
    }

    @media (max-width: 768px) {
      .form-grid, .permissions-grid {
        grid-template-columns: 1fr;
      }
      .main-content {
        margin-left: 0;
        padding: 20px;
      }
    }
  </style>
</head>
<body>

  <aside class="sidebar">
    <div class="sidebar-header">
      <div class="sidebar-logo"><i class="fas fa-graduation-cap"></i></div>
      <div class="sidebar-brand">
        <h2>Gabriela Mistral</h2>
        <p>Sistema Escolar</p>
      </div>
    </div>
    <nav class="sidebar-nav">
      <a href="#" class="nav-item active"><i class="fas fa-user-shield"></i>Admins</a>
      <a href="#" class="nav-item"><i class="fas fa-users"></i>Usuarios</a>
      <a href="#" class="nav-item"><i class="fas fa-cog"></i>Configuración</a>
    </nav>
  </aside>

  <main class="main-content">
    <div class="content-wrapper">
      <div class="page-header">
        <div class="page-icon"><i class="fas fa-user-shield"></i></div>
        <h1>Nuevo Administrador</h1>
        <p>Complete los datos para crear la cuenta</p>
        <div class="header-divider"></div>
      </div>

      <div class="form-card">
        <div class="form-card-header">
          <h2>Información del Administrador</h2>
          <p>Campos marcados con * son obligatorios</p>
        </div>

        <div class="form-card-body">
          <form>
            <div class="form-section">
              <h3 class="section-title"><i class="fas fa-user"></i>Datos Personales</h3>
              <div class="form-grid">
                <div class="form-group">
                  <label>Nombre(s) *</label>
                  <div class="input-wrapper">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" class="form-control" placeholder="Ej: Juan Carlos">
                  </div>
                </div>
                <div class="form-group">
                  <label>Apellido(s) *</label>
                  <div class="input-wrapper">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" class="form-control" placeholder="Ej: Pérez González">
                  </div>
                </div>
              </div>
            </div>

            <div class="form-section">
              <h3 class="section-title"><i class="fas fa-lock"></i>Credenciales</h3>
              <div class="form-grid">
                <div class="form-group">
                  <label>Contraseña *</label>
                  <div class="input-wrapper">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" id="password" class="form-control" placeholder="Mínimo 8 caracteres">
                    <button type="button" class="toggle-password" onclick="togglePassword('password')">
                      <i class="fas fa-eye" id="eye-password"></i>
                    </button>
                  </div>
                </div>
                <div class="form-group">
                  <label>Confirmar *</label>
                  <div class="input-wrapper">
                    <i class="fas fa-check-circle input-icon"></i>
                    <input type="password" id="password_confirmation" class="form-control" placeholder="Repita contraseña">
                    <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation')">
                      <i class="fas fa-eye" id="eye-password_confirmation"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-section">
              <h3 class="section-title"><i class="fas fa-key"></i>Permisos</h3>
              <div class="permissions-grid">
                <div class="permission-item"><input type="checkbox"><label>Usuarios</label></div>
                <div class="permission-item"><input type="checkbox"><label>Estudiantes</label></div>
                <div class="permission-item"><input type="checkbox"><label>Profesores</label></div>
                <div class="permission-item"><input type="checkbox"><label>Reportes</label></div>
              </div>
            </div>

            <div class="form-actions">
              <button type="submit" class="btn btn-primary">Crear</button>
              <button type="reset" class="btn btn-secondary">Cancelar</button>
            </div>
          </form>
        </div>
      </div>

      <div class="alert">
        <strong>Nota:</strong> El correo institucional se generará automáticamente como
        <em>nombre.apellido@admin.edu</em>.
      </div>
    </div>
  </main>

  <script>
    function togglePassword(id) {
      const input = document.getElementById(id);
      const icon = document.getElementById('eye-' + id);
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
      }
    }
  </script>
</body>
</html>
