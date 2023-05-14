<?php
// TP N° 2 - Inteligencia Artificial - Siglo 21 - 2023
// Eduardo Van Cauteren
//***************************************************************************************************

// PRUEBA DE ESCRITORIO

// Vector que contiene las lecturas de las posiciones leídas:
$posiciones = [0=>"H",
			   1=>"B",
			   2=>"B1",
			   3=>"B2",
			   4=>"B3",
			   5=>"A", //Posición meta
			   6=>"B4",
			   7=>"B5"];

//Buscamos la posición A (meta) en el vector y la imprimimos:
$busqueda = primeroEnAnchura($posiciones, "A");

if ($busqueda != null) {
	echo "El brazo debe desplazarse ".$busqueda." mm a la derecha";
} 
else {
	echo "No se puede determinar la posición";
}
	
//***************************************************************************************************

// FUNCIÓN

//Definimos la función para el método exhaustivo primero en anchura (BFS)
function primeroEnAnchura($vector, $objetivo) {
  $cola = array(); //Definimos la variable cola
  array_push($cola, 0); //Inicializamos la cola
  $visitado = array(); //Definimos la variable que guardará los nodos visitados
  $visitado[0] = true; //Inicializamos la raíz como visitada
  
  //Recorremos la cola
  while (count($cola) > 0) {
    $actual = array_shift($cola);
    
    //Si encontramos el punto buscado, devolvemos su índice
    if ($vector[$actual] == $objetivo) {
      return $actual;
    }
    
    //Recorremos los nodos adyacentes al nodo actual
    $adyacentes = encontrarAdyacente($vector, $actual);
    foreach ($adyacentes as $adyacente) {
      if (!isset($visitado[$adyacente]) && $vector[$adyacente] != null) {
        array_push($cola, $adyacente);
        $visitado[$adyacente] = true;
      }
    }
  }
  //Si no encontramos el valor meta, devolvemos null
  return null;
}

//Función que visita los nodos adyacentes
function encontrarAdyacente($vector, $actual) {
  $adyacentes = array();
  $dimension = count($vector);
  
  //Movimientos posibles: izquierda o derecha
  if ($actual - 1 >= 0) {
    array_push($adyacentes, $actual - 1);
  }
  if ($actual + 1 < $dimension) {
    array_push($adyacentes, $actual + 1);
  }
  return $adyacentes;
}