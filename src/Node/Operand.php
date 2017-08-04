<?php

namespace ReversePolish\Node;

class Operand implements NodeInterface
{
    /**
     * @var string
     */
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getNode()
    {
        return $this->value;
    }
}
