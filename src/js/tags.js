(function(){

    const tagsInput = document.querySelector('#tags_input');
    const tagsDiv = document.querySelector('#tags');
    const inputHidden = document.querySelector('input[name="tags"]');
    
    
    if(tagsInput) {
        let arrTags = [];
        tagsInput.addEventListener('keypress', addTags);
        
        //Recuperar y mostrar los tags - aplica durante la edición de un registro de ponente
        if(inputHidden.value != '') {
            arrTags = inputHidden.value.split(',');
            showTags();
        }

        function addTags(event) {            

            if(event.keyCode === 44) {

                if(event.target.value.trim() === '' || event.target.value < 1){
                    return;
                };

                event.preventDefault(); //previene la accion de agregar la coma

                arrTags = [...arrTags, event.target.value.trim()];
                tagsInput.value = '';

                showTags();
            }
        }

        function showTags() {
            //limpiar HTML existente
            tagsDiv.innerHTML = '';

            arrTags.forEach(tag => {
                const contenedorTag = document.createElement('DIV');
                contenedorTag.classList.add('formulario__contenedor-tag');

                const etiqueta = document.createElement('LI');
                etiqueta.classList.add('formulario__tag');
                etiqueta.textContent = tag;

                const icono = document.createElement('I');
                icono.classList.add('fa-regular', 'fa-circle-xmark', 'formulario__tag-icono');
                icono.onclick = removeTag;
                contenedorTag.appendChild(etiqueta);
                contenedorTag.appendChild(icono);
                tagsDiv.appendChild(contenedorTag);

                addTextInputHidden();
            });
        }

        function addTextInputHidden() {
            inputHidden.value = arrTags.toString();
        }

        function removeTag(event) {

            //eliminar elemento del DOM
            event.target.parentElement.remove();

            //filtar elemenos restantes del arreglo
            arrTags = arrTags.filter(tag => tag !== event.target.parentElement.firstElementChild.innerText);

            addTextInputHidden();
        }
    }

})();