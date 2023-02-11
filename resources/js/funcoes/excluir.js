function excluir(nomeFormExcluir) {
    swal({
        title: "Tem certeza que deseja excluir?",
        text: "Uma vez excluído, você não será capaz de recuperar!",
        icon: "warning",
        buttons: {
            cancel: "Cancelar",
            confirm: "Excluir"
        },
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            document.getElementById(nomeFormExcluir).submit();
        }
    });
}

export default excluir;