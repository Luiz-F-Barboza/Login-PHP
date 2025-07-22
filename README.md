
---

## Como Rodar o Projeto

1. Instale o [XAMPP](https://www.apachefriends.org/pt_br/index.html) e certifique-se que Apache e MySQL estão ativos.
2. Crie o banco e a tabela conforme instruções acima.
3. Copie a estrutura do projeto para a pasta `htdocs` do XAMPP (ex: `C:\xampp\htdocs\loginphp`).
4. Acesse o sistema pelo navegador:
   - Cadastro: `http://localhost/loginphp/cadastro.php`
   - Login: `http://localhost/loginphp/login.php`
5. Use o sistema para criar usuários, realizar login e acessar o painel protegido.

---

## Validações

- Validação simples de campos com JavaScript para garantir que nome, email e senha estejam preenchidos corretamente antes de enviar ao servidor.
- Validação back-end para evitar duplicidade de emails e garantir segurança na inserção.

---

## Segurança

- Senhas nunca são armazenadas em texto claro, sempre usando `password_hash`.
- Consulta ao banco feita com prepared statements para evitar SQL Injection.
- Sessões PHP protegem páginas sensíveis.

---

## Possíveis Melhorias Futuras

- Implementar recuperação de senha por email.
- Adicionar níveis de acesso (admin, usuário, etc).
- Implementar confirmação por email no cadastro.
- Melhorar validação front-end e UI com frameworks como Bootstrap.
- Usar PDO em vez de MySQLi para maior flexibilidade.

---

## Contato

Qualquer dúvida ou sugestão, entre em contato.

---

## Licença

Projeto open source para aprendizado e uso livre.

