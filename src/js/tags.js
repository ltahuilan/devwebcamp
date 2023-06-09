(function(){
    const tagsInput = document.querySelector('#tags_input');
    const tagsHidden = document.querySelector('[name="tags"]');
    const tagsDiv = document.querySelector('#tags');
    
    //si existe el elemento en el html
    if(tagsInput) {
        let tags = [];

        //verificar si hay datso en el input hidden
        if(tagsHidden.value !== ''){
            tags = tagsHidden.value.split(',');
            mostrarTags();
        }

        tagsInput.addEventListener('keypress', agregarTags);

        function agregarTags(event) {
            //detectar el keycode de la coma
            if(event.keyCode === 44) {
                //prevenir agregar vacíos o textos con una letra
                if(event.target.value.trim() === '' || event.target.value.length <= 1) {
                    event.preventDefault();
                    //limpiar input
                    tagsInput.value = '';
                    return;
                }
    
                event.preventDefault();
    
                //agregar al arreglo de tags
                tags = [...tags, event.target.value.trim()];
    
                //agregar al input hidden
                agregarTagsInputHidden();
    
                //limpiar input
                tagsInput.value = '';
    
                mostrarTags();
    
            }
        }
    
        function agregarTagsInputHidden() {        
            tagsHidden.value = tags;
        }
    
        function mostrarTags() {
            //remover elementos existentes
            while(tagsDiv.firstChild){
                tagsDiv.removeChild(tagsDiv.firstChild);
            }
    
            tags.forEach(tag => {
                const contenedorTag = document.createElement('DIV');
                contenedorTag.classList.add('formulario__contenedor-tag');
    
                const tagLi = document.createElement('LI');
                tagLi.classList.add('formulario__tag');
                tagLi.textContent = tag;
    
                const icon = document.createElement('I');
                icon.classList.add('fa-regular', 'fa-circle-xmark', 'formulario__tag-icono');
                icon.onclick = eliminarTag;
    
                contenedorTag.appendChild(tagLi);
                contenedorTag.appendChild(icon);
                tagsDiv.appendChild(contenedorTag);
            })
        }
    
        function eliminarTag(event) {
            //remover elemento del DOM
            event.target.parentElement.remove();
    
            //actualizar arreglo
            tags = tags.filter(tag => tag !== event.target.parentElement.firstChild.textContent);
    
            //actualizar el value del input hidden
            agregarTagsInputHidden();
        };
    }

})();