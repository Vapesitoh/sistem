
        function mostrarSeccionFotoDeposito(opcionSeleccionada) {
            var seccionFotoDeposito = document.getElementById('seccion_foto_deposito');
            if (opcionSeleccionada === 'Depósito') {
                seccionFotoDeposito.style.display = 'block';
            } else {
                seccionFotoDeposito.style.display = 'none';
            }
        }
