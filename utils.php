<?php
class Utils {

    /**
     * Limpia una cadena eliminando espacios y caracteres especiales.
     * Se usa htmlspecialchars() para evitar inyección de código (XSS).
     * Ideal para limpiar datos provenientes de formularios antes de procesarlos.
     */
    public static function limpiar($valor) {
        return htmlspecialchars(trim($valor));
    }

    /**
     * Valida si un valor es un número entero positivo.
     * Usa filter_var() con la opción min_range = 1.
     * Devuelve el número si es válido, o false si no lo es.
     */
    public static function esPositivo($valor) {
        return filter_var($valor, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]);
    }

    /**
     * Verifica que el valor ingresado sea únicamente numérico (solo dígitos).
     * Se usa preg_match() con una expresión regular simple.
     * Retorna 1 (verdadero) si el valor es válido, o 0 si no cumple.
     */
    public static function esNumero($valor) {
        return preg_match('/^\d+$/', $valor);
    }

    /**
     * Genera un enlace HTML para regresar al menú principal.
     * Recibe la URL como parámetro.
     * Retorna una cadena HTML con el enlace formateado con clases CSS.
     */
    public static function enlaceVolver($url) {
        return "<p><a href='$url' class='btn-volver'>⬅ Volver al menú</a></p>";
    }
}
?>