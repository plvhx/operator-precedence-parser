<?php

namespace ReversePolish\Stack;

use ReversePolish\Node\Operator as OperatorNode;
use ReversePolish\NodeValidator;

class Operator implements StackInterface
{
	/**
	 * @var array
	 */
	private $operator = [];

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
		if (!$this->validator->isOperator($data['symbol']) &&
			!$this->validator->isOpeningBrace($data['symbol']) &&
			!$this->validator->isClosingBrace($data['symbol'])) {
			throw new \InvalidArgumentException(
				sprintf("Parameter 1 of %s must be a valid operator.", __METHOD__)
			);
		}

		array_push($this->operator, new OperatorNode($data));
	}

	public function pull()
	{
		if (empty($this->operator)) {
			return null;
		}

		if (sizeof($this->operator) > 1) {
			$op = [];

			$pivot = array_pop($this->operator);
			$curr = end($this->operator);

			while (($pivot->getPriority() <= $curr->getPriority() && $pivot->getAssociation() == 'left') ||
				   ($pivot->getPriority() <  $curr->getPriority() && $pivot->getAssociation() == 'right')) {
				array_push($op, array_pop($this->operator));

				$curr = end($this->operator);

				if ($curr === false) {
					break;
				}
			}

			array_push($this->operator, $pivot);

			return $op;
		}
	}

	public function pullUntil($token)
	{
		if (!$this->validator->isOperator($token) &&
			!$this->validator->isOpeningBrace($token) &&
			!$this->validator->isClosingBrace($token)) {
			throw new \InvalidArgumentException(
				sprintf("Parameter 1 of %s must be a valid arithmetic operator or brackets.", __METHOD__)
			);
		}

		if (sizeof($this->operator) > 1) {
			$op = [];

			while (end($this->operator)->getSymbol() !== $token) {
				array_push($op, array_pop($this->operator));
			}

			return $op;
		}
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