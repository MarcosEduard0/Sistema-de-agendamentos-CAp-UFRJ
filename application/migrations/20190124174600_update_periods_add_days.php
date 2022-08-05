<?php defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'third_party/simple_bitmask.php');

class Migration_Update_periods_add_days extends CI_Migration
{

	public function up()
	{
		$fields = array(
			'day_1' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
				'unsigned' => TRUE,
				'default' => 0,
				'after' => 'bookable',
			),
			'day_2' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
				'unsigned' => TRUE,
				'default' => 0,
				'after' => 'day_1',
			),
			'day_3' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
				'unsigned' => TRUE,
				'default' => 0,
				'after' => 'day_2',
			),
			'day_4' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
				'unsigned' => TRUE,
				'default' => 0,
				'after' => 'day_3',
			),
			'day_5' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
				'unsigned' => TRUE,
				'default' => 0,
				'after' => 'day_4',
			),
			'day_6' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
				'unsigned' => TRUE,
				'default' => 0,
				'after' => 'day_5',
			),
			'day_7' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
				'unsigned' => TRUE,
				'default' => 0,
				'after' => 'day_6',
			),
		);

		$this->dbforge->add_column('periods', $fields);

		$this->migrate_periods_data();
	}


	public function down()
	{
	}


	private function migrate_periods_data()
	{
		$periods = $this->db->get('periods')->result_array();
		$days = $this->get_days();

		foreach ($periods as $period) {
			$update = array();

			$bitmask = new SimpleBitmask(array_keys($days));
			$days_bitmask = $bitmask->getOptions($period['days']);

			foreach ($days_bitmask as $day => $set) {
				if ($day == 0) continue;
				if ($set) {
					$update["day_{$day}"] = 1;
				}
			}

			if (empty($update)) {
				continue;
			}

			$this->db->update('periods', $update, "period_id = {$period['period_id']}", 1);
		}
	}


	private function get_days()
	{
		$days = array();

		$tables = $this->db->list_tables();
		if (in_array('school', $tables)) {
			$days[0] = '';
		}

		$days[1] = 'Segunda-Feira';
		$days[2] = 'Terça-Feira';
		$days[3] = 'Quarta-Feira';
		$days[4] = 'Quinta-Feira';
		$days[5] = 'Sexta-Feira';
		$days[6] = 'Sábado';
		$days[7] = 'Domingo';

		return $days;
	}
}
