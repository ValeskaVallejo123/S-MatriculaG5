<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Escuela Gabriela Mistral - Sistema Escolar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      overflow-x: hidden;
    }

    /* ========== NAVBAR ========== */
    .navbar-custom {
      background: linear-gradient(135deg, #003b73 0%, #00508f 50%, #4ec7d2 100%);
      padding: 18px 0;
      box-shadow: 0 4px 20px rgba(0, 59, 115, 0.3);
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 1000;
      backdrop-filter: blur(10px);
    }

    .navbar-custom .navbar-brand {
      display: flex;
      align-items: center;
      gap: 12px;
      color: white;
      font-weight: 700;
      font-size: 1.5rem;
      text-decoration: none;
    }

    .navbar-custom .navbar-brand i {
      font-size: 2rem;
      color: #4ec7d2;
    }

    .navbar-custom .nav-link {
      color: white !important;
      font-weight: 500;
      margin: 0 15px;
      transition: all 0.3s ease;
      position: relative;
    }

    .navbar-custom .nav-link:hover {
      transform: translateY(-2px);
      color: #4ec7d2 !important;
    }

    .navbar-custom .nav-link::after {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 0;
      height: 3px;
      background: #4ec7d2;
      transition: width 0.3s ease;
    }

    .navbar-custom .nav-link:hover::after {
      width: 100%;
    }

    .btn-login {
  background: rgba(78, 199, 210, 0.2);
  color: white !important;
  padding: 10px 28px;
  border-radius: 25px;
  border: 2px solid #4ec7d2;
  font-weight: 600;
  transition: all 0.3s ease;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  white-space: nowrap;
}

.btn-login:hover {
  background: #4ec7d2;
  color: #003b73 !important;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(78, 199, 210, 0.4);
}

.btn-login i {
  font-size: 0.95rem;
}

    .btn-login:hover {
      background: #4ec7d2;
      color: #003b73 !important;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(78, 199, 210, 0.4);
    }

    /* ========== HERO SECTION ========== */
    .hero-section {
      background: linear-gradient(135deg, #003b73 0%, #00508f 50%, #07196b 100%);
      min-height: 100vh;
      padding: 140px 0 100px;
      position: relative;
      overflow: hidden;
    }

    /* Fondo con ondas decorativas */
    .hero-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image:
        radial-gradient(circle at 20% 80%, rgba(78, 199, 210, 0.15) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(78, 199, 210, 0.12) 0%, transparent 50%),
        radial-gradient(circle at 40% 40%, rgba(191, 217, 234, 0.08) 0%, transparent 50%);
      pointer-events: none;
      animation: pulseGlow 8s ease-in-out infinite;
    }

    @keyframes pulseGlow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.7; }
    }

    /* Patrón de grid decorativo */
    .hero-section::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image:
        linear-gradient(rgba(78, 199, 210, 0.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(78, 199, 210, 0.05) 1px, transparent 1px);
      background-size: 60px 60px;
      pointer-events: none;
      opacity: 0.4;
      animation: gridMove 30s linear infinite;
    }

    @keyframes gridMove {
      0% { transform: translate(0, 0); }
      100% { transform: translate(60px, 60px); }
    }

    /* Formas geométricas decorativas */
    .hero-shapes {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      overflow: hidden;
      pointer-events: none;
      z-index: 1;
    }

    .shape {
      position: absolute;
      opacity: 0.06;
      animation: floatShape 20s ease-in-out infinite;
    }

    @keyframes floatShape {
      0%, 100% { transform: translateY(0) rotate(0deg); }
      25% { transform: translateY(-30px) rotate(5deg); }
      50% { transform: translateY(-60px) rotate(-5deg); }
      75% { transform: translateY(-30px) rotate(3deg); }
    }

    .shape-circle {
      width: 400px;
      height: 400px;
      border-radius: 50%;
      background: linear-gradient(135deg, #4ec7d2, #00508f);
      top: 5%;
      right: -5%;
      animation-delay: 0s;
      filter: blur(40px);
    }

    .shape-circle-2 {
      width: 300px;
      height: 300px;
      border-radius: 50%;
      background: linear-gradient(135deg, #bfd9ea, #4ec7d2);
      bottom: 10%;
      left: -5%;
      animation-delay: 3s;
      filter: blur(35px);
    }

    .shape-square {
      width: 250px;
      height: 250px;
      background: linear-gradient(135deg, rgba(78, 199, 210, 0.3), rgba(0, 80, 143, 0.3));
      transform: rotate(45deg);
      bottom: 20%;
      left: 10%;
      animation-delay: 2s;
      filter: blur(25px);
    }

    .shape-triangle {
      width: 0;
      height: 0;
      border-left: 200px solid transparent;
      border-right: 200px solid transparent;
      border-bottom: 350px solid rgba(78, 199, 210, 0.08);
      top: 15%;
      right: 15%;
      animation-delay: 1.5s;
      filter: blur(20px);
    }

    /* Partículas flotantes */
    .particles {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      pointer-events: none;
      z-index: 1;
    }

    .particle {
      position: absolute;
      background: rgba(78, 199, 210, 0.3);
      border-radius: 50%;
      animation: particleFloat 15s infinite ease-in-out;
    }

    @keyframes particleFloat {
      0% {
        transform: translateY(0) translateX(0);
        opacity: 0;
      }
      10% {
        opacity: 0.3;
      }
      90% {
        opacity: 0.3;
      }
      100% {
        transform: translateY(-100vh) translateX(50px);
        opacity: 0;
      }
    }

    .particle:nth-child(1) {
      left: 10%;
      width: 8px;
      height: 8px;
      animation-delay: 0s;
      animation-duration: 18s;
    }

    .particle:nth-child(2) {
      left: 25%;
      width: 6px;
      height: 6px;
      animation-delay: 3s;
      animation-duration: 15s;
    }

    .particle:nth-child(3) {
      left: 40%;
      width: 10px;
      height: 10px;
      animation-delay: 1s;
      animation-duration: 20s;
    }

    .particle:nth-child(4) {
      left: 60%;
      width: 7px;
      height: 7px;
      animation-delay: 4s;
      animation-duration: 17s;
    }

    .particle:nth-child(5) {
      left: 75%;
      width: 9px;
      height: 9px;
      animation-delay: 2s;
      animation-duration: 16s;
    }

    .particle:nth-child(6) {
      left: 90%;
      width: 5px;
      height: 5px;
      animation-delay: 5s;
      animation-duration: 19s;
    }

    .floating-element {
      position: absolute;
      animation: float 8s ease-in-out infinite;
      opacity: 0.15;
      filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
      color: #4ec7d2;
      z-index: 2;
    }

    @keyframes float {
      0%, 100% {
        transform: translateY(0px) rotate(0deg);
        opacity: 0.15;
      }
      25% {
        transform: translateY(-15px) rotate(3deg);
        opacity: 0.25;
      }
      50% {
        transform: translateY(-25px) rotate(-3deg);
        opacity: 0.2;
      }
      75% {
        transform: translateY(-10px) rotate(2deg);
        opacity: 0.25;
      }
    }

    .pencil {
      top: 15%;
      left: 8%;
      font-size: 3.5rem;
      animation-delay: 0s;
    }

    .ruler {
      top: 25%;
      right: 10%;
      font-size: 3rem;
      animation-delay: 1.5s;
    }

    .book {
      bottom: 25%;
      left: 5%;
      font-size: 4rem;
      animation-delay: 2.5s;
    }

    .atom {
      top: 45%;
      right: 8%;
      font-size: 3.5rem;
      animation-delay: 1s;
    }

    .calculator {
      top: 65%;
      right: 12%;
      font-size: 3rem;
      animation-delay: 0.8s;
    }

    .microscope {
      bottom: 18%;
      right: 18%;
      font-size: 3.5rem;
      animation-delay: 3s;
    }

    .hero-content {
      text-align: center;
      color: white;
      position: relative;
      z-index: 10;
      max-width: 900px;
      margin: 0 auto;
    }

    .hero-content h1 {
      font-size: 3.8rem;
      font-weight: 800;
      margin-bottom: 30px;
      text-shadow: 2px 4px 8px rgba(0, 0, 0, 0.3);
      line-height: 1.3;
      letter-spacing: -1px;
    }

    .hero-content h1 span {
      background: linear-gradient(to right, #4ec7d2, #bfd9ea);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .hero-content p {
      font-size: 1.35rem;
      max-width: 750px;
      margin: 0 auto 50px;
      opacity: 0.95;
      line-height: 1.7;
      font-weight: 400;
      text-shadow: 1px 2px 4px rgba(0, 0, 0, 0.2);
      color: #bfd9ea;
    }

    .categories {
      text-align: center;
      margin-top: 50px;
    }

    .categories h3 {
      color: white;
      font-size: 1.3rem;
      font-weight: 600;
      margin-bottom: 25px;
      opacity: 0.95;
    }

    .category-tags {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 15px;
      max-width: 800px;
      margin: 0 auto;
    }

    .category-tag {
      padding: 14px 32px;
      background: rgba(78, 199, 210, 0.2);
      border: 2px solid #4ec7d2;
      color: white;
      border-radius: 30px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.4s ease;
      backdrop-filter: blur(10px);
      font-size: 0.95rem;
      text-decoration: none;
      display: inline-block;
    }

    .category-tag:hover {
      background: #4ec7d2;
      color: #003b73;
      transform: translateY(-5px) scale(1.05);
      box-shadow: 0 10px 30px rgba(78, 199, 210, 0.4);
      border-color: #4ec7d2;
    }

    .hero-rocket {
      position: absolute;
      bottom: 8%;
      left: 50%;
      transform: translateX(-50%);
      font-size: 7rem;
      color: rgba(78, 199, 210, 0.2);
      animation: rocketLaunch 4s ease-in-out infinite;
      filter: drop-shadow(0 8px 16px rgba(0, 0, 0, 0.3));
      z-index: 2;
    }

    @keyframes rocketLaunch {
      0%, 100% {
        transform: translateX(-50%) translateY(0) rotate(-5deg);
        opacity: 0.2;
      }
      25% {
        transform: translateX(-50%) translateY(-20px) rotate(0deg);
        opacity: 0.3;
      }
      50% {
        transform: translateX(-50%) translateY(-40px) rotate(5deg);
        opacity: 0.25;
      }
      75% {
        transform: translateX(-50%) translateY(-20px) rotate(0deg);
        opacity: 0.3;
      }
    }

    /* ========== MATRICULA SECTION ========== */
    .matricula-section {
      padding: 100px 0;
      background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
      position: relative;
      overflow: hidden;
    }

    .matricula-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image:
        radial-gradient(circle at 20% 30%, rgba(78, 199, 210, 0.08) 0%, transparent 50%),
        radial-gradient(circle at 80% 70%, rgba(0, 80, 143, 0.06) 0%, transparent 50%);
      pointer-events: none;
    }

    .matricula-content {
      max-width: 1000px;
      margin: 0 auto;
      text-align: center;
      position: relative;
      z-index: 2;
    }

    .matricula-header {
      margin-bottom: 60px;
    }

    .matricula-header h2 {
      font-size: 2.8rem;
      font-weight: 700;
      color: #003b73;
      margin-bottom: 15px;
    }

    .matricula-header p {
      font-size: 1.2rem;
      color: #00508f;
      max-width: 800px;
      margin: 0 auto;
      line-height: 1.7;
    }

    .matricula-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 30px;
      margin-bottom: 50px;
    }

    .matricula-card {
      background: white;
      padding: 40px 30px;
      border-radius: 20px;
      box-shadow: 0 8px 30px rgba(0, 59, 115, 0.1);
      transition: all 0.4s ease;
      border: 2px solid transparent;
      position: relative;
      overflow: hidden;
    }

    .matricula-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, #4ec7d2 0%, #00508f 100%);
    }

    .matricula-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 40px rgba(78, 199, 210, 0.3);
      border-color: #4ec7d2;
    }

    .matricula-card-icon {
      width: 80px;
      height: 80px;
      margin: 0 auto 25px;
      background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2.5rem;
      color: white;
      box-shadow: 0 10px 30px rgba(78, 199, 210, 0.3);
      transition: all 0.3s ease;
    }

    .matricula-card:hover .matricula-card-icon {
      transform: scale(1.1) rotate(5deg);
    }

    .matricula-card h3 {
      font-size: 1.4rem;
      font-weight: 700;
      color: #003b73;
      margin-bottom: 15px;
    }

    .matricula-card ul {
      list-style: none;
      padding: 0;
      text-align: left;
      margin-bottom: 25px;
    }

    .matricula-card ul li {
      color: #00508f;
      margin-bottom: 12px;
      padding-left: 30px;
      position: relative;
      line-height: 1.6;
    }

    .matricula-card ul li::before {
      content: '\f00c';
      font-family: 'Font Awesome 6 Free';
      font-weight: 900;
      position: absolute;
      left: 0;
      color: #4ec7d2;
      font-size: 1rem;
    }

    .btn-matricula {
      background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
      color: white;
      padding: 15px 40px;
      border-radius: 30px;
      text-decoration: none;
      font-weight: 600;
      display: inline-block;
      transition: all 0.3s ease;
      border: none;
      font-size: 1rem;
      box-shadow: 0 8px 25px rgba(78, 199, 210, 0.3);
    }

    .btn-matricula:hover {
      transform: scale(1.08);
      box-shadow: 0 12px 35px rgba(78, 199, 210, 0.5);
      color: white;
      background: linear-gradient(135deg, #00508f 0%, #003b73 100%);
    }

    .matricula-cta {
      background: linear-gradient(135deg, #003b73 0%, #00508f 100%);
      padding: 50px;
      border-radius: 25px;
      box-shadow: 0 15px 50px rgba(0, 59, 115, 0.3);
      position: relative;
      overflow: hidden;
    }

    .matricula-cta::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image:
        radial-gradient(circle at 30% 50%, rgba(78, 199, 210, 0.15) 0%, transparent 50%),
        radial-gradient(circle at 70% 80%, rgba(78, 199, 210, 0.12) 0%, transparent 50%);
      pointer-events: none;
    }

    .matricula-cta-content {
      position: relative;
      z-index: 2;
    }

    .matricula-cta h3 {
      font-size: 2rem;
      font-weight: 700;
      color: white;
      margin-bottom: 20px;
    }

    .matricula-cta p {
      font-size: 1.1rem;
      color: #bfd9ea;
      margin-bottom: 30px;
      max-width: 700px;
      margin-left: auto;
      margin-right: auto;
    }

    .btn-matricula-principal {
      background: #4ec7d2;
      color: #003b73;
      padding: 18px 50px;
      border-radius: 50px;
      text-decoration: none;
      font-weight: 700;
      display: inline-block;
      transition: all 0.3s ease;
      border: none;
      font-size: 1.15rem;
      box-shadow: 0 10px 30px rgba(78, 199, 210, 0.4);
    }

    .btn-matricula-principal:hover {
      background: white;
      color: #003b73;
      transform: translateY(-5px) scale(1.05);
      box-shadow: 0 15px 40px rgba(255, 255, 255, 0.3);
    }

    /* ========== FEATURES SECTION ========== */
    .features-section {
      padding: 100px 0;
      background: linear-gradient(to bottom, #f8f9fa 0%, #ffffff 100%);
    }

    .section-title {
      text-align: center;
      margin-bottom: 70px;
    }

    .section-title h2 {
      font-size: 2.8rem;
      font-weight: 700;
      color: #003b73;
      margin-bottom: 15px;
    }

    .section-title p {
      font-size: 1.2rem;
      color: #00508f;
    }

    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 40px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .feature-card {
      background: white;
      padding: 45px 35px;
      border-radius: 25px;
      box-shadow: 0 8px 30px rgba(0, 59, 115, 0.1);
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      text-align: center;
      border: 2px solid transparent;
      position: relative;
      overflow: hidden;
    }

    .feature-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, #4ec7d2 0%, #00508f 100%);
      transform: scaleX(0);
      transition: transform 0.4s ease;
    }

    .feature-card:hover::before {
      transform: scaleX(1);
    }

    .feature-card:hover {
      transform: translateY(-15px) scale(1.02);
      box-shadow: 0 20px 50px rgba(78, 199, 210, 0.3);
      border-color: #4ec7d2;
    }

    .feature-icon {
      width: 95px;
      height: 95px;
      margin: 0 auto 25px;
      background: linear-gradient(135deg, #00508f 0%, #003b73 100%);
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2.8rem;
      color: #4ec7d2;
      box-shadow: 0 10px 30px rgba(0, 80, 143, 0.3);
      transition: all 0.4s ease;
    }

    .feature-card:hover .feature-icon {
      transform: scale(1.1) rotate(5deg);
      box-shadow: 0 15px 40px rgba(78, 199, 210, 0.5);
      background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
      color: white;
    }

    .feature-card h3 {
      font-size: 1.5rem;
      font-weight: 700;
      color: #003b73;
      margin-bottom: 15px;
    }

    .feature-card p {
      color: #00508f;
      line-height: 1.7;
      margin-bottom: 25px;
    }

    .btn-feature {
      background: linear-gradient(135deg, #00508f 0%, #003b73 100%);
      color: white;
      padding: 14px 35px;
      border-radius: 30px;
      text-decoration: none;
      font-weight: 600;
      display: inline-block;
      transition: all 0.3s ease;
      border: none;
      font-size: 0.95rem;
    }

    .btn-feature:hover {
      transform: scale(1.08);
      box-shadow: 0 10px 30px rgba(78, 199, 210, 0.5);
      color: white;
      background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
    }

    /* ========== STATS SECTION ========== */
    .stats-section {
      background: linear-gradient(135deg, #4ec7d2 0%, #00508f 50%, #003b73 100%);
      padding: 90px 0;
      color: white;
      position: relative;
      overflow: hidden;
    }

    .stats-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image:
        radial-gradient(circle at 30% 50%, rgba(255, 255, 255, 0.12) 0%, transparent 50%),
        radial-gradient(circle at 70% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
      pointer-events: none;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 50px;
      max-width: 1200px;
      margin: 0 auto;
      text-align: center;
      position: relative;
      z-index: 2;
    }

    .stat-item {
      transition: all 0.3s ease;
    }

    .stat-item:hover {
      transform: scale(1.1);
    }

    .stat-item h3 {
      font-size: 4rem;
      font-weight: 900;
      margin-bottom: 15px;
      text-shadow: 2px 4px 8px rgba(0, 0, 0, 0.2);
    }

    .stat-item p {
      font-size: 1.2rem;
      opacity: 0.95;
      font-weight: 600;
      letter-spacing: 0.5px;
    }

    /* ========== CTA SECTION ========== */
    .cta-section {
      padding: 100px 0;
      background: linear-gradient(135deg, rgba(78, 199, 210, 0.08) 0%, rgba(191, 217, 234, 0.15) 100%);
      text-align: center;
    }

    .cta-content h2 {
      font-size: 2.5rem;
      font-weight: 700;
      color: #003b73;
      margin-bottom: 20px;
    }

    .cta-content p {
      font-size: 1.2rem;
      color: #00508f;
      margin-bottom: 40px;
      max-width: 700px;
      margin-left: auto;
      margin-right: auto;
    }

    .btn-cta {
      background: linear-gradient(135deg, #00508f 0%, #003b73 100%);
      color: white;
      padding: 20px 55px;
      border-radius: 50px;
      text-decoration: none;
      font-weight: 700;
      font-size: 1.2rem;
      display: inline-block;
      transition: all 0.4s ease;
      border: none;
      box-shadow: 0 15px 40px rgba(0, 80, 143, 0.4);
      position: relative;
      overflow: hidden;
    }

    .btn-cta::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(78, 199, 210, 0.4), transparent);
      transition: left 0.6s ease;
    }

    .btn-cta:hover::before {
      left: 100%;
    }

    .btn-cta:hover {
      transform: translateY(-5px) scale(1.05);
      box-shadow: 0 20px 50px rgba(78, 199, 210, 0.5);
      color: white;
      background: linear-gradient(135deg, #4ec7d2 0%, #00508f 100%);
    }

    /* ========== FOOTER ========== */
    footer {
      background: #003b73;
      color: white;
      padding: 50px 0 30px;
    }

    .footer-content {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 40px;
      max-width: 1200px;
      margin: 0 auto 40px;
    }

    .footer-section h4 {
      font-size: 1.3rem;
      margin-bottom: 20px;
      font-weight: 700;
      color: #4ec7d2;
    }

    .footer-section p,
    .footer-section a {
      color: rgba(255, 255, 255, 0.8);
      text-decoration: none;
      line-height: 2;
      display: block;
    }

    .footer-section a:hover {
      color: #4ec7d2;
      padding-left: 5px;
      transition: all 0.3s ease;
    }

    .footer-bottom {
      text-align: center;
      padding-top: 30px;
      border-top: 1px solid rgba(78, 199, 210, 0.2);
    }

    .social-icons {
      display: flex;
      gap: 15px;
      margin-top: 20px;
    }

    .social-icons a {
      width: 40px;
      height: 40px;
      background: rgba(78, 199, 210, 0.2);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
      color: white;
    }

    .social-icons a:hover {
      background: #4ec7d2;
      color: #003b73;
      transform: translateY(-3px);
    }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 768px) {
      .hero-content h1 {
        font-size: 2.2rem;
      }

      .hero-content p {
        font-size: 1.1rem;
      }

      .floating-element {
        font-size: 2rem !important;
      }

      .section-title h2 {
        font-size: 2rem;
      }

      .navbar-custom .nav-link {
        margin: 10px 0;
      }

      .shape {
        display: none;
      }

      .matricula-header h2 {
        font-size: 2rem;
      }

      .matricula-cards {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>

<!-- ========== NAVBAR ========== -->
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
      <a class="navbar-brand" href="{{ url('/') }}">
        <i class="fas fa-graduation-cap"></i>
        Escuela Gabriela Mistral
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
              style="background-color: rgba(78, 199, 210, 0.3); border: none;">
        <span class="navbar-toggler-icon" style="filter: brightness(0) invert(1);"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item">
            <a class="nav-link" href="#inicio">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#matricula">Matrícula</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#nosotros">Nosotros</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#modulos">Módulos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#contacto">Contacto</a>
          </li>
          <li class="nav-item ms-3">
            <a class="btn-login" href="{{ route('login') }}">
  <i class="fas fa-sign-in-alt me-2"></i>Acceso Sistema
</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                style="background-color: rgba(78, 199, 210, 0.3); border: none;">
            <span class="navbar-toggler-icon" style="filter: brightness(0) invert(1);"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="#inicio">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#matricula">Matrícula</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#nosotros">Nosotros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#modulos">Módulos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contacto">Contacto</a>
                </li>
                <li class="nav-item ms-3">
                    <a class="btn-login" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt me-2"></i>Acceso Sistema
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- ========== HERO SECTION ========== -->
<section class="hero-section" id="inicio">
    <!-- Formas geométricas decorativas -->
    <div class="hero-shapes">
        <div class="shape shape-circle"></div>
        <div class="shape shape-circle-2"></div>
        <div class="shape shape-square"></div>
        <div class="shape shape-triangle"></div>
    </div>

    <!-- Partículas flotantes -->
    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <!-- Elementos decorativos flotantes -->
    <i class="fas fa-pencil-alt floating-element pencil"></i>
    <i class="fas fa-ruler floating-element ruler"></i>
    <i class="fas fa-book floating-element book"></i>
    <i class="fas fa-atom floating-element atom"></i>
    <i class="fas fa-calculator floating-element calculator"></i>
    <i class="fas fa-microscope floating-element microscope"></i>

    <div class="container hero-content">
        <h1><span>Centro de Educación Básico</span><br>Gabriela Mistral</h1>
        <p>
            Sistema integral de gestión escolar para una educación moderna y eficiente.
            Administra matrículas, calificaciones, asistencias y mucho más en un solo lugar.
        </p>

      <div class="categories">
        <h3>Servicios Disponibles</h3>
        <div class="category-tags">
          <a href="#matricula" class="category-tag">Matrícula en Línea</a>
          <a href="{{ route('matriculas.index') }}" class="category-tag">Consultar Solicitud</a>
          <a href="#nosotros" class="category-tag">Sobre Nosotros</a>
          <a href="#contacto" class="category-tag">Contacto</a>
        </div>
    </div>

    <i class="fas fa-rocket hero-rocket"></i>
</section>
  <!-- ========== MATRICULA SECTION ========== -->
  <section class="matricula-section" id="matricula">
    <div class="container matricula-content">

      <div class="matricula-header">
        <h2>Proceso de Matrícula 2025</h2>
        <p>
          Inscribe a tu hijo(a) en la Escuela Gabriela Mistral y forma parte de nuestra familia educativa.
          Proceso sencillo, rápido y 100% en línea.
        </p>
      </div>

      <div class="matricula-cards">

        <div class="matricula-card">
          <div class="matricula-card-icon">
            <i class="fas fa-clipboard-list"></i>
          </div>
          <h3>Requisitos</h3>
          <ul>
            <li>Partida de nacimiento original</li>
            <li>Certificado de estudios previo</li>
            <li>Documento de identidad del padre/madre</li>
            <li>Constancia de domicilio</li>
            <li>2 fotografías tamaño carnet</li>
          </ul>
        </div>

        <div class="matricula-card">
          <div class="matricula-card-icon">
            <i class="fas fa-file-signature"></i>
          </div>
          <h3>Proceso en Línea</h3>
          <ul>
            <li>Completa el formulario digital</li>
            <li>Sube documentos requeridos</li>
            <li>Recibe confirmación inmediata</li>
            <li>Programa tu cita presencial</li>
            <li>Finaliza el proceso en la escuela</li>
          </ul>
        </div>

        <div class="matricula-card">
          <div class="matricula-card-icon">
            <i class="fas fa-calendar-check"></i>
          </div>
          <h3>Fechas Importantes</h3>
          <ul>
            <li>Apertura: 2 de enero, 2025</li>
            <li>Cierre: 28 de febrero, 2025</li>
            <li>Inicio de clases: 10 de marzo</li>
            <li>Matrícula abierta todo el año</li>
            <li>Cupos limitados disponibles</li>
          </ul>
        </div>

      </div>

      <div class="matricula-cta">
        <div class="matricula-cta-content">
          <h3>¿Listo para Inscribir a tu Hijo(a)?</h3>
          <p>
            Completa el formulario de matrícula en línea y un miembro de nuestro equipo
            se pondrá en contacto contigo para continuar con el proceso.
          </p>
         <a href="{{ route('matriculas.public.create') }}" class="btn-matricula-principal">
  <i class="fas fa-pen-alt me-2"></i> Iniciar Matrícula en Línea
</a>
        </div>
      </div>

    </div>
  </section>

  <!-- ========== FEATURES SECTION ========== -->
  <section class="features-section" id="modulos">
    <div class="container">
      <div class="section-title">
        <h2>Nuestro Sistema</h2>
        <p>Plataforma completa para la gestión educativa moderna</p>
      </div>

        <div class="matricula-header">
            <h2>Proceso de Matrícula 2025</h2>
            <p>
                Inscribe a tu hijo(a) en la Escuela Gabriela Mistral y forma parte de nuestra familia educativa.
                Proceso sencillo, rápido y 100% en línea.
            </p>
        </div>

        <div class="matricula-cards">

            <div class="matricula-card">
                <div class="matricula-card-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h3>Requisitos</h3>
                <ul>
                    <li>Partida de nacimiento original</li>
                    <li>Certificado de estudios previo</li>
                    <li>Documento de identidad del padre/madre</li>
                    <li>Constancia de domicilio</li>
                    <li>2 fotografías tamaño carnet</li>
                </ul>
            </div>

            <div class="matricula-card">
                <div class="matricula-card-icon">
                    <i class="fas fa-file-signature"></i>
                </div>
                <h3>Proceso en Línea</h3>
                <ul>
                    <li>Completa el formulario digital</li>
                    <li>Sube documentos requeridos</li>
                    <li>Recibe confirmación inmediata</li>
                    <li>Programa tu cita presencial</li>
                    <li>Finaliza el proceso en la escuela</li>
                </ul>
            </div>

            <div class="matricula-card">
                <div class="matricula-card-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h3>Fechas Importantes</h3>
                <ul>
                    <li>Apertura: 2 de enero, 2025</li>
                    <li>Cierre: 28 de febrero, 2025</li>
                    <li>Inicio de clases: 10 de marzo</li>
                    <li>Matrícula abierta todo el año</li>
                    <li>Cupos limitados disponibles</li>
                </ul>
            </div>

        </div>

        <div class="matricula-cta">
            <div class="matricula-cta-content">
                <h3>¿Listo para Inscribir a tu Hijo(a)?</h3>
                <p>
                    Completa el formulario de matrícula en línea y un miembro de nuestro equipo
                    se pondrá en contacto contigo para continuar con el proceso.
                </p>
                <a href="{{ route('matriculas.public.create') }}" class="btn-matricula-principal">
                    <i class="fas fa-pen-alt me-2"></i> Iniciar Matrícula en Línea
                </a>
            </div>
        </div>

        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-clipboard-list"></i>
          </div>
          <h3>Proceso de Matrícula</h3>
          <p>Información sobre requisitos y proceso de inscripción para nuevos estudiantes.</p>
          <a href="#matricula" class="btn-feature">Información</a>
        </div>

        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-book-open"></i>
          </div>
          <h3>Plan de Estudios</h3>
          <p>Programas educativos diseñados para el desarrollo integral de nuestros estudiantes.</p>
          <a href="#nosotros" class="btn-feature">Ver Detalles</a>
        </div>

        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-phone-alt"></i>
          </div>
          <h3>Contáctanos</h3>
          <p>¿Tienes dudas? Nuestro equipo está disponible para atenderte y resolver tus consultas.</p>
          <a href="#contacto" class="btn-feature">Contactar</a>
        </div>

      </div>
    </div>
</section>

<!-- ========== FEATURES SECTION ========== -->
<section class="features-section" id="modulos">
    <div class="container">
        <div class="section-title">
            <h2>Nuestro Sistema</h2>
            <p>Plataforma completa para la gestión educativa moderna</p>
        </div>

        <div class="features-grid">

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <h3>Consulta de Solicitudes</h3>
                <p>Verifica el estado de tu solicitud de matrícula en tiempo real con tu número de identidad.</p>
                <a href="{{ route('matriculas.index') }}" class="btn-feature">Consultar Ahora</a>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Comunidad Educativa</h3>
                <p>Espacio dedicado para estudiantes, padres y profesores con acceso personalizado.</p>
                <a href="{{ route('login') }}" class="btn-feature">Acceder</a>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3>Excelencia Académica</h3>
                <p>Formación integral con docentes calificados y programas educativos de calidad.</p>
                <a href="#nosotros" class="btn-feature">Conocer Más</a>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h3>Proceso de Matrícula</h3>
                <p>Información sobre requisitos y proceso de inscripción para nuevos estudiantes.</p>
                <a href="#matricula" class="btn-feature">Información</a>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h3>Plan de Estudios</h3>
                <p>Programas educativos diseñados para el desarrollo integral de nuestros estudiantes.</p>
                <a href="#nosotros" class="btn-feature">Ver Detalles</a>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <h3>Contáctanos</h3>
                <p>¿Tienes dudas? Nuestro equipo está disponible para atenderte y resolver tus consultas.</p>
                <a href="#contacto" class="btn-feature">Contactar</a>
            </div>

        </div>
    </div>
</section>

<!-- ========== STATS SECTION ========== -->
<section class="stats-section" id="nosotros">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <h3>850+</h3>
                <p>Estudiantes Activos</p>
            </div>
            <div class="stat-item">
                <h3>45</h3>
                <p>Profesores</p>
            </div>
            <div class="stat-item">
                <h3>12</h3>
                <p>Grados Escolares</p>
            </div>
            <div class="stat-item">
                <h3>98%</h3>
                <p>Satisfacción</p>
            </div>
        </div>
    </div>
</section>

<!-- ========== CTA SECTION ========== -->
<section class="cta-section" id="contacto">
    <div class="container cta-content">
        <h2>¿Listo para Formar Parte de Nuestra Familia?</h2>
        <p>
            Únete a la comunidad educativa Gabriela Mistral. Para más información sobre el proceso
            de matrícula o consultas generales, contáctanos.
        </p>
        <a href="{{ route('login') }}" class="btn-cta">
            <i class="fas fa-sign-in-alt me-2"></i> Acceder al Sistema
        </a>
    </div>
</section>

<!-- ========== FOOTER ========== -->
<footer>
    <div class="container">
        <div class="footer-content">

            <div class="footer-section">
                <h4><i class="fas fa-graduation-cap"></i> Gabriela Mistral</h4>
                <p>Centro de Educación Básico comprometido con la formación integral de nuestros estudiantes.</p>
                <div class="social-icons">
                    <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <div class="footer-section">
                <h4>Enlaces Rápidos</h4>
                <a href="#inicio">Inicio</a>
                <a href="#matricula">Matrícula</a>
                <a href="#nosotros">Nosotros</a>
                <a href="{{ route('matriculas.index') }}">Consultar Solicitud</a>
            </div>

            <div class="footer-section">
                <h4>Para la Comunidad</h4>
                <a href="{{ route('login') }}">Portal Estudiantes</a>
                <a href="{{ route('login') }}">Portal Profesores</a>
                <a href="{{ route('login') }}">Portal Padres</a>
            </div>

            <div class="footer-section">
                <h4>Contacto</h4>
                <p><i class="fas fa-map-marker-alt"></i> Danlí, El Paraíso, Honduras</p>
                <p><i class="fas fa-phone"></i> +504 2763-4567</p>
                <p><i class="fas fa-envelope"></i> info@gabrielamistral.edu.hn</p>
            </div>

        </div>
        <div class="footer-section">
          <h4>Enlaces Rápidos</h4>
          <a href="#inicio">Inicio</a>
          <a href="#matricula">Matrícula</a>
          <a href="#nosotros">Nosotros</a>
          <a href="{{ route('matriculas.index') }}">Consultar Solicitud</a>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Scroll suave
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const offsetTop = target.offsetTop - 80;
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Animación de aparición
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '0';
                entry.target.style.transform = 'translateY(30px)';
                entry.target.style.transition = 'all 0.6s ease';

                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, 100);
            }
        });
    });

    document.querySelectorAll('.feature-card, .stat-item, .matricula-card').forEach(el => {
      observer.observe(el);
    });
</script>

</body>
</html>
