<?php

namespace ReversePolish\Node;

class Operator implements NodeInterface
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
	public function getSymbol()
	{
		return $this->value['symbol'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAssociation()
	{
		return $this->value['assoc'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getPriority()
	{
		return $this->value['priority'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getNode()
	{
		return $this->getSymbol();
	}
}