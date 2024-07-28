<?php declare(strict_types = 0);



namespace Modules\ProblemswIcons\Actions;

use APP,
	CControllerDashboardWidgetView,
	CControllerResponseData;

use Widgets\ProblemsBySv\Widget;

require_once APP::getRootDir().'/include/blocks.inc.php';

class WidgetView extends CControllerDashboardWidgetView {

	protected function init(): void {
		parent::init();

		$this->addValidationRules([
			'initial_load' => 'in 0,1'
		]);
	}

	protected function doAction(): void {
		$filter = [
			'groupids' => getSubGroups($this->fields_values['groupids']),
			'exclude_groupids' => getSubGroups($this->fields_values['exclude_groupids']),
			'hostids' => $this->fields_values['hostids'],
			'problem' => $this->fields_values['problem'],
			'severities' => $this->fields_values['severities'],
			'show_type' => $this->fields_values['show_type'],
			'layout' => $this->fields_values['layout'],
			'show_suppressed' => $this->fields_values['show_suppressed'],
			'hide_empty_groups' => $this->fields_values['hide_empty_groups'],
			'show_opdata' => $this->fields_values['show_opdata'],
			'ext_ack' => $this->fields_values['ext_ack'],
			'show_timeline' => $this->fields_values['show_timeline'],
			'evaltype' => $this->fields_values['evaltype'],
			'tags' => $this->fields_values['tags']
		];

		$data = getSystemStatusData($filter);

		if ($filter['show_type'] == Widget::SHOW_TOTALS) {
			$data['groups'] = getSystemStatusTotals($data);
		}

		$this->setResponse(new CControllerResponseData([
			'name' => $this->getInput('name', $this->widget->getDefaultName()),
			'initial_load' => (bool) $this->getInput('initial_load', 0),
			'data' => $data,
			'filter' => $filter,
			'user' => [
				'debug_mode' => $this->getDebugMode()
			],
			'allowed' => $data['allowed']
		]));
	}
}