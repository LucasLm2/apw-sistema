function inativar(nomeFormInativar) {
    swal({
        title: "Tem certeza que deseja inativar?",
        text: "Uma vez inativado, você terá que solicitar ativação para recuperar!",
        icon: "warning",
        buttons: {
            cancel: "Cancelar",
            confirm: "Inativar"
        },
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            document.getElementById(nomeFormInativar).submit();
        }
    });
}

export default inativar;