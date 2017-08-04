<?php

namespace ReversePolish;

use ReversePolish\Stack\Operand as OperandStack;
use ReversePolish\Stack\Operator as OperatorStack;
use ReversePolish\TokenReader;
use ReversePolish\NodeValidator;
use ReversePolish\ParserUtil;

class Parser extends TokenList
{
	/**
	 * @var array
	 */
	private $parsed = [];

	/**
	 * @var TokenReader
	 */
	private $reader;

	/**
	 * @var OperandStack
	 */
	private $operandStack;

	/**
	 * @var OperatorStack
	 */
	private $operatorStack;

	/**
	 * @var NodeValidator
	 */
	private $validator;

	/**
	 * @var ParserUtil
	 */
	private $util;

	public function __construct(
		OperandStack $operandStack,
		OperatorStack $operatorStack,
		TokenReader $reader,
		NodeValidator $validator,
		ParserUtil $util)
	{
		$this->operandStack = $operandStack;
		$this->operatorStack = $operatorStack;
		$this->reader = $reader;
		$this->validator = $validator;
		$this->util = $util;
	}

	public function parse($expr)
	{
		$this->reader->setExpression($expr);

		while (($q = $this->reader->next()) !== '') {
			if ($this->validator->isOperand($q)) {
				$this->operandStack->append($q);
			}
			else if ($this->validator->isOperator($q)) {
				while (($l = $this->operandStack->pull()) !== null) {
					array_push($this->parsed, $l);
				}

				$this->operatorStack->append($this->util->resolve($this->validator, $q));

				if (!$this->util->hasOpeningBrace($this->operatorStack)) {
					$op = $this->operatorStack->pull();

					if ($op !== null) {
						while (!empty($op)) {
							array_push($this->parsed, array_pop($op));
						}
					}
				}
			}
			else if ($this->validator->isOpeningBrace($q)) {
				$this->operatorStack->append(
					$this->util->resolve($this->validator, self::R_TOKEN_OPENING_BRACE['symbol'])
				);
			}
			else if ($this->validator->isClosingBrace($q)) {
				while (($l = $this->operandStack->pull()) !== null) {
					array_push($this->parsed, $l);
				}

				$op = $this->operatorStack->pullUntil(self::R_TOKEN_OPENING_BRACE['symbol']);

				$this->util->discardOpeningBrace($this->operatorStack);

				if ($op !== null) {
					while (!empty($op)) {
						array_push($this->parsed, array_pop($op));
					}
				}
			}
		}

		while (($l = $this->operandStack->pull()) !== null) {
			array_push($this->parsed, $l);
		}
		
		$tmp = $this->operatorStack->operator;

		while (($l = array_pop($tmp)) !== null) {
			array_push($this->parsed, $l);
		}
	}

	public function compile()
	{
		return join(' ', array_map(function($q) { return $q->getNode(); }, $this->parsed));
	}
}