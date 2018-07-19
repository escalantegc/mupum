<?php
class ei_cuadro_solicitudes extends mupum_ei_cuadro
{
	function html_cuadro_cabecera_columnas()
	{
		echo "<tr>\n";
		echo "<td class='ei-cuadro-col-tit' colspan='2'>\n";
		echo "Seleccionar <a href=\"javascript:{$this->get_objeto_js()}.seleccionar_todo(true)\">todas</a> /
				<a href=\"javascript:{$this->get_objeto_js()}.seleccionar_todo(false)\">ninguna</a>
			";
		echo "</td>\n";
		echo "</tr>\n";
		parent::html_cuadro_cabecera_columnas();
	}
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		{$this->objeto_js}.seleccionar_todo = function(seleccionar)
		{
			var check;
			
			for (i in this._filas) {
				check = $$(this._input_submit + i + '_seleccion');
				if (!check.checked && seleccionar) {
					this.seleccionar(i, 'seleccion');
				}
				if (check.checked && !seleccionar) {
					this.seleccionar(i, 'seleccion');
				}
			}
		}
		";
	}
}

?>