function duplicarCampos(el, destino){
    let clone = el.parentElement.parentElement.parentElement.cloneNode(true);
    let localDestino = document.getElementById(destino);
    localDestino.appendChild(clone);
    
    let input = clone.getElementsByTagName('input');

    for(let i = 0; i < input.length; i++){
        input[i].value = '';
        mascaraTelefoneCelular('.telefone-mask');
    }
}

function removerCampo(el){
    el.parentElement.parentElement.parentElement.remove();
}

export {duplicarCampos, removerCampo};