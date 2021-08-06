// main.js

// gerador de senha aleatório
function gerarSenha(numChars){
    let codigo = '';
    let txt_senha = document.getElementById('txt_senha');
    let caracteres = 'abcdefghijklmnopqrstwxyz0123456789ABCDEFGHIJKLMNOPQRSTWXYZ!?#$%&*()';
    for(let i=0; i<numChars; i++){
        let r = Math.floor(Math.random() * caracteres.length) + 1;
        codigo += caracteres.substr(r, 1);
    }

    txt_senha.value = codigo;
}

// ********* marca / desmarca checkbox

function checar(status){
    $("input:checkbox").prop("checked", status);
}