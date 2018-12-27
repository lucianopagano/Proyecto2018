<?php

require_once "./view/Home.php";

/**
 * 
 */
class HomeController{
	
	function Index($mensaje=null){

		$v = new Home;
		if(isset($_SESSION['uid'])){
			//home del usuario
			$v->ShowHomeUser($mensaje);
		}
		else{
			//home Publica
			$v->ShowHomePublic($mensaje);

		}


	}
}