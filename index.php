<!DOCTYPE html>
<html>

<head>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script>
        /* Función asíncrona mediante AJAX que recoge las sugerencias obtenidas desde el servidor
        para la letra o conjunto de letras que se han introducido en el buscador. */
        function mostrar_sugerencias(str) {
            // Se comprueba que la cadena a buscar está vacía y de ser así no se muestran sugerencias.
            if (str.length == 0) {
                document.getElementById("sugerencias").innerHTML = "";
                return;
            } else {
                var asyncRequest = new XMLHttpRequest();
                asyncRequest.onreadystatechange = stateChange;
                asyncRequest.open("GET", "sugerencias.php?q=" + str, true);
                asyncRequest.send(null);

                function stateChange() {
                    if (asyncRequest.readyState == 4 && asyncRequest.status == 200) {
                        document.getElementById("sugerencias").innerHTML =
                            asyncRequest.responseText;
                    }
                }
            }
        }
    </script>
    <style>
        .container {
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 20px;
        }

        input[type=text] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            resize: vertical;
        }

        label {
            padding: 12px 12px 12px 0;
            display: inline-block;
        }

        input[type=submit] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
		
		input[type=button] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
			margin-top: 20px;
        }
		
		#parques {
  			font-family: Arial, Helvetica, sans-serif;
 			border-collapse: collapse;
  			width: 100%;
		}

		#parques td, #parques th {
  			border: 1px solid #ddd;
  			padding: 8px;
		}

		#parques tr:nth-child(even){background-color: #f2f2f2;}

		#parques tr:hover {background-color: #ddd;}

		#parques th {
	  		padding-top: 12px;
  			padding-bottom: 12px;
  			text-align: left;
  			background-color: #4CAF50;
  			color: white;
		}
    </style>
</head>

<body>
    <div class="container">
        <form>
            <div class="row">
                <div class="col-25">
                    <h2><b>Búsqueda de libros</b></h2>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label><b>Título del libro</b></label>
                </div>
                <div class="col-75">
                    <input type="text" onkeyup="mostrar_sugerencias(this.value)">
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <br><label><strong>Sugerencias:</strong></label>
                </div>
                <div class="col-75">
                    <span id="sugerencias" style="color: #0080FF;"></span>
                </div>
            </div>
        </form>
    </div>
    <br>
	<div class="container">
        <form>
            <div class="row">
                <div class="col-25">
                    <h2><b>Listado de parques de bomberos de Madrid</b></h2>
                </div>
            </div>
            <div class="row">
    		<div id="datosParque" style="display:none">
        <?php
            $url = "https://datos.madrid.es/egob/catalogo/211642-0-bomberos-parques.json";
            $resultado = json_decode(file_get_contents($url),true);
            $datos = $resultado["@graph"];
			echo "<table id='parques'>
 				<tr>
    				<th>Referencia</th>
    				<th>Nombre</th>
   					<th>Localidad</th>
					<th>Código postal</th>
					<th>Dirección</th>
 				</tr>";
			foreach($datos as $dato){
				echo "<tr>";
				echo "<td>".$dato["id"]."</td>";
				echo "<td>".$dato["title"]."</td>";
				echo "<td>".$dato["address"]["locality"]."</td>";
				echo "<td>".$dato["address"]["postal-code"]."</td>";
				echo "<td>".$dato["address"]["street-address"]."</td>";
				echo "</tr>";
			};
			echo "</table>";
           ?>
    </div>
		<input type="button" id="mostrar" value="Pulse para mostrar">
		<input type="button" id="ocultar" value="Pulse para ocultar" style="display:none; background-color:#FB8080;">
			</div>
		</form>
		<script>
		$(document).ready(function(){
			$("#mostrar").on( "click", function() {
				$('#datosParque').show();
				$('#ocultar').show();
		 	});
			$("#ocultar").on( "click", function() {
				$('#datosParque').hide();
				$('#ocultar').hide();
			});
		});
	</script>
	</div>
	
</body>

</html>