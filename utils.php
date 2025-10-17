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
     /* =====================  UTILIDADES  ===================== */

    /** Float (acepta coma o punto decimal) */
    public static function esFloat(string $s): bool {
        $s = trim($s);
        return (bool) preg_match('/^-?\d+([.,]\d+)?$/', $s);
    }

    /** Rango entero [min, max] */
    public static function rangoInt(int $v, int $min, int $max): bool {
        return $v >= $min && $v <= $max;
    }

    /** Rango float [min, max] */
    public static function rangoFloat(float $v, float $min, float $max): bool {
        return $v >= $min && $v <= $max;
    }

    /** Fecha ISO yyyy-mm-dd */
    public static function fechaISO(string $s): bool {
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $s)) return false;
        [$y,$m,$d] = array_map('intval', explode('-', $s));
        return checkdate($m, $d, $y);
    }

    /** Formateo numérico con separadores (por defecto 2 decimales) */
    public static function numero(float|int $v, int $dec = 2): string {
        return number_format($v, $dec, '.', ',');
    }

    /** Dinero en USD */
    public static function dinero(float $v): string {
        return '$' . number_format($v, 2, '.', ',');
    }

    /** Fecha dd-mm desde ISO */
    public static function fechaDM(string $iso): string {
        $ts = strtotime($iso);
        return date('d-m', $ts);
    }
}
?>
