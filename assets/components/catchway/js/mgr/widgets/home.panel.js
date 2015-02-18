catchway.panel.Home = function (config) {
	config = config || {};
	Ext.apply(config, {
		baseCls: 'modx-formpanel',
		layout: 'anchor',
		/*
		 stateful: true,
		 stateId: 'catchway-panel-home',
		 stateEvents: ['tabchange'],
		 getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
		 */
		hideMode: 'offsets',
		items: [{
			html: '<h2>' + _('catchway') + '</h2>',
			cls: '',
			style: {margin: '15px 0'}
		}, {
			xtype: 'modx-tabs',
			defaults: {border: false, autoHeight: true},
			border: true,
			hideMode: 'offsets',
			items: [{
				title: _('catchway_items'),
				layout: 'anchor',
				items: [{
					html: _('catchway_intro_msg'),
					cls: 'panel-desc',
				}, {
					xtype: 'catchway-grid-items',
					cls: 'main-wrapper',
				}]
			}]
		}]
	});
	catchway.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(catchway.panel.Home, MODx.Panel);
Ext.reg('catchway-panel-home', catchway.panel.Home);
