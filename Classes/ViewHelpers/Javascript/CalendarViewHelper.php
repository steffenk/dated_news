<?php
namespace FalkRoeder\DatedNews\ViewHelpers\Javascript;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Falk Röder <mail@falk-roeder.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * CalendarViewHelper
 * 
 * @package TYPO3
 * @subpackage dated_news
 * @author Falk Röder
 */
class CalendarViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	* Arguments initialization
	*
	* @return void
	*/
	public function initializeArguments() {
		$this->registerArgument('settings', 'mixed', 'settings');
	}

	/**
	* @param \TYPO3\CMS\Extbase\Persistence\QueryResultInterface $objects
	* @return string the needed html markup inklusive javascript
	*/
	public function render() {
 		$settings = $this->arguments['settings'];
 		$uiThemeCustom = $settings['uiThemeCustom'];
 		$uiTheme = $settings['uiTheme'];
 		$tooltipPreStyle = $settings['tooltipPreStyle'];
 		$twentyfourhour = $settings['twentyfourhour'];





		if ($uiTheme === 'custom') {
			$uiTheme = $uiThemeCustom;
		}
		if ($uiTheme != NULL) {
			$GLOBALS['TSFE']->additionalHeaderData['dated_news'] = '<link rel="stylesheet" type="text/css" href="typo3conf/ext/dated_news/Resources/Public/CSS/jqueryThemes/'.$uiTheme.'/jquery-ui.min.css" media="all">';
			$GLOBALS['TSFE']->additionalHeaderData['dated_news1'] = '<link rel="stylesheet" type="text/css" href="typo3conf/ext/dated_news/Resources/Public/CSS/jqueryThemes/'.$uiTheme.'/jquery-ui.theme.min.css" media="all">';
		}

		$lang = $GLOBALS['TSFE']->lang;

		if ($twentyfourhour === '0') {
			$tformat = "timeFormat: 'h(:mm)'";
		} else {
			$twentyfourhour = "timeFormat: 'H(:mm)'";
		}
		$container = '<div id="calendar" class="fc-calendar-container"></div>';
		$js = <<<EOT
			
			
			(function($) {
					newsCalendar = $('#calendar').fullCalendar({
						eventRender: function(event, element) {
					        element.qtip({
				        		style: { 
				        			classes: 'qtip-rounded, qtip-shadow, qtip-cluetip, $tooltipPreStyle' 
				        		},
					        	hide: {
							        delay: 200,
							        fixed: true, 
							        effect: function() { $(this).fadeOut(250); }
							    },
							    position: {
							        viewport: $(window),
							        adjust: {
							            method: 'flip'
							        }
							    },
					            content: function(ev, api){
					            	var title = '<div class="qtip-title"><a href="'+event.uri+'" alt="go to event">'+event.title+'</a></div>';
					            	var desc = event.description ? '<div class="qtip-desc">'+event.description+'</div>' : '' ;
					            	var startDay = event.start.date() > 9 ? event.start.date() : '0'+event.start.date();
					            	var startMonth = event.start.month().length > 8 ? (event.start.month() +1) : '0'+(event.start.month()+1);
					            	if (event.end != null) {
						            	var endDay = event.end.date() > 9 ? '&nbsp;- ' + event.end.date() : '&nbsp;- 0'+event.end.date();
						            	var endMonth = event.end.month().length > 8 ? (event.end.month() +1) : '0'+(event.end.month()+1);
						            	var endTime = event.end.hour()+':'+event.end.minute();
					            	}
					            		
					            	if (event.allDay === false) {
					            		var start = '<div class="qtip-start">'
					            			+'<b>'
					            			+ startDay
					            			+'.'
					            			+startMonth
					            			+'</b> '
					            			+ event.start.hour()+':'+event.start.minute()
					            			+'</div>';
					            		var end = '<div class="qtip-end">'
					            			+'<b>'
					            			+ endDay
					            			+'.'
					            			+endMonth
					            			+'</b> '
					            			+ endTime
					            			+'</div>';
					            	} else {
										var start = '<div class="qtip-start">'
						            		+'<b>'
						            		+ startDay
						            		+'.'
						            		+startMonth
						            		+'</b> '
						            		+'</div>';
						            	var end = '<div class="qtip-end">'
						            		+'<b>'
						            		+ endDay
						            		+'.'
						            		+endMonth
						            		+'</b> '
						            		+'</div>';
					            	}

					            	if (event.end != null) {
					            		return title + start + end + desc;
					            	} else {
					            		return title + start + desc;
					            	}
					            }
					        });
					    },
				        lang: '$lang',
				        height: 'auto',
				        theme : 'true',
						buttonIcons: true, // show the prev/next text
						weekNumbers: false,

			        	timezone : 'none',
			        	$tformat

			    	})
					
					function addAllEvents(){
						for (var key in newsCalendarEvent) {
						  if (newsCalendarEvent.hasOwnProperty(key)) {
							newsCalendar.fullCalendar( 'addEventSource', newsCalendarEvent[key] )	
							//console.log(key)
						  }
						}
					}
					addAllEvents();
					function removeAllEvents(){
						for (var key in newsCalendarEvent) {
						  if (newsCalendarEvent.hasOwnProperty(key)) {
							newsCalendar.fullCalendar( 'removeEventSource', newsCalendarEvent[key] )	
						  }
						}
					}

					$('.dated-news-filter').on('click', function(){
						removeAllEvents();
						$(this).hasClass('dn-checked') ? $(this).removeClass('dn-checked') : $(this).addClass('dn-checked');
						var dnchecked = $('.dated-news-filter.dn-checked');
						// wenn nix gechecked dann alle adden
						if (!dnchecked.length) {
							addAllEvents();
						} else {
							var added =[];
							dnchecked.each(function(){
								var filter = $(this).data('dn-filter');
								for (var key in newsCalendarTags[filter]) {
							  		if (newsCalendarTags[filter].hasOwnProperty(key)) {
							  			//make sure event wasn't added before
							  			if (!added['Event_'+newsCalendarTags[filter][key]]) {
											newsCalendar.fullCalendar( 'addEventSource', newsCalendarEvent['Event_'+newsCalendarTags[filter][key]] )	
								  			added['Event_'+newsCalendarTags[filter][key]] = 1;
							  			}
							  		}
								}		
							}) 
						}

							
						
					})
			})(jQuery);
			jQuery.noConflict(true);
			
EOT;

		$this->templateVariableContainer->add('datedNewsCalendarJS', $js);
		$this->templateVariableContainer->add('datedNewsCalendarHtml', $container);
	}
}