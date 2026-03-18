<?php
/**
 * Rodapé Compartilhado
 * Inclua no final de cada página antes do fechamento do </body>
 */
?>

<!-- Footer -->
<footer class="site-footer mt-auto">
    <div class="container-fluid px-4">
        <div class="row align-items-center py-3">

            <!-- Logo -->
            <div class="col-md-4 text-center text-md-start mb-2 mb-md-0">
                <a href="index.php">
                    <img src="assets/img/logo-rent-a-car.png" alt="DriveEasy" height="32" class="footer-logo">
                </a>
            </div>

            <!-- Créditos -->
            <div class="col-md-4 text-center mb-2 mb-md-0">
                <small class="footer-credits">
                    Criado por <strong>Carlos Gabriel dos Santos Modesto</strong><br>
                    SENAI "Luiz Massa" &copy; 2023 &mdash; v2.0
                </small>
            </div>

            <!-- Botão de tema -->
            <div class="col-md-4 text-center text-md-end">
                <button class="btn btn-sm btn-outline-warning footer-theme-btn" onclick="alterarTema()" title="Alternar tema">
                    <i class="bi bi-moon-stars-fill" id="iconeTemaFooter"></i>
                    <span id="textoTemaFooter">Tema escuro</span>
                </button>
            </div>

        </div>
    </div>
</footer>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- JS personalizado -->
<script src="assets/js/script.js"></script>
</body>
</html>
