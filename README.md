# Passo a passo para utilizar este sistema WEB no seu computador:

1- Copie o link HTTPS do repositório GitHub do projeto;

2- Crie uma pasta (opcional), e abra o terminal;

3- Digite "git clone" e cole o link copiado no passo 1;

4- Após isso, será criada a pasta do projeto, para acessá-la digite o seguinte comando: "cd + nome da pasta criada";

5- Com isso você estará dentro da pasta do projeto, para prosseguir, digite o comando "composer update" no terminal, esse comando serve para instalar as dependências necessárias para executar o projeto;

6- Após a conclusão do composer update, digite "code ." para abrir o Visual Studio Code direto na pasta do projeto;

7- clique encima do arquivo .env.example e o renomeie para apenas ".env";

8- Entre na .env e apague os "#" dessas seguintes linhas:

DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

10- Em "DB_DATABASE", em frente ao sinal de igual coloque o nome que você deseja dar para a sua database;

11- Em "DB_USERNAME", coloque o seu nome de usuário e em "DB_PASSWORD" a senha, ambos os dados devem ser colocados em frente ao sinal de igual;

12- Agora modifique o arquivo colocando "file" no lugar de "database" nas linhas:

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database

Execute CTRL + S para salvar as modificações;

13 - Voltando para o terminal de controle execute o seguinte comando "php artisan key:generate" para gerar automáticamente uma nova APP KEY, ela é utilizada pelo Laravel em operações de criptografia, como proteger dados criptografados e informações de sessão;

14- Após isso, escreva "php artisan migrate" no terminal e execute, esse comando cria as tabelas necessárias para o funcionamento do sistema dentro do banco de dados configurado anteriormente;

15- Para finalizar, digite "php artisan serve" também no terminal, esse comando irá gerar um servidor local para a aplicação laravel, para abri-lo, segure CRTL e clique no link; 
