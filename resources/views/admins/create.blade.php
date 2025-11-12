<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear Administrador - Escuela Gabriela Mistral</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<<<<<<< HEAD
@section('title', 'Crear Administrador')

@section('content')
<div class="min-h-screen py-12">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-indigo-600 to-indigo-800 rounded-2xl shadow-lg mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-3">Registro de Administrador</h1>
            <p class="text-lg text-gray-600">Complete el formulario para crear una nueva cuenta de administrador</p>
            <div class="w-24 h-1 bg-indigo-600 mx-auto mt-4 rounded-full"></div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-8 py-6">
                <h2 class="text-xl font-semibold text-white">Información del Administrador</h2>
                <p class="text-indigo-100 text-sm mt-1">Los campos marcados con asterisco son obligatorios</p>
            </div>

            <!-- Form Body -->
            <form action="{{ route('admins.store') }}" method="POST" class="p-8">
                @csrf

                <div class="space-y-8">
                    <!-- Sección: Datos Personales -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-5 pb-2 border-b-2 border-indigo-100">
                            Datos Personales
                        </h3>

                        <div class="space-y-6">
                            <!-- Nombre -->
                            <div>
                                <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nombre Completo
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="nombre"
                                        name="nombre"
                                        value="{{ old('nombre') }}"
                                        class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white outline-none transition-all @error('nombre') border-red-400 bg-red-50 @enderror"
                                        placeholder="Ingrese el nombre completo"
                                        required
                                        minlength="3"
                                        maxlength="50"
                                    >
                                </div>
                                <p class="text-xs text-gray-500 mt-2 ml-1">Entre 3 y 50 caracteres</p>
                                @error('nombre')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Correo Electrónico Institucional
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white outline-none transition-all @error('email') border-red-400 bg-red-50 @enderror"
                                        placeholder="@admin.edu"
                                        required
                                        maxlength="100"
                                    >
                                </div>
                                <p class="text-xs text-gray-500 mt-2 ml-1">Dirección de correo válida (máximo 100 caracteres)</p>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Sección: Seguridad -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-5 pb-2 border-b-2 border-indigo-100">
                            Credenciales de Acceso
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Contraseña -->
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Contraseña
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        class="w-full pl-12 pr-12 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white outline-none transition-all @error('password') border-red-400 bg-red-50 @enderror"
                                        placeholder="Mínimo 8 caracteres"
                                        required
                                        minlength="8"
                                        maxlength="50"
                                    >
                                    <button
                                        type="button"
                                        onclick="togglePassword('password')"
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-indigo-600 transition"
                                    >
                                        <svg id="eye-password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Requisitos de contraseña -->
                        <div class="mt-4 bg-indigo-50 border border-indigo-200 rounded-xl p-4">
                            <p class="text-sm font-semibold text-indigo-900 mb-2">Requisitos de seguridad:</p>
                            <ul class="text-xs text-indigo-700 space-y-1 ml-4">
                                <li class="flex items-center">
                                    <span class="w-1.5 h-1.5 bg-indigo-400 rounded-full mr-2"></span>
                                    Mínimo 8 caracteres, máximo 50
                                </li>
                                <li class="flex items-center">
                                    <span class="w-1.5 h-1.5 bg-indigo-400 rounded-full mr-2"></span>
                                    Al menos una letra mayúscula y una minúscula
                                </li>
                                <li class="flex items-center">
                                    <span class="w-1.5 h-1.5 bg-indigo-400 rounded-full mr-2"></span>
                                    Al menos un número
                                </li>
                                <li class="flex items-center">
                                    <span class="w-1.5 h-1.5 bg-indigo-400 rounded-full mr-2"></span>
                                    Al menos un carácter especial
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Sección: Permisos -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-5 pb-2 border-b-2 border-indigo-100">
                            Permisos y Privilegios
                        </h3>

                        <div class="bg-gray-50 rounded-xl p-6 border-2 border-gray-200">
                            <p class="text-sm text-gray-600 mb-4">Seleccione los permisos que tendrá este administrador en el sistema:</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($permisos as $key => $label)
                                    <label class="flex items-start p-4 bg-white border-2 border-gray-200 rounded-xl cursor-pointer hover:border-indigo-400 hover:bg-indigo-50 transition-all group">
                                        <input
                                            type="checkbox"
                                            name="permisos[]"
                                            value="{{ $key }}"
                                            {{ in_array($key, old('permisos', [])) ? 'checked' : '' }}
                                            class="w-5 h-5 mt-0.5 text-indigo-600 border-gray-300 rounded focus:ring-2 focus:ring-indigo-500 transition"
                                        >
                                        <div class="ml-3">
                                            <span class="text-sm font-medium text-gray-800 group-hover:text-indigo-700">{{ $label }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex flex-col sm:flex-row gap-4 mt-10 pt-6 border-t-2 border-gray-100">
                    <button
                        type="submit"
                        class="flex-1 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white py-4 rounded-xl font-semibold hover:from-indigo-700 hover:to-indigo-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Crear Cuenta de Administrador
                    </button>
                    <a
                        href="{{ route('admins.index') }}"
                        class="flex-1 bg-white text-gray-700 py-4 rounded-xl font-semibold border-2 border-gray-300 hover:bg-gray-50 hover:border-gray-400 transition-all flex items-center justify-center"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

        <!-- Nota informativa -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div class="text-sm text-blue-800">
                    <p class="font-semibold mb-1">Información importante</p>
                    <p>El administrador recibirá un correo de confirmación con sus credenciales de acceso. Asegúrese de que la dirección de correo electrónico sea correcta y esté activa.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const eye = document.getElementById('eye-' + inputId);

    if (input.type === 'password') {
        input.type = 'text';
    } else {
        input.type = 'password';
    }
}
</script>
@endpush
@endsection
=======
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
>>>>>>> 5567870dc482cc51bd50123ee3f8d77b5b73b3b6
