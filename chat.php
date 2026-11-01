<?php
require 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat Grupal</title>
  <style>
    * { box-sizing: border-box; }
    body { margin: 0; font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif; background: #f4f4f4; color: #111; }
    .contenedor { max-width: 720px; margin: 0 auto; height: 100vh; display: flex; flex-direction: column; background: #fff; border-left: 1px solid #ddd; border-right: 1px solid #ddd; }
    header { padding: 14px 16px; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center; gap: 12px; }
    header h1 { font-size: 18px; margin: 0; }
    .derecha { display: flex; align-items: center; gap: 12px; }
    #estado { font-size: 12px; color: #666; }
    .volver { background: #111; color: #fff; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 13px; }
    #mensajes { flex: 1; overflow-y: auto; padding: 16px; display: flex; flex-direction: column; gap: 10px; }
    .mensaje { max-width: 80%; padding: 8px 12px; border-radius: 8px; background: #eee; align-self: flex-start; word-wrap: break-word; }
    .mensaje.propio { background: #111; color: #fff; align-self: flex-end; }
    .mensaje .meta { font-size: 11px; opacity: 0.7; margin-bottom: 2px; }
    .vacio { color: #888; text-align: center; margin-top: 40px; }
    form { display: flex; gap: 8px; padding: 12px 16px; border-top: 1px solid #ddd; }
    input { padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; }
    #texto { flex: 1; }
    button { padding: 10px 16px; border: none; border-radius: 6px; background: #111; color: #fff; font-size: 14px; cursor: pointer; }
    button:disabled { opacity: 0.5; cursor: default; }
  </style>
</head>
<body>
  <div class="contenedor">
    <header>
      <h1>💬 Chat Grupal</h1>
      <div class="derecha">
        <span id="estado">Conectando...</span>
        <a class="volver" href="menu.php">Menú</a>
      </div>
    </header>

    <div id="mensajes">
      <p class="vacio" id="vacio">Aún no hay mensajes.</p>
    </div>

    <form id="formulario">
      <input id="texto" type="text" placeholder="Escribe como <?= e($_SESSION['nombre']) ?>..." maxlength="500" required autocomplete="off">
      <button id="enviar" type="submit">Enviar</button>
    </form>
  </div>

  <script>
    const INTERVALO_MS = 3000;
    let ultimoId = 0;

    const caja = document.getElementById("mensajes");
    const estado = document.getElementById("estado");
    const formulario = document.getElementById("formulario");
    const campoTexto = document.getElementById("texto");
    const botonEnviar = document.getElementById("enviar");

    function pintarMensaje(m) {
      const vacio = document.getElementById("vacio");
      if (vacio) vacio.remove();

      const div = document.createElement("div");
      div.className = "mensaje" + (m.propio ? " propio" : "");

      const meta = document.createElement("div");
      meta.className = "meta";
      const hora = new Date(m.ts * 1000).toLocaleTimeString("es-MX", { hour: "2-digit", minute: "2-digit" });
      meta.textContent = m.usuario + " · " + hora;

      const cuerpo = document.createElement("div");
      cuerpo.textContent = m.texto;

      div.append(meta, cuerpo);
      caja.appendChild(div);
    }

    async function consultarMensajes() {
      try {
        const resp = await fetch("api_chat.php?desde=" + ultimoId);
        if (resp.status === 401) { location.href = "login.php"; return; }
        if (!resp.ok) throw new Error("HTTP " + resp.status);
        const nuevos = await resp.json();
        if (nuevos.length > 0) {
          const alFinal = caja.scrollHeight - caja.scrollTop - caja.clientHeight < 60;
          nuevos.forEach(pintarMensaje);
          ultimoId = nuevos[nuevos.length - 1].id;
          if (alFinal) caja.scrollTop = caja.scrollHeight;
        }
        estado.textContent = "Conectado";
      } catch (err) {
        estado.textContent = "Sin conexión, reintentando...";
      }
    }

    formulario.addEventListener("submit", async (evento) => {
      evento.preventDefault();
      const texto = campoTexto.value.trim();
      if (!texto) return;

      botonEnviar.disabled = true;
      try {
        const resp = await fetch("api_chat.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ texto })
        });
        if (!resp.ok) {
          const error = await resp.json().catch(() => ({}));
          alert(error.error || "No se pudo enviar el mensaje.");
        } else {
          campoTexto.value = "";
          await consultarMensajes();
          caja.scrollTop = caja.scrollHeight;
        }
      } catch (err) {
        alert("No hay conexión con el servidor.");
      } finally {
        botonEnviar.disabled = false;
        campoTexto.focus();
      }
    });

    consultarMensajes();
    setInterval(consultarMensajes, INTERVALO_MS);
  </script>
</body>
</html>