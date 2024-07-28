<?php declare(strict_types = 0);



namespace Widgets\ProblemswIcons\Includes;

use Zabbix\Widgets\{
	CWidgetField,
	CWidgetForm
};

use Zabbix\Widgets\Fields\{
	CWidgetFieldCheckBox,
	CWidgetFieldMultiSelectGroup,
	CWidgetFieldMultiSelectHost,
	CWidgetFieldRadioButtonList,
	CWidgetFieldSeverities,
	CWidgetFieldTags,
	CWidgetFieldTextBox
};

use Modules\ProblemswIcons\Widget;

/**
 * Problems by severity widget form.
 */
class WidgetForm extends CWidgetForm {

	public function addFields(): self {
		return $this
			->addField(
				new CWidgetFieldMultiSelectGroup('groupids', _('Host groups'))
			)
			->addField(
				new CWidgetFieldMultiSelectGroup('exclude_groupids', _('Exclude host groups'))
			)
			->addField(
				new CWidgetFieldMultiSelectHost('hostids', _('Hosts'))
			)
			->addField(
				new CWidgetFieldTextBox('problem', _('Problem'))
			)
			->addField(
				new CWidgetFieldSeverities('severities', _('Severity'))
			)
			->addField(
				(new CWidgetFieldRadioButtonList('evaltype', _('Tags'), [
					TAG_EVAL_TYPE_AND_OR => _('And/Or'),
					TAG_EVAL_TYPE_OR => _('Or')
				]))->setDefault(TAG_EVAL_TYPE_AND_OR)
			)
			->addField(
				new CWidgetFieldTags('tags')
			)
			->addField(
				(new CWidgetFieldRadioButtonList('show_type', _('Show'), [
					Widget::SHOW_GROUPS => _('Host groups'),
					Widget::SHOW_TOTALS => _('Totals')
				]))->setDefault(Widget::SHOW_GROUPS)
			)
			->addField(
				(new CWidgetFieldRadioButtonList('layout', _('Layout'), [
					STYLE_HORIZONTAL => _('Horizontal'),
					STYLE_VERTICAL => _('Vertical')
				]))
					->setDefault(STYLE_HORIZONTAL)
					->setFlags(
						!array_key_exists('show_type', $this->values)
							|| !$this->values['show_type'] == Widget::SHOW_TOTALS
						? CWidgetField::FLAG_DISABLED
						: 0x00
					)
			)
			->addField(
				(new CWidgetFieldRadioButtonList('show_opdata', _('Show operational data'), [
					OPERATIONAL_DATA_SHOW_NONE => _('None'),
					OPERATIONAL_DATA_SHOW_SEPARATELY => _('Separately'),
					OPERATIONAL_DATA_SHOW_WITH_PROBLEM => _('With problem name')
				]))->setDefault(OPERATIONAL_DATA_SHOW_NONE)
			)
			->addField(
				new CWidgetFieldCheckBox('show_suppressed', _('Show suppressed problems'))
			)
			->addField(
				(new CWidgetFieldCheckBox('hide_empty_groups', _('Hide groups without problems')))
					->setFlags(
						array_key_exists('show_type', $this->values)
							&& $this->values['show_type'] == Widget::SHOW_TOTALS
						? CWidgetField::FLAG_DISABLED
						: 0x00
					)
			)
			->addField(
				(new CWidgetFieldRadioButtonList('ext_ack', _('Problem display'), [
					EXTACK_OPTION_ALL => _('All'),
					EXTACK_OPTION_BOTH => _('Separated'),
					EXTACK_OPTION_UNACK => _('Unacknowledged only')
				]))
					->setDefault(EXTACK_OPTION_ALL)
					->setFlags(CWidgetField::FLAG_ACKNOWLEDGES)
			)
			->addField(
				(new CWidgetFieldCheckBox('show_timeline', _('Show timeline')))->setDefault(ZBX_TIMELINE_ON)
			);
	}
}