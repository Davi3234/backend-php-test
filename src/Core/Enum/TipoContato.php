<?php

namespace Core\Enum;

enum TipoContato: int{
    case EMAIL = 1;
    case TELEFONE = 2;

    public function label(): string{
        return match($this) {
            self::EMAIL => 'E-mail',
            self::TELEFONE => 'Telefone',
        };
    }
}
