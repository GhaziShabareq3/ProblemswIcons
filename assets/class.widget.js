

class CWidgetProblemsBySv extends CWidget {

	static SHOW_GROUPS = 0;
	static SHOW_TOTALS = 1;

	_registerEvents() {
		super._registerEvents();

		this._events = {
			...this._events,

			acknowledgeCreated: (e, response) => {
				clearMessages();
				addMessage(makeMessageBox('good', [], response.success.title));

				if (this._state === WIDGET_STATE_ACTIVE) {
					this._startUpdating();
				}
			}
		}
	}

	_activateEvents() {
		super._activateEvents();

		$.subscribe('acknowledge.create', this._events.acknowledgeCreated);
	}

	_deactivateEvents() {
		super._deactivateEvents();

		$.unsubscribe('acknowledge.create', this._events.acknowledgeCreated);
	}

	_hasPadding() {
		return this._view_mode == ZBX_WIDGET_VIEW_MODE_NORMAL
			&& this._fields.show_type != CWidgetProblemsBySv.SHOW_TOTALS;
	}
}