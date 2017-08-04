<?php

namespace ReversePolish;

use ReversePolish\TokenList;

class NodeValidator extends TokenList
{
    public function isOperand($operand)
    {
        return ctype_digit($operand);
    }

    public function isOperator($operator)
    {
        if ($operator != self::R_TOKEN_PLUS['symbol'] &&
            $operator != self::R_TOKEN_MINUS['symbol'] &&
            $operator != self::R_TOKEN_MULTIPLY['symbol'] &&
            $operator != self::R_TOKEN_DIVIDE['symbol'] &&
            $operator != self::R_TOKEN_POWER_SIGN['symbol']) {
            return false;
        }

        return true;
    }

    public function isOpeningBrace($symbol)
    {
        return ($symbol === self::R_TOKEN_OPENING_BRACE['symbol'] ? true : false);
    }

    public function isClosingBrace($symbol)
    {
        return ($symbol === self::R_TOKEN_CLOSING_BRACE['symbol'] ? true : false);
    }
}
