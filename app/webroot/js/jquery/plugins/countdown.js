/* http://keith-wood.name/countdown.html
   Countdown for jQuery v1.3.0.
   Written by Keith Wood (kbwood@virginbroadband.com.au) January 2008.
   Dual licensed under the GPL (http://dev.jquery.com/browser/trunk/jquery/GPL-LICENSE.txt) and 
   MIT (http://dev.jquery.com/browser/trunk/jquery/MIT-LICENSE.txt) licenses. 
   Please attribute the author if you use it. */
(function($){function Countdown(){this.regional=[];this.regional['']={labels:['Years','Months','Weeks','Days','Hours','Minutes','Seconds'],labelsSingle:['Year','Month','Week','Day','Hour','Minute','Second'],compactLabels:['y','m','w','d'],compactLabelsSingle:['y','m','w','d'],timeSeparator:':'};this._defaults={format:'dHMS',compact:false,description:'',expiryUrl:null,alwaysExpire:false,onExpiry:null,onTick:null,serverTime:null};$.extend(this._defaults,this.regional[''])}var q='countdown';var Y=0;var O=1;var W=2;var D=3;var H=4;var M=5;var S=6;$.extend(Countdown.prototype,{markerClassName:'hasCountdown',setDefaults:function(a){extendRemove(this._defaults,a||{})},_attachCountdown:function(a,b){a=$(a);if(a.is('.'+this.markerClassName)){return}a.addClass(this.markerClassName);if(!a[0].id){a[0].id='cdn'+new Date().getTime()}var c={};c.options=$.extend({},b);c._periods=[0,0,0,0,0,0,0];this._adjustSettings(c);$.data(a[0],q,c);this._updateCountdown(a,c)},_updateCountdown:function(a,b){var c=$(a);b=b||$.data(c[0],q);if(!b){return}c.html(this._generateHTML(b));var d=this._get(b,'onTick');if(d){d.apply(c[0],[b._hold!='lap'?b._periods:this._calculatePeriods(b,b._show,new Date())])}var e=b._hold!='pause'&&(b._since?b._now.getTime()<=b._since.getTime():b._now.getTime()>=b._until.getTime());if(e){if(b._timer||this._get(b,'alwaysExpire')){var f=this._get(b,'onExpiry');if(f){f.apply(c[0],[])}var g=this._get(b,'expiryUrl');if(g){window.location=g}}b._timer=null}else if(b._hold=='pause'){b._time=null}else{var h=this._get(b,'format');b._timer=setTimeout('$.countdown._updateCountdown("#'+c[0].id+'")',(h.match('s|S')?1:(h.match('m|M')?30:600))*980)}$.data(c[0],q,b)},_changeCountdown:function(a,b){var c=$.data(a,q);if(c){extendRemove(c.options,b||{});this._adjustSettings(c);$.data(a,q,c);this._updateCountdown(a,c)}},_destroyCountdown:function(a){a=$(a);if(!a.is('.'+this.markerClassName)){return}a.removeClass(this.markerClassName).empty();var b=$.data(a[0],q);if(b._timer){clearTimeout(b._timer)}$.removeData(a[0],q)},_pauseCountdown:function(a){this._hold(a,'pause')},_lapCountdown:function(a){this._hold(a,'lap')},_resumeCountdown:function(a){this._hold(a,null)},_hold:function(a,b){var c=$.data(a,q);if(c){if(c._hold=='pause'&&!b){c._periods=c._savePeriods;var d=(c._since?'-':'+');c[c._since?'_since':'_until']=this._determineTime(d+c._periods[0]+'Y'+d+c._periods[1]+'O'+d+c._periods[2]+'W'+d+c._periods[3]+'D'+d+c._periods[4]+'H'+d+c._periods[5]+'M'+d+c._periods[6]+'S')}c._hold=b;c._savePeriods=(b=='pause'?c._periods:null);$.data(a,q,c);this._updateCountdown(a,c)}},_getTimesCountdown:function(a){var b=$.data(a,q);return(!b?null:(!b._hold?b._periods:this._calculatePeriods(b,b._show,new Date())))},_get:function(a,b){return(a.options[b]!=null?a.options[b]:$.countdown._defaults[b])},_adjustSettings:function(a){var b=new Date();var c=this._get(a,'serverTime');a._offset=(c?c.getTime()-b.getTime():0);a._since=this._get(a,'since');if(a._since){a._since=this._determineTime(a._since,null)}a._until=this._determineTime(this._get(a,'until'),b);a._show=this._determineShow(a)},_determineTime:function(k,l){var m=function(a){var b=new Date();b.setTime(b.getTime()+a*1000);return b};var n=function(a,b){return 32-new Date(a,b,32).getDate()};var o=function(a){var b=new Date();var c=b.getFullYear();var d=b.getMonth();var e=b.getDate();var f=b.getHours();var g=b.getMinutes();var h=b.getSeconds();var i=/([+-]?[0-9]+)\s*(s|S|m|M|h|H|d|D|w|W|o|O|y|Y)?/g;var j=i.exec(a);while(j){switch(j[2]||'s'){case's':case'S':h+=parseInt(j[1]);break;case'm':case'M':g+=parseInt(j[1]);break;case'h':case'H':f+=parseInt(j[1]);break;case'd':case'D':e+=parseInt(j[1]);break;case'w':case'W':e+=parseInt(j[1])*7;break;case'o':case'O':d+=parseInt(j[1]);e=Math.min(e,n(c,d));break;case'y':case'Y':c+=parseInt(j[1]);e=Math.min(e,n(c,d));break}j=i.exec(a)}b=new Date(c,d,e,f,g,h,0);return b};var p=(k==null?l:(typeof k=='string'?o(k):(typeof k=='number'?m(k):k)));if(p)p.setMilliseconds(0);return p},_generateHTML:function(b){b._periods=periods=(b._hold?b._periods:this._calculatePeriods(b,b._show,new Date()));var c=false;var d=0;for(var e=0;e<b._show.length;e++){c|=(b._show[e]=='?'&&periods[e]>0);b._show[e]=(b._show[e]=='?'&&!c?null:b._show[e]);d+=(b._show[e]?1:0)}var f=this._get(b,'compact');var g=(f?this._get(b,'compactLabels'):this._get(b,'labels'));var h=(f?this._get(b,'compactLabelsSingle'):this._get(b,'labelsSingle'))||g;var i=this._get(b,'timeSeparator');var j=this._get(b,'description')||'';var k=function(a){return(a<10?'0':'')+a};var l=function(a){return(b._show[a]?periods[a]+(periods[a]==1?h[a]:g[a])+' ':'')};var m=function(a){return(b._show[a]?'<div class="countdown_section"><span class="countdown_amount">'+periods[a]+'</span><br/>'+(periods[a]==1?h[a]:g[a])+'</div>':'')};return(f?'<div class="countdown_row countdown_amount'+(b._hold?' countdown_holding':'')+'">'+l(Y)+l(O)+l(W)+l(D)+k(periods[H])+i+k(periods[M])+(b._show[S]?i+k(periods[S]):''):'<div class="countdown_row countdown_show'+d+(b._hold?' countdown_holding':'')+'">'+m(Y)+m(O)+m(W)+m(D)+m(H)+m(M)+m(S))+'</div>'+(j?'<div class="countdown_row countdown_descr">'+j+'</div>':'')},_determineShow:function(a){var b=this._get(a,'format');var c=[];c[Y]=(b.match('y')?'?':(b.match('Y')?'!':null));c[O]=(b.match('o')?'?':(b.match('O')?'!':null));c[W]=(b.match('w')?'?':(b.match('W')?'!':null));c[D]=(b.match('d')?'?':(b.match('D')?'!':null));c[H]=(b.match('h')?'?':(b.match('H')?'!':null));c[M]=(b.match('m')?'?':(b.match('M')?'!':null));c[S]=(b.match('s')?'?':(b.match('S')?'!':null));return c},_calculatePeriods:function(c,d,e){c._now=e;c._now.setMilliseconds(0);var f=new Date(c._now.getTime());if(c._since&&e.getTime()<c._since.getTime()){c._now=e=f}else if(c._since){e=c._since}else{f.setTime(c._until.getTime());if(e.getTime()>c._until.getTime()){c._now=e=f}}f.setTime(f.getTime()-c._offset);var g=[0,0,0,0,0,0,0];if(d[Y]||d[O]){var h=Math.max(0,(f.getFullYear()-e.getFullYear())*12+f.getMonth()-e.getMonth()+(f.getDate()<e.getDate()?-1:0));g[Y]=(d[Y]?Math.floor(h/12):0);g[O]=(d[O]?h-g[Y]*12:0);if(c._since){f.setFullYear(f.getFullYear()-g[Y]);f.setMonth(f.getMonth()-g[O])}else{e=new Date(e.getTime());e.setFullYear(e.getFullYear()+g[Y]);e.setMonth(e.getMonth()+g[O])}}var i=Math.floor((f.getTime()-e.getTime())/1000);var j=function(a,b){g[a]=(d[a]?Math.floor(i/b):0);i-=g[a]*b};j(W,604800);j(D,86400);j(H,3600);j(M,60);j(S,1);return g}});function extendRemove(a,b){$.extend(a,b);for(var c in b){if(b[c]==null){a[c]=null}}return a}$.fn.countdown=function(a){var b=Array.prototype.slice.call(arguments,1);if(a=='getTimes'){return $.countdown['_'+a+'Countdown'].apply($.countdown,[this[0]].concat(b))}return this.each(function(){if(typeof a=='string'){$.countdown['_'+a+'Countdown'].apply($.countdown,[this].concat(b))}else{$.countdown._attachCountdown(this,a)}})};$.countdown=new Countdown()})(jQuery);