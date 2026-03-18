/**
 * DriveEasy — Pátio de Automóveis
 * script.js  |  v2.1
 */

/* ── Tema ── */
const TEMA_KEY = 'driveeasy_tema';

/** Aplica o tema salvo antes do render para evitar flash */
(function aplicarTemaInicial() {
    if (localStorage.getItem(TEMA_KEY) === 'claro') {
        document.body.classList.add('tema-claro');
    }
})();

/** Sincroniza todos os ícones e textos de tema na página */
function sincronizarIconesTema(claro) {
    // Ícone navbar
    const iconeNav = document.getElementById('iconeTema');
    if (iconeNav) {
        iconeNav.className = claro ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
    }
    // Ícone footer
    const iconeFooter = document.getElementById('iconeTemaFooter');
    if (iconeFooter) {
        iconeFooter.className = claro ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
    }
    // Texto footer
    const textoFooter = document.getElementById('textoTemaFooter');
    if (textoFooter) {
        textoFooter.textContent = claro ? 'Tema claro' : 'Tema escuro';
    }
}

/** Alterna entre tema escuro (padrão) e claro */
function alterarTema() {
    const claro = document.body.classList.toggle('tema-claro');
    sincronizarIconesTema(claro);
    localStorage.setItem(TEMA_KEY, claro ? 'claro' : 'escuro');
}

/* ── Inicialização ── */
document.addEventListener('DOMContentLoaded', function () {
    // Sincroniza ícones com o estado atual do tema
    const claro = document.body.classList.contains('tema-claro');
    sincronizarIconesTema(claro);

    // Inicializa tooltips Bootstrap 5
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
        .forEach(el => new bootstrap.Tooltip(el));
});

