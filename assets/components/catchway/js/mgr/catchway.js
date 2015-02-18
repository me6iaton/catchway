var catchway = function (config) {
	config = config || {};
	catchway.superclass.constructor.call(this, config);
};
Ext.extend(catchway, Ext.Component, {
	page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('catchway', catchway);

catchway = new catchway();