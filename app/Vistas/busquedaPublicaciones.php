<?php 
ob_start();
?>
<div class="formularioBusqueda">
    <form action="/ProyectoAlvaroTFG/web/index.php?accion=busquedaPublicaciones" method="post">
        <h4>SELECCIONA EL PARÁMETRO DE BÚSQUEDA:</h4><br>
        <div class="form-group">
            <select name="parametroBusqueda">
                <option value="cabecera">CABECERA</option>
                <option value="estrellas">ESTRELLAS</option>
            </select>
        </div><br>
        <div class="form-group">
            <input type="text" name="parametroCoincidencia" value="<?php echo isset($_POST['parametroCoincidencia']) ? $_POST['parametroCoincidencia'] : ""?>" class="form-control" placeholder="Coincidencia..."><br>
        </div>
        <button type="submit" class="btn btn-primary">BUSCAR</button><br><br>
    </form>
    <?= mostrarMensajes::imprimirMensaje();?>
</div>  
<?php   if(isset($publicaciones1)):
            foreach ($publicaciones1 as $p1):?>
                <div class="elementoListadoPublicaciones">
                    <a href="/ProyectoAlvaroTFG/web/index.php?accion=verPublicacion&id=<?= $p1->getIdPublicacion();?>"><?php echo $p1->getCabecera();?></a><br><br>
                    <?php if(count($p1->getImagenes()) >= 1):?>
                        <div class="imgPublicaciones" style="background-image: url(imgPublicaciones/<?= $p1->getImagenes()[0]->getNombreImagen()?>)"></div><br>
                    <?php else:?>
                        <div class="imgPublicaciones" style="background-image: url(imgWeb/interrogacion.jpg)"></div><br>
                    <?php endif;?>
                    <?php 

                    $estrellas = $p1->getEstrellas();

                    if(!empty($estrellas)){
                        if($estrellas == 1 || $estrellas == 0){
                            echo '<i class="fas fa-star"></i>';
                        }
                        if($estrellas == 2){
                            echo '<i class="fas fa-star"></i><i class="fas fa-star"></i>';
                        }
                        if($estrellas == 3){
                            echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>';
                        }
                        if($estrellas == 4){
                            echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>';
                        }
                        if($estrellas == 5){
                            echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>';
                        }
                    }else{
                        echo 'No valorado.';
                    }
                    ?><br><br>
                </div>
                
            <?php endforeach; ?>
        <?php endif; ?>
<?php
$contenido = ob_get_clean();
require 'cabecera.php';
?>