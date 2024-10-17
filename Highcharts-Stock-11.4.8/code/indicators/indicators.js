!/**
 * Highstock JS v11.4.8 (2024-08-29)
 *
 * Indicator series type for Highcharts Stock
 *
 * (c) 2010-2024 Pawel Fus, Sebastian Bochan
 *
 * License: www.highcharts.com/license
 */function(t){"object"==typeof module&&module.exports?(t.default=t,module.exports=t):"function"==typeof define&&define.amd?define("highcharts/indicators/indicators",["highcharts","highcharts/modules/stock"],function(e){return t(e),t.Highcharts=e,t}):t("undefined"!=typeof Highcharts?Highcharts:void 0)}(function(t){"use strict";var e=t?t._modules:{};function a(e,a,i,s){e.hasOwnProperty(a)||(e[a]=s.apply(null,i),"function"==typeof CustomEvent&&t.win.dispatchEvent(new CustomEvent("HighchartsModuleLoaded",{detail:{path:a,module:e[a]}})))}a(e,"Stock/Indicators/SMA/SMAIndicator.js",[e["Core/Chart/Chart.js"],e["Core/Series/SeriesRegistry.js"],e["Core/Utilities.js"]],function(t,e,a){let{line:i}=e.seriesTypes,{addEvent:s,fireEvent:n,error:o,extend:r,isArray:l,merge:p,pick:h,splat:u}=a;class c extends i{destroy(){this.dataEventsToUnbind.forEach(function(t){t()}),super.destroy.apply(this,arguments)}getName(){let t=[],e=this.name;return e||((this.nameComponents||[]).forEach(function(e,a){t.push(this.options.params[e]+h(this.nameSuffixes[a],""))},this),e=(this.nameBase||this.type.toUpperCase())+(this.nameComponents?" ("+t.join(", ")+")":"")),e}getValues(t,e){let a=e.period,i=t.xData,s=t.yData,n=s.length,o=[],r=[],p=[],h,u=-1,c=0,d,f=0;if(!(i.length<a)){for(l(s[0])&&(u=e.index?e.index:0);c<a-1;)f+=u<0?s[c]:s[c][u],c++;for(h=c;h<n;h++)f+=u<0?s[h]:s[h][u],d=[i[h],f/a],o.push(d),r.push(d[0]),p.push(d[1]),f-=u<0?s[h-c]:s[h-c][u];return{values:o,xData:r,yData:p}}}init(e,a){let i=this;super.init.call(i,e,a);let n=s(t,"afterLinkSeries",function({isUpdating:t}){if(t)return;let a=!!i.dataEventsToUnbind.length;if(!i.linkedParent)return o("Series "+i.options.linkedTo+" not found! Check `linkedTo`.",!1,e);if(!a&&(i.dataEventsToUnbind.push(s(i.linkedParent,"updatedData",function(){i.recalculateValues()})),i.calculateOn.xAxis&&i.dataEventsToUnbind.push(s(i.linkedParent.xAxis,i.calculateOn.xAxis,function(){i.recalculateValues()}))),"init"===i.calculateOn.chart)i.processedYData||i.recalculateValues();else if(!a){let t=s(i.chart,i.calculateOn.chart,function(){i.recalculateValues(),t()})}},{order:0});i.dataEventsToUnbind=[],i.eventsToUnbind.push(n)}recalculateValues(){let t=[],e=this.points||[],a=(this.xData||[]).length,i=!0,s,o,r,l,p,h,c=this.linkedParent.options&&this.linkedParent.yData&&this.linkedParent.yData.length&&this.getValues(this.linkedParent,this.options.params)||{values:[],xData:[],yData:[]};if(a&&!this.hasGroupedData&&this.visible&&this.points){if(this.cropped){for(this.xAxis&&(l=this.xAxis.min,p=this.xAxis.max),r=this.cropData(c.xData,c.yData,l,p),h=0;h<r.xData.length;h++)t.push([r.xData[h]].concat(u(r.yData[h])));s=c.xData.indexOf(this.xData[0]),o=c.xData.indexOf(this.xData[this.xData.length-1]),-1===s&&o===c.xData.length-2&&t[0][0]===e[0].x&&t.shift(),this.updateData(t)}else(this.updateAllPoints||c.xData.length!==a-1&&c.xData.length!==a+1)&&(i=!1,this.updateData(c.values))}i&&(this.xData=c.xData,this.yData=c.yData,this.options.data=c.values),this.calculateOn.xAxis&&this.processedXData&&(delete this.processedXData,this.isDirty=!0,this.redraw()),this.isDirtyData=!!this.linkedSeries.length,n(this,"updatedData")}processData(){let t=this.options.compareToMain,e=this.linkedParent;super.processData.apply(this,arguments),this.dataModify&&e&&e.dataModify&&e.dataModify.compareValue&&t&&(this.dataModify.compareValue=e.dataModify.compareValue)}}return c.defaultOptions=p(i.defaultOptions,{name:void 0,tooltip:{valueDecimals:4},linkedTo:void 0,compareToMain:!1,params:{index:3,period:14}}),r(c.prototype,{calculateOn:{chart:"init"},hasDerivedData:!0,nameComponents:["period"],nameSuffixes:[],useCommonDataGrouping:!0}),e.registerSeriesType("sma",c),c}),a(e,"Stock/Indicators/EMA/EMAIndicator.js",[e["Core/Series/SeriesRegistry.js"],e["Core/Utilities.js"]],function(t,e){let{sma:a}=t.seriesTypes,{correctFloat:i,isArray:s,merge:n}=e;class o extends a{accumulatePeriodPoints(t,e,a){let i=0,s=0;for(;s<t;)i+=e<0?a[s]:a[s][e],s++;return i}calculateEma(t,e,a,s,n,o,r){let l=t[a-1],p=o<0?e[a-1]:e[a-1][o];return[l,void 0===n?r:i(p*s+n*(1-s))]}getValues(t,e){let a=e.period,i=t.xData,n=t.yData,o=n?n.length:0,r=2/(a+1),l=[],p=[],h=[],u,c,d,f=-1,m=0;if(!(o<a)){for(s(n[0])&&(f=e.index?e.index:0),m=this.accumulatePeriodPoints(a,f,n)/a,d=a;d<o+1;d++)c=this.calculateEma(i,n,d,r,u,f,m),l.push(c),p.push(c[0]),h.push(c[1]),u=c[1];return{values:l,xData:p,yData:h}}}}return o.defaultOptions=n(a.defaultOptions,{params:{index:3,period:9}}),t.registerSeriesType("ema",o),o}),a(e,"Stock/Indicators/MultipleLinesComposition.js",[e["Core/Series/SeriesRegistry.js"],e["Core/Utilities.js"]],function(t,e){var a;let{sma:{prototype:i}}=t.seriesTypes,{defined:s,error:n,merge:o}=e;return function(t){let e=["bottomLine"],a=["top","bottom"],r=["top"];function l(t){return"plot"+t.charAt(0).toUpperCase()+t.slice(1)}function p(t,e){let a=[];return(t.pointArrayMap||[]).forEach(t=>{t!==e&&a.push(l(t))}),a}function h(){let t=this,e=t.pointValKey,a=t.linesApiNames,r=t.areaLinesNames,h=t.points,u=t.options,c=t.graph,d={options:{gapSize:u.gapSize}},f=[],m=p(t,e),x=h.length,y;if(m.forEach((t,e)=>{for(f[e]=[];x--;)y=h[x],f[e].push({x:y.x,plotX:y.plotX,plotY:y[t],isNull:!s(y[t])});x=h.length}),t.userOptions.fillColor&&r.length){let e=f[m.indexOf(l(r[0]))],a=1===r.length?h:f[m.indexOf(l(r[1]))],s=t.color;t.points=a,t.nextPoints=e,t.color=t.userOptions.fillColor,t.options=o(h,d),t.graph=t.area,t.fillGraph=!0,i.drawGraph.call(t),t.area=t.graph,delete t.nextPoints,delete t.fillGraph,t.color=s}a.forEach((e,a)=>{f[a]?(t.points=f[a],u[e]?t.options=o(u[e].styles,d):n('Error: "There is no '+e+' in DOCS options declared. Check if linesApiNames are consistent with your DOCS line names."'),t.graph=t["graph"+e],i.drawGraph.call(t),t["graph"+e]=t.graph):n('Error: "'+e+" doesn't have equivalent in pointArrayMap. To many elements in linesApiNames relative to pointArrayMap.\"")}),t.points=h,t.options=u,t.graph=c,i.drawGraph.call(t)}function u(t){let e,a=[],s=[];if(t=t||this.points,this.fillGraph&&this.nextPoints){if((e=i.getGraphPath.call(this,this.nextPoints))&&e.length){e[0][0]="L",a=i.getGraphPath.call(this,t),s=e.slice(0,a.length);for(let t=s.length-1;t>=0;t--)a.push(s[t])}}else a=i.getGraphPath.apply(this,arguments);return a}function c(t){let e=[];return(this.pointArrayMap||[]).forEach(a=>{e.push(t[a])}),e}function d(){let t=this.pointArrayMap,e=[],a;e=p(this),i.translate.apply(this,arguments),this.points.forEach(i=>{t.forEach((t,s)=>{a=i[t],this.dataModify&&(a=this.dataModify.modifyValue(a)),null!==a&&(i[e[s]]=this.yAxis.toPixels(a,!0))})})}t.compose=function(t){let i=t.prototype;return i.linesApiNames=i.linesApiNames||e.slice(),i.pointArrayMap=i.pointArrayMap||a.slice(),i.pointValKey=i.pointValKey||"top",i.areaLinesNames=i.areaLinesNames||r.slice(),i.drawGraph=h,i.getGraphPath=u,i.toYData=c,i.translate=d,t}}(a||(a={})),a}),a(e,"masters/indicators/indicators.src.js",[e["Core/Globals.js"],e["Stock/Indicators/MultipleLinesComposition.js"]],function(t,e){return t.MultipleLinesComposition=t.MultipleLinesComposition||e,t})});