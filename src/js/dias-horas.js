(function() {
    //constantes
    const STRING_VACIO = '';

    //selectores
    const categoria_id = document.querySelector("[name='categoria_id']");
    const dias = document.querySelectorAll("[name='dia']");
    const inputHiddenDia = document.querySelector("[name='dia_id']");
    const inputHiddenHora = document.querySelector("[name='hora_id']");

    const evento = {
        'categoria_id': STRING_VACIO,
        'dia': STRING_VACIO
    }

    if(categoria_id){
        categoria_id.addEventListener('change', terminosDeBusqueda);
        dias.forEach(dia => dia.addEventListener('change', terminosDeBusqueda));
    }

    function terminosDeBusqueda(event) {
        evento[event.target.name] = event.target.value;

        //reset a los campos ocultos
        inputHiddenHora.value = STRING_VACIO;
        inputHiddenDia.value = STRING_VACIO;

        if(!Object.values(evento).includes(STRING_VACIO)) {
            obtenerEventos();
        }  
    }
    
    async function obtenerEventos() {
        
        const {categoria_id, dia} = evento;
        const url = `/api/eventos?categoria_id=${categoria_id}&dia_id=${dia}`;
        
        try {
            const respuesta = await fetch(url);
            const eventos = await respuesta.json();
            obtenerHorasDisponibles(eventos);
        } catch (error) {
            console.log(error);
        }       
    }

    
    function obtenerHorasDisponibles(eventos) {

        /**
         * Reset de las clases en los elementos li
         * restaurar la clase horas__hora--desactivada
         * eliminar la clase horas__hora--select
         * remover eventListener de los elementos con la clase horas__hora--desactivada
         */
        const listaHoras = document.querySelectorAll('#horas li');
        listaHoras.forEach(li => {
            li.classList.add('horas__hora--desactivada');
        });
        
        horaActiva = document.querySelector('.horas__hora--selec');
        if(horaActiva) {
            horaActiva.classList.remove('horas__hora--selec');
        }

        const horasOcupadas = eventos.map(horas => horas.hora_id);

        //el selector listaHoras contiene un nodelist, convertirlo en array para utilizar filter()
        const listaHorasArray = Array.from(listaHoras);

        //filtrar las horas disponibles
        const resultado = listaHorasArray.filter(hora => !horasOcupadas.includes(hora.dataset.horaId) );

        //eliminar la clase .horas__hora--desactivada
        resultado.forEach(hora => hora.classList.remove('horas__hora--desactivada'));

        //iterar las horas para agregar un evento que permita seleccionar una hora
        const horasDisponibles = document.querySelectorAll('.horas__hora:not(.horas__hora--desactivada)');
        horasDisponibles.forEach( hora => hora.addEventListener('click', seleccionarHora));
        
        //remover eventListener de los elementos con la clase horas__hora--desactivada
        const horasNoDisponibles = document.querySelectorAll('.horas__hora--desactivada');
        Array.from(horasNoDisponibles).forEach(hora => hora.removeEventListener('click', seleccionarHora));
    }

    function seleccionarHora(event) {

        //agregar valores a los inputs ocultos
        inputHiddenHora.value = event.target.dataset.horaId;        
        inputHiddenDia.value = document.querySelector('[name="dia"]:checked').value;
        
        //eliminar clase de un elemento previamente seleccionado
        horaActiva = document.querySelector('.horas__hora--selec');
        if(horaActiva) {
            horaActiva.classList.remove('horas__hora--selec');
        }

        //agregar clase a la hora seleccionda
        event.target.classList.add('horas__hora--selec');
        
    }

})();