<?php
print(PHP_EOL);
print('*****************************************************************************');
print(PHP_EOL);
print('* консольный php-скрипт для формирования отчетов компаний в разных форматах *');
print(PHP_EOL);
print('*****************************************************************************');

include_once('Connect.php');
include_once('Report.php');
$report = new Report();

do {

	do {
		print(PHP_EOL . PHP_EOL);
		print('[1] - Количество всех клиентов, подписанных хоть на один тариф');
		print(PHP_EOL);
		print('[2] - Количество неактивных клиентов, подписанных на тарифы');
		print(PHP_EOL);
		print('[3] - Список тарифов и количество активных клиентов подписанных на эти тарифы');
		print(PHP_EOL);
		print('[0] - Выход');
		print(PHP_EOL . PHP_EOL);

		$r = readline('Выберите отчет: ');

		switch ($r) {
			case 0:
				print('Выход');
				exit(0);
				break 3;
			case 1:
			case 2:
			case 3:
				break 2;
			default:
				print('Пожалуйста, выберите цифру из вариантов');
				break;
		}

	} while (true);


	do {
		print(PHP_EOL . PHP_EOL);
		print('[1] - XML');
		print(PHP_EOL);
		print('[2] - CSV');
		print(PHP_EOL);
		print('[3] - JSON');
		print(PHP_EOL);
		print('[4] - Excel');
		print(PHP_EOL);
		print('[0] - Вернуться в предыдущее меню');
		print(PHP_EOL . PHP_EOL);

		$f = readline('Выберите формат отчета: ');

		switch ($f) {
			case 0:
				break 2;
			case 1:
			case 2:
			case 3:
			case 4:
				$report->setType($r);
				$report->setFormat($f);
				print($report->create());
				break;
			default:
				print('Пожалуйста, выберите цифру из вариантов');
				break;
		}

	} while (true);
	

	
} while (true);

?>