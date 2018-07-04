<?php
/**
 * Tipo de página pensado para pantallas de login, presenta un logo y un pie de página básico
 * 
 * @package SalidaGrafica
 */
class mupum_tp_logon extends toba_tp_logon
{
	function barra_superior()
	{
		echo "
			<style type='text/css'>
				.cuerpo {
					
				}
			</style>
		";
		echo "<div id='barra-superior' class='barra-superior-login'>\n";		
	}	

	function pre_contenido()
	{
		echo "<div class='login-titulo'>". toba_recurso::imagen_proyecto("logo.gif",true);
		echo "<div>versi&oacuten ".toba::proyecto()->get_version()."</div>";
		echo "</div>";
		echo "\n<div align='center' class='cuerpo'>\n";		
	}

	function post_contenido()
	{
		echo "</div>";		
		echo "<div class='login-pie'>";
		echo "<div font-size = 12>Si usted es un afiliado activo, debe hacer clic en el el bot&oacuten Soy Afiliado </br>para crear su usuario. Una vez creado, los datos de acceso se enviar&aacuten al correo especificado </br>y con ellos podr&aacute ingresar al sistema</a></strong></div>
			";
		echo "</div>";
	}
}
?>
