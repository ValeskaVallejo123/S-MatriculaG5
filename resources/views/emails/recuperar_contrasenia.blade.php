<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recuperar contraseña - Escuela Gabriela Mistral</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body style="margin:0;padding:0;background:#f0f4f8;font-family:'Poppins',sans-serif;">

  <div style="max-width:580px;margin:30px auto;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,59,115,.12);">

    {{-- ── HEADER con gradiente azul ── --}}
    <div style="background:linear-gradient(135deg,#1e5a8e 0%,#0d3d66 50%,#003153 100%);padding:40px 30px;text-align:center;position:relative;overflow:hidden;">

      {{-- Hexágonos decorativos (SVG inline) --}}
      <svg style="position:absolute;top:0;left:0;width:100%;height:100%;opacity:.12;" xmlns="http://www.w3.org/2000/svg">
        <polygon points="30,5 70,5 95,48 70,91 30,91 5,48" fill="#4ec7d2" transform="translate(-20,10) scale(1.2)"/>
        <polygon points="30,5 70,5 95,48 70,91 30,91 5,48" fill="#4ec7d2" transform="translate(460,60) scale(0.9)"/>
        <polygon points="30,5 70,5 95,48 70,91 30,91 5,48" fill="#4ec7d2" transform="translate(200,-30) scale(0.7)"/>
        <polygon points="30,5 70,5 95,48 70,91 30,91 5,48" fill="#4ec7d2" transform="translate(380,20) scale(1.1)"/>
      </svg>

      {{-- Logo circular --}}
      <div style="width:72px;height:72px;border-radius:50%;background:rgba(255,255,255,.15);border:3px solid rgba(78,199,210,.45);margin:0 auto 16px;display:flex;align-items:center;justify-content:center;position:relative;">
        <span style="font-size:2rem;">🎓</span>
      </div>

      <h1 style="color:#ffffff;font-size:1.25rem;font-weight:700;margin:0 0 4px;position:relative;">
        Escuela Gabriela Mistral
      </h1>
      <p style="color:rgba(255,255,255,.7);font-size:.78rem;margin:0;position:relative;">
        Sistema de Gestión Escolar · Danlí, El Paraíso
      </p>
    </div>

    {{-- ── BODY ── --}}
    <div style="background:#ffffff;padding:36px 32px;">

      {{-- Ícono de llave --}}
      <div style="text-align:center;margin-bottom:22px;">
        <div style="display:inline-flex;align-items:center;justify-content:center;width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,rgba(78,199,210,.15),rgba(0,80,143,.08));border:2px solid rgba(78,199,210,.3);">
          <span style="font-size:1.5rem;">🔑</span>
        </div>
      </div>

      <h2 style="color:#003b73;font-size:1.1rem;font-weight:700;text-align:center;margin:0 0 18px;">
        Solicitud de recuperación de contraseña
      </h2>

      <p style="color:#4a5568;font-size:.88rem;line-height:1.7;margin:0 0 12px;">
        Hola{!! isset($user) ? ', <strong style="color:#003b73;">' . $user->name . '</strong>' : '' !!} 👋
      </p>

      <p style="color:#4a5568;font-size:.88rem;line-height:1.7;margin:0 0 24px;">
        Recibimos una solicitud para restablecer la contraseña de tu cuenta en el
        <strong style="color:#003b73;">Sistema de Matrícula</strong>.
        Si fuiste tú, haz clic en el botón de abajo para crear una nueva contraseña.
      </p>

      {{-- Botón principal --}}
      <div style="text-align:center;margin:28px 0;">
        <a href="{{ $link }}"
           style="display:inline-block;padding:14px 38px;background:linear-gradient(135deg,#1e5a8e,#003153);color:#ffffff;text-decoration:none;border-radius:10px;font-size:.92rem;font-weight:700;letter-spacing:.3px;box-shadow:0 6px 20px rgba(30,90,142,.35);">
          Restablecer mi contraseña
        </a>
      </div>

      {{-- Nota expiración --}}
      <div style="display:flex;align-items:flex-start;gap:10px;background:#fff8e1;border:1px solid #ffe082;border-radius:8px;padding:12px 14px;margin-bottom:22px;">
        <span style="font-size:1rem;flex-shrink:0;">⏰</span>
        <p style="color:#b45309;font-size:.78rem;line-height:1.5;margin:0;">
          Este enlace es válido por <strong>60 minutos</strong>. Después de ese tiempo deberás solicitar uno nuevo.
        </p>
      </div>

      {{-- Link alternativo --}}
      <p style="color:#64748b;font-size:.78rem;margin:0 0 8px;">
        Si el botón no funciona, copia y pega este enlace en tu navegador:
      </p>
      <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:10px 14px;margin-bottom:22px;word-break:break-all;">
        <a href="{{ $link }}" style="color:#4ec7d2;font-size:.72rem;text-decoration:none;">{{ $link }}</a>
      </div>

      {{-- Aviso de seguridad --}}
      <div style="border-top:1px solid #f1f5f9;padding-top:18px;">
        <p style="color:#94a3b8;font-size:.75rem;line-height:1.6;margin:0;">
          🔒 Si <strong>no solicitaste</strong> este cambio, ignora este mensaje. Tu contraseña no será modificada y tu cuenta sigue siendo segura.
        </p>
      </div>

    </div>

    {{-- ── FOOTER ── --}}
    <div style="background:#f8fafc;border-top:1px solid #e2e8f0;padding:20px 32px;text-align:center;">
      <p style="color:#94a3b8;font-size:.72rem;line-height:1.7;margin:0;">
        <strong style="color:#003b73;">Escuela Gabriela Mistral</strong><br>
        Danlí, El Paraíso, Honduras<br>
        Este es un correo automático — por favor no respondas a este mensaje.<br>
        © {{ date('Y') }} Todos los derechos reservados.
      </p>
    </div>

  </div>

</body>
</html>
