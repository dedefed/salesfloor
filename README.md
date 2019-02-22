# Test SalesFloor

Test for SalesFloor position
I use Symfony 4 but I'm just add what I need to create command.
It's also more easy to me to do the test, seems I an familiar with the framework.

## Installation
You can edit the command list by editing the file in the root file of the project
```bash
/salesfloor/commands.txt
```

1) step1
```bash
composer_install
```

2) to run the command
```bash
php bin/console app:block-command commands.txt 
```

3) Unit test
```bash
./bin/phpunit
```