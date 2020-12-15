## About Mercatodo

<p>Mercatodo es una aplicaci&oacute;n de comercio electr&oacute;nico que permite la creaci&oacute;n, gesti&oacute;n y venta de libros por medio de pago en l&iacute;nea a trav&eacute;s de la pasarela de pagos PlacetoPay de EVERTEC. Adicionalmente Mercatodo permite gestionar productos por medio de una API REST.</p>

## Instalación

Crear una base de datos local llamada <strong>mercatodo</strong>

Descargar composer https://getcomposer.org/download/

Hacer pull del proyecto en https://github.com/dsanchezvalle/mercatodo

Reemplazar el archivo .env con el archivo .env.example dentro del directorio raíz de tu proyecto y
llenar los campos relacionados con la base de datos creada.

Abre la terminal y accede al directorio raíz de tu proyecto.

Ejecuta el comando 'composer install' o 'php composer.phar install'.

Ejecuta 'php artisan key:generate'

Ejecuta php artisan migrate

Ejecuta 'php artisan db:seed' para que los seeders puedan poblar la base de datos.

Ejecuta php artisan serve

#####Ahora podrás acceder al proyecto en tu navegador accediendo a la dirección que te proporciona el anterior comando.


<p></p>
<div align="center"><b>Principales funcionalidades de la aplicaci&oacute;n y permisos ACL</b></div>
<p></p>
<p>La aplicaci&oacute;n cuenta con un usuario administrador con todos los permisos necesarios para operarla y gestionarla. Adicionalmente puede conceder o denegar permisos a los otros usuarios de la aplicaci&oacute;n.</p>
<p><strong>Datos de acceso:</strong></p>
<table border="1" style="height: 59px; width: 54.1342%; border-collapse: collapse; margin-left: auto; margin-right: auto;" height="59">
<tbody>
<tr>
<td style="width: 50%; text-align: center;"><strong>e-mail</strong></td>
<td style="width: 50%; text-align: center;">admin@mercatodo.com</td>
</tr>
<tr>
<td style="width: 50%; text-align: center;"><strong>password</strong></td>
<td style="width: 50%; text-align: center;">admin123</td>
</tr>
</tbody>
</table>
<p></p>
<p>Los dem&aacute;s usuarios deben registrarse en el enlace "Register" disponible en la pantalla de bienvenida. Una vez registrados recibir&aacute;n un correo en el que deber&aacute;n dirigirse al enlace de verificaci&oacute;n suministrado. Luego de este procedimiento contar&aacute;n con acceso a la aplicaci&oacute;n con su e-mail y password.</p>
<p><strong>Roles y permisos:&nbsp;</strong></p>
<p><strong></strong></p>
<table border="1" style="border-collapse: collapse;">
<tbody>
<tr style="height: 21px;">
<td style="width: 16.6%; text-align: center; height: 21px;"><strong>Roles</strong></td>
<td style="width: 19.6%; height: 21px; text-align: center;"><strong>Libros</strong></td>
<td style="width: 15.8%; height: 21px; text-align: center;"><strong>&Oacute;rdenes</strong></td>
<td style="width: 18%; height: 21px; text-align: center;"><strong>Clientes</strong></td>
<td style="width: 20%; height: 21px; text-align: center;"><strong>Reportes</strong></td>
</tr>
<tr style="height: 21px;">
<td style="width: 16.6%; height: 21px;"><strong>Administrador (Admin)</strong></td>
<td style="width: 19.6%; height: 21px; text-align: center;">
<p>Crear, visualizar, editar, actualizar, importar, exportar, desactivar, ver vitrina de libros.</p>
</td>
<td style="width: 15.8%; height: 21px; text-align: center;">Crear, visualizar, editar, pagar.</td>
<td style="width: 18%; height: 21px; text-align: center;">Crear, visualizar, editar, actualizar, desactivar.&nbsp;</td>
<td style="width: 20%; height: 21px; text-align: center;">Crear, visualizar, descargar.</td>
</tr>
<tr style="height: 21px;">
<td style="width: 16.6%; height: 21px;"><strong>Editor (Editor)</strong></td>
<td style="width: 19.6%; height: 21px; text-align: center;">Crear, visualizar, editar, actualizar, importar, exportar, desactivar, ver vitrina de libros.</td>
<td style="width: 15.8%; height: 21px; text-align: center;">Crear, visualizar, editar, pagar</td>
<td style="width: 18%; height: 21px; text-align: center;">&nbsp;No</td>
<td style="width: 20%; height: 21px; text-align: center;">Crear, visualizar, descargar.</td>
</tr>
<tr style="height: 21px;">
<td style="width: 16.6%; height: 21px;"><strong>Comprador (Buyer)</strong></td>
<td style="width: 19.6%; height: 21px; text-align: center;">Ver vitrina de libros (Bookshelf).</td>
<td style="width: 15.8%; height: 21px; text-align: center;">Agregar libros al carrito de compras, editar carrito de compras, pagar.</td>
<td style="width: 18%; height: 21px; text-align: center;">No</td>
<td style="width: 20%; height: 21px; text-align: center;">No</td>
</tr>
</tbody>
</table>
