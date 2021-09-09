//Função para validação de login

$(function(){
  $("button#btnLogin").on("click", function(e){
    e.preventDefault();

    var fieldEmail = $("form#formLogin #email").val();
    var fieldKeyword =$("form#formLogin #keyword").val();

    if(fieldEmail.trim() == "" || fieldKeyword.trim() == ""){
      $("div#message").show().html("Inserir E-mail e Senha!");

    }else{
      $.ajax({
        url:"actions/login.php",
        type: "POST",
        data:{
          email: fieldEmail,
          keyword: fieldKeyword
        },

        success: function(reply){
          reply = JSON.parse(reply);

          if(reply["error"]){
            $("div#message").show().html(reply["message"]);
          }else{
            window.location = "dashboard.php";
          }
        },
        error: function(){
          $("div#message").show().html("Erro na solicitação!");  
        }
      });
    }
  });
});

