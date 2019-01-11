// Captura individual de precio de oferta
var system = require('system');
var url = system.args[1];
var page = require("webpage").create();
        page.onError = function(msg, trace) {
        var msgStack = ['ERROR: ' + msg];
        if (trace && trace.length) {
            msgStack.push('TRACE:');
            trace.forEach(function(t) {
                msgStack.push(' -> ' + t.file + ': ' + t.line + (t.function ? ' (in function "' + t.function + '")' : ''));
            });
        }
        // uncomment to log into the console 
        // console.error(msgStack.join('\n'));
        };

        page.open(url, function(status) {
        var precio_oferta = page.evaluate(function() {
        return fbra_browseMainProductConfig.state.product.prices[0].originalPrice;
        });
        console.log(precio_oferta);
        phantom.exit();
        });


        