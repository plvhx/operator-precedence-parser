<?php

namespace ReversePolish\Stack;

use ReversePolish\Node\Operand as OperandNode;
use ReversePolish\NodeValidator;

class Operand implements StackInterface
{
    /**
     * @var array
     */
    private $operand = [];

    /**
     * @var NodeValidator
     */
    private $validator;

    public function __construct(NodeValidator $validator)
    {
        $this->validator = $validator;
    }

    public function append($data)
    {
        if (!$this->validator->isOperand($data)) {
            throw new \InvalidArgumentException(
                sprintf("Parameter 1 of %s must be a digit.", __METHOD__)
            );
        }

        array_push($this->operand, new OperandNode($data));
    }

    public function pull()
    {
        if (empty($this->operand)) {
            return null;
        }

        return array_pop($this->operand);
    }

    public function __set($name, $value)
    {
        $this->{$name} = $value;
    }

    public function __get($name)
    {
        return $this->{$name};
    }
}
