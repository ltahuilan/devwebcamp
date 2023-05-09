
////////////////////////////////
(function(){

    const ponentesInput = document.querySelector('#ponentes');
    
    if(ponentesInput) {
        let ponentes = [];
        let ponentesFiltrados = [];

        
        ponentesInput.addEventListener('input', buscarPonentes);
        const listaPonentes = document.querySelector('#lista-ponentes');
        const ponenteHiddenInput = document.querySelector("[name='ponente_id']");
        
        //Si hay algo en el input hidden entonces se esta editando un evento
        if(ponenteHiddenInput.value) {        
            (async() => {
                const ponente = await buscarPonente(ponenteHiddenInput.value);
                
                const {nombre, apellido} = ponente;
                const ponenteHTML = document.createElement('LI');
                ponenteHTML.classList.add('lista-ponentes__ponente', 'lista-ponentes__ponente--seleccionado');
                ponenteHTML.textContent = `${nombre} ${apellido}`;
                listaPonentes.appendChild(ponenteHTML);                
            })();
        }

        consultarPonentes();

        /**
         * Obtiene todos los  ponenetes
         */
        async function consultarPonentes() {

            const url = '/api/ponentes';
            const request = await fetch(url);
            const response= await request.json();

            formatearPonentes(response);
        }


        /**
         * Obtiene solo el ponente requerido
         */
        async function buscarPonente(id) {
            
            const url = `/api/ponente?id=${id}`;
            const request = await fetch(url);
            const response = await request.json();
            return response;
        }

        function formatearPonentes(arrayResponse = []) {
            ponentes = arrayResponse.map(ponente => {
                return {
                    nombre: `${ponente.nombre.trim()} ${ponente.apellido.trim()}`,
                    id: ponente.id
                }
            })  
        }

        function buscarPonentes(event) {
            const busqueda = event.target.value;

            if(busqueda.length >= 3) {
                const regexp = new RegExp(busqueda, "i");
                ponentesFiltrados = ponentes.filter(ponente => {
                    if(ponente.nombre.toLowerCase().search(regexp) !== -1) {
                        return ponente;
                    }
                })          
                
                mostrarPonentesFiltrados();
                return;
            }

            ponentesFiltrados = [];
            mostrarPonentesFiltrados();

            //borrar el ponente_id
            ponenteHiddenInput.value = "";
        }

        function mostrarPonentesFiltrados() {

            while(listaPonentes.firstChild) {
                listaPonentes.removeChild(listaPonentes.firstChild);
            }

            if(ponentesFiltrados.length) {
                ponentesFiltrados.forEach(ponente => {
                    const li = document.createElement('LI');
                    li.classList.add('lista-ponentes__ponente');
                    li.dataset.ponenteHiddenInput = ponente.id;
                    li.textContent = ponente.nombre;
                    li.onclick = seleccionarPonente;
                    listaPonentes.appendChild(li);  
                })
                return;
            }
            
            const noPonentes = document.createElement('P');
            noPonentes.classList.add('lista-ponentes__no-ponentes');
            noPonentes.textContent = 'No se encontraron resultados';
            listaPonentes.appendChild(noPonentes);

        }

        function seleccionarPonente(event) {

            //agregar clase para darle estilos
            const ponenteSeleccionado = document.querySelector('.lista-ponentes__ponente--seleccionado');

            if(ponenteSeleccionado) {
                ponenteSeleccionado.classList.remove('lista-ponentes__ponente--seleccionado');
            }

            event.target.classList.add('lista-ponentes__ponente--seleccionado');

            //agregar el ponente_id al value
            ponenteHiddenInput.value = event.target.dataset.ponenteHiddenInput;           
        }
    }

})();