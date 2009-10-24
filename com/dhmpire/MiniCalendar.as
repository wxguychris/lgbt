/***********************************
 * MiniCalendar v1.3
 * 
 * Build Date: 05/24/2008
 * 
 * Adam Jackett
 * adam@darkhousemedia.com
 * www.darkhousemedia.com
 ***********************************/

package com.dhmpire {
	
	import caurina.transitions.Tweener;
	import caurina.transitions.properties.ColorShortcuts;
	import caurina.transitions.properties.DisplayShortcuts;
	import com.dhmpire.SmoothScroller;
	import flash.display.DisplayObject;
	import flash.display.DisplayObjectContainer;
	import flash.display.Sprite;
	import flash.display.Stage;
	import flash.display.MovieClip;
	import flash.display.SimpleButton;
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.MouseEvent;
	import flash.events.TextEvent;
	import flash.filters.GlowFilter;
	import flash.text.TextField;
	import flash.text.TextFieldAutoSize;
	import flash.text.TextFormat;
	import flash.text.TextFormatAlign;
	import flash.text.AntiAliasType;
	import flash.text.StyleSheet;	
	import flash.net.URLLoader;
	import flash.net.URLRequest;
	import XML;
	import XMLList;
	
	public class MiniCalendar extends EventDispatcher {
		
		private var container:DisplayObjectContainer;
		private var stage:Stage;
		private var loader:URLLoader;
		private var xml:XML;
		public var events:Object = new Object();
		private var firstRun:Boolean = true;
		
		private var stylesheet:StyleSheet = new StyleSheet();
		private var textFormat1:TextFormat;
		private var textFormat2:TextFormat;
		private var textFormat2b:TextFormat;
		private var textFormat3:TextFormat;
		private var textFormat4:TextFormat;
		private var textFormat5:TextFormat;
		private var todayStroke:GlowFilter;
		private var todayBackground:Number;
		
		private var dateBackground:Number;
		private var dateStroke:GlowFilter;
		private var dateWidth:Number;
		private var dateHeight:Number;
		
		private var initialDays:Array = new Array("S", "M", "T", "W", "T", "F", "S");
		//private var shortDays:Array = new Array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");
		//private var longDays:Array = new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
		//private var shortMonths:Array = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
		private var longMonths:Array = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		private var monthDays:Array = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
		private var dateFormat:Array = new Array("m", " ", "d", ",", " ", "y");
		private var dateAlign:String = "C";
		
		private var today:Date = new Date();
		private var calendar:Date = new Date(today.fullYear, today.month);
		
		private var incX:Number;
		private var incY:Number;
		private var buffer:Number;
		private var day:Number = 0;
		private var week:Number = 0;
		private var weekStart:Number = 0;
		private var days:Array = new Array();
		
		private var monthLabel:TextField;
		
		private var dayLabels:Sprite = new Sprite();
		
		private var arrowLeft:Sprite;
		private var arrowRight:Sprite;
		private var arrowUp:Sprite;
		private var arrowDown:Sprite;
		
		private var dates:Sprite = new Sprite();
		
		private var eventData:Sprite = new Sprite();
		private var eventPosition:String;
		
		private var dateLabel:TextField;
		private var eventContent:Sprite;
		private var maskContent:Sprite;
		private var scrollContent:Sprite;
		private var eventScroller:SmoothScroller;
		
		private var eventWidth:Number;
		private var eventHeight:Number;
		private var eventPadding:Number;
		private var autoDisplayEvent:Boolean = false;
		
		public function MiniCalendar(objContainer:DisplayObjectContainer, dataURL:String, arrows:Object) {
			
			ColorShortcuts.init();
			DisplayShortcuts.init();
			
			stage = objContainer.stage;
			container = objContainer;
			
			container.addChild(dates);
			Tweener.addTween(eventData, { _autoAlpha: 0, time: 0 } );
			container.addChild(eventData);
			
			for (var istr:String in arrows) {
				switch (istr) {					
					case "left":
						arrowLeft = arrows[istr];
						break;
					case "right":
						arrowRight = arrows[istr];
						break;
					case "up":
						arrowUp = arrows[istr];
						break;
					case "down":
						arrowDown = arrows[istr];
						break;
				}
			}
			
			loader = new URLLoader(new URLRequest(dataURL));
			loader.addEventListener(Event.COMPLETE, initCalendar);
			
		}
		
		private function initCalendar(e:Event):void {
			xml = new XML(e.target.data);
			
			if (xml.settings.stylesheet != undefined) {
				var styleLoader:URLLoader = new URLLoader(new URLRequest(String(xml.settings.stylesheet.text())));
				styleLoader.addEventListener(Event.COMPLETE, styleLoaded);
			}
			
			if (xml.settings.weekFirstDay != undefined) weekStart = Number(xml.settings.weekFirstDay.text());
			if (weekStart > 6) weekStart = 0;
			
			if (xml.settings.dayInitials != undefined) {
				var tempInitials:String = xml.settings.dayInitials.text();
				initialDays = tempInitials.split(",");
			}
			
			if (xml.settings.monthNames != undefined) {
				var tempMonths:String = xml.settings.monthNames.text();
				longMonths = tempMonths.split(",");
			}
			
			if (xml.settings.dateFormat != undefined) {
				var tempFormat:String = xml.settings.dateFormat.text();
				dateFormat = tempFormat.split("");
			}
			
			buffer = Number(xml.settings.datePadding.text());
			incX = Number(xml.settings.dateWidth.text()) + buffer;
			incY = Number(xml.settings.dateHeight.text()) + buffer;
			
			if(xml.settings.dateAlign != undefined) dateAlign = String(xml.settings.dateAlign.text());
			
			textFormat1 = new TextFormat();
			textFormat1.align = TextFormatAlign.CENTER;
			textFormat1.font = xml.settings.monthFontName.text();
			textFormat1.size = xml.settings.monthFontSize.text();
			textFormat1.color = Number("0x"+xml.settings.monthFontColor.text());
			
			textFormat2 = new TextFormat();
			textFormat2.font = xml.settings.dateFontName.text();
			textFormat2.size = xml.settings.dateFontSize.text();
			textFormat2.color = Number("0x" + xml.settings.dateFontColor.text());
			
			textFormat2b = new TextFormat();
			textFormat2b.font = xml.settings.dateFontName.text();
			textFormat2b.size = xml.settings.dateFontSize.text();
			textFormat2b.color = Number("0x" + xml.settings.dateFontColor.text());
			textFormat2b.leading = -2;
			
			switch(dateAlign) {
				case "C":
					textFormat2.align = TextFormatAlign.CENTER;
					break;
				case "TL":
				case "BL":
					textFormat2.align = TextFormatAlign.LEFT;
					textFormat2b.align = TextFormatAlign.LEFT;
					break;
				case "TR":
				case "BR":
					textFormat2.align = TextFormatAlign.RIGHT;
					textFormat2b.align = TextFormatAlign.RIGHT;
					break;
			}
			
			textFormat3 = new TextFormat();
			textFormat3.align = TextFormatAlign.CENTER;
			textFormat3.font = xml.settings.dayFontName.text();
			textFormat3.size = xml.settings.dayFontSize.text();
			textFormat3.color = Number("0x"+xml.settings.dayFontColor.text());
			
			textFormat4 = new TextFormat();
			textFormat4.font = xml.settings.eventTitleFontName.text();
			textFormat4.size = xml.settings.eventTitleFontSize.text();
			textFormat4.color = Number("0x"+xml.settings.eventTitleFontColor.text());
			
			textFormat5 = new TextFormat();
			textFormat5.font = xml.settings.eventDataFontName.text();
			textFormat5.size = xml.settings.eventDataFontSize.text();
			textFormat5.color = Number("0x"+xml.settings.eventDataFontColor.text());
			
			if (xml.settings.todayHighlightColor != undefined) todayStroke = new GlowFilter(Number("0x" + xml.settings.todayHighlightColor.text()), 1, 1.1, 1.1, 10, 2, true);
			if (xml.settings.todayBackgroundColor != undefined) todayBackground = Number("0x" + xml.settings.todayBackgroundColor.text());
			if (xml.settings.dateBackgroundColor != undefined) dateBackground = Number("0x" + xml.settings.dateBackgroundColor.text());
			if (xml.settings.dateHighlightColor != undefined) dateStroke = new GlowFilter(Number("0x" + xml.settings.dateHighlightColor.text()), 1, 1.1, 1.1, 10, 2, true);
			if (xml.settings.dateWidth != undefined) dateWidth = Number(xml.settings.dateWidth.text());
			if (xml.settings.dateHeight!= undefined) dateHeight = Number(xml.settings.dateHeight.text());			
			
			monthLabel = new TextField();
			monthLabel.antiAliasType = AntiAliasType.ADVANCED;
			//monthLabel.autoSize = TextFieldAutoSize.LEFT;
			monthLabel.embedFonts = true;
			monthLabel.width = incX * 7 - buffer;
			monthLabel.height = Number(textFormat1.size) + 4;
			monthLabel.selectable = false;
			monthLabel.defaultTextFormat = textFormat1;
			monthLabel.text = String(longMonths[calendar.month]) + " " + String(calendar.fullYear);
			container.addChild(monthLabel);
			
			for (var j:int = 0; j < initialDays.length; j++) {
				var jx:int = j;
				if (weekStart > 0) jx -= weekStart;
				if (jx < 0) jx += 7;
				var dayLabel:TextField = new TextField();
				dayLabel.antiAliasType = AntiAliasType.ADVANCED;
				dayLabel.embedFonts = true;
				dayLabel.x = incX * jx;
				dayLabel.width = incX - buffer;
				dayLabel.height = Number(textFormat3.size);
				dayLabel.selectable = false;
				dayLabel.defaultTextFormat = textFormat3;
				dayLabel.text = initialDays[jx];
				dayLabels.addChild(dayLabel);
			}
			container.addChild(dayLabels);
			
			dayLabels.y = monthLabel.height + 10;
			
			dates.y = dayLabels.y + dayLabels.height + 10;
			
			arrowLeft.x = (incX - buffer) / 2 - arrowLeft.width / 2;
			arrowLeft.y = monthLabel.height / 2;
			arrowLeft.buttonMode = true;
			arrowLeft.mouseChildren = false;
			arrowLeft.addEventListener(MouseEvent.CLICK, prevMonth);
			
			arrowRight.x = incX * 7 - buffer - (incX - buffer) / 2 + arrowRight.width / 2;
			arrowRight.y = monthLabel.height / 2;
			arrowRight.buttonMode = true;
			arrowRight.mouseChildren = false;
			arrowRight.addEventListener(MouseEvent.CLICK, nextMonth);
			
			container.addChild(arrowLeft);
			container.addChild(arrowRight);
			
			dateLabel = new TextField();
			dateLabel.antiAliasType = AntiAliasType.ADVANCED;
			dateLabel.autoSize = TextFieldAutoSize.LEFT;
			dateLabel.embedFonts = true;
			dateLabel.width = 0;
			dateLabel.selectable = false;
			dateLabel.defaultTextFormat = textFormat4;
			dateLabel.height = dateLabel.textHeight * dateLabel.numLines;
			eventData.addChild(dateLabel);
			
			var txtClose:TextField = new TextField();
			txtClose.antiAliasType = AntiAliasType.ADVANCED;
			txtClose.autoSize = TextFieldAutoSize.LEFT;
			txtClose.embedFonts = true;
			txtClose.width = 0;
			txtClose.height = 0;
			txtClose.selectable = false;
			txtClose.defaultTextFormat = textFormat5;
			txtClose.text = "X";
			
			var hitClose:Sprite = new Sprite();
			hitClose.graphics.beginFill(0);
			hitClose.graphics.drawRect(0, 0, txtClose.width, txtClose.height);
			hitClose.graphics.endFill();
			
			var btnClose:SimpleButton = new SimpleButton(txtClose, txtClose, txtClose, hitClose);
			btnClose.addEventListener(MouseEvent.CLICK, clickClose);
			eventData.addChild(btnClose);
			
			eventWidth = Number(xml.settings.eventWidth.text());
			eventHeight = Number(xml.settings.eventHeight.text());
			eventPadding = Number(xml.settings.eventPadding.text());
			eventPosition= String(xml.settings.eventPosition.text());
			autoDisplayEvent = (Number(xml.settings.autoDisplayEvent.text()) == 1) ? true : false;
			
			eventContent = new Sprite();
			eventContent.y = btnClose.height + 10;
			eventData.addChild(eventContent);
			
			maskContent = new Sprite();
			maskContent.y = eventContent.y;
			maskContent.graphics.beginFill(0);
			maskContent.graphics.drawRect(0, 0, eventWidth, eventHeight);
			maskContent.graphics.endFill();
			eventData.addChild(maskContent);
			
			switch(eventPosition) {
				case "up":
					eventData.y = -(eventHeight) - maskContent.y - eventPadding;
					break;
				case "down":
					eventData.y = dates.y + incY * 6 - buffer + eventPadding;
					break;
				case "left":
					eventData.x = -(eventWidth) - eventPadding;
					break;
				case "right":
				default:
					eventData.x = incX * 7 - buffer + eventPadding;
					break;				
			}
			
			eventContent.mask = maskContent;
			
			btnClose.x = maskContent.x + maskContent.width - btnClose.width;
			
			arrowUp.x = maskContent.width;
			arrowUp.y = maskContent.y;
			arrowUp.buttonMode = true;
			arrowUp.mouseChildren = false;
			arrowUp.addEventListener(MouseEvent.MOUSE_DOWN, scrollUp);
			
			arrowDown.x = maskContent.width;
			arrowDown.y = maskContent.y + maskContent.height;
			arrowDown.buttonMode = true;
			arrowDown.mouseChildren = false;
			arrowDown.addEventListener(MouseEvent.MOUSE_DOWN, scrollDown);
			
			eventData.addChild(arrowUp);
			eventData.addChild(arrowDown);
			
			eventScroller = new SmoothScroller(eventContent, {axis: "y", speed: 4, min: eventContent.y, max: eventContent.y, increment: 40 });
				
			var xmlList:XMLList = xml.item;
			for(var i:int = 0; i < xmlList.length(); i++){
				var tempDate:String = xmlList[i].timestart.text();
				var eDate:Array = tempDate.split("-");
				var eYear:String = "y"+eDate[0];
				var eMonth:String = "m"+eDate[1];
				var eDay:String = "d"+eDate[2];
				if(events[eYear] == undefined) events[eYear] = new Object();
				if(events[eYear][eMonth] == undefined) events[eYear][eMonth] = new Object();
				if(events[eYear][eMonth][eDay] == undefined) events[eYear][eMonth][eDay] = new Array();
				events[eYear][eMonth][eDay].push({title: xmlList[i].title.text(), date: xmlList[i].timestart.text(), description: xmlList[i].description.text(), subTitle: xmlList[i].sub.title.text(), subColor: Number("0x"+xmlList[i].sub.color.text())});
			}
			
			for (var d:int = 1; d <= 31; d++) {
				var cd:MovieClip = new MovieClip();
				
				var cdbg:Sprite = new Sprite();
				if(!isNaN(dateBackground)){
					cdbg.graphics.beginFill(dateBackground);
				} else {
					cdbg.graphics.beginFill(0, 0);
				}
				cdbg.graphics.drawRect(0, 0, dateWidth, dateHeight);
				cdbg.graphics.endFill();
				
				if (dateStroke != null) cd.filters = [dateStroke];
				
				cd.bg = cdbg;
				cd.addChild(cdbg);
				
				var txtLabel:TextField = new TextField();
				txtLabel.name = "tLabel"+String(d);
				txtLabel.antiAliasType = AntiAliasType.ADVANCED;
				txtLabel.autoSize = TextFieldAutoSize.LEFT;
				txtLabel.embedFonts = true;
				txtLabel.width = 0;
				txtLabel.height = 0;
				txtLabel.selectable = false;
				txtLabel.defaultTextFormat = textFormat2;
				txtLabel.text = String(d);
				
				var txtSub:TextField = new TextField();
				txtSub.name = "tSub" + String(d);
				txtSub.multiline = true;
				txtSub.wordWrap = true;
				txtSub.antiAliasType = AntiAliasType.ADVANCED;
				txtSub.embedFonts = true;
				txtSub.width = cd.width;
				txtSub.height = 0;
				txtSub.selectable = false;
				txtSub.defaultTextFormat = textFormat2b;
				
				switch(dateAlign) {
					case "C":
						txtLabel.autoSize = TextFieldAutoSize.CENTER;
						txtLabel.x = cd.width / 2 - txtLabel.width / 2;
						txtLabel.y = cd.height / 2 - txtLabel.height / 2;						
						txtSub.visible = false;
						break;
					case "TL":
						txtSub.autoSize = TextFieldAutoSize.LEFT;
						break;
					case "TR":
						txtLabel.x = cd.width - txtLabel.width;
						txtLabel.autoSize = TextFieldAutoSize.RIGHT;
						txtSub.autoSize = TextFieldAutoSize.RIGHT;
						break;
					case "BL":
						txtLabel.y = cd.height - txtLabel.height;
						txtSub.autoSize = TextFieldAutoSize.LEFT;
						break;
					case "BR":
						txtLabel.x = cd.width - txtLabel.width;
						txtLabel.y = cd.height - txtLabel.height;
						txtLabel.autoSize = TextFieldAutoSize.RIGHT;
						txtSub.autoSize = TextFieldAutoSize.RIGHT;
						break;
				}
				cd.addChild(txtLabel);
				cd.addChild(txtSub);
				
				dates.addChild(cd);
				days.push(cd);
			}
				
			changeCalendar();
			
			this.dispatchEvent(new Event(Event.COMPLETE));
		}

		private function nextMonth(e:MouseEvent):void {
			var month:Number = calendar.month + 1;
			var year:Number = calendar.fullYear;
			if(month == 12){
				month = 0;
				year += 1;
			}
			calendar = new Date(year, month);
			changeCalendar();
		}

		private function prevMonth(e:MouseEvent):void {
			var month:Number = calendar.month - 1;
			var year:Number = calendar.fullYear;
			if(month == -1){
				month = 11;
				year -= 1;
			}
			calendar = new Date(year, month);
			changeCalendar();
		}
		
		private function scrollUp(e:MouseEvent):void {
			eventScroller.scroll("dec");
			stage.addEventListener(MouseEvent.MOUSE_UP, endScroll);
		}
		
		private function scrollDown(e:MouseEvent):void {
			eventScroller.scroll("inc");
			stage.addEventListener(MouseEvent.MOUSE_UP, endScroll);
		}
		
		private function endScroll(e:MouseEvent):void {
			eventScroller.endScroll();
			stage.removeEventListener(MouseEvent.MOUSE_UP, endScroll);
		}
		
		private function changeCalendar():void {
			monthLabel.text = String(longMonths[calendar.month]) + " " + String(calendar.fullYear);
			if(calendar.month == 1) monthDays[1] = (calendar.fullYear % 4 == 0) ? 29 : 28;
			day = calendar.day;
			week = 0;
			var delay:Number = xml.settings.transitionDelay.text();
			for(var d:int = 0; d < 31; d++){
				var cd:MovieClip = days[d];
				
				var dayx:int = day;
				if (weekStart > 0) dayx -= weekStart;
				if (dayx < 0) dayx += 7;
				
				var newX:Number = dayx * incX;
				var newY:Number = week * incY;
				var newAlpha:Number = 0.5;
				if(d >= monthDays[calendar.month]){
					newAlpha = 0;
				} else {
					newAlpha = 0.5;
				}
				//cd.filters = null;
				var isToday:Boolean = false;
				if(calendar.fullYear == today.fullYear && calendar.month == today.month && today.date == d+1){
					if (todayStroke != null) cd.filters = [todayStroke];
					if (!isNaN(todayBackground)) Tweener.addTween(cd.bg, { _color: todayBackground, time: 0.5, transition: "linear" } );
					isToday = true;
				} else {
					if (dateStroke != null) cd.filters = [dateStroke];
					if (!isNaN(dateBackground)) Tweener.addTween(cd.bg, { _color: dateBackground, time: 0.5, transition: "linear" } );
				}
				var xYear:String = "y"+calendar.fullYear;
				var xMonth:String = "m"+zeropad(calendar.month+1, 2);
				var xDay:String = "d"+zeropad(d+1, 2);
				cd.buttonMode = false;
				cd.removeEventListener(MouseEvent.CLICK, clickEvents);
				var txtSub:TextField = cd.getChildByName("tSub" + String(d + 1)) as TextField;
				txtSub.text = "";
				if(events[xYear] != undefined){
					if(events[xYear][xMonth] != undefined){
						if(events[xYear][xMonth][xDay] != undefined){
							newAlpha = 1;
							cd.buttonMode = true;
							cd.mouseChildren = false;
							cd.date = new Array(xYear, xMonth, xDay);
							cd.dateText = dateText(calendar.month, d+1, calendar.fullYear);
							cd.addEventListener(MouseEvent.CLICK, clickEvents);
							if (events[xYear][xMonth][xDay][0].subTitle != undefined) {
								txtSub.text = events[xYear][xMonth][xDay][0].subTitle;
								txtSub.textColor = events[xYear][xMonth][xDay][0].subColor;
								switch(dateAlign) {
									case "TL":
									case "TR":
										txtSub.y = cd.height - txtSub.height;
										break;
								}
							}
							if (firstRun && isToday) {
								getEvents(xYear, xMonth, xDay, cd.dateText);
							}
						}
					}
				}
				if (firstRun) {
					cd.x = newX;
					cd.y = newY;
					cd.alpha = newAlpha;
				} else {
					Tweener.addTween(cd, { x: newX, y: newY, alpha: newAlpha, time: xml.settings.transitionTime.text(), delay: delay * d } );
				}
				day++;
				if(day == 7) day = 0;
				if(day == weekStart) week++;
			}
			
			if (firstRun) firstRun = false;
		}
		
		private function clickEvents(e:MouseEvent):void {
			var btn:MovieClip = e.target as MovieClip;
			getEvents(btn.date[0], btn.date[1], btn.date[2], btn.dateText);
		}
		
		private function styleLoaded(e:Event):void {
			stylesheet.parseCSS(e.target.data);
		}
		
		private function getEvents(eventY:String, eventM:String, eventD:String, dLabel:String):void {
			var xEvents:Array = events[eventY][eventM][eventD];
			
			dateLabel.text = dLabel;
			
			eventScroller.killScroll();
			
			if(scrollContent != null) eventContent.removeChild(scrollContent);
			scrollContent = new Sprite();
			
			for(var i:int = 0; i < xEvents.length; i++){
				
				var txtTitle:TextField = new TextField();
				txtTitle.selectable = false;
				txtTitle.multiline = true;
				txtTitle.wordWrap = true;
				txtTitle.antiAliasType = AntiAliasType.ADVANCED;
				txtTitle.autoSize = TextFieldAutoSize.LEFT;
				txtTitle.embedFonts = true;
				txtTitle.width = maskContent.width - 10;
				txtTitle.height = 0;
				if(i > 0) txtTitle.y = scrollContent.height + 10;
				txtTitle.defaultTextFormat = textFormat4;
				txtTitle.htmlText = xEvents[i].title;
				scrollContent.addChild(txtTitle);
				
				var txtContent:TextField = new TextField();
				txtContent.selectable = false;
				txtContent.multiline = true;
				txtContent.wordWrap = true;
				txtContent.antiAliasType = AntiAliasType.ADVANCED;
				txtContent.autoSize = TextFieldAutoSize.LEFT;
				txtContent.embedFonts = true;
				txtContent.width = maskContent.width - 10;
				txtContent.height = 0;
				txtContent.y = txtTitle.y + txtTitle.height;
				txtContent.defaultTextFormat = textFormat5;
				txtContent.htmlText = xEvents[i].description;
				txtContent.styleSheet = stylesheet;
				scrollContent.addChild(txtContent);
			}
			
			eventContent.addChild(scrollContent);
			eventData.addEventListener(Event.ENTER_FRAME, checkContent);
			
			if(eventData.alpha < 1){
				Tweener.addTween(eventData, {_autoAlpha: 1, time: 0.5, transition: "linear"});
			}
		}
		
		private function checkContent(e:Event):void {
			if(scrollContent.height > maskContent.height){
				arrowUp.visible = arrowDown.visible = true;
				if (eventScroller.max != eventScroller.min - eventContent.height + maskContent.height) {
					eventScroller.max = eventScroller.min - eventContent.height + maskContent.height;
				}
			} else {
				arrowUp.visible = arrowDown.visible = false;
			}
		}
		
		private function clickClose(e:MouseEvent):void {
			Tweener.addTween(eventData, {_autoAlpha: 0, time: 0.5, transition: "linear", onComplete: function(){ eventData.visible = false; }});
		}
		
		private function dateText(dMonth:Number, dDay:Number, dYear:Number):String {
			var dText:String = "";
			for each(var df:* in dateFormat) {
				switch(df) {
					case "F":
						dText += longMonths[dMonth];
						break;
					case "m":
						dText += zeropad(dMonth+1, 2);
						break;
					case "n":
						dText += (dMonth+1);
						break;
					case "d":
						dText += zeropad(dDay, 2);
						break;
					case "j":
						dText += dDay;
						break;
					case "Y":
						dText += dYear;
						break;
					case "y":
						var shortYear:Array = String(dYear).split("");
						dText += shortYear[2];
						dText += shortYear[3];
						break;
					default:
						dText += df;
						break;
				}
			}
			return dText;
		}
		
		private function zeropad(num:Number, len:Number):String {
			var newnum:String = String(num);
			for(var i:int = 0; i < len-newnum.length; i++){
				newnum = "0"+newnum;
			}
			return newnum;
		}
		
	}

}