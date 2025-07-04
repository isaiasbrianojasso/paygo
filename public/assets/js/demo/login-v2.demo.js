/*
Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 5
Version: 5.1.4
Author: Sean Ngu
Website: http://www.seantheme.com/color-admin/
*/
document.addEventListener('shown.bs.modal', function () {
    const backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) {
        backdrop.classList.add('blur-backdrop');
    }
});

var handleLoginPageChangeBackground = function() {
	var toggleAttr = '[data-toggle="login-change-bg"]';
	var toggleImageAttr = '[data-id="login-cover-image"]';
	var toggleImageSrcAttr = 'data-img';
	var toggleItemClass = '.login-bg-list-item';
	var toggleActiveClass = 'active';

	$(document).on('click', toggleAttr, function(e) {
		e.preventDefault();

		$(toggleImageAttr).css('background-image', 'url(' + $(this).attr(toggleImageSrcAttr) +')');
		$(toggleAttr).closest(toggleItemClass).removeClass(toggleActiveClass);
		$(this).closest(toggleItemClass).addClass(toggleActiveClass);
	});
};

var LoginV2 = function () {
	"use strict";
	return {
		//main function
		init: function () {
			handleLoginPageChangeBackground();
		}
	};
}();

$(document).ready(function() {
	LoginV2.init();
});