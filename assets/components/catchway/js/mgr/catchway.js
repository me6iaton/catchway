Ext.ComponentMgr.onAvailable('modx-resource-main-right', function () {
  var mainPanel = Ext.getCmp('modx-panel-resource')
    , data = mainPanel.record.properties
    , checked = false;
  if (data && data.catchway && (data.catchway.catchway_city === "1")) {
    checked = true;
  }
  this.on('afterRender', function () {
    this.add({
      xtype: 'xcheckbox',
      boxLabel: 'Это город',
      description: 'Среди этих ресурсов будет осуществлен поиск при определении города пользователя',
      hideLabel: true,
      name: 'catchway-city',
      id: 'modx-resource-catchway-city',
      inputValue: 1,
      checked: checked,
      onClick: function(e, t){
        var cmp = Ext.getCmp('modx-action-buttons');
        if (cmp) {
          cmp.items.items[0].enable()
        }
      }
    })
  })
});