<?php 

require_once "./view/TwigView.php";

class ReporteConsultaView extends TwigView {

	function ShowConsultasMotivo($cantidadDatos,$total_paginas,$cantidadRegistrosPorListado,$pagina,$datos,$mensaje = null){

		$roles=$_SESSION['rol'];

	  	$array = array('mensaje'=> $mensaje,
	  		'num_filas'=> $cantidadDatos,
	  		'total_paginas'=>$total_paginas,
	      	'tamagno_paginas'=>$cantidadRegistrosPorListado,
	  		'pagina'=> $pagina,
	  		'datos'=>$datos,
	      	'rolesUserSistema'=>$roles);

		echo self::getTwig()->render('motivo-consultas-repote.twig',$array);
	}

	function ShowConsultasLocalidad($cantidadDatos,$total_paginas,$cantidadRegistrosPorListado,$pagina,$datos,$mensaje = null){
	    $roles=$_SESSION['rol'];
	  	$array = array('mensaje'=> $mensaje,
	  		'num_filas'=> $cantidadDatos,
	  		'total_paginas'=>$total_paginas,
	      	'tamagno_paginas'=>$cantidadRegistrosPorListado,
	  		'pagina'=> $pagina,
	  		'datos'=>$datos,
	      	'rolesUserSistema'=>$roles);
		echo self::getTwig()->render('localidad-consultas-repote.twig',$array);
	}

	function ShowConsultasGenero($cantidadDatos,$total_paginas,$cantidadRegistrosPorListado,$pagina,$datos,$mensaje = null){
	    $roles=$_SESSION['rol'];

	  	$array = array('mensaje'=> $mensaje,
	  		'num_filas'=> $cantidadDatos,
	  		'total_paginas'=>$total_paginas,
	      	'tamagno_paginas'=>$cantidadRegistrosPorListado,
	  		'pagina'=> $pagina,
	  		'datos'=>$datos,
	      	'rolesUserSistema'=>$roles);

		echo self::getTwig()->render('genero-consultas-repote.twig',$array);
	}

}