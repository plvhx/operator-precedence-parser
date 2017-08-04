<?php

namespace ReversePolish\Stack;

interface StackInterface
{
    /**
     * Push data onto the stack.
     *
     * @param mixed $data
     * @return void
     */
    public function append($data);

    /**
     * Pop data from the stack.
     *
     * @return mixed
     */
    public function pull();
}
