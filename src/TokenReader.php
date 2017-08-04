<?php

namespace ReversePolish;

class TokenReader
{
    /**
     * @var integer
     */
    private $offset = 0;

    /**
     * @var string
     */
    private $expr;

    public function setExpression($expr)
    {
        $this->expr = $expr;
    }

    public function next()
    {
        $tmp = '';

        if ($this->offset < strlen($this->expr)) {
            $tmp .= $this->expr[$this->offset++];

            while (isset($this->expr[$this->offset])) {
                if (!ctype_digit($this->expr[$this->offset]) || !ctype_digit($tmp)) {
                    break;
                }

                $tmp .= $this->expr[$this->offset];

                $this->offset++;
            }
        }

        return $tmp;
    }
}
