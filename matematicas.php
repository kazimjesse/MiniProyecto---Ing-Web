<?php
declare(strict_types=1);

/**
 * Biblioteca de funciones matemáticas 
 * Reutilizable por varios problemas
 */
class Matematicas
{
    public static function promedio(array $numeros): float
    {
        return array_sum($numeros) / max(1, count($numeros));
    }

    public static function desviacionEstandar(array $numeros): float
    {
        $media = self::promedio($numeros);
        $suma = 0.0;
        foreach ($numeros as $n) {
            $suma += ($n - $media) ** 2;
        }
        return sqrt($suma / max(1, count($numeros))); 
    }

    public static function minimo(array $numeros): float
    {
        return (float) min($numeros);
    }

    public static function maximo(array $numeros): float
    {
        return (float) max($numeros);
    }
}