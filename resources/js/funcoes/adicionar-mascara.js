function mascaraPorAtributo(campos) {
    Inputmask().mask(campos);
}

function mascaraTelefoneCelular(seletor) {
    Inputmask(
        { 
            mask: () => ["(99) 9999-9999", "(99) 99999-9999"]
        }
    ).mask(document.querySelectorAll(seletor));
}

function mascaraCpfCnpj(seletor) {
    Inputmask(
        { 
            mask: () => ["999.999.999-99", "99.999.999/9999-99"]
        }
    ).mask(document.querySelectorAll(seletor));
}

export {mascaraPorAtributo, mascaraTelefoneCelular, mascaraCpfCnpj};