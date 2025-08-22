/**
 * Archivo JavaScript principal para el Sistema de Gestión Escolar
 */

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar tooltips de Bootstrap
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Añadir efecto de hover a las tarjetas
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 10px 20px rgba(0,0,0,0.15)';
            this.style.transition = 'all 0.3s ease';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 5px 8px rgba(0,0,0,0.1)';
        });
    });

    // Mostrar mensajes de alerta con animación
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        // Añadir animación de entrada
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-20px)';
        alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        
        setTimeout(() => {
            alert.style.opacity = '1';
            alert.style.transform = 'translateY(0)';
        }, 100);
        
        // Añadir botón de cierre si no existe
        if (!alert.querySelector('.btn-close')) {
            const closeButton = document.createElement('button');
            closeButton.className = 'btn-close';
            closeButton.setAttribute('type', 'button');
            closeButton.setAttribute('data-bs-dismiss', 'alert');
            closeButton.setAttribute('aria-label', 'Close');
            alert.classList.add('alert-dismissible', 'fade', 'show');
            alert.appendChild(closeButton);
        }
    });
});