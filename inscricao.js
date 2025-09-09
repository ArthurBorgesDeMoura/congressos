function getParametro(nome) {
  const params = new URLSearchParams(window.location.search);
  return params.get(nome);
}

function abrirModal() {
  // Usando a API do Bootstrap para mostrar o modal
  const modalElement = document.getElementById("modalSucesso");
  const modal = new bootstrap.Modal(modalElement);
  modal.show();
}

function fecharModal() {
  const modalElement = document.getElementById("modalSucesso");
  const modal = bootstrap.Modal.getInstance(modalElement);
  if (modal) modal.hide();
}

// Executa ao carregar a página
window.addEventListener("DOMContentLoaded", () => {
  if (getParametro("abrirModal") === "true") {
    abrirModal();
  }
});