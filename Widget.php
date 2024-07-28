<?php declare(strict_types = 0);


namespace Modules\ProblemswIcons;

use Zabbix\Core\CWidget;

class Widget extends CWidget {

	public const SHOW_GROUPS = 0;
	public const SHOW_TOTALS = 1;

	public function getDefaultName(): string {
		return _('Problems by severity');
	}
}