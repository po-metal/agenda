webpackJsonp([1],{FfO2:function(t,e){},NHnr:function(t,e,s){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n=s("7+uW"),a=s("mtWM"),r=s.n(a),i=s("n8qV"),o=s("PJh5"),c=s.n(o),l=(s("LT9G"),{name:"day",props:["value"],data:function(){return{day:""}},created:function(){console.log(this.value),this.day=this.value}}),d={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"col-lg-6 col-lg-offset-3"},[s("div",{staticClass:"row"},[t._m(0),t._v(" "),s("div",{staticClass:"col-xs-8"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.day,expression:"day"}],staticClass:"form-control",attrs:{type:"date"},domProps:{value:t.day},on:{input:function(e){e.target.composing||(t.day=e.target.value)}}})]),t._v(" "),t._m(1)])])},staticRenderFns:[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"col-xs-2"},[e("button",{staticClass:"btn material-icons"},[this._v("navigate_before")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"col-xs-2"},[e("button",{staticClass:"btn material-icons"},[this._v("navigate_next")])])}]},u=s("VU/8")(l,d,!1,null,null,null).exports,h={name:"calnedarTd",props:["id","name","hour","parentTop","parentLeft"],components:{Drag:i.Drag,Drop:i.Drop},data:function(){return{}},methods:{handleDrop:function(t){var e=this.$el.getBoundingClientRect().top-this.parentTop,s=this.$el.getBoundingClientRect().left-this.parentLeft+10;void 0!=t.type&&"t"==t.type&&this.$emit("dropForNewEvent",{id:this.id,name:this.name},t.id,this.hour,e,s),void 0!=t.type&&"e"==t.type&&this.$emit("dropForChangeEvent",{id:this.id,name:this.name},t.id,this.hour,e,s)}}},f={render:function(){var t=this.$createElement,e=this._self._c||t;return e("td",{staticClass:"zfc-column-calendar"},[e("drop",{staticClass:"zfc-dropcell",on:{drop:this.handleDrop}})],1)},staticRenderFns:[]};var j=s("VU/8")(h,f,!1,function(t){s("FfO2")},"data-v-b3507f80",null).exports,p={name:"event",props:["date","calendar","ticketId","hour","top","left"],components:{Drag:i.Drag},data:function(){return{id:"",duration:50,title:"",description:""}},created:function(){},methods:{},computed:{getMainClass:function(){return"zfc-event"},getStyle:function(){return"top: "+this.getTop+"px; left: "+this.getLeft+"px; height:"+this.getHeight+"px;"},getTop:function(){return this.top},getLeft:function(){return this.left},start:function(){var t=c()(this._date.format("YYYY-MM-DD")+" "+this.hour);return t},end:function(){var t=c()(this._date.format("YYYY-MM-DD")+" "+this.hour);return t.add(this.duration,"minutes")},getHeight:function(){return this.duration<=30?25:25*Math.ceil(this.duration/30)}}},v={render:function(){var t=this.$createElement,e=this._self._c||t;return e("Drag",{class:this.getMainClass,style:this.getStyle,attrs:{"transfer-data":{id:this.$vnode.key,type:"e"}}},[e("span",[this._v(this._s(this.ticketId))])])},staticRenderFns:[]};var g=s("VU/8")(p,v,!1,function(t){s("jzRq")},"data-v-3ec2505e",null).exports,m={name:"ticket",props:["ticket","event"],components:{Drag:i.Drag,Drop:i.Drop},data:function(){return{obj:{id:"",subject:"",time:60}}},created:function(){this.obj=this.ticket},methods:{},computed:{isDraggable:function(){return null==this.event}}},y={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("drag",{attrs:{"transfer-data":{id:t.obj.id,type:"t"},draggable:t.isDraggable}},[s("div",{staticClass:"zfc-ticket",class:{"zfc-ticket-a":!t.isDraggable}},[t._v("\n        "+t._s(t.obj.id)+" - "+t._s(t.obj.subject)+"\n    ")])])},staticRenderFns:[]};var k=s("VU/8")(m,y,!1,function(t){s("i/0d")},"data-v-6a49dc27",null).exports,z=r.a.create({baseURL:"/calendar/api/",timeout:5e3,headers:{accept:"application/json"}}),b=r.a.create({baseURL:"/zfmapi/",timeout:5e3,headers:{accept:"application/json"}}),C={name:"calendars",components:{day:u,calendarTd:j,event:g,ticket:k,Drag:i.Drag,Drop:i.Drop},data:function(){return{calendars:[],tickets:[],date:c()().locale("es"),events:[],top:0,left:0}},created:function(){this.calendarList(),this.ticketList()},mounted:function(){this.$nextTick(function(){window.addEventListener("resize",this.onResize)}),this.getTop(),this.getLeft()},methods:{calendarList:function(){var t=this;z.get("list").then(function(e){e.data.success&&(t.calendars=e.data.data)})},ticketList:function(){var t=this;b.get("list/ticket").then(function(e){t.tickets=e.data.data})},onResize:function(){this.getTop(),this.getLeft()},getTop:function(){this.top=this.$refs.zfcCalendars.getBoundingClientRect().top},getLeft:function(){this.left=this.$refs.zfcCalendars.getBoundingClientRect().left},onDropForNewEvent:function(t,e,s,n,a){this.events.push({calendar:t,ticketId:e,hour:s,top:n+this.getScrollX()+this.getBodyScrollTop(),left:a+this.getScrollY()+this.getBodyScrollLeft()}),this.getTicketById(e).event=1},onDropForChangeEvent:function(t,e,s,n,a){this.events[e].top=n+this.getScrollX()+this.getBodyScrollTop(),this.events[e].left=a+this.getScrollY()+this.getBodyScrollLeft(),this.events[e].hour=s,this.events[e].calendar=t},getTicketById:function(t){for(var e=0;e<this.tickets.length;e++)if(this.tickets[e].id==t)return this.tickets[e];return null},getScrollX:function(){return this.$refs.zfcCalendars.scrollTop},getScrollY:function(){return this.$refs.zfcCalendars.scrollLeft},getBodyScrollTop:function(){return window.pageYOffset||document.documentElement.scrollTop},getBodyScrollLeft:function(){return window.pageXOffset||document.documentElement.scrollLeft}},computed:{getDate:function(){return this.date.format("YYYY-MM-DD")},getDay:function(){return this.date.day()+1},hasCalendars:function(){return void 0!=this.calendars&&this.calendars.length>0},getStart:function(){var t=null;if(this.hasCalendars)for(var e=0;e<this.calendars.length;++e)if(void 0!=this.calendars[e].schedules.collection)for(var s=0;s<this.calendars[e].schedules.collection.length;++s)this.calendars[e].schedules.collection[s].day==this.getDay&&(this.calendars[e].schedules.collection[s].start<t||null==t)&&(t=this.calendars[e].schedules.collection[s].start);return t},getEnd:function(){var t=null;if(this.hasCalendars)for(var e=0;e<this.calendars.length;++e)if(void 0!=this.calendars[e].schedules.collection)for(var s=0;s<this.calendars[e].schedules.collection.length;++s)this.calendars[e].schedules.collection[s].day==this.getDay&&(this.calendars[e].schedules.collection[s].end>t||null==t)&&(t=this.calendars[e].schedules.collection[s].end);return t},getHours:function(){var t=[];if(this.hasCalendars)for(var e=!0,s=c()(this.getStart,"hh:mm"),n=c()(this.getEnd,"hh:mm");e;)t.push(s.format("hh:mm")),s.add(30,"minutes"),s>=n&&(e=!1);return t}}},_={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"row"},[s("div",{staticClass:"col-lg-2"},[s("h3",[t._v("Tickets")]),t._v(" "),t._l(t.tickets,function(e){return t.tickets?s("ticket",{key:e.id,attrs:{ticket:e,event:e.event}}):t._e()})],2),t._v(" "),s("div",{staticClass:"col-lg-10"},[s("div",{staticClass:"text-center"},[s("day",{model:{value:t.getDate,callback:function(e){t.getDate=e},expression:"getDate"}})],1),t._v(" "),s("div",{staticClass:"clearfix"}),t._v(" "),s("div",{ref:"zfcCalendars",staticClass:"zfc-calendars"},[s("table",{staticClass:"table-bordered table-striped table-responsive  zfc-td"},[s("thead",[s("tr",[s("th",{staticClass:"zfc-column-hours"}),t._v(" "),t._l(t.calendars,function(e){return t.hasCalendars?s("th",{key:e.id,staticClass:"zfc-column-calendar"},[t._v("\n                        "+t._s(e.name)+"\n                    ")]):t._e()})],2)]),t._v(" "),s("tbody",t._l(t.getHours,function(e){return t.hasCalendars?s("tr",{key:e},[s("td",{staticClass:"zfc-column-hours"},[t._v(t._s(e))]),t._v(" "),t._l(t.calendars,function(n){return t.hasCalendars?s("calendarTd",{key:n.id+"-"+e,attrs:{id:n.id,name:n.name,hour:e,parentTop:t.top,parentLeft:t.left},on:{dropForNewEvent:t.onDropForNewEvent,dropForChangeEvent:t.onDropForChangeEvent}}):t._e()})],2):t._e()}))]),t._v(" "),t._l(t.events,function(e,n){return t.events?s("event",{key:n,attrs:{date:t.date,calendar:e.calendar,hour:e.hour,ticketId:e.ticketId,top:e.top,left:e.left}}):t._e()})],2)])])},staticRenderFns:[]};var D={name:"App",components:{calendars:s("VU/8")(C,_,!1,function(t){s("SnLU")},"data-v-32b17288",null).exports},created:function(){}},E={render:function(){var t=this.$createElement,e=this._self._c||t;return e("div",[e("calendars")],1)},staticRenderFns:[]},w=s("VU/8")(D,E,!1,null,null,null).exports,x=s("nqYh");n.a.config.productionTip=!1,n.a.use(x.a),new n.a({el:"#app",components:{App:w,vuescroll:x.a},template:"<App/>"})},SnLU:function(t,e){},"i/0d":function(t,e){},jzRq:function(t,e){},uslO:function(t,e,s){var n={"./af":"3CJN","./af.js":"3CJN","./ar":"3MVc","./ar-dz":"tkWw","./ar-dz.js":"tkWw","./ar-kw":"j8cJ","./ar-kw.js":"j8cJ","./ar-ly":"wPpW","./ar-ly.js":"wPpW","./ar-ma":"dURR","./ar-ma.js":"dURR","./ar-sa":"7OnE","./ar-sa.js":"7OnE","./ar-tn":"BEem","./ar-tn.js":"BEem","./ar.js":"3MVc","./az":"eHwN","./az.js":"eHwN","./be":"3hfc","./be.js":"3hfc","./bg":"lOED","./bg.js":"lOED","./bm":"hng5","./bm.js":"hng5","./bn":"aM0x","./bn.js":"aM0x","./bo":"w2Hs","./bo.js":"w2Hs","./br":"OSsP","./br.js":"OSsP","./bs":"aqvp","./bs.js":"aqvp","./ca":"wIgY","./ca.js":"wIgY","./cs":"ssxj","./cs.js":"ssxj","./cv":"N3vo","./cv.js":"N3vo","./cy":"ZFGz","./cy.js":"ZFGz","./da":"YBA/","./da.js":"YBA/","./de":"DOkx","./de-at":"8v14","./de-at.js":"8v14","./de-ch":"Frex","./de-ch.js":"Frex","./de.js":"DOkx","./dv":"rIuo","./dv.js":"rIuo","./el":"CFqe","./el.js":"CFqe","./en-au":"Sjoy","./en-au.js":"Sjoy","./en-ca":"Tqun","./en-ca.js":"Tqun","./en-gb":"hPuz","./en-gb.js":"hPuz","./en-ie":"ALEw","./en-ie.js":"ALEw","./en-il":"QZk1","./en-il.js":"QZk1","./en-nz":"dyB6","./en-nz.js":"dyB6","./eo":"Nd3h","./eo.js":"Nd3h","./es":"LT9G","./es-do":"7MHZ","./es-do.js":"7MHZ","./es-us":"INcR","./es-us.js":"INcR","./es.js":"LT9G","./et":"XlWM","./et.js":"XlWM","./eu":"sqLM","./eu.js":"sqLM","./fa":"2pmY","./fa.js":"2pmY","./fi":"nS2h","./fi.js":"nS2h","./fo":"OVPi","./fo.js":"OVPi","./fr":"tzHd","./fr-ca":"bXQP","./fr-ca.js":"bXQP","./fr-ch":"VK9h","./fr-ch.js":"VK9h","./fr.js":"tzHd","./fy":"g7KF","./fy.js":"g7KF","./gd":"nLOz","./gd.js":"nLOz","./gl":"FuaP","./gl.js":"FuaP","./gom-latn":"+27R","./gom-latn.js":"+27R","./gu":"rtsW","./gu.js":"rtsW","./he":"Nzt2","./he.js":"Nzt2","./hi":"ETHv","./hi.js":"ETHv","./hr":"V4qH","./hr.js":"V4qH","./hu":"xne+","./hu.js":"xne+","./hy-am":"GrS7","./hy-am.js":"GrS7","./id":"yRTJ","./id.js":"yRTJ","./is":"upln","./is.js":"upln","./it":"FKXc","./it.js":"FKXc","./ja":"ORgI","./ja.js":"ORgI","./jv":"JwiF","./jv.js":"JwiF","./ka":"RnJI","./ka.js":"RnJI","./kk":"j+vx","./kk.js":"j+vx","./km":"5j66","./km.js":"5j66","./kn":"gEQe","./kn.js":"gEQe","./ko":"eBB/","./ko.js":"eBB/","./ky":"6cf8","./ky.js":"6cf8","./lb":"z3hR","./lb.js":"z3hR","./lo":"nE8X","./lo.js":"nE8X","./lt":"/6P1","./lt.js":"/6P1","./lv":"jxEH","./lv.js":"jxEH","./me":"svD2","./me.js":"svD2","./mi":"gEU3","./mi.js":"gEU3","./mk":"Ab7C","./mk.js":"Ab7C","./ml":"oo1B","./ml.js":"oo1B","./mn":"CqHt","./mn.js":"CqHt","./mr":"5vPg","./mr.js":"5vPg","./ms":"ooba","./ms-my":"G++c","./ms-my.js":"G++c","./ms.js":"ooba","./mt":"oCzW","./mt.js":"oCzW","./my":"F+2e","./my.js":"F+2e","./nb":"FlzV","./nb.js":"FlzV","./ne":"/mhn","./ne.js":"/mhn","./nl":"3K28","./nl-be":"Bp2f","./nl-be.js":"Bp2f","./nl.js":"3K28","./nn":"C7av","./nn.js":"C7av","./pa-in":"pfs9","./pa-in.js":"pfs9","./pl":"7LV+","./pl.js":"7LV+","./pt":"ZoSI","./pt-br":"AoDM","./pt-br.js":"AoDM","./pt.js":"ZoSI","./ro":"wT5f","./ro.js":"wT5f","./ru":"ulq9","./ru.js":"ulq9","./sd":"fW1y","./sd.js":"fW1y","./se":"5Omq","./se.js":"5Omq","./si":"Lgqo","./si.js":"Lgqo","./sk":"OUMt","./sk.js":"OUMt","./sl":"2s1U","./sl.js":"2s1U","./sq":"V0td","./sq.js":"V0td","./sr":"f4W3","./sr-cyrl":"c1x4","./sr-cyrl.js":"c1x4","./sr.js":"f4W3","./ss":"7Q8x","./ss.js":"7Q8x","./sv":"Fpqq","./sv.js":"Fpqq","./sw":"DSXN","./sw.js":"DSXN","./ta":"+7/x","./ta.js":"+7/x","./te":"Nlnz","./te.js":"Nlnz","./tet":"gUgh","./tet.js":"gUgh","./tg":"5SNd","./tg.js":"5SNd","./th":"XzD+","./th.js":"XzD+","./tl-ph":"3LKG","./tl-ph.js":"3LKG","./tlh":"m7yE","./tlh.js":"m7yE","./tr":"k+5o","./tr.js":"k+5o","./tzl":"iNtv","./tzl.js":"iNtv","./tzm":"FRPF","./tzm-latn":"krPU","./tzm-latn.js":"krPU","./tzm.js":"FRPF","./ug-cn":"To0v","./ug-cn.js":"To0v","./uk":"ntHu","./uk.js":"ntHu","./ur":"uSe8","./ur.js":"uSe8","./uz":"XU1s","./uz-latn":"/bsm","./uz-latn.js":"/bsm","./uz.js":"XU1s","./vi":"0X8Q","./vi.js":"0X8Q","./x-pseudo":"e/KL","./x-pseudo.js":"e/KL","./yo":"YXlc","./yo.js":"YXlc","./zh-cn":"Vz2w","./zh-cn.js":"Vz2w","./zh-hk":"ZUyn","./zh-hk.js":"ZUyn","./zh-tw":"BbgG","./zh-tw.js":"BbgG"};function a(t){return s(r(t))}function r(t){var e=n[t];if(!(e+1))throw new Error("Cannot find module '"+t+"'.");return e}a.keys=function(){return Object.keys(n)},a.resolve=r,t.exports=a,a.id="uslO"}},["NHnr"]);
//# sourceMappingURL=app.js.map