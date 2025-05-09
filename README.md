# MultiZApis

## English
MultiZApis is a powerful and intuitive tool designed to streamline your client and instance management tasks. With its user-friendly interface and robust features.

## Português
MultiZApis é uma ferramenta poderosa e intuitiva projetada para simplificar suas tarefas de gerenciamento de clientes e instâncias. Com sua interface amigável e recursos robustos.

## How to Run MultiZApis

### English

1. **Clone the repository:**
    ```bash
    git clone https://github.com/PanelZap/panelzap
    cd panelzap
    ```

2. **Install dependencies:**
    ```bash
    composer install
    npm install
    ```

3. **Run the installation command:**
    ```bash
    php artisan install
    ```

4. **Create a user:**
    ```bash
    php artisan makeUser
    ```

### Português

1. **Clone o repositório:**
    ```bash
    git clone https://github.com/PanelZap/panelzap
    cd panelzap
    ```

2. **Instale as dependências:**
    ```bash
    composer install
    npm install
    ```

3. **Execute o comando de instalação:**
    ```bash
    php artisan install
    ```

4. **Crie um usuário:**
    ```bash
    php artisan makeUser
    ```

## Deployment Guide

### Stack for Portainer

#### English

To deploy MultiZApis using Portainer, follow these steps:

1. **Create a new stack:**
    - Open Portainer and navigate to the "Stacks" section.
    - Click on "Add stack".

2. **Configure the stack:**
    - Name your stack `panelzap`.
    - In the "Web editor" section, paste the following Docker Compose configuration:
    - you can download the stack file directly from [docker-compose-stack.yml](https://github.com/PanelZap/panelzap/blob/main/docker-compose-stack.yml).

3. **Deploy the stack:**
    - Click on "Deploy the stack".

#### Português

Para implantar o MultiZApis usando o Portainer, siga estes passos:

1. **Crie uma nova stack:**
    - Abra o Portainer e navegue até a seção "Stacks".
    - Clique em "Add stack".

2. **Configure a stack:**
    - Nomeie sua stack como `panelzap`.
    - Na seção "Web editor", cole a seguinte configuração do Docker Compose:
    Você pode baixar o arquivo da stack diretamente de [docker-compose-stack.yml](https://github.com/PanelZap/panelzap/blob/main/docker-compose-stack.yml).

3. **Implante a stack:**
    - Clique em "Deploy the stack".

### English

Follow these steps to deploy MultiZApis in a production environment. For a detailed walkthrough, watch our [deployment video](https://www.youtube.com/watch?v=frFe-enogq0&t=1s).

### Português

Siga estes passos para implantar o MultiZApis em um ambiente de produção. Para um tutorial detalhado, assista ao nosso [vídeo de implantação](https://www.youtube.com/watch?v=frFe-enogq0&t=1s).
