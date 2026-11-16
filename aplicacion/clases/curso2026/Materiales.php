<?php
 enum Materiales: int
    {
        case Madera = 5;
        case Hierro = 10;
        case Aluminio = 15;
        case Piedra = 20;

        public function etiqueta(): int
        {
            return match ($this) {
                self::Madera => 5,
                self::Hierro => 10,
                self::Aluminio => 15,
                self::Piedra => 20,
            };
        }
    }