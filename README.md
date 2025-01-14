# Gerenciamento de Pedidos


## O que é este projeto?
O projeto tem como objetivo gerenciar pedidos de viagem da Onfly.

## Recursos da estrutura
* <pre>PHP <font color="#26A269"> 8.4.2</font></pre>
* <pre>Mysql<font color="#26A269"> 8.3</font></pre>
* <pre>Laravel Framework <font color="#26A269">11.37.0</font></pre>


## O que necessário para seu funcionamento?
* Docker Desktop
* Bash terminal ou similar
* Insomnia ou similar
* Conta de email que permita envio SMTP


## Instruções de configuraçãoo
O projeto conta com um script de configuração automática que pode ser acionado usando os seguinte passos:

```bash
$ git clone https://github.com/brenousm/orders.git
```
```bash
$ cd orders
```
Importante:  Edite as variáveis de ambiente de envio smtp para as notificações por email funcionarem e as configurações de banco de dados (necessário colocar o ip do banco IPV4, 192.168.1.12 por exemplo) no env.example antes de rodar o script de configuração: 
```bash
$ sh configProj.sh 
```
## Para rodar os testes 

#### Usuários
```bash
docker exec -it api-orders ./vendor/bin/phpunit --filter UserTest
```

#### Pedidos
```bash
docker exec -it api-orders ./vendor/bin/phpunit --filter OrderTest
```
