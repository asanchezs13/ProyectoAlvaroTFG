<?php
ob_start();
?>
<div class="listadoPublicaciones">
    <?php foreach($mejoresPublicaciones as $mP):?>
        <div class="elementoListadoPublicaciones">
            <a href="/ProyectoAlvaroTFG/web/index.php?accion=verPublicacion&id=<?= $mP->getIdPublicacion();?>"><?php echo $mP->getCabecera();?></a><br><br>
            <?php if(count($mP->getImagenes()) >= 1):?>
                <div class="imgPublicaciones" style="background-image: url(imgPublicaciones/<?= $mP->getImagenes()[0]->getNombreImagen()?>)"></div><br>
            <?php else:?>
                <div class="imgPublicaciones" style="background-image: url(imgWeb/interrogacion.jpg)"></div><br>
            <?php endif;?>
            <?php 
            
            $estrellas = $mP->getEstrellas();
            
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
    <?php endforeach;?>
</div><br><br>
<?php
$contenido = ob_get_clean();

require 'cabecera.php';
?>






