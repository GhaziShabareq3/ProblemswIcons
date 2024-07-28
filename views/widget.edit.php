<?php declare(strict_types = 0);


/**
 * Problems by severity widget form view.
 *
 * @var CView $this
 * @var array $data
 */

$groupids = new CWidgetFieldMultiSelectGroupView($data['fields']['groupids'], $data['captions']['groups']['groupids']);

(new CWidgetFormView($data))
	->addField($groupids)
	->addField(
		new CWidgetFieldMultiSelectGroupView($data['fields']['exclude_groupids'],
			$data['captions']['groups']['exclude_groupids']
		)
	)
	->addField(
		(new CWidgetFieldMultiSelectHostView($data['fields']['hostids'], $data['captions']['hosts']['hostids']))
			->setFilterPreselect(['id' => $groupids->getId(), 'submit_as' => 'groupid'])
	)
	->addField(
		new CWidgetFieldTextBoxView($data['fields']['problem'])
	)
	->addField(
		new CWidgetFieldSeveritiesView($data['fields']['severities'])
	)
	->addField(
		new CWidgetFieldRadioButtonListView($data['fields']['evaltype'])
	)
	->addField(
		new CWidgetFieldTagsView($data['fields']['tags'])
	)
	->addField(
		new CWidgetFieldRadioButtonListView($data['fields']['show_type'])
	)
	->addField(
		new CWidgetFieldRadioButtonListView($data['fields']['layout'])
	)
	->addField(
		new CWidgetFieldRadioButtonListView($data['fields']['show_opdata'])
	)
	->addField(
		new CWidgetFieldCheckBoxView($data['fields']['show_suppressed'])
	)
	->addField(
		new CWidgetFieldCheckBoxView($data['fields']['hide_empty_groups'])
	)
	->addField(
		new CWidgetFieldRadioButtonListView($data['fields']['ext_ack'])
	)
	->addField(
		new CWidgetFieldCheckBoxView($data['fields']['show_timeline'])
	)
	->includeJsFile('widget.edit.js.php')
	->addJavaScript('widget_problemsbysv_form.init();')
	->show();