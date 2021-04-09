<?php
include_once('vendor/autoload.php');

class Report
{

	protected $type, $format;
	protected $columns = [], $data = [];
	protected $connect;


	function __construct() {
		if ($connect = (new Connect())->getConnection()) {
			$this->connect = $connect;
		} else {
			die('Error connection');
		}
	}


	/**
	* @param int
	*/
	function setType($type) {
		$method = 'report_' . $type;
		if (!method_exists($this, $method)) {
			print(PHP_EOL . 'Неверный метод' . PHP_EOL);
			return;
		}
		$this->type = $method;
	}


	/**
	* @param int
	*/
	function setFormat($format) {
		$method = 'save_' . $format;
		if (!method_exists($this, $method)) {
			print(PHP_EOL . 'Неверный метод' . PHP_EOL);
			return;
		}
		$this->format = $method;
	}


	function create() {
		if (!$this->format || !$this->type) {
			return 'Неизвестный метод';
		}
		$report = $this->type;
		$save = $this->format;
		$i = 0;

		$this->$report();

		$company_list = array_column($this->data, 'Компания');
                $company_list = array_unique($company_list);
		foreach ($company_list as $company) {
			$this->$report($company);
			$this->$save($company);
			$i++;
		}

		return ($i . ' reports saved');
	}


	protected function save_1($company) {
		$dom = new DOMDocument();

		$dom->encoding = 'utf-8';
		$dom->xmlVersion = '1.0';
		$dom->formatOutput = true;

		$root = $dom->createElement('Report');

		foreach ($this->data as $row) {

			$row_node = $dom->createElement('row');

			foreach ($row as $name => $value) {
				$child_node = $dom->createElement('Name', $name);
				$row_node->appendChild($child_node);
				$child_node = $dom->createElement('Value', $value);
				$row_node->appendChild($child_node);
			}

			$root->appendChild($row_node);

		}

		$dom->appendChild($root);

		$dom->save('reports' . DIRECTORY_SEPARATOR . $company . '-report-' . date('Y-m-d') . '.xml');
	}


	protected function save_2($company) {
		$fp = fopen('reports' . DIRECTORY_SEPARATOR . $company . '-report-' . date('Y-m-d') . '.csv', 'w');
		fputcsv($fp, $this->columns);
		foreach ($this->data as $data) {
			fputcsv($fp, $data);
		}
		fclose($fp);
	}


    protected function save_3($company) {

		file_put_contents('reports' . DIRECTORY_SEPARATOR . $company . '-report-' . date('Y-m-d') . '.json', json_encode($this->data), 8);

	}


	protected function save_4($company) {

		$spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		

		$spreadsheet->getActiveSheet()->fromArray($this->columns, null, 'A1');
		$spreadsheet->getActiveSheet()->fromArray($this->data, null, 'A2');

		$writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('reports' . DIRECTORY_SEPARATOR . $company . '-report-' . date('Y-m-d') . '.xlsx');

	}


	protected function report_1($company = '') {

		$where = '';
		if (!empty($company)) {
			$where = ' WHERE `co`.`name` LIKE \'' . $company . '\'';
		}

		// # Количество всех клиентов, подписанных хоть на один тариф (по компаниям)
		$query = 'SELECT `co`.`name` AS `Компания`, COUNT(`co`.`id`) AS `Кол-во всех клиентов`, NOW() AS `дата формирования отчета`
			FROM `company` AS `co`
			RIGHT JOIN `company_customer_tarif` AS `cct` ON `cct`.`company_id` = `co`.`id`
			LEFT JOIN `customer` AS `cu` ON `cu`.`id` = `cct`.`customer_id` '
			. $where . ' 
			GROUP BY `co`.`id`
			ORDER BY `co`.`name`';

		try {
			$this->data = $this->connect->query($query)->fetchAll(PDO::FETCH_ASSOC);
			$this->columns = ['Компания', 'Кол-во всех клиентов', 'дата формирования отчета'];
		} catch(PDOException $e) {
		}
	}


	protected function report_2($company = '') {

		$where = '';
		if (!empty($company)) {
			$where = ' AND `co`.`name` LIKE \'' . $company . '\'';
		}

		# Количество неактивных клиентов, подписанных на тарифы (по компаниям)
		$query = 'SELECT `co`.`name` AS `Компания`, COUNT(`co`.`id`) AS `Кол-во неактивных клиентов`, NOW() AS `дата формирования отчета`
			FROM `company` AS `co`
			RIGHT JOIN `company_customer_tarif` AS `cct` ON `cct`.`company_id` = `co`.`id`
			LEFT JOIN `customer` AS `cu` ON `cu`.`id` = `cct`.`customer_id`
			RIGHT JOIN `tarif_active` AS `a` ON `a`.`cct_id` = `cct`.`id`
			WHERE (`a`.`is_active` = 0 OR `a`.`date_end` < NOW() ) ' . $where . '
			GROUP BY `co`.`id`
			ORDER BY `co`.`name`';

		try {
			$this->data = $this->connect->query($query)->fetchAll(PDO::FETCH_ASSOC);
			$this->columns = ['Компания', 'Кол-во неактивных клиентов', 'дата формирования отчета'];
		} catch(PDOException $e) {
		}
	}


	protected function report_3($company = '') {
		$where = '';
		if (!empty($company)) {
			$where = ' AND `co`.`name` LIKE \'' . $company . '\'';
		}

		# Список тарифов и количество активных клиентов подписанных на эти тарифы (по компаниям)
		$query = 'SELECT `co`.`name` AS `Компания`, `t`.`name` AS `тариф`, COUNT(`a`.`id`) AS `Кол-во активных клиентов`, NOW() AS `дата формирования отчета`
			FROM `tarif` AS `t`
			LEFT JOIN `company_customer_tarif` AS `cct` ON `cct`.`tarif_id` = `t`.`id`
			LEFT JOIN `company` AS `co` ON `co`.`id` = `cct`.`company_id`
			LEFT JOIN `tarif_active` AS `a` ON `a`.`cct_id` = `cct`.`id`
			WHERE (`a`.`is_active` = 1 AND `a`.`date_end` >= NOW()) ' . $where . '
			GROUP BY `a`.`id`
			ORDER BY `co`.`name`';

		try {
			$this->data = $this->connect->query($query)->fetchAll(PDO::FETCH_ASSOC);
			$this->columns = ['Компания', 'тариф', 'Кол-во активных клиентов', 'дата формирования отчета'];
		} catch(PDOException $e) {
		}
	}

}
?>