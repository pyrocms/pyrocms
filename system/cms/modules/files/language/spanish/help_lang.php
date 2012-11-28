<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = "
<h6>Información general</h6><hr>
<p>El módulo de archivos es una excelente manera para que el administrador del sitio pueda gestionar los archivos en uso del sitio.
Todas las imágenes o archivos que se insertan en las páginas, galerías o entradas de blog se guardan aquí.
Para las imágenes de contenido de página usted puede subirlas directamente desde el editor WYSIWYG o puede subirlas aquí y luego insertarlas a través del WYSIWYG.</p>
<p>La interfaz de archivos funciona como un sistema de archivos local: utiliza el botón derecho del ratón para mostrar un menú contextual. A todo en el panel central se le puede hacer clic.</p>

<h6>Administración de carpetas</h6>
<p>Después de crear la carpeta de nivel superior o las carpetas, usted puede crear las subcarpetas que sean necesarias tal como blog/images/screenshots/ o pages/audio/.
Los nombres de las carpetas son sólo para su uso, el nombre no aparece en el enlace de descarga o en el frontend del sitio.
Para gestionar una carpeta o bien haga clic derecho sobre ella y seleccione una acción en el menú resultante, o haga doble clic en la carpeta para abrirla.
También puede hacer clic en las carpetas de la columna de la izquierda para abrirlas.</p>
<p>Si los proveedores de almacenamiento en las nubes están habilitados usted podrá establecer la ubicación de la carpeta haciendo clic derecho sobre la misma y seleccionando la opción de Detalles.
Luego usted podrá seleccionar una ubicación (por ejemplo \"Amazon S3\") y colocar el nombre de su contenedor remoto.
Si el contenedor remoto no existe este será creado cuando haga clic en Guardar. Tenga en cuenta que solo se puede cambiar la ubicación de una carpeta vacía.</p>

<h6>Administración de archivos</h6>
<p>Para administrar los archivos navegue hacia la carpeta mediante el árbol de carpetas en la columna de la izquierda o haciendo clic en la carpeta en el panel central.
Una vez que usted esté viendo los archivos puede editarlos haciendo clic derecho sobre ellos. También se pueden ordenar arrastrándolos en su posición.
Tenga en cuenta que si usted tiene las carpetas y archivos en la misma carpeta padre, las carpetas se mostrarán siempre en primer lugar seguido por los archivos.</p>

<h6>Subiendo archivos</h6>
<p>Después de hacer clic derecho en la carpeta deseada, una ventana de carga aparecerá.
Puede añadir archivos tanto como arrastrándolos en el cuadro de Cargar archivos o haciendo clic en el cuadro y la seleccionando los archivos desde e cuadro de diálogo estándar.
Usted puede seleccionar varios archivos presionando las tecla Control/Command o Shift mientras hace clic en estos. Los archivos seleccionados se mostrarán en una lista en la parte inferior de la pantalla.
A continuación, usted puede o bien eliminar los archivos innecesarios de la lista o hacer clic en Subir  para iniciar el proceso de subida de archivos..</p>
<p>Si usted recibe una advertencia sobre el tamaño de los archivos es demasiado grande tenga en cuenta que algunos hosting no permiten la subida de archivos de más de 2 MB.
Muchas cámaras de fotos modernas producen imágenes de más de 5 MB por lo que es muy común encontrarse con este problema.
Para solucionar esta limitación, usted puede pedir a su hosting cambiar el límite de subida de archivos o puede que desee cambiar el tamaño de sus imágenes antes de subirlas.
Cambiar el tamaño tiene la ventaja añadida de tiempos más rápidos de subida. También puede cambiar el límite de subida en
CP > Archivos > Configuraciones , pero este sería una solución secundaria respecto a la que le ofrece su hosting. Por ejemplo, si su hosting permite una subida de 50 MB, usted todavía puede limitar el tamaño de la subida mediante el establecimiento de un máximo de
 \"20\" (por ejemplo) en la CP > Archivos > Configuraciones.</p>

<h6>Sincronizando Archivos</h6>
<p>Si va a guardar los archivos con un proveedor de almacenamiento en las nubes es posible que desee utilizar la función Sincronizar. Esto le permite \"actualizar\"
su base de datos de archivos para mantenerla al día con su almacenamiento remoto. Por ejemplo, si usted tiene otro servicio que sube sus archivos en una carpeta en Amazon,
los cuales usted desea mostrar en su entrada en el blog semanal, simplemente puede ir a la carpeta que está vinculada a ese contenedor y hacer clic en Sincronizar.
Esto descargará toda la información disponible en Amazon y lo almacenará en la base de datos como si el archivo fuese subido a través de la interfaz de archivos. Los archivos ahora están disponibles para ser insertado en la página de contenido, a su entrada en el blog, etc.
Si los archivos han sido borrados del almacenamiento remoto desde la última sincronización estos ahora se eliminarán de la base de datos también.</p>

<h6>Búsqueda</h6>
<p>Usted puede buscar todos los archivos y carpetas, escriba un término de búsqueda en la columna de la derecha y luego presione Enter. Los 5 primeros resultados de las carpetas y los primeros 5 resultados de archivos serán devueltos.
Al hacer clic en un elemento se mostrará la carpeta que lo contiene y los elementos que coinciden con su búsqueda serán resaltados.
Los elementos se buscan usando el nombre de la carpeta, el nombre del archivo, extensión, ubicación y el nombre del contenedor remoto.</p>";