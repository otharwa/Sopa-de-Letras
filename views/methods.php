<?php
/**
 * Funcion para debugear, si $title no desea ser usado, se asume que es la $data,
 * caso contrario se imprime un titulo y la $data.
 *
 * @param mixed $title El mensaje que acompaña el debug, o la informacion a debugear si $data es null
 * @param mixed $data El contenido a debugear
 *
 * @return void
*/
function debug($title=null, $data=null){
	if($data === null) var_dump($title);
	else {
		echo $title . '  :';
		var_dump($data);
	}
	echo "\n\r";
}


class Crossword {
/**
 * Matrices predefinidas.
 *
 * @var array $__matrixes
*/
	private $__matrixes			= [];
/**
 * Palabra que tiene que ser buscada.
 *
 * @var array $__word Default: 'OIE'
*/
	private $__word				= ['O','I','E'];
/**
 * Almacena la matriz que se desea usar.
 *
 * @var string $__SELECTED Default: '3_3'
*/
	private static $__SELECTED	= null;
/**
 * Direcciones en las que puede aparecer la palabra dentro de una matriz.
 *
 * @var array $__directions_values
*/
	private $__directions_values = [
		'horizontal_positiva'	=> null, // Derecha
		'horizontal_negativa'	=> null, // Izquierda
		'vertical_superior'		=> null, // Arriba
		'vertical_inferior'		=> null, // Abajo
		'diagonal_1'			=> null, // Superior Derecho
		'diagonal_2'			=> null, // Superior Izquierdo
		'diagonal_3'			=> null, // Inferior Derecho
		'diagonal_4'			=> null, // Inferior Izquierdo
	];
/**
 * Registra las matrices predefinidas donde se "esconde" la palabra a buscar.
*/
	public function __construct(){
		$this->__matrixes['3_3']	= [
			['O','I','E'],
			['I','I','X'],
			['E','X','E'],
		];
		$this->__matrixes['1_10']	= [
			['E','I','O','I','E','I','O','E','I','O'],
		];
		$this->__matrixes['5_5']	= [
			['E','A','E','A','E'],
			['A','I','I','I','A'],
			['E','I','O','I','E'],
			['A','I','I','I','A'],
			['E','A','E','A','E'],
		];
		$this->__matrixes['7_2']	= [
			['O','X'],
			['I','O'],
			['E','X'],
			['I','I'],
			['O','X'],
			['I','E'],
			['E','X'],
		];

		$this->changeSelected('1_10');
	}
/**
 * Devuelve la matriz que se esta usando.
 *
 * @return array
*/
	public function getMatrix(){
		return (array)$this->__matrixes[self::$__SELECTED];
	}
/**
 * Devuelve la matriz completa.
 *
 * @return array
*/
	public function getFullMatrix(){
		return (array)$this->__matrixes;
	}

/**
 * Selecionar una matriz para usar.
 *
 * @param string $choice Una de las matrices validas
 * @return Crossword::
*/
	public function changeSelected($choice=null){
		if(!empty($choice) && !empty($this->__matrixes[$choice]))
			self::$__SELECTED	= $choice;

		return $this;
	}

/**
 * Cuenta la cantidad de veces que aparece la palabra ($this->__word) en una matriz de letras seleccionada.
 *
 * @return int
*/
	public function countWordAppers(){
		$mtx	=& $this->getMatrix();

		$firt_letter	= []; // Coordenadas donde aparece la letra O
		foreach ($mtx as $row_index => &$row) {
			foreach ($row as $column_index => &$letter) {
				if($letter == $this->__word[0])
					$firt_letter[]	= [$row_index, $column_index];
			}
		}

		$countTimes	= function ($letterCalc=null){
			$count = 0;
			foreach ($letterCalc as $letter_coordinate) {
				if($letter_coordinate !== null)
					$count++;
			}
			return $count;
		};
		
		$count	= 0;
		foreach ($firt_letter as $let) {
			$searchLetter	= null;
			foreach ($this->__word as $letter_word) {
				if($letter_word === $this->__word[0])
					continue;
				if($searchLetter === null)
					$searchLetter	= $this->nextLetter($let, $mtx, $letter_word); // Coordenadas donde aparece la letra I
				else
					$searchLetter	= $this->nextLetter($searchLetter, $mtx, $letter_word); // Coordenadas donde aparece la letra E
			}

			$count = $count + $countTimes($searchLetter);
		}

		return $count;
	}
/**
 * Encuentra las coordenadas de una letra especifica, a partir de las coordenadas de una letra conocida, dentro de una matriz dada.
 *
 * Puede recibir las coordenadas de una sola letra $var[$row, $column], o el resultado de este metodo para encontrar las subsiguientes letras requeridas.
 *
 * @param array $letter			- Posicion de la letra anterior. Se usa como punto de partida.
 * @param array $matrix			- Matriz de letras a buscar
 * @param string $letterToFind	- Letra susera a buscar 
 * @return array
*/
	public function nextLetter($letter=null, &$matrix=null, $letterToFind=null){
		if(isset($letter[0]) && !isset($letter[0][0])) {
			$tmp_a	= $this->__directions_values;
			foreach ($tmp_a as $key => $value) {
				$tmp_a[$key]	= $letter;
			}
			$letter	= $tmp_a;
		}
		if(isset($letter[0]))
			return false;

		$direct	= $this->__directions_values;
		foreach ($letter as $__direct => $position) {
			$r	= $position[0];
			$c	= $position[1];

			switch ($__direct) {
				case 'horizontal_positiva': //Derecha
					if(isset($matrix[$r][$c+1]) && $matrix[$r][$c+1] == $letterToFind)
						$direct['horizontal_positiva']	= [$r, ($c+1)];
					break;

				case 'horizontal_negativa': // Izquierda
					if(isset($matrix[$r][$c-1]) && $matrix[$r][$c-1] == $letterToFind)
						$direct['horizontal_negativa']	= [$r, ($c-1)];
					break;

				case 'vertical_superior': // Arriba
					if(isset($matrix[$r-1][$c]) && $matrix[$r-1][$c] == $letterToFind)
						$direct['vertical_superior']	= [($r-1), $c];
					break;

				case 'vertical_inferior': // Abajo
					if(isset($matrix[$r+1][$c]) && $matrix[$r+1][$c] == $letterToFind)
						$direct['vertical_inferior']	= [($r+1), $c];
					break;

				case 'diagonal_1': // Superior Derecho
					if(isset($matrix[$r-1][$c-1]) && $matrix[$r-1][$c-1] == $letterToFind)
						$direct['diagonal_1']			= [($r-1), ($c-1)];
					break;

				case 'diagonal_2': // Superior Izquierdo
					if(isset($matrix[$r-1][$c+1]) && $matrix[$r-1][$c+1] == $letterToFind)
						$direct['diagonal_2']			= [($r-1), ($c+1)];
					break;

				case 'diagonal_3': // Inferior Derecho
					if(isset($matrix[$r+1][$c-1]) && $matrix[$r+1][$c-1] == $letterToFind)
						$direct['diagonal_3']			= [($r+1), ($c-1)];
					break;

				case 'diagonal_4': // Inferior Derecho
					if(isset($matrix[$r+1][$c+1]) && $matrix[$r+1][$c+1] == $letterToFind)
						$direct['diagonal_4']			= [($r+1), ($c+1)];
					break;
			}
		}
		return $direct;
	}
}