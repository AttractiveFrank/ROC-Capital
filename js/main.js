'use strict';
// var mainDocument = $(document);

// init foundation
// $(document).foundation();

// Init all plugin when document is ready 
$(document).on('ready', function () {
	// 0. Init console to avoid error
	var method;
	var noop = function () { };
	var methods = [
		'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
		'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
		'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
		'timeStamp', 'trace', 'warn'
	];
	var length = methods.length;
	var console = (window.console = window.console || {});
	var contextWindow = $(window);
	var $root = $('html, body');
	while (length--) {
		method = methods[length];
		// Only stub undefined methods.
		if (!console[method]) {
			console[method] = noop;
		}
	}

	// 1. Background image as data attribut 
	var list = $('.bg-img');
	for (var i = 0; i < list.length; i++) {
		var src = list[i].getAttribute('data-image-src');
		list[i].style.backgroundImage = "url('" + src + "')";
		list[i].style.backgroundRepeat = "no-repeat";
		list[i].style.backgroundPosition = "center";
		list[i].style.backgroundSize = "cover";
	}
	// Image block to Background image 
	var listImgBlock = $('.img-block');
	for (var i = 0; i < listImgBlock.length; i++) {
		var src = listImgBlock[i].getAttribute('src');
		var divBlock = document.createElement("div");
		divBlock.setAttribute("class", "img");
		divBlock.style.backgroundImage = "url('" + src + "')";
		divBlock.style.backgroundRepeat = "no-repeat";
		divBlock.style.backgroundPosition = "center";
		divBlock.style.backgroundSize = "cover";
		$(listImgBlock[i]).after(divBlock);
		listImgBlock[i].style.display = "none";
	}
	// Background color as data attribut
	var listColor = $('.bg-color');
	for (var i = 0; i < listColor.length; i++) {
		var src = listColor[i].getAttribute('data-bgcolor');
		listColor[i].style.backgroundColor = src;
	}

	// 2. Init Coutdown clock
	try {
		// check if clock is initialised
		$('.clock-countdown').downCount({
			date: $('.site-config').attr('data-date'),
			offset: +10
		});
	}
	catch (error) {
		// Clock error : clock is unavailable
		console.log("clock disabled/unavailable");
	}

	// 3. Show/hide menu when icon is clicked
	var menuItems = $('.all-menu-wrapper .nav-link');
	var menuIcon = $('.menu-icon, #navMenuIcon');
	var menuBlock = $('.all-menu-wrapper');
	var clickExit = $('.click-exit');
	var reactToMenu = $('.page-main, .navbar-sidebar, .page-cover')
	var menuLinks = $(".navbar-mainmenu a, .navbar-sidebar a");
	// Menu icon clicked
	menuIcon.on('click', function () {
		menuIcon.toggleClass('menu-visible');
		menuBlock.toggleClass('menu-visible');
		menuItems.toggleClass('menu-visible');
		reactToMenu.toggleClass('menu-visible');
		return false;
	});

	// Hide menu after a menu item clicked
	menuLinks.on('click', function () {
		menuIcon.removeClass('menu-visible');
		menuBlock.removeClass('menu-visible');
		menuItems.removeClass('menu-visible');
		reactToMenu.removeClass('menu-visible');
		return true;
	});
	clickExit.on('click', function () {
		menuIcon.toggleClass('menu-visible');
		menuBlock.toggleClass('menu-visible');
		menuItems.toggleClass('menu-visible');
		reactToMenu.toggleClass('menu-visible');
		return false;
	});

	// 4. Carousel Slider
	// 4.1 Slideshow slider
	var imageList = $('.slide-show .img');
	var imageSlides = [];
	for (var i = 0; i < imageList.length; i++) {
		var src = imageList[i].getAttribute('data-src');
		imageSlides.push({ src: src });
	}
	$('.slide-show').vegas({
		delay: 5000,
		shuffle: true,
		slides: imageSlides,
		animation: ['kenburnsUp', 'kenburnsDown', 'kenburnsLeft', 'kenburnsRight']
	});

	// 5. Init video background
	var videoBg = $('.video-container video, .video-container object');

	// 6. Prepare content for animation
	$('.section .content .anim.anim-wrapped').wrap("<span class='anim-wrapper'></span>");
	if (contextWindow.width() > 768) {
		$('.text-slide-in').each(function () {
			// separates line
			var $t = $(this),
				lines = $.trim($t.html()).split('<br>');

			$t.html('');
			// separate letter
			$.each(lines, function (i, val) {
				$('<span class="line"></span>').appendTo($t);
				val = $("<textarea />").html(val).text();
				var letters = $.trim(val).split('');

				$.each(letters, function (j, v) {
					v = (v == ' ') ? '&nbsp;' : v;
					$('<span class="letter">' + $.trim(v) + '</span>').appendTo($('.line:last', $t));
				});

			});
		});
	}


	// 7. Init fullPage.js plugin
	var pageSectionDivs = $('.page-fullpage .section');
	var headerLogo = $('.header-top .logo');
	var bodySelector = $('body');
	var sectionSelector = $('.section');
	var headerContainer = $('.hh-header');
	var slideElem = $('.slide');
	var arrowElem = $('.p-footer .arrow-d');
	var siteFooter = $('.page-footer');
	var siteHeader = $('.page-header');
	var siteHeaderFooter = $('.page-header,.page-footer,.section-footer, .cover-frame');
	var pageElem = $('.section');
	var pageSections = [];
	var pageAnchors = [];
	var nextSectionDOM;
	var nextSection;
	var fpnavItem;
	var mainPage = $('#mainpage');
	var galleryPage = $('.gallery-main');
	var sendEmailForm = $('.send_email_form');
	var sendMessageForm = $('.send_message_form');
	var scrollOverflow = false;
	var autoScrolling = false;
	var css3 = true;
	var fitToSection = true;
	// disable scroll overflow on small device
	if (contextWindow.width() < 601) {
		scrollOverflow = false;
		css3 = false;
	}
	if (contextWindow.height() < 480) {
		scrollOverflow = false;
		css3 = false;
	}
	if (galleryPage.height() > 1) {
		fitToSection = false;
	}
	if (mainPage.hasClass('scroll-fullpage')) {
		scrollOverflow = true;
		autoScrolling = true;
	}
	// Get sections name
	for (var i = 0; i < pageSectionDivs.length; i++) {
		pageSections.push(pageSectionDivs[i]);
	}
	window.asyncEach(pageSections, function (pageSection, cb) {
		var anchor = pageSection.getAttribute('data-section');
		pageAnchors.push(anchor + "");
		cb();
	}, function (err) {
		// Init plugin
		if (mainPage.width()) {
			// config fullpage.js
			mainPage.fullpage({
				menu: '#qmenu',
				anchors: pageAnchors,
				verticalCentered: false,
				// css3: css3,
				css3: false,
				navigation: true,
				responsiveWidth: 1024,
				responsiveHeight: 480,
				// scrollOverflow: true,
				scrollOverflow: scrollOverflow,
				autoScrolling: autoScrolling,
				fitToSection: fitToSection,
				// scrollOverflow: scrollOverflow,
				scrollOverflowOptions: {
					// scrollbars: false,
					click: false,
					submit: true,
				},
				normalScrollElements: '.section .scrollable',
				afterRender: function () {
					// init parallax 
					var parallaxCover = document.getElementById('parallax-cover')
					if (parallaxCover) {
						if (contextWindow.width() > 1024) {
							var parallaxInstance = new Parallax(parallaxCover);
						}
					}

					// init sliders

					// carousel-alpha : team about us
					new Swiper('.carousel-swiper-alpha-demo .swiper-container', {
						pagination: '.carousel-swiper-alpha-demo .items-pagination',
						paginationClickable: '.carousel-alpha-demo .items-pagination',
						nextButton: '.carousel-swiper-alpha-demo .items-button-next',
						prevButton: '.carousel-swiper-alpha-demo .items-button-prev',
						loop: true,
						grabCursor: true,
						centeredSlides: false,
						autoplay: 5000,
						autoplayDisableOnInteraction: false,
						slidesPerView: 2,
						spaceBetween: 16,
						effect: 'slide',
						breakpoints: {
							440: {
								slidesPerView: 1,
								spaceBetween: 0
							}
						}
					});


					// Fix video background
					videoBg.maximage('maxcover');

					// init contact form
					// Default server url
					var newsletterServerUrl = './ajaxserver/serverfile.php';
					var messageServerUrl = './ajaxserver/serverfile.php';

					// Use form define action attribute
					if (sendEmailForm.attr('action') && (sendEmailForm.attr('action')) != '') {
						newsletterServerUrl = sendEmailForm.attr('action');
					}
					if (sendMessageForm.attr('action') && (sendMessageForm.attr('action') != '')) {
						messageServerUrl = sendMessageForm.attr('action');
					}

					sendEmailForm.initForm({
						serverUrl: newsletterServerUrl,
					});
					sendMessageForm.initForm({
						serverUrl: messageServerUrl,
					});

				},
				afterResize: function () {
					var pluginContainer = $(this);
					$.fn.fullpage.reBuild();
					// uncomment below to force reload windows on screen resize
					/* if (contextWindow.width() > 1023) {
						location.reload();
					} */
				},
				onLeave: function (index, nextIndex, direction) {
					// Behavior when a full page is leaved
					arrowElem.addClass('gone');
					pageElem.addClass('transition');
					slideElem.removeClass('transition');
					pageElem.removeClass('transition');
				},
				afterLoad: function (anchorLink, index) {
					// Behavior after a full page is loaded
					var pageCover = $('.page-cover');
					if (index > 1) {
						if (!pageCover.hasClass('scrolled')) {
							pageCover.addClass('scrolled');
						}
						if (!siteHeader.hasClass('fp-scrolled')) {
							siteHeader.addClass('fp-scrolled');
						}
						if (!siteFooter.hasClass('fp-scrolled')) {
							siteFooter.addClass('fp-scrolled');
						}
					} else {
						pageCover.removeClass('scrolled');
						siteHeader.removeClass('fp-scrolled');
						siteFooter.removeClass('fp-scrolled');
					}
					var activeSection = $('.section.active');
					var fpNav = $('#fp-nav');
					if (!activeSection.hasClass('section-anim')) {
						// uncomment below for onetime animation
						// activeSection.addClass('section-anim');
					}

					// text color by section
					if (activeSection.hasClass('section-text-bright')) {
						// uncomment below for onetime animation
						siteHeaderFooter.addClass('text-bright');
						fpNav.addClass('text-bright');
					} else {
						siteHeaderFooter.removeClass('text-bright');
						fpNav.removeClass('text-bright');
					}

					if (activeSection.hasClass('section-text-dark')) {
						// uncomment below for onetime animation
						siteHeaderFooter.addClass('text-dark');
						fpNav.addClass('text-dark');
					} else {
						siteHeaderFooter.removeClass('text-dark');
						fpNav.removeClass('text-dark');
					}

					if (activeSection.hasClass('content-white')) {
						siteHeaderFooter.addClass('content-white');
						fpNav.addClass('content-white');
					} else {
						siteHeaderFooter.removeClass('content-white');
						fpNav.removeClass('content-white');
					}

					// hide or show clock
					if (activeSection.hasClass('hide-clock')) {
						headerContainer.addClass('gone');
					} else {
						headerContainer.removeClass('gone');
					}
				}
			});
		}
	});
	// Scroll to fullPage.js next/previous section
	$('.scrolldown .down, .scroll.down').on('click', function () {
		try {
			// fullpage scroll
			$.fn.fullpage.moveSectionDown();
		} catch (error) {
			// normal scroll
			$root.animate({
				scrollTop: window.innerHeight
			}, 400, function () {
			});
		}
	});
	$('.scrolldown .up, .scroll.up').on('click', function () {
		try {
			// fullpage scroll
			$.fn.fullpage.moveSectionUp();
		} catch (error) {
			// normal scroll
			$root.animate({
				scrollTop: window.innerHeight
			}, 400, function () {
			});
		}
	});
	// Scroll to fullPage.js next/previous section
	$('.slider-navigation .left').on('click', function () {
		try {
			// fullpage scroll
			$.fn.fullpage.moveSlideLeft();
		} catch (error) {
		}
	});
	$('.slider-navigation .right').on('click', function () {
		try {
			// fullpage scroll
			$.fn.fullpage.moveSlideRight();
		} catch (error) {
		}
	});

	// 8. Hide some ui on scroll
	var scrollHeight = $(document).height() - contextWindow.height();
	contextWindow.on('scroll', function () {
		var scrollpos = $(this).scrollTop();
		var siteHeaderFooter = $('.page-footer, .page-header');

		if (scrollpos > 100 && scrollpos < scrollHeight - 100) {
			// uncomment if btllow for scroll after top only
			// if (scrollpos > 100) {
			siteHeaderFooter.addClass("scrolled");
		}
		else {
			siteHeaderFooter.removeClass("scrolled");
		}
	});


	// 9. Page Loader : hide loader when all are loaded
	contextWindow.on('load', function () {
		$('#page-loader').addClass('p-hidden');
		$('.section').addClass('section-anim');
	});

});

