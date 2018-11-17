<?php

session_start();
include './header_login.php';
?>
<div class="container">
    &emsp;
    <div class="row">
        <div class="col-md-6">
            <h4><strong> Login </strong></h4>
            &emsp;
            <form action="./loginFormProcess.php" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" id="login_userName" placeholder="Username" name="login_userName" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="login_password" placeholder="Palavra Chave" name="login_password" required>
                </div>
                <button type="submit" class="btn btn-secondary">Enviar</button>
            </form>
        </div>

        <div class="col-md-6">
            <h4><strong> Registo </strong></h4>
            &emsp;
            <form method="post" action="register.php">
                <div class="form-group">
                    <div class="form-group">
                        <input type="text" class="form-control" id="real_name" placeholder="Nome do Utilizador" name="real_name" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="register_userName" placeholder="Username" name="registed_userName" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="register_password1" placeholder="Palavra-Chave" name="registed_password1" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="register_password2" placeholder="Repetir Palavra-Chave" name="registed_password2" required>
                        <span id="match_message"> </span>
                    </div>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                    <script>
                        $('#register_password1, #register_password2').on('keyup', function () {
                        if ($('#register_password1').val() == $('#register_password2').val()) {
                            $('#match_message').html('As Palavras-Chave correspondem').css('color', 'green');
                        } else 
                            $('#match_message').html('As Palavras-Chave não correspondem').css('color', 'red');
                        });
                    </script>
                    <div class="form-group">
                        <input type="text" class="form-control" id="email" placeholder="E-mail" name="email" required>
                    </div>
                </div>
                <div class="form-group">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input class="form-check-input" type="checkbox" name="Simpatizante" value="Simpatizante" id="simpatizanteCheckbox" onclick="ativarSimpatizante()">
                    <label class="form-check-label" for="simpatizanteCheckbox">
                        Simpatizante
                    </label>
                </div>
                <div class="form-group" id="divHierarquia" style = "display:none">
                    <select class="form-control" name="hierarchy">
                        <option value="Caloira">Caloira</option>
                        <option value="Veterana">Veterana</option>
                    </select>
                </div>
                <div class="form-group" id="divAlcunha" style = "display:none">
                    <input type="text" class="form-control" name="nickname" placeholder="Alcunha">
                </div>
                
                <script>
                    function ativarSimpatizante() {
                        var checkBox = document.getElementById("simpatizanteCheckbox");
                        var divAlcunha = document.getElementById("divAlcunha");
                        var divHierarquia = document.getElementById("divHierarquia");

                        if (checkBox.checked == true) {
                            divAlcunha.style.display = "block";
                            divHierarquia.style.display = "block";
                        } else {
                            divAlcunha.style.display = "none";
                            divHierarquia.style.display = "none";
                        }
                    }
                </script>
                 <div class="g-recaptcha" data-sitekey="6LcS_2AUAAAAAGs1p9z4JemmZkXICI0IsBI5kvfO"></div>
                 <div>&emsp;</div>
                <button type="submit" class="btn btn-secondary">Enviar</button>
                <div>&emsp;</div>
            </form>
        </div>
    </div>
</div>

<?php include './footer.php'; ?>

