# SGE - Sistema de Gerenciamento de Estágio
O SGE é um Trabalho de Conclusão de Curso apresentado ao CTI - Colégio Técnico Industrial "Prof. Isaac Portal Roldán" - Unesp - Universidade Estadual Paulista "Júlio de Mesquita Filho" - Campus de Bauru.
Desenvolvido pela equipe Blitz, o projeto tem como finalidade gerenciar os estágios do CTI.

<p align="center">
<a href="https://travis-ci.org/blitzcti/sgecti"><img src="https://travis-ci.org/blitzcti/sgecti.svg?branch=master" alt="Build Status"></a>
<a href="https://github.com/laravel/laravel"><img src="https://img.shields.io/badge/Laravel-6.0.3-red.svg" alt="Laravel Version"></a>
<a href="https://github.com/ColorlibHQ/AdminLTE"><img src="https://img.shields.io/badge/AdminLTE-2.4.18-blue.svg" alt="AdminLTE Version"></a>
</p>

## Instalação e configuração inicial
O SGE é feito em cima do framework Laravel, o qual utiliza do PHP 7 para ser executado.
Assim, é recomendado que se instale um servidor HTTP com o PHP e um gerenciador de banco de dados.

### Instalando o SGE
Para sistemas Windows e Mac OS, nossa recomendação é utilizar o XAMPP, que já inclui o Apache2, PHP e MySQL.
Você pode baixar e instalar o XAMPP em https://www.apachefriends.org/pt_br/download.html.

Caso esteja em um ambiente Linux, siga as instruções abaixo para instalar o Apache, PHP e PostgreSQL:

1. Baixe o Apache, PHP e PostgreSQL do gerenciador de pacotes da sua distribuição.
Para o Ubuntu, rode o seguinte comando:

    ```console
    sudo apt install apache2 php php-json php-mbstring php-pgsql php-xml php-gd postgresql postgresql-contrib
    ```

2. Habilite e inicie os serviços do Apache e do PostgreSQL. Para o Ubuntu, execute os comandos a seguir:
    ```console
    sudo systemctl enable apache2
    sudo service apache2 start
    sudo systemctl enable postgresql
    sudo service postgresql start
    ```
   
3. Adicione seu usuário ao grupo www-data:
    ```console
   sudo usermod -aG www-data ${USER}
   ```

### Configurando o SGE
Feito a instalação do servidor HTTP, PHP e do gerenciador de banco de dados, agora será necessário realizar as devidas configurações.

#### Apache
1. Em `apache2.conf`, configure o AllowOverride para All no diretório de instalação do SGE:
        
       <Directory {Diretório de instalação do SGE}>
               ...
               AllowOverride All
               ...
       </Directory>

2. Configure o site do Apache para utilizar a pasta public/ como a DocumentRoot:
        
       <VirtualHost *:{Porta, use 80 para HTTP (padrão) e 443 para HTTPS}>
           ...
           DocumentRoot {Instalação do SGE no servidor}/public
           ...
       </VirtualHost>

3. Reinicie o Apache para aplicar as alterações.

#### SGE
Após o servidor estar devidamente configurado, clone esse repositório para {Instalação do SGE no servidor}
(por exemplo, para /var/www/html):
```console
cd {Instalação do SGE no servidor}
git clone https://github.com/blitzcti/sgecti.git
```

#### Composer
O Composer é um gerenciador de pacotes para o PHP. O SGE utiliza o Composer para gerenciar suas dependências de back-end.
Para baixar o Composer, siga as instruções abaixo para o seu sistema operacional:

1. Para sistemas Windows e Mac OS, siga as instruções em https://getcomposer.org/download/ para baixar e instalar o Composer em sua máquina.

2. Em sistemas Linux, baixe o Composer do gerenciador de pacotes da sua distribuição. No Ubuntu, rode o comando:
    
    ```console
    sudo apt install composer
    ```

Com o composer instalado, baixe as dependências PHP do SGE com o comando:

```console
composer install
```


#### Artisan
O Artisan é a interface de linha de comando incluída com o Laravel. Aqui iremos utilizá-lo para configurar as conexões do SGE.
Para isso, siga as intruções abaixo: 

1. Crie um arquivo `.env` utilizando o `.env.example` como molde e modifique-o conforme o seu ambiente.

2. Rode os seguintes comandos para armazenar as configurações em `.env` em cache e gerar as tabelas no banco:
    ```console
    php artisan key:generate
    php artisan config:cache
    php artisan migrate --seed
    ```


### Tarefas agendadas
#### Windows
No Windows, utilize o Agendador de Tarefas para executar o agendador de tarefas do Laravel.
Para isso, crie uma nova tarefa que execute o Laravel Scheduler:

1. Geral

    Selecione a opção `Executar estando o usuário conectado ou não`.

2. Disparadores

    Crie um novo disparador com as seguintes opções:
    1. Em configurações selecione `Diário`, Repetir a cada `365 dias`;
    2. Repetir a tarefa a cada `1 minutos` por um período de `Indefinidamente`
    
3. Ações

    Crie uma nova ação com as seguintes opções:
    1. Em `Programa/script` selecione o executável do PHP;
    2. Em `Adicione argumentos`, digite `artisan schedule:run`;
    3. Em `Iniciar em`, insira o diretório onde o SGE está instalado.

4. Configurações
    
    Selecione `Executar a tarefa o mais cedo possível após uma inicialização agendada ter sido permitida`. 

#### Linux
O SGE no Linux utiliza do Cron para executar tarefas agendadas, como o backup automático.
Para que o agendador de tarefas do Laravel seja executado, primeiro é necessário adicionar uma entrada no CRON do servidor.
Para editar o CronTab, rode o seguinte comando:
    
```console
sudo crontab -u www-data -e
```
    
Em seguida, adicione a seguinte entrada no CronTab para que o SGE possa executar as tarefas agendadas:

    * * * * * cd /{Diretório de instalação do SGE} && php artisan schedule:run >> /dev/null 2>&1


#### Node.js
O Node.js gerencia as dependências do front-end do SGE.
Siga as instruções em https://nodejs.org/en/download/ para baixar o Node.js no seu sistema operacional.

Com o Node instalado, execute o seguinte comando para instalar as dependências do front-end do SGE:

```console
npm ci
```

## Preparando para uso (Linux)
Após instalar o SGE, certifique-se que as permissões estão corretas:
```console
cd {Instalação do SGE no servidor}
sudo chown www-data:www-data ./ -R
sudo find . -type f -exec chmod 664 {} \;
sudo find . -type d -exec chmod 775 {} \;
```

## Usando o SGE
### Usuário administrador
O login padrão do usuário administrador é
```dir-cti@feb.unesp.br```
e a senha é
```123456789```.
Assim que entrar no sistema, altere a senha de administrador imediatamente para manter o sistema seguro.

## FAQ
### 1. O sistema apenas retorna "The stream or file "{laravel.log}" could not be opened: failed to open stream: Permission denied" ao tentar salvar um arquivo.
#### R: O arquivo de log não está acessível para o Apache/Nginx, assim é necessário dar permissões de acesso para o usuário www-data. Pode ser também que as tarefas agendadas estejam sendo executadas como usuário root, ao invés de serem executadas como www-data.

© 2019 Equipe Blitz.

