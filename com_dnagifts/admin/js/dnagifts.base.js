/**
* Simple API to Namespace.js (http://code.google.com/p/namespacedotjs/)
**/
window.root = {
    basePageNameSpace: 'DnaGifts', // first part of the HTML Namespace in the templates
    baseContentWrapper: 'content-box', // must be an id
    myNamespace: {
        /**
        * Create a namespace
        */
        create: function (name, attributes)
        {
            Namespace(name, attributes);
        },
        /**
        * Check if a namespace already exists
        */
        exists: function(name)
        {
            return Namespace.exist(name)
        }
    },
    /**
    * Determine if a page's namespace exists.
    */
    exists_page_namespace: function (namespace)
    {
        page_namespace = root.get_page_namespace();
        return (namespace == page_namespace);
    },
    /**
    * Determine the namespace of a page.
    */ 
    get_page_namespace: function ()
    {
        return jQuery("#" + this.baseContentWrapper + " > div[id^='" + this.basePageNameSpace + "']").attr("id");
    }
};

/**
 * Helper functions that needs to be available accross the entire site
 */
root.myNamespace.create('Base.Helpers', {
    onload_functions: Array(),
    bind_load: function (func)
    {
        this.onload_functions[this.onload_functions.length] = func;
    },
    init: function(){
        jQuery.each(this.onload_functions, function(idx, func){
            func();
        });
    },
    getRecordID: function(formID)
    {
        var actionUrl = jQuery("form#"+formID).attr("action");
        var params = actionUrl.split("?")[1];
        var obj = jQuery.parseParams( params || '' );
        return obj.id;
    },
    deleteOptions: function(elemID)
    {
        jQuery("select#"+elemID+" option").remove();
    },
    appendOption: function(elemID, value, text)
    {
        jQuery('#'+elemID).append(jQuery("<option></option>").attr("value",value).text(text));
    }
});


var BrowserDetect = 
{
    init: function () 
    {
        this.browser = this.searchString(this.dataBrowser) || "Other";
        this.version = this.searchVersion(navigator.userAgent) ||       this.searchVersion(navigator.appVersion) || "Unknown";
    },

    searchString: function (data) 
    {
        for (var i=0 ; i < data.length ; i++)   
        {
            var dataString = data[i].string;
            this.versionSearchString = data[i].subString;

            if (dataString.indexOf(data[i].subString) != -1)
            {
                return data[i].identity;
            }
        }
    },

    searchVersion: function (dataString) 
    {
        var index = dataString.indexOf(this.versionSearchString);
        if (index == -1) return;
        return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
    },

    dataBrowser: 
    [
        { string: navigator.userAgent, subString: "Chrome",  identity: "Chrome" },
        { string: navigator.userAgent, subString: "MSIE",    identity: "Explorer" },
        { string: navigator.userAgent, subString: "Firefox", identity: "Firefox" },
        { string: navigator.userAgent, subString: "Safari",  identity: "Safari" },
        { string: navigator.userAgent, subString: "Opera",   identity: "Opera" },
    ]

};
BrowserDetect.init();


(function($) {
var re = /([^&=]+)=?([^&]*)/g;
var decodeRE = /\+/g; // Regex for replacing addition symbol with a space
var decode = function (str) {return decodeURIComponent( str.replace(decodeRE, " ") );};
jQuery.parseParams = function(query) {
    var params = {}, e;
    while ( e = re.exec(query) ) {
        var k = decode( e[1] ), v = decode( e[2] );
        if (k.substring(k.length - 2) === '[]') {
            k = k.substring(0, k.length - 2);
            (params[k] || (params[k] = [])).push(v);
        }
        else params[k] = v;
    }
    return params;
};
})(jQuery);