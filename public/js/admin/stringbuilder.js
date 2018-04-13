/**
 * Created by steve Samson <stevee.samson@gmail.com> on 2/10/14.
 */

(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define([], factory);
    } else if (typeof module === 'object' && module.exports) {
        module.exports = factory();
    } else {
        root.stringbuilder = factory();
    }
}(this, function () {

    return function(initialString){
        var content = [];
        (initialString && content.push(initialString));

        return {
            append:function(text){
                content.push(text);
                this.length = content.length;
                return this;
            },
            length:content.length,
            toString:function(){
                return content.join('');
            }
        };

    };

}));
