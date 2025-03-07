// Bloquear fechas anteriores a hoy
document.addEventListener('DOMContentLoaded', function() {
    var today = new Date().toISOString().split('T')[0];
    document.getElementById('fecha_inicio').setAttribute('min', today);
    document.getElementById('fecha_fin').setAttribute('min', today);
});
