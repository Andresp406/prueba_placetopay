# PRUEBA PLACETOPAY

## INSTALACIONES NECESARIAS

Para el correcto funcionamiento de esta aplicacion se debe clonar el repositorio, luego instalar composer, node.js 
```bash
git clone https://github.com/andresp406/prueba_placetopay.git
```
```bash
composer install
```
```bash
npm install && npm run dev
```

una vez se tenga preparado el sistema con sus dependencias en una terminal se de copiar el archivo .env.example a .env y colocar en los valores de la variables de entornos dadas por placetopay y generar la key y luego correr las migraciones con sus respectivos seeders

```bash
copy .env.example 
```
```bash
key:generate
```
```bash
php artisan migrate:fresh --seed
```

## DATOS SOBRE LA APLICACION

esta aplicacion es una completa tienda virtual la cual abarca todos los aspectos de un ecommerce real donde se realizan pedidos con carrito de compras y ademas se integra con la pasarela de pagos de placetopay, me base en la arquitectura SOLID delegando responsabilidad a cada una de las dependencias, use policy para que cada cliente vea los productos que tiene su cuenta, ademas cuenta con interactividad reactiva por parte de livewire y alpine.js.

## RUTAS 

* para visualizar las ordenes del usuario orders.index.
* este sistema inicia desde el home y es muy intuitivo al momento de hacer el proceso de compra.

## SERVIDOR DE LA APLICACION

```bash
php artisan serve
```


