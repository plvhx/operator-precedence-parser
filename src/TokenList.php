<?php

namespace ReversePolish;

abstract class TokenList
{
    const R_TOKEN_PLUS = [
        'symbol' => '+',
        'priority' => 2,
        'assoc' => 'left'
    ];

    const R_TOKEN_MINUS = [
        'symbol' => '-',
        'priority' => 2,
        'assoc' => 'left'
    ];

    const R_TOKEN_MULTIPLY = [
        'symbol' => '*',
        'priority' => 3,
        'assoc' => 'left'
    ];

    const R_TOKEN_DIVIDE = [
        'symbol' => '/',
        'priority' => 3,
        'assoc' => 'left'
    ];

    const R_TOKEN_POWER_SIGN = [
        'symbol' => '^',
        'priority' => 4,
        'assoc' => 'right'
    ];

    const R_TOKEN_OPENING_BRACE = [
        'symbol' => '(',
        'priority' => 0,
        'assoc' => 'left'
    ];

    const R_TOKEN_CLOSING_BRACE = [
        'symbol' => ')',
        'priority' => 0,
        'assoc' => 'left'
    ];
}
