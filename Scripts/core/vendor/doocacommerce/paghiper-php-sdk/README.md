# PagHiper PHP SDK - Desenvolvido por DoocaCommerce

## Documentação do PagHiper: https://dev.paghiper.com

## Recursos:
* Criar transações
* Consultar transações
* Cancelar transações
* Consultar notificações

## Instalação

- Para instalar é necessário que utilize `composer`, mais informações podem ser consultadas em: https://getcomposer.org/
- Em seu projeto execute o seguinte comando, `composer require doocacommerce/paghiper-php-sdk`

## Utilização
1) Incluir autoload do composer

    ```php
    require __DIR__  . '/vendor/autoload.php';
    ```
    
2) Settar suas credenciais

    ```php
    \PagHipperSDK\Auth::init(
        '{api_key}',
        '{token}'
    );
    ```
    
3) Realizar uma requisição (exemplo de criar transição)

    ```php
    $pagHiper = new \PagHipperSDK\PagHiper();
    $items = [];
    $items[] = (new \PagHipperSDK\Entities\Item())
        ->setItemId('1')
        ->setDescription('Descrição do produto')
        ->setQuantity(1)
        ->setPriceCents(30.00);
    
    $payer = (new \PagHipperSDK\Entities\Payer())
        ->setPayerEmail('webmaster@dooca.com.br')
        ->setPayerName('Webmaster Dooca')
        ->setPayerCpfCnpj('11144477735')
        ->setPayerPhone('5139393660')
        ->setPayerStreet('Rua Sapiranga')
        ->setPayerNumber(90)
        ->setPayerComplement('Sala 204')
        ->setPayerDistrict('Mauá')
        ->setPayerCity('Novo Hamburgo')
        ->setPayerState('RS')
        ->setPayerZipCode(93548192);
    
    $transaction = (new \PagHipperSDK\Entities\Transaction())
        ->setOrderId('TESTE-' . rand(0, 10000))
        ->setNotificationUrl('https://url-de-notificaca.example')
        ->setDiscountCents(10.00)
        ->setShippingPriceCents(19.90)
        ->setShippingMethods('PAC')
        ->setFixedDescription(true)
        ->setDaysDueDate('3')
        ->setPayer($payer)
        ->setItems($items);
    
    try {
        $transaction = $pagHiper->createTransaction($transaction);
    } catch (\PagHipperSDK\Exception\ErrorException $e) {
        // Exception normalmente gerada pelo retorno do PagHiper
        echo $e->getMessage();
        die;
    } catch (Exception $e) {
        // Outras Exceptions, Auth e Invalid Arguments
        echo $e->getMessage();
        die;
    }
    ```

4) Pode encontrar outros exemplos na pasta `examples`

## Contribuição
Sinta-se livre, para realizar pull requests, abrir issues etc, desde que, mantenha a retrocompatibilidade do código e siga o coding standard `PSR-2` (https://www.php-fig.org/psr/psr-2/)

## Contato
E-mail: <arthurnascimentolauck@gmail.com>