<?php

namespace App\Util;


class BlockWorldService
{
	CONST MAXVAL = 25;
	private $verbList = ['move', 'pile'];
	private $prepositionList = ['onto', 'over'];
	private $blockWorldArray = [];
	
	public function __construct(int $blockNumber)
	{
		$this->_setBlockWorldArray($blockNumber);
		
	}
	
	/**
	 * @return array
	 */
	public function getBlockWorldArray(): array
	{
		return $this->blockWorldArray;
	}
	
	
	/**
	 * @param int $blockNumber
	 * @throws \Exception
	 */
	private function _setBlockWorldArray(int $blockNumber): void
	{
		if ($blockNumber == 0)
			throw new \Exception("Value have to be superior at 0");
		if ($blockNumber > self::MAXVAL)
			throw new \Exception(sprintf("%d should be inferior or equals to %d",
					$this->blockNumber,
					self::MAXVAL)
			);
		for($i=0; $i < $blockNumber; $i++) {
			$this->blockWorldArray[$i][] = $i;
		}
	}
	
	
	private function _isValidValue(int $valueA, int $valueB) : bool
	{
		if (!is_int($valueA)) {
			return false;
		}
		if (!is_int($valueB)) {
			return false;
		}
		
		if ($valueA == $valueB) {
			return false;
		}
		
		return true;
	}
	
	private function _isValidVerb(string $verb) : bool
	{
		if (!in_array($verb,$this->verbList))
			return false;
		
		return true;
	}
	
	private function _isValidPreposition(string $preposition) : bool
	{
		if (!in_array($preposition,$this->prepositionList))
			return false;
		
		return true;
	}
	
	/**
	 * This function will check if the command and value are valid
	 *
	 * @param array $parsedCommand
	 * @return bool
	 */
	public function isValidCommand(array $parsedCommand) : bool
	{
		if (
			count($parsedCommand) == 4 &&
			$this->_isValidVerb($parsedCommand[0]) &&
			$this->_isValidPreposition($parsedCommand[2]) &&
			$this->_isValidValue($parsedCommand[1], $parsedCommand[3])
		)
			return true;
		
		return false;
	}
	
	/**
	 * Simple function but I decided to create a function
	 * in case of
	 * @param string $cmd
	 * @return array
	 */
	public function splitCmd(string $cmd) : array
	{
		return preg_split('/\s+/', $cmd);
	}
	
	/**
	 * I was not sure how to interact with this action,
	 * it's seem similar to the over so I recall moveOver function
	 *
	 * @param int $a
	 * @param int $b
	 */
	public function moveOnto(int $a, int $b): void
	{
		$this->moveOver($a, $b);
	}
	
	/**
	 * the $blockWorldArray is 2 dimensional array
	 * so I need to find the key of $a and $b to push the data
	 * and I clean the key A
	 * @param int $a
	 * @param int $b
	 */
	public function moveOver(int $a, int $b): void
	{
		$aLocatedKey = null;
		$bLocatedKey = null;
		foreach ($this->blockWorldArray as $num => $valueList) {
			if(is_array($valueList)) {
				
				foreach ($valueList as $key => $value) {
					if ($value == $b) {
						$bLocatedKey = $num;
					}
					if ($value == $a) {
						$aLocatedKey = $num;
					}
				}
			}
			
		}
		array_push($this->blockWorldArray[$bLocatedKey], $a);
		$this->clearContent($aLocatedKey);
	}
	
	/**
	 * Same as Move over and Move onto, I don't really understand the difference
	 * I tried every logic in my mind but this one was close to the example
	 * @param int $a
	 * @param int $b
	 */
	public function pileOnto(int $a, int $b): void
	{
		$this->pileOver($a,$b);
	}
	
	/**
	 * I tried to find every value equal to $a and $b on this logic
	 * and pile the data after finding the key and position of $a and $b
	 * @param int $a
	 * @param int $b
	 */
	public function pileOver(int $a, int $b): void
	{
		$aLocatedKey = null;
		$bLocatedKey = null;
		foreach ($this->blockWorldArray as $num => $valueList) {
			if(is_array($valueList)) {
				
				foreach ($valueList as $key => $value) {
					if ($value == $b) {
						$bLocatedKey = $num;
					}
					if ($value == $a) {
						$aLocatedKey = $num;
					}
				}
			}
			
		}
		
		if ($bLocatedKey == $aLocatedKey) {
			return;
		}
		
		$aPosition = array_search($a,$this->blockWorldArray[$aLocatedKey]);
		$resetValueForLocatedKey = [];
		$pileArrayOfA = [];
		for ($i = 0; $i < $aPosition; $i++) {
			$resetValueForLocatedKey[] = $this->blockWorldArray[$aLocatedKey][$i];
		}
		for ($i = $aPosition; $i < count($this->blockWorldArray[$aLocatedKey]); $i++) {
			$pileArrayOfA[] = $this->blockWorldArray[$aLocatedKey][$i];
		}
		$this->blockWorldArray[$aLocatedKey] = $resetValueForLocatedKey;
		
		foreach ($pileArrayOfA as $value) {
			$this->blockWorldArray[$b][] = $value;
		}
		$this->clearContent($a);
		
	}
	
	/**
	 * @param int $index
	 */
	private function clearContent(int $index) : void
	{
		$this->blockWorldArray[$index] = array();
	}
	
	
}