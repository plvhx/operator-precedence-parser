<?php

namespace ReversePolish;

use ReversePolish\TokenList;

class ParserUtil extends TokenList
{
	public function hasOpeningBrace(Stack\Operator $operatorStack)
	{
		return array_search(
			self::R_TOKEN_OPENING_BRACE['symbol'],
			array_map(function($q) { return $q->getSymbol(); }, $operatorStack->operator),
			true
		);
	}

	public function hasClosingBrace(Stack\Operator $operatorStack)
	{
		return array_search(
			self::R_TOKEN_CLOSING_BRACE['symbol'],
			array_map(function($q) { return $q->getSymbol(); }, $operatorStack->operator),
			true
		);
	}

	public function discardOpeningBrace(Stack\Operator $operatorStack)
	{
		$idx = array_search(
			self::R_TOKEN_OPENING_BRACE['symbol'],
			array_map(function($q) { return $q->getSymbol(); }, $operatorStack->operator),
			true
		);

		if ($idx !== false) {
			$tmp = $operatorStack->operator;

			array_splice($tmp, $idx, 1);

			$operatorStack->operator = $tmp;
		}
	}

	public function discardClosingBrace(Stack\Operator $operatorStack)
	{
		$idx = array_search(
			self::R_TOKEN_CLOSING_BRACE['symbol'],
			array_map(function($q) { return $q->getSymbol(); }, $operatorStack->operator),
			true
		);

		if ($idx !== false) {
			$tmp = $operatorStack->operator;

			array_splice($tmp, $idx, 1);

			$operatorStack->operator = $tmp;
		}
	}

	public function resolve(NodeValidator $validator, $operator)
	{
		if (!$validator->isOperator($operator) &&
			!$validator->isOpeningBrace($operator) &&
			!$validator->isClosingBrace($operator)) {
			throw new \InvalidArgumentException(
				sprintf("Parameter 1 of %s must be a valid operator.", __METHOD__)
			);
		}

		switch ($operator) {
			case self::R_TOKEN_PLUS['symbol']:
				$q = self::R_TOKEN_PLUS;
				break;
			case self::R_TOKEN_MINUS['symbol']:
				$q = self::R_TOKEN_MINUS;
				break;
			case self::R_TOKEN_MULTIPLY['symbol']:
				$q = self::R_TOKEN_MULTIPLY;
				break;
			case self::R_TOKEN_DIVIDE['symbol']:
				$q = self::R_TOKEN_DIVIDE;
				break;
			case self::R_TOKEN_POWER_SIGN['symbol']:
				$q = self::R_TOKEN_POWER_SIGN;
				break;
			case self::R_TOKEN_OPENING_BRACE['symbol']:
				$q = self::R_TOKEN_OPENING_BRACE;
				break;
			case self::R_TOKEN_CLOSING_BRACE['symbol']:
				$q = self::R_TOKEN_CLOSING_BRACE;
				break;
		}

		return $q;
	}
}