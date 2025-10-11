# Proyecto Final: Aplicaciones Web con PHP y Estándares de Código
## 1. Introducción
Este repositorio contiene una colección de programas de aplicación práctica desarrollados en PHP y HTML/CSS/JavaScript. El objetivo principal del proyecto fue afianzar los conceptos de Programación Orientada a Objetos (POO), la gestión de utilidades mediante métodos estáticos, y la adhesión a estándares de código como CamelCase (PSR-1/PSR-12), junto con la implementación de validación y sanitización de datos.

Cada "problema" aborda una lógica específica (cálculos matemáticos, manipulación de estructuras de datos, etc.) presentada a través de una interfaz web sencilla y funcional.

## 2. Tecnologías y Estándares Utilizados

### Lenguaje Backend

PHP (Hypertext Preprocessor): Utilizado para la lógica de negocio, cálculos y manejo de datos.

### Lenguaje Frontend

HTML5, CSS3: Estructura y estilos de la interfaz de usuario.

### Estilización

CSS Personalizado: Diseño limpio y responsivo con aplicación de Flexbox para un footer fijo.

### Estándares de Código

CamelCase (PSR-1/PSR-12): Aplicado consistentemente en nombres de funciones, variables y parámetros para mejorar la legibilidad.

### Arquitectura

Programación Orientada a Objetos (POO): Implementación de clases para modularizar la lógica y las utilidades.

## 3. Información del Grupo y Curso
Curso: Ingeniería Web

Grupo: 1SF-131

Institución: Universidad Tecnológica de Panamá

Kazim Jesse

kazim.jesse@utp.ac.pa

Jose Centella

jose.centella1@utp.ac.pa

## 4. Diseño y Enfoque del Backend
### 4.1. Uso de Programación Orientada a Objetos (POO)
El proyecto utiliza POO para crear una estructura de código modular y reutilizable. La pieza central de esta modularidad es la clase Utils, diseñada para manejar operaciones transversales que son comunes a múltiples problemas, tales como validación y funciones matemáticas.

### 4.2. Métodos Estáticos para Utilidades
Se implementó una clase Utils que contiene exclusivamente métodos estáticos. Esto permite invocar funciones de propósito general sin necesidad de instanciar la clase, facilitando su uso en cualquier punto del proyecto:

•	limpiar() Limpia una cadena de espacios iniciales/finales y la sanitiza usando htmlspecialchars para prevenir XSS.Sanitización y limpieza de texto.
•	enlaceVolver() Genera una cadena HTML para crear un enlace de navegación.
•	fechaDM() Convierte una fecha en formato ISO (cadena) a un formato de cadena diferente (dd-mm).
•	esEnteroPositivo() Valida si un valor es un número entero positivo (>= 1). Validación de tipo y rango mediante filter_var.
•	esEntero() Valida si un valor representa un número entero. Validación de tipo mediante filter_var.
•	esFloatValido() Valida si un valor representa un número decimal (float), manejando diferentes formatos de entrada. Validación de tipo mediante filter_var.
•	fechaISO() Verifica si una cadena tiene el formato YYYY-MM-DD y si es una fecha real y válida. Uso de expresiones regulares (preg_match) y función de calendario (checkdate).
•	rangoInt() Verifica si un número entero se encuentra dentro de un rango específico.
•	rangoFloat() Verifica si un número decimal se encuentra dentro de un rango específico.
•	numero() Formatea un número (entero o float) aplicando separadores de miles y decimales para presentación.
•	dinero() Formatea un número como una cantidad monetaria con el símbolo de dólar y dos decimales.

### 4.3. Documentación de Funciones Matemáticas
Para mantener la claridad y la estandarización, las funciones complejas o con lógica especializada fueron documentadas utilizando el formato de comentarios PHPDoc.

calcularPotencia(int $base, int $exponente): int

Calcula la potencia de un número base elevado a un exponente utilizando un bucle for.

calcularRaizCuadrada(float $numero): float

Calcula la raíz cuadrada de un número utilizando la función nativa sqrt() de PHP.

### 4.4. Validación y Sanitización de Datos
El módulo Utils fue crucial para centralizar la seguridad y la robustez del código mediante funciones dedicadas a:

Validación: Determinar si un dato cumple con un tipo o rango esperado.

esNumero(mixed $valor): bool: Verifica si el valor es un número válido.

esEntero(mixed $valor): bool: Verifica si el valor es un número entero.

esPositivo(int $valor): bool: Verifica si el número es positivo.

sanitizarEntero(mixed $valor): int: Convierte y limpia el valor para asegurar que sea un entero seguro para su uso.

sanitizarCadena(string $valor): string: Limpia una cadena eliminando etiquetas HTML y caracteres potencialmente peligrosos.

Este enfoque asegura que todos los datos recibidos del usuario pasen por un proceso uniforme de limpieza y verificación antes de ser procesados por la lógica del programa.
