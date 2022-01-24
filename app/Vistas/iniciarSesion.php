<?php
ob_start();
?>
<div class="formulario">
    <form action="/ProyectoAlvaroTFG/web/index.php?accion=login" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <input type="email" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '';?>" id="exampleInputEmail" placeholder="Email"><br>
        </div>
        <div class="form-group">
            <input type="password" name="contrasena" class="form-control" id="exampleInputPassword" placeholder="Contraseña"><br>
        </div>
        <button type="submit" class="btn btn-primary">INICIAR SESIÓN</button><br><br>
    </form>
    <?= mostrarMensajes::imprimirMensaje();?>
</div>
<?php
$contenido = ob_get_clean();
require 'cabecera.php';
?>