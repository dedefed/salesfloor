<?php
	
	namespace App\Tests;
	
	use App\Util\BlockWorldService;
	use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
	
	class BlockWorldServiceTest extends TestCase
	{
		
		
		public function testValidationCommandFailureWithWrongVerb()
		{
			$param = [0 => "mo2ve", 1 => "9", 2 => "onto", 3 => "1"];

			$mock = $this->getMockBuilder(BlockWorldService::class)
				->disableOriginalConstructor()
				->getMock();
			
			$mock->method('isValidCommand')
				->with(
					$this->equalTo($param)
				)
				->willReturn(false);
			
		}
		
		public function testValidationCommandFailureWithWrongPreposition()
		{
			$param = [0 => "move", 1 => "9", 2 => "onto2", 3 => "1"];

			$mock = $this->getMockBuilder(BlockWorldService::class)
				->disableOriginalConstructor()
				->getMock();
			
			$mock->method('isValidCommand')
				->with(
					$this->equalTo($param)
				)
				->willReturn(false);
			
		}
		
		public function testMoveOntoMethod()
		{
			$param = 10;
			$blockWorldService = new BlockWorldService($param);
			$blockWorldService->moveOnto(9, 1);
			$this->assertEquals($blockWorldService->getBlockWorldArray()[1], array(0 => 1, 1 => 9));
			$this->assertEquals($blockWorldService->getBlockWorldArray()[9], array());
		}
		
		public function testMoveOverMethod()
		{
			$param = 10;
			$blockWorldService = new BlockWorldService($param);
			$blockWorldService->moveOver(9, 1);
			$this->assertEquals($blockWorldService->getBlockWorldArray()[1], array(0 => 1, 1 => 9));
			$this->assertEquals($blockWorldService->getBlockWorldArray()[9], array());
		}
		
		public function testPileOntoMethod()
		{
			$param = 10;
			$blockWorldService = new BlockWorldService($param);
			$blockWorldService->moveOver(9, 1);
			$this->assertEquals($blockWorldService->getBlockWorldArray()[1], array(0 => 1, 1 => 9));
			$this->assertEquals($blockWorldService->getBlockWorldArray()[9], array());
		}
		
		public function testPileOverMethod()
		{
			$param = 10;
			$blockWorldService = new BlockWorldService($param);
			$blockWorldService->pileOver(9, 1);
			$this->assertEquals($blockWorldService->getBlockWorldArray()[1], array(0 => 1, 1 => 9));
			$this->assertEquals($blockWorldService->getBlockWorldArray()[9], array());
		}
	}