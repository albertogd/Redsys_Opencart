# Redsys Payment module for OpenCart #

Esta es una extensión gratuita para Opencart.

Si tienes algún problema o sugerencia, puedes comentar en el foro de opencart o escribir un comentario en la [página de la extensión](http://www.opencart.com/index.php?route=extension/extension/info&extension_id=14416).

Gracias por utilizar esta extensión.

## Descripción ##

Pasarela de pago Redsys para Opencart 1.5.X. Válido para todos los bancos de España: La Caixa, BBVA, Bankia, Santander, Popular, Sabadell, Bankinter...

## Requirements ##

- **[Vqmod](https://code.google.com/p/vqmod/)**

## License ##

Este código ha sido publicado bajo licencia [GNU GPL v3](https://www.gnu.org/copyleft/gpl.html).

**Author**: [Alberto González de Dios](http://alberto.gonzalezdedios.es)

**Email**: <alberto@gonzalezdedios.es>

## Versiones ##

**Versión 1.5**

- Corregido un error que se producía en la cantidad cuando el número de decimales de la moneda no estaba configurado a 2.

**Versión 1.4**

- Añadido el idioma catalán (solo para el catálogo y la pasarela de pago)

**Versión 1.3**

- Añadida la opción de firma SHA-1 completa
- Añadida una opción para elegir entre la firma SHA-1 completa y la firma SHA-1 completa extendida
- Añadido un Manual de Usuario


**Versión 1.2**

- Solucionado un problema con el archivo xml de vqmod en versiones de Opencart inferiores a 1.5.6

**Versión 1.1**

- Solucionado un problema en la URL de entorno de produccion

**Versión 1.0**

- Multi-idioma: Inglés, Español, Francés y Alemán (la interfaz de administrador sólo en inglés y español)
- Moneda de pago en euros
- Multidivisa: si la tarjeta de credito está asociada a una cuenta con otra moneda, da la opción de pagar en euros o en esa moneda (se hace a nivel de Redsys, no del TPV)


## TODO ##

You can contribute with TODO section in [github](https://github.com/albertogd/Redsys_Opencart) adding:

- **Recurrent Payments**
- **Returns**
- **Payment in other currencies**