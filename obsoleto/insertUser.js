$(function(){
  $("button#btnInsertUser").on("click", function(e){
    e.preventDefault();

    var fieldName = $("form#newUser #name").val();
    var fieldEmail = $("form#newUser #email").val();
    var fieldTelefone = $("form#newUser #telefone").val();
    var fieldKeyword = $("form#newUser #keyword").val();
    var fieldAdmin= $("form#newUser #admin").val();

    if(fieldName.trim() == "" || fieldEmail.trim() == "" || fieldTelefone.trim() == "" || fieldKeyword.trim() == "" || fieldAdmin.trim() == ""){
      $("div#message").show().html("Preencher todos os campos!");

    }else{
      $.ajax({
        url:"actions/insertUser.php",
        type: "POST",
        data:{
          name: fieldName,
          email: fieldEmail,
          telefone: fieldTelefone,
          keyword: fieldKeyword,
          admin: fieldAdmin
        },

        success: function(reply){
          reply = JSON.parse(reply);

          if(reply["error"]){
            $("div#message").show().html(reply["Erro, utilizador não inserido"]);
          }else{
            window.location = "dashboardNewUser.php";
            $("div#message").show().html("Utilizador inserido com sucesso!"); 
          }
        },
        error: function(){
          $("div#message").show().html("Erro, utilizador não inserido");  
        }
      });
    }
  });
});

