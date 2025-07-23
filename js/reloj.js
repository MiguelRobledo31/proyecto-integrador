function actualizarReloj() {
  const ahora = new Date();
  const opciones = {
    day: "numeric",
    month: "numeric",
    year: "numeric",
    hour: "numeric",
    minute: "numeric",
    second: "numeric",
    hour12: true,
  };
  document.getElementById("reloj").textContent = ahora.toLocaleString(
    "es-MX",
    opciones
  );
}

setInterval(actualizarReloj, 1000);
actualizarReloj();

const inputMatricula = document.getElementById("matricula");
inputMatricula.focus();
