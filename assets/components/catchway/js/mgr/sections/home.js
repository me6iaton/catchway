catchway.page.Home = function (config) {
	config = config || {};
	Ext.applyIf(config, {
		components: [{
			xtype: 'catchway-panel-home', renderTo: 'catchway-panel-home-div'
		}]
	});
	catchway.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(catchway.page.Home, MODx.Component);
Ext.reg('catchway-page-home', catchway.page.Home);