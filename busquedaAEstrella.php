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
			   4=>"A", //Posición meta
			   5=>"B3",
			   6=>"B4",
			   7=>"B5"];

//Buscamos la posición A (meta) en el vector y la imprimimos:
$busqueda = aEstrella($posiciones, "A");

if ($busqueda != null) {
	echo "El brazo debe desplazarse ".array_key_last($busqueda)." mm a la derecha";
} 
else {
	echo "No se puede determinar la posición";
}

//***************************************************************************************************

// FUNCIÓN

//Definimos la función para el método heurístico A*
function aEstrella($vector, $objetivo) {
  $inicio = 0; //Definimos la variable inicio y la inicializamos en 0
  $meta = array_search($objetivo, $vector); //Buscamos el índice de la meta en el vector
  $visitado = array(); //Definimos la variable que guardará los nodos visitados
  $cola = new SplPriorityQueue(); //Definimos la variable cola como una cola de prioridad
  
  $cola->insert(array($inicio, null, 0), 0); //Insertamos el primer nodo en la cola usando los métodos de la cola
  
  while (!$cola->isEmpty()) {
    $actual = $cola->extract(); //Obtenemos el nodo con menor costo
    $indice = $actual[0]; //Almacenamos el índice del nodo actual
    
    if ($indice === $meta) {
      //Si se llegó a la meta, reconstruimos el camino
      $camino = array();
      while ($actual[1] !== null) {
        array_unshift($camino, $vector[$actual[0]]);
        $actual = $visitado[$actual[1]];
      }
      array_unshift($camino, $vector[$actual[0]]);
      return $camino;
    }
    
    if (!isset($visitado[$indice])) {
      $visitado[$indice] = $actual; //Marcamos el nodo actual como visitado
      
      //Exploramos los nodos adyacentes al nodo actual
      foreach (array($indice - 1, $indice + 1) as $adyacente) {
        if ($adyacente >= 0 && $adyacente < count($vector) && !isset($visitado[$adyacente])) {
          $g = $actual[2] + 1; // costo acumulado hasta el vecino
          $h = distanciaAdyacente($vector[$adyacente], $objetivo); // costo heurístico del vecino
          $f = $g + $h; // costo total del vecino
          $cola->insert(array($adyacente, $indice, $g), -$f); // insertamos el vecino en la cola
        }
      }
    }
  }
  //Si no encontramos el valor meta, devolvemos null
  return null;
}

//Función que calcula la distancia entre dos elementos del vector
//Como en este ejemplo particular el vector contiene letras, se usa la función ord()
//Para usar el valor ASCII del caracter y poder calcular la distancia
function distanciaAdyacente($actual, $objetivo) {
  return abs(ord($actual) - ord($objetivo));
}