<?php
function cacha_lesp ($variable){
	if(isset($_POST["$variable"])){
	$cadena=$_POST["$variable"];
	 //$cadena = utf8_encode($cadena);

    //Ahora reemplazamos las letras
    $cadena = str_replace(
        array('à', 'ä', 'â', 'ª', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'A', 'A', 'A'),
        $cadena
    );

    $cadena = str_replace(
        array('è', 'ë', 'ê', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'E', 'E', 'E'),
        $cadena );

    $cadena = str_replace(
        array('ì', 'ï', 'î', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'I', 'I', 'I'),
        $cadena );

    $cadena = str_replace(
        array('ò', 'ö', 'ô', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'O', 'O', 'O'),
        $cadena );

    $cadena = str_replace(
        array('ù', 'ü', 'û', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'U', 'U', 'U'),
        $cadena );

    $cadena = str_replace(
        array('ç', 'Ç'),
        array('c', 'C'),
        $cadena
    );
	$cadena=utf8_decode($cadena);
	
	
    return trim($cadena);
}
else{
	return "";
}

}

function cacha ($variable){
	if(isset($_POST["$variable"])){
	$cadena=strtoupper($_POST["$variable"]);
	 //$cadena = utf8_encode($cadena);

    //Ahora reemplazamos las letras
    $cadena = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $cadena
    );

    $cadena = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $cadena );

    $cadena = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $cadena );

    $cadena = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $cadena );

    $cadena = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $cadena );

    $cadena = str_replace(
        array('ç', 'Ç','ñ'),
        array('c', 'C', 'Ñ'),
        $cadena
    );
	
	
	/*
    $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    $modificadas ='AAAAAAACEEEEIIIIDÑOOOOOOUUUUYBBAAAAAAACEEEEIIIIDÑOOOOOOUUUYYBYRR';
	*/
    //$cadena = $cadena;
	
	//echo $cadena."<br>";
	//echo utf8_decode(utf8_encode($cadena))."<br>";
	//$cadena=utf8_decode(utf8_encode($cadena));
	//echo utf8_encode(utf8_decode($cadena))."<br>";
    //$cadena = strtr($cadena, $originales, $modificadas);
	//echo $cadena."<br>";;
    $cadena = trim(strtoupper($cadena));
    return $cadena;
}
else{
	return "";
}

}
?>