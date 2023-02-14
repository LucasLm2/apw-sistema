function ativar(nomeFormAtivar) {
    swal({
        title: "Tem certeza que deseja ativar?",
        icon: "warning",
        buttons: {
            cancel: "Cancelar",
            confirm: "Ativar"
        },
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            document.getElementById(nomeFormAtivar).submit();
        }
    });
}

export default ativar;