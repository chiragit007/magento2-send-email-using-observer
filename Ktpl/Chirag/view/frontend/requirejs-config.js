/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
var config = {
"paths":{
    "jQuery1": "Ktpl_Chirag/js/jquery",
    "jqueryNoConflict": "Ktpl_Chirag/js/jquery.no-conflict",
    "jCarousel": "Ktpl_Chirag/js/jquery.jcarousel.min",
    "jcarousel_slider": "Ktpl_Chirag/js/jcarousel_slider",
	"transitions": "Ktpl_Chirag/js/jcarousel.transitions",
	"modernizr": "Ktpl_Chirag/js/modernizr",
},
"shim":{
        "jCarousel":{
            "deps": ['jQuery1'],
            "exports": 'jQuery'
        }
    }
};