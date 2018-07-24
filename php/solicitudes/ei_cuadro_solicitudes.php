<?php
class ei_cuadro_solicitudes extends mupum_ei_cuadro
{
	function html_cuadro_cabecera_columnas()
	{
		echo "<tr>\n";
		echo "<td class='ei-cuadro-col-tit' colspan='4'>\n";
		echo "Seleccionar <a href=\"javascript:{$this->get_objeto_js()}.seleccion_total()\">todas</a> /
				<a href=\"javascript:{$this->get_objeto_js()}.deseleccion_total()\">ninguna</a>
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
		{$this->objeto_js}.evt__seleccion_total = function ()
          {
              var check;
              for (i in this._filas) {
                  check = $(this._input_submit + i + '_' + 'seleccion');
                  if (!check.checked) {
                      this.seleccionar(i, 'seleccion');
                  }
              }
              return true;
          }
   
          {$this->objeto_js}.evt__deseleccion_total = function ()
          {
              var check;
              for (i in this._filas) {
                  check = $(this._input_submit + i + '_' + 'seleccion');
                  if (check.checked) {
                      this.seleccionar(i, 'seleccion');
                  }
              }
              return true;
          }  
		";
	}
}

?>