<?php
ob_start();
?>
<div class="formulario">
    <form action="/ProyectoAlvaroTFG/web/index.php?accion=subirPublicacion" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <input type="text" name="cabecera" value="<?php echo isset($_POST['cabecera']) ? $_POST['cabecera'] : '';?>" class="form-control" placeholder="Cabecera"><br>
        </div>
        <div class="form-group">
            <textarea name="cuerpo" class="form-control" rows="10" placeholder="Cuerpo"><?php echo isset($_POST['cuerpo']) ? $_POST['cuerpo'] : '';?></textarea><br>
        </div>
        <div class="form-group">
            <input type="file" name="imagen[]" class="form-control-file" multiple="multiple">
        </div><br>
        <div class="form-group">
            <select name="continente">
                <?php foreach($continentes as $c):?>
                    <option value="<?= $c->getIdContinente()?>"><?= $c->getNombre()?></option>
                <?php endforeach;?>
            </select>
        </div><br>
        <div class="form-group">
            <p class="clasificacion">
                <input id="radio1" type="radio" name="estrellas" value="5">
                    <label for="radio1">★</label>
                <input id="radio2" type="radio" name="estrellas" value="4">
                    <label for="radio2">★</label>
                <input id="radio3" type="radio" name="estrellas" value="3">
                    <label for="radio3">★</label>
                <input id="radio4" type="radio" name="estrellas" value="2">
                    <label for="radio4">★</label>
                <input id="radio5" type="radio" name="estrellas" value="1">
                    <label for="radio5">★</label>
            </p>
        </div>
        <button type="submit" class="btn btn-primary">SUBIR PUBLICACIÓN</button><br><br>
    </form>
    <?= mostrarMensajes::imprimirMensaje();?>
</div>
<?php
$contenido = ob_get_clean();
require 'cabecera.php';
?>