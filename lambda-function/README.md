# Descrição

Um script bem simples que chama uma lambda function que recebe dois valores e calcula uma multiplicacao entre eles.

Essa chamada é de forma sincrona. Isso para deixar mais simples o exemplo

Existem outros casos de chamada como enviar uma mensagem em um SQS e configurar um trigger na lambda function a partir dessa SQS.

# Como rodar

1 - Configure o .env com suas informações

2 - Cria a lambda function no AWS

3 - rode dentro de service-php 
```
composer install 
```

4 - execute o script
```
php index.php
```