function verifyStrongKeyword() 
{
	var numbers = /([0-9])/;
	var alfaMinuscule = /([a-z])/;
	var alfaCapital = /([A-Z])/;


	if($('#keyword').val().length<8){
    var numberQuantity = "Minimo 8 Caracteres. "
  }else{
    var numberQuantity = ""
  }

  if($('#keyword').val().match(numbers)){
    var numberOk = ""
  }else{
    var numberOk = "Utilizar número. "
  }

  if($('#keyword').val().match(alfaMinuscule)){
    var minusculeOk = ""
  }else{
    var minusculeOk = "Utilizar letra minuscula. "
  }

  if($('#keyword').val().match(alfaCapital)){
    var capitalOk = ""
  }else{
    var capitalOk = "Utilizar letra maiuscula. "
  }

  $('#keywordStatus').html("<span style='color:red'>" + numberQuantity + numberOk + minusculeOk + capitalOk + "</span>");
}