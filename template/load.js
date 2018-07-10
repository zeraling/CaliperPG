/* 
 * Copyright (C) 2016 Sistemas Radproct
 *
 * Each line should be prefixed with  * 
 */

try{ace.settings.loadState('main-container')}catch(e){}
try{ace.settings.loadState('sidebar')}catch(e){}

if ('ontouchstart' in document.documentElement){
            document.write('<script src="'+baseUrl()+'template/jquery/jquery-migrate-3.0.0.min.js">' + '<' + '/script>');
            document.write('<script src="'+baseUrl()+'template/jquery/jquery.mobile.custom.min.js">' + '<' + '/script>');
}