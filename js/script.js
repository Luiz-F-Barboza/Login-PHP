document.addEventListener("DOMContentLoaded", () => {
    const formCadastro = document.querySelector("#form-cadastro");
    if(formCadastro){
        formCadastro.addEventListener("submit", (e) => {
            let nome = formCadastro.nome.value.trim();
            let email = formCadastro.email.value.trim();
            let senha = formCadastro.senha.value;

            if(nome.length < 3){
                alert("Nome deve ter ao menos 3 caracteres.");
                e.preventDefault();
                return;
            }
            // Validação simples de email
            if(!email.includes("@") || !email.includes(".")){
                alert("Digite um email válido.");
                e.preventDefault();
                return;
            }
            if(senha.length < 6){
                alert("Senha deve ter ao menos 6 caracteres.");
                e.preventDefault();
                return;
            }
        });
    }

    const formLogin = document.querySelector("#form-login");
    if(formLogin){
        formLogin.addEventListener("submit", (e) => {
            let email = formLogin.email.value.trim();
            let senha = formLogin.senha.value;

            if(email === "" || senha === ""){
                alert("Preencha todos os campos do login.");
                e.preventDefault();
            }
        });
    }
});
