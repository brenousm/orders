# Gerenciamento de Pedidos


## O que é este projeto?
O projeto tem como objetivo gerenciar pedidos de viagem.


## Para rodar este projeto
```bash
$ git clone https://github.com/fabiosperotto/laravel-blog
$ cd orders
$ Edite as variáveis de envio smtp contidas e as configurações de banco de dados (necessário colocar o ip do banco IPV4, 192.168.1.12 por exemplo) no env.example
$ rodar o script :sh configProj.sh e todas as configurações serão feita automaticamente. 
```

## Para rodar os testes
```bash
docker exec -it api-orders ./vendor/bin/phpunit
```

