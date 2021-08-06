<?php
// rodapé frontend
?>

<footer class="container rodape">
    <div class="row">
        <div class="col-sm-6 col-12">
            <p>ControlServ &copy; <?php echo date('Y'); ?> | <a href="mailto:"><i class="fa fa-envelope"></i> cameraeuterpe@gmail.com</a></p>
            <p>Sistema de controle de serviços on-line. <br>Auxiliando no controle de serviços onde quer que você esteja. <br>Tenha o controle dos seus serviços onde você quiser.</p>
            <!-- <p><a href="http://localhost/www/servicos/sp-admin/">Área Reservada</a></p> -->
        </div>
        <div class="col-sm-6 col-12 rodape-social text-right">
        <a href=""><i class="fa fa-facebook-square mr-2"></i></a>
        <a href=""><i class="fa fa-twitter-square mr-2"></i></a>
        <a href=""><i class="fa fa-instagram mr-2"></i></a>
        <a href=""><i class="fa fa-linkedin"></i></a>

        <p></p>
        </div>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="inc/js/main.js"></script>

<script>
    $(document).ready(function() {
        $("#termo").hide();
        $("#show").click(function() {
            $("#termo").show();
        });
    });
</script>

</body>

</html>