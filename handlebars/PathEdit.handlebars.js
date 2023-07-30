(function() {
  var template = Handlebars.template, templates = Handlebars.templates = Handlebars.templates || {};
templates['PathEdit'] = template({"1":function(container,depth0,helpers,partials,data) {
    var helper, lookupProperty = container.lookupProperty || function(parent, propertyName) {
        if (Object.prototype.hasOwnProperty.call(parent, propertyName)) {
          return parent[propertyName];
        }
        return undefined
    };

  return "    <span class=\"caret\">\n        <!--<i class=\"far fa-plus-square\"></i>-->"
    + container.escapeExpression(((helper = (helper = lookupProperty(helpers,"name") || (depth0 != null ? lookupProperty(depth0,"name") : depth0)) != null ? helper : container.hooks.helperMissing),(typeof helper === "function" ? helper.call(depth0 != null ? depth0 : (container.nullContext || {}),{"name":"name","hash":{},"data":data,"loc":{"start":{"line":4,"column":49},"end":{"line":4,"column":57}}}) : helper)))
    + "</span>\n";
},"3":function(container,depth0,helpers,partials,data) {
    var helper, lookupProperty = container.lookupProperty || function(parent, propertyName) {
        if (Object.prototype.hasOwnProperty.call(parent, propertyName)) {
          return parent[propertyName];
        }
        return undefined
    };

  return "    "
    + container.escapeExpression(((helper = (helper = lookupProperty(helpers,"name") || (depth0 != null ? lookupProperty(depth0,"name") : depth0)) != null ? helper : container.hooks.helperMissing),(typeof helper === "function" ? helper.call(depth0 != null ? depth0 : (container.nullContext || {}),{"name":"name","hash":{},"data":data,"loc":{"start":{"line":6,"column":4},"end":{"line":6,"column":12}}}) : helper)))
    + "\n";
},"5":function(container,depth0,helpers,partials,data) {
    var stack1, lookupProperty = container.lookupProperty || function(parent, propertyName) {
        if (Object.prototype.hasOwnProperty.call(parent, propertyName)) {
          return parent[propertyName];
        }
        return undefined
    };

  return "    <ul class=\"nested treeview\">\n"
    + ((stack1 = lookupProperty(helpers,"each").call(depth0 != null ? depth0 : (container.nullContext || {}),(depth0 != null ? lookupProperty(depth0,"subitems") : depth0),{"name":"each","hash":{},"fn":container.program(6, data, 0),"inverse":container.noop,"data":data,"loc":{"start":{"line":42,"column":8},"end":{"line":44,"column":17}}})) != null ? stack1 : "")
    + "    </ul>\n";
},"6":function(container,depth0,helpers,partials,data) {
    var stack1, lookupProperty = container.lookupProperty || function(parent, propertyName) {
        if (Object.prototype.hasOwnProperty.call(parent, propertyName)) {
          return parent[propertyName];
        }
        return undefined
    };

  return ((stack1 = container.invokePartial(lookupProperty(partials,"PathEdit"),depth0,{"name":"PathEdit","hash":{"formid":(depth0 != null ? lookupProperty(depth0,"formid") : depth0),"url":(depth0 != null ? lookupProperty(depth0,"url") : depth0)},"data":data,"indent":"        ","helpers":helpers,"partials":partials,"decorators":container.decorators})) != null ? stack1 : "");
},"compiler":[8,">= 4.3.0"],"main":function(container,depth0,helpers,partials,data) {
    var stack1, helper, alias1=depth0 != null ? depth0 : (container.nullContext || {}), alias2=container.hooks.helperMissing, alias3="function", alias4=container.escapeExpression, lookupProperty = container.lookupProperty || function(parent, propertyName) {
        if (Object.prototype.hasOwnProperty.call(parent, propertyName)) {
          return parent[propertyName];
        }
        return undefined
    };

  return "<li>\n"
    + ((stack1 = lookupProperty(helpers,"if").call(alias1,(depth0 != null ? lookupProperty(depth0,"subitems") : depth0),{"name":"if","hash":{},"fn":container.program(1, data, 0),"inverse":container.program(3, data, 0),"data":data,"loc":{"start":{"line":2,"column":4},"end":{"line":7,"column":11}}})) != null ? stack1 : "")
    + "\n    <button\n        type=\"button\"\n        class=\"btn btn-outline-secondary btn-sm\"\n        data-toggle=\"modal\"\n        data-target=\"#deleteDialogModal\"\n        data-url=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"url") || (depth0 != null ? lookupProperty(depth0,"url") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"url","hash":{},"data":data,"loc":{"start":{"line":14,"column":18},"end":{"line":14,"column":25}}}) : helper)))
    + "\"\n        data-item-id=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"id") || (depth0 != null ? lookupProperty(depth0,"id") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"id","hash":{},"data":data,"loc":{"start":{"line":15,"column":22},"end":{"line":15,"column":28}}}) : helper)))
    + "\"\n        data-form-id=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"formid") || (depth0 != null ? lookupProperty(depth0,"formid") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"formid","hash":{},"data":data,"loc":{"start":{"line":16,"column":22},"end":{"line":16,"column":32}}}) : helper)))
    + "\"\n    >-</button>\n    <button\n        type=\"button\"\n        class=\"btn btn-outline-secondary btn-sm\"\n        data-toggle=\"modal\"\n        data-target=\"#createDialogModal\"\n        data-url=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"url") || (depth0 != null ? lookupProperty(depth0,"url") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"url","hash":{},"data":data,"loc":{"start":{"line":23,"column":18},"end":{"line":23,"column":25}}}) : helper)))
    + "\"\n        data-form-id=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"formid") || (depth0 != null ? lookupProperty(depth0,"formid") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"formid","hash":{},"data":data,"loc":{"start":{"line":24,"column":22},"end":{"line":24,"column":32}}}) : helper)))
    + "\"\n    >+</button>\n    <button\n        type=\"button\"\n        class=\"btn btn-outline-secondary btn-sm\"\n        data-toggle=\"modal\"\n        data-target=\"#createDialogModal\"\n        data-url=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"url") || (depth0 != null ? lookupProperty(depth0,"url") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"url","hash":{},"data":data,"loc":{"start":{"line":31,"column":18},"end":{"line":31,"column":25}}}) : helper)))
    + "\"\n        data-item-id=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"id") || (depth0 != null ? lookupProperty(depth0,"id") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"id","hash":{},"data":data,"loc":{"start":{"line":32,"column":22},"end":{"line":32,"column":28}}}) : helper)))
    + "\"\n        data-form-id=\""
    + alias4(((helper = (helper = lookupProperty(helpers,"formid") || (depth0 != null ? lookupProperty(depth0,"formid") : depth0)) != null ? helper : alias2),(typeof helper === alias3 ? helper.call(alias1,{"name":"formid","hash":{},"data":data,"loc":{"start":{"line":33,"column":22},"end":{"line":33,"column":32}}}) : helper)))
    + "\"\n    >+</button>\n    <!--\n    <i class=\"far fa-file\"></i>\n    <i class=\"far fa-edit\"></i>\n    <i class=\"far fa-trash-alt\"></i>\n    -->\n"
    + ((stack1 = lookupProperty(helpers,"if").call(alias1,(depth0 != null ? lookupProperty(depth0,"subitems") : depth0),{"name":"if","hash":{},"fn":container.program(5, data, 0),"inverse":container.noop,"data":data,"loc":{"start":{"line":40,"column":4},"end":{"line":46,"column":11}}})) != null ? stack1 : "")
    + "</li>\n";
},"usePartial":true,"useData":true});
})();