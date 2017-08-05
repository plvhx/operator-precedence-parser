<?php

namespace ReversePolish;

class Evaluator extends TokenList implements EvaluatorInterface
{
	/**
	 * @var array
	 */
	private $evalStack = [];

	/**
	 * @var TokenReader
	 */
	private $reader;

	/**
	 * @var NodeValidator
	 */
	private $validator;

	public function __construct(
		TokenReader $reader,
		NodeValidator $validator
	) {
		$this->reader = $reader;
		$this->validator = $validator;
	}

	private function append($data)
	{
		array_push($this->evalStack, $data);
	}

	private function pull()
	{
		return (!empty($this->evalStack) ? array_pop($this->evalStack) : null);
	}

	public function evaluate($expr)
	{
		$this->reader->setExpression($expr);

		while (($q = $this->reader->next()) !== '') {
			if ($this->validator->isOperand($q)) {
				$this->append($q);
			}
			else if ($this->validator->isOperator($q)) {
				$o1 = $this->pull();
				$o2 = $this->pull();

				switch ($q) {
					case self::R_TOKEN_PLUS['symbol']:
						$l = floatval($o2) + floatval($o1);
						break;
					case self::R_TOKEN_MINUS['symbol']:
						$l = floatval($o2) - floatval($o1);
						break;
					case self::R_TOKEN_MULTIPLY['symbol']:
						$l = floatval($o2) * floatval($o1);
						break;
					case self::R_TOKEN_DIVIDE['symbol']:
						$l = floatval($o2) / floatval($o1);
						break;
					case self::R_TOKEN_POWER_SIGN['symbol']:
						$l = pow(floatval($o2), floatval($o1));
						break;
				}

				array_push($this->evalStack, $l);
			}
		}

		return array_pop($this->evalStack);
	}
}