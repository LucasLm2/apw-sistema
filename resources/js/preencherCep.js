function pesquisaCep(valor) {
    let cep = limpaValor(valor);
    if(cep == "") {
        limpaFormCep();
        return;
    }

    if (!validaCep(cep)) {
        limpaFormCep();
        alert(`CEP: "${valor}" com formato inválido.`);
        return;
    }

    bloqueaCampos();
    aguardarPesquisa();

    let url = `${document.getElementById('url-cep').value}${cep}`;

    fetch(url)
    .then(async response => {
        const isJson = response.headers.get('content-type')?.includes('application/json');
        const data = isJson && await response.json();

        if (!response.ok) {
            const error = (data && data.message) || response.status;
            return Promise.reject(error);
        }

        await buscarMunicipios(data.uf);
        populandoCampos(data);
    })
    .catch(error => {
        alert(error);
    }).finally(() => liberaCampos());
}

function bloqueaCampos() {
    document.getElementById('cep').disabled = true;
    document.getElementById('estado').disabled = true;
    document.getElementById('municipio').disabled = true;
    document.getElementById('bairro').disabled = true;
    document.getElementById('rua').disabled = true;
    document.getElementById('complemento').disabled = true;
}

function liberaCampos() {
    document.getElementById('cep').disabled = false;
    document.getElementById('estado').disabled = false;
    document.getElementById('municipio').disabled = false;
    document.getElementById('bairro').disabled = false;
    document.getElementById('rua').disabled = false;
    document.getElementById('complemento').disabled = false;
}

function limpaFormCep() {
    document.getElementById('cep').value = "";
    document.getElementById('estado').value = "";
    document.getElementById('municipio').value = "";
    document.getElementById('bairro').value = "";
    document.getElementById('rua').value = "";
    document.getElementById('complemento').value = "";
}

function limpaValor(valor) {
    return valor.replace(/\D/g, '');
}

function validaCep(cep) {
    let validacep = /^[0-9]{8}$/;
    return validacep.test(cep);
}

function aguardarPesquisa() {
    document.getElementById('estado').value = "";
    document.getElementById('municipio').value = "";
    document.getElementById('bairro').value= "Aguarde...";
    document.getElementById('rua').value= "Aguarde...";
    document.getElementById('complemento').value = "Aguarde...";
}

function populandoCampos(data) {
    document.getElementById('estado').value = data.uf;
    document.getElementById('municipio').value = data.ibge;
    document.getElementById('bairro').value = data.bairro;
    document.getElementById('rua').value = data.logradouro;
    document.getElementById('complemento').value = data.complemento;
}

async function buscarMunicipios(uf) {
    if(uf == "") {
        return;
    }

    let municipioSelect = document.getElementById('municipio');
    municipioSelect.length = 1;
    municipioSelect.disabled = true;

    const url = `${document.getElementById('url-base').value}/api/v1/municipios/${uf}`;

    await fetch(url)
    .then(async response => {
        const isJson = response.headers.get('content-type')?.includes('application/json');
        const data = isJson && await response.json();

        if (!response.ok) {
            const error = (data && data.message) || response.status;
            return Promise.reject(error);
        }

        for (let i = 0; i < data.length; i++) {
            const option = document.createElement("option");
            option.text = data[i].nome;
            option.value = data[i].cod_ibge;
            municipioSelect.add(option);                  
        }
    })
    .catch(error => {
        alert(error);
    });

    municipioSelect.disabled = false;
}

export { pesquisaCep, buscarMunicipios };