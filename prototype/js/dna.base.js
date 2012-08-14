/**
* Simple API to Namespace.js (http://code.google.com/p/namespacedotjs/)
**/
window.root = {
    basePageNameSpace: 'dna',
    baseContentWrapper: 'content_wrapper', // must be an id
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
        return $("#" + this.baseContentWrapper + " > div[id^='" + this.basePageNameSpace + "']").attr("id");
    }
};

/**
 * Helper functions that needs to be available accross the entire site
 */
root.myNamespace.create('Base.Helpers', {
    onload_functions: Array(),
    bind_load: function (func)
    {
        this.onload_functions.append(func);
    },
    init: function(){
        for (var idx in this.onload_functions)
        {
            func = this.onload_functions[idx];
            func();
        }
    }
    
    // Add more helper functions here
    
});

/**
 * Special Effects that need to be available accross the entire site
 */
root.myNamespace.create('Base.Effects', {
    // effects that need to be available accross the entire site
});


/**
 * Extend the standard Array object to include an "append" function.
 */
Array.prototype.append = function (elem)
{
    this[this.length] = elem;
};