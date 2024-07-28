<?php declare(strict_types = 0);



/**
 * Problems by severity widget view.
 *
 * @var CView $this
 * @var array $data
 */

use Modules\ProblemswIcons\Widget;

if ($data['filter']['show_type'] == Widget::SHOW_TOTALS) {
	$table = makeSeverityTotals($data)
		->addClass(ZBX_STYLE_BY_SEVERITY_WIDGET)
		->addClass(ZBX_STYLE_TOTALS_LIST)
		->addClass(($data['filter']['layout'] == STYLE_HORIZONTAL)
			? ZBX_STYLE_TOTALS_LIST_HORIZONTAL
			: ZBX_STYLE_TOTALS_LIST_VERTICAL
		);
}
else {
	$filter_severities = (array_key_exists('severities', $data['filter']) && $data['filter']['severities'])
		? $data['filter']['severities']
		: range(TRIGGER_SEVERITY_NOT_CLASSIFIED, TRIGGER_SEVERITY_COUNT - 1);

	$header = [[_x('Host group', 'compact table header'), (new CSpan())->addClass(ZBX_STYLE_ARROW_UP)]];

	for ($severity = TRIGGER_SEVERITY_COUNT - 1; $severity >= TRIGGER_SEVERITY_NOT_CLASSIFIED; $severity--) {
		if (in_array($severity, $filter_severities)) {
			$header[] = CSeverityHelper::getName($severity);
		}
	}

	$hide_empty_groups = array_key_exists('hide_empty_groups', $data['filter'])
		? $data['filter']['hide_empty_groups']
		: 0;

	$group_url = (new CUrl('zabbix.php'))
		->setArgument('action', 'problem.view')
		->setArgument('filter_set', '1')
		->setArgument('show', TRIGGERS_OPTION_RECENT_PROBLEM)
		->setArgument('hostids', array_key_exists('hostids', $data['filter']) ? $data['filter']['hostids'] : null)
		->setArgument('name', array_key_exists('problem', $data['filter']) ? $data['filter']['problem'] : null)
		->setArgument('show_suppressed',
			(array_key_exists('show_suppressed', $data['filter']) && $data['filter']['show_suppressed'] == 1) ? 1 : null
		);

	$table = makeSeverityTable($data, $hide_empty_groups, $group_url)
		->addClass(ZBX_STYLE_BY_SEVERITY_WIDGET)
		->setHeader($header)
		->setHeadingColumn(0);
}

(new CWidgetView($data))
	->addItem($table)
	->show();