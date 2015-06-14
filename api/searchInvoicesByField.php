<?php	
	
	header('Content-type: application/json');

	if( isset($_GET['op']) && isset($_GET['field']) && isset($_GET['value']) ){

		$op = $_GET['op'];
		$field = $_GET['field'];
		$value = $_GET['value'];

		$dataBase = new PDO('sqlite:BdLtw.db');

		switch( $op ){
			case 'range':
						 $dataBaseArray = $dataBase->query( 'SELECT * FROM Fatura WHERE '.$field.' BETWEEN '.$value[0].' AND '.$value[1] );
						 break;
			case 'equal':
						$dataBaseArray = $dataBase->query( 'SELECT * FROM Fatura WHERE '.$field.' = '.$value[0] );
						 break; 
			case 'contains':
						$dataBaseArray = $dataBase->query( 'SELECT * FROM Fatura WHERE '.$field.' LIKE %'.$value[0].'%' );
						 break;
			case 'min':
						$dataBaseArray = $dataBase->query( 'SELECT * FROM Fatura WHERE '.$field.' BETWEEN '.$value[0].' AND '.'(SELECT max('.$field.') FROM Fatura)');
						break;
			case 'max':
						$dataBaseArray = $dataBase->query( 'SELECT * FROM Fatura WHERE '.$field.' BETWEEN '.'(SELECT min('.$field.') FROM Fatura)'.' AND '.$value[0]);
						 break;
			default:
					break;
		}

		$arrayToReturn = $dataBaseArray->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($arrayToReturn);
	}else{
		$arrayToReturn = array( 'error'=>array('code'=>'400', 'reason'=>'Bad Request'));
		echo json_encode($arrayToReturn, JSON_PRETTY_PRINT);
	}

?>