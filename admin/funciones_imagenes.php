<?php
/**
 * Comprime y redimensiona una imagen subida, y la guarda en destino.
 * Soporta JPG, PNG, GIF, WEBP.
 *
 * @param string $origen   Ruta temporal del archivo subido ($_FILES[...]['tmp_name'])
 * @param string $destino  Ruta final donde se guardará la imagen ya comprimida
 * @param int    $anchoMax Ancho máximo en píxeles (si la imagen es más ancha, se reduce)
 * @param int    $calidad  Calidad JPG/WEBP (0-100). Para PNG se traduce a compresión 0-9.
 * @return bool true si se guardó correctamente
 */
function comprimirImagen($origen, $destino, $anchoMax = 1200, $calidad = 75) {

    $info = @getimagesize($origen);
    if ($info === false) {
        // No es una imagen válida, copiar tal cual como respaldo
        return move_uploaded_file($origen, $destino) || copy($origen, $destino);
    }

    list($anchoOriginal, $altoOriginal) = $info;
    $tipo = $info[2];

    // Crear imagen origen según el tipo
    switch ($tipo) {
        case IMAGETYPE_JPEG:
            $imagenOrigen = @imagecreatefromjpeg($origen);
            break;
        case IMAGETYPE_PNG:
            $imagenOrigen = @imagecreatefrompng($origen);
            break;
        case IMAGETYPE_GIF:
            $imagenOrigen = @imagecreatefromgif($origen);
            break;
        case IMAGETYPE_WEBP:
            $imagenOrigen = @imagecreatefromwebp($origen);
            break;
        default:
            // Tipo no soportado por GD, copiar tal cual
            return move_uploaded_file($origen, $destino) || copy($origen, $destino);
    }

    if (!$imagenOrigen) {
        return move_uploaded_file($origen, $destino) || copy($origen, $destino);
    }

    // Calcular nuevas dimensiones manteniendo proporción
    if ($anchoOriginal > $anchoMax) {
        $nuevoAncho = $anchoMax;
        $nuevoAlto  = intval($altoOriginal * ($anchoMax / $anchoOriginal));
    } else {
        $nuevoAncho = $anchoOriginal;
        $nuevoAlto  = $altoOriginal;
    }

    $imagenNueva = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

    // Preservar transparencia en PNG y GIF
    if ($tipo == IMAGETYPE_PNG || $tipo == IMAGETYPE_GIF) {
        imagecolortransparent($imagenNueva, imagecolorallocatealpha($imagenNueva, 0, 0, 0, 127));
        imagealphablending($imagenNueva, false);
        imagesavealpha($imagenNueva, true);
    }

    imagecopyresampled(
        $imagenNueva, $imagenOrigen,
        0, 0, 0, 0,
        $nuevoAncho, $nuevoAlto,
        $anchoOriginal, $altoOriginal
    );

    // Guardar según el tipo original, pero siempre comprimido
    $resultado = false;
    switch ($tipo) {
        case IMAGETYPE_JPEG:
            $resultado = imagejpeg($imagenNueva, $destino, $calidad);
            break;
        case IMAGETYPE_PNG:
            // PNG usa escala 0-9, convertimos calidad 0-100 a esa escala (invertido)
            $nivelPng = (int) round((100 - $calidad) / 100 * 9);
            $resultado = imagepng($imagenNueva, $destino, $nivelPng);
            break;
        case IMAGETYPE_GIF:
            $resultado = imagegif($imagenNueva, $destino);
            break;
        case IMAGETYPE_WEBP:
            $resultado = imagewebp($imagenNueva, $destino, $calidad);
            break;
    }

    imagedestroy($imagenOrigen);
    imagedestroy($imagenNueva);

    return $resultado;
} 