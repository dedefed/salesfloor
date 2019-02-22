<?php
/**
 * Created by PhpStorm.
 * User: denissok
 * Date: 2019-02-21
 * Time: 23:19
 */

namespace App\Controller\Command;

use App\Util\BlockWorldService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
class BlockCommand extends Command
{
    protected static $defaultName = 'app:block-command';

    protected function configure()
    {
	    $this->addArgument('filename', InputArgument::REQUIRED);
    }
	
	/**
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 * @return int|void|null
	 * @throws \Exception
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
    {
	    $fileSystem = new Filesystem();
	    $filename = sprintf('./%s', $input->getArgument('filename'));
	    if (!$fileSystem->exists($filename))
	    	throw new \Exception('file not found');
	
	    $cmdList = explode(PHP_EOL, file_get_contents($filename));
	    $blockUtil = new BlockWorldService($cmdList[0]);
	    array_shift($cmdList);
	    foreach($cmdList as $key=> $cmd) {
	    	if ($cmd == 'quit') {
			    foreach ($blockUtil->getBlockWorldArray() as $key => $data) {
				    if (is_array($data)) {
					    $value = implode(" ", $data);
				    } else {
					    $value = $data;
				    }
				
				    $output->writeln(
					    sprintf(
						    '%d:%s ',
						    $key,
						    $value
					    )
				    );
			    }
		    } else {
			    $parseCmd = $blockUtil->splitCmd($cmd);
			    if(!$blockUtil->isValidCommand($parseCmd)) {
				    continue;
			    } else {
				    call_user_func_array(array($blockUtil,$parseCmd[0].ucfirst($parseCmd[2])), array($parseCmd[1], $parseCmd[3]));
			    }
		    }
		    
	    }
	    
    }
}