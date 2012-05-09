/**
 * Functiones varias para el manejo de elementos DOM con javascript y prototype
 */


/**
 * Funcion para cambiar el valor de un elemento de formulario tipo: text, hidden
 */
function changeFormElement(element, value) {
    $(element).value = value;
}

/**
 * Funcion para cambiar visibilidad de un elementode manera opuesta al estado
 * actual del elemento
 */
function toggleElement(element){
    $(element).toggle();
}

/**
 * Function para cambiar la visibilidad de un elemento segun el parametro 'visible'
 */
function changeVisibility(element, visible) {
    if(visible==1)
        $(element).setStyle({
            visibility: 'visible',
            display: 'block'
        });
    else
        $(element).setStyle({
            visibility: 'hidden',
            display: 'none'
        });
}