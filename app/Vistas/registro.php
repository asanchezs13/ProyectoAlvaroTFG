<?php
ob_start();
?>
<div class="formulario">
    <form action="/ProyectoAlvaroTFG/web/index.php?accion=registro" method="post" enctype="multipart/form-data">
        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
        <div class="form-group">
            <input type="text" name="nombre" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ""?>" class="form-control" id="exampleInputNombre" placeholder="Nombre"><br>
        </div>
        <div class="form-group">
            <input type="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ""?>" class="form-control" id="exampleInputEmail" placeholder="Email"><br>
        </div>
        <div class="form-group">
            <input type="password" name="contrasena" class="form-control" id="exampleInputPassword" placeholder="Contraseña"><br>
        </div>
        <div class="form-group">
            <input type="file" name="imagen" class="form-control-file" id="exampleFormControlFile"><br><br>
        </div>
        <button type="submit" class="btn btn-primary">REGISTRAR</button><br><br>
    </form>
    <?= mostrarMensajes::imprimirMensaje();?>
</div>
<?php
$contenido = ob_get_clean();
require 'cabecera.php';
?>