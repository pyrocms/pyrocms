<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = "
<h4>Información general</h4>
<p>El módulo de páginas es una manera simple pero potente para manejar el contenido estático en su sitio.
Desde aquí los diseños de página pueden ser manejados y los widgets incorporados sin tener que editar los archivos de las plantillas.</p>

<h4>Administración de Páginas</h4><hr>
<h6>Contenido de Página</h6>
<p>Al elegir el título de la página recuerda que el diseño de la página por defecto mostrará el título de la página encima del contenido de la página.
Ahora cree el contenido de su página utilizando el editor WYSIWYG.
Cuando esté listo para que la página pueda ser vista por los visitantes, establezca el estado a Publicada y esta será accesible en la URL que se muestra.
También debe ir a Diseño -> Navegación y crear un vínculo de navegación nuevo, si usted quiere que su página se muestre en el menú o puede seleccionar un área de navegación en el menú desplegable si desea que este se cree automáticamente.</p>

<h6>Datos Meta</h6>
<p>El Meta título se utiliza generalmente como el título en los resultados de búsqueda y se cree que tienen un peso significativo en el posicionamiento de la página en los motores de búsqueda.<br />
Los Meta keywords son palabras que describen el contenido de su sitio y son solamente para el beneficio de los motores de búsqueda.<br />
La meta descripción es una breve descripción de esta página y puede ser utilizado como el fragmento de búsqueda si el motor de búsqueda considera relevante para la misma.</p>

<h6>Diseño</h6>
<p>La pestaña de diseño le permite seleccionar un diseño de página personalizado y opcionalmente aplicar un estilo css diferente solo para esta página.
Consulte la sección de diseños de página a continuación para obtener instrucciones sobre la mejor forma de usar los diseños de página.</p>

<h6>Script</h6>
<p>Usted puede colocar el javascript aquí que le gustaría anexar al &lt;head&gt; de la página.</p>

<h6>Opciones</h6>
<p>Le permite activar los comentarios y una fuente RSS para esta página. También puede restringir una página a un grupo de usuarios específico mediante la especificación del campo de Acceso.
Si la fuente RSS se habilita un visitante puede suscribirse a esta página y este recibirá cada página descendiente en su lector de RSS.</p>
<p>El campo de \"¿Requiere que las uri coincidan exactamente?\" es una herramienta tan inteligente que le permite pasar parámetros en la URL. Por defecto PyroCMS busca una página con
el slug de \"acme-widgets\" el cual es el descendiente \"products\" cuando usted visita ".site_url('products/acme-widgets').". Al marcar esta casilla en la página de Products, le está diciendo PyroCMS que está bien si no hay una página llamada Acme Widgets.
Ahora se cargará Products y 'acme-widgets' sólo será un parámetro.
Esto hace que sea fácil de pasar parámetros a las etiquetas incrustadas. Un ejemplo usando el agregado de Streams para mostrar el stream 'acme-widgets' en la página de Products:
<pre><code>{{ streams:cycle stream={url:segments segment=&quot;2&quot;} }}
    {{ entries }}
        {{ company_intro }}
        {{ owner_name }}
        {{ owner_phone }}
    {{ /entries }}
{{ /streams:cycle }}</code></pre></p>

<h4>Diseños de Página</h4><hr>
<p>Los diseños de página le permite controlar el diseño de la página sin modificar los archivos del tema. También puede seleccionar los archivos del tema de diseño al crear diseños de página.
Puede incrustar etiquetas en el diseño de la página en lugar de colocar en cada página.
Por ejemplo: Si usted tiene un widget de Twitter que desea mostrar en la parte inferior de cada página usted puede colocar la etiqueta de widget en el diseño de página:</p><br />
<pre><code>
{{ page:title }}
{{ page:body }}

&lt;div class=&quot;my-twitter-widget&quot;&gt;
	{{ widgets:instance id=&quot;1&quot; }}
&lt;/div&gt;
</code></pre>
<p>Ahora usted puede aplicar un estilo CSS a la clase \"my-twitter-widget\" en la pestaña de CSS.</p>";