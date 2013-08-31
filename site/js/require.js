/*
 ***********************************************************/
/**
 * @name          : Joomla HD Video Share
 *** @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component require.js file
 * @Creation Date : March 2010
 * @Modified Date : May 2013
 * */

/*
 ***********************************************************/

var require,define;
(function(){function A(a){return O.call(a)==="[object Function]"}function t(a,b,d){var c=f.plugins.defined[a];if(c)c[d.name].apply(null,d.args);else{c=f.plugins.waiting[a]||(f.plugins.waiting[a]=[]);c.push(d);g(["require/"+a],b.contextName)}}function z(a,b){L.apply(g,a);b.loaded[a[0]]=true}function k(a,b,d){var c,e,i;for(c=0;i=b[c];c++){i=typeof i==="string"?{name:i}:i;e=i.location;if(d&&(!e||e.indexOf("/")!==0&&e.indexOf(":")===-1))i.location=d+"/"+(i.location||i.name);i.location=i.location||i.name;
i.lib=i.lib||"lib";i.main=i.main||"main";a[i.name]=i}}function h(a){var b=true,d=a.config.priorityWait,c,e;if(d){for(e=0;c=d[e];e++)if(!a.loaded[c]){b=false;break}b&&delete a.config.priorityWait}return b}function j(a){var b,d=f.paused;if(a.scriptCount<=0){for(a.scriptCount=0;J.length;){b=J.shift();b[0]===null?g.onError(new Error("Mismatched anonymous require.def modules")):z(b,a)}if(!(a.config.priorityWait&&!h(a))){if(d.length)for(a=0;b=d[a];a++)g.checkDeps.apply(g,b);g.checkLoaded(f.ctxName)}}}function p(a,
b){var d=f.plugins.callbacks[a]=[];f.plugins[a]=function(){for(var c=0,e;e=d[c];c++)if(e.apply(null,arguments)===true&&b)return true;return false}}function m(a){return function(b){a.exports=b}}function o(a,b,d){return function(){var c=[].concat(T.call(arguments,0));c.push(b,d);return(a?require[a]:require).apply(null,c)}}function x(a,b){var d=a.contextName,c=o(null,d,b);g.mixin(c,{modify:o("modify",d,b),def:o("def",d,b),get:o("get",d,b),nameToUrl:o("nameToUrl",d,b),ready:g.ready,context:a,config:a.config,
isBrowser:f.isBrowser});return c}var r={},f,s,v=[],u,D,G,H,E,F={},P,U=/^(complete|loaded)$/,V=/(\/\*([\s\S]*?)\*\/|\/\/(.*)$)/mg,W=/require\(["']([\w-_\.\/]+)["']\)/g,L,C=!!(typeof window!=="undefined"&&navigator&&document),Q=!C&&typeof importScripts!=="undefined",O=Object.prototype.toString,R=Array.prototype,T=R.slice,M,g,K,J=[],S=false,N;if(typeof require!=="undefined")if(A(require))return;else F=require;g=require=function(a,b,d,c,e){var i;if(typeof a==="string"&&!A(b))return require.get(a,b,d,
c);if(!require.isArray(a)){i=a;if(require.isArray(b)){a=b;b=d;d=c;c=e}else a=[]}L(null,a,b,i,d,c);(a=f.contexts[d||i&&i.context||f.ctxName])&&a.scriptCount===0&&j(a)};g.onError=function(a){throw a;};define=g.def=function(a,b,d,c){var e,i,l=N;if(typeof a!=="string"){c=d;d=b;b=a;a=null}if(!g.isArray(b)){c=d;d=b;b=[]}if(!a&&!b.length&&g.isFunction(d)){d.toString().replace(V,"").replace(W,function(n,w){b.push(w)});b=["require","exports","module"].concat(b)}if(!a&&S){e=document.getElementsByTagName("script");
for(a=e.length-1;a>-1&&(i=e[a]);a--)if(i.readyState==="interactive"){l=i;break}l||g.onError(new Error("ERROR: No matching script interactive for "+d));a=l.getAttribute("data-requiremodule")}J.push([a,b,d,null,c])};L=function(a,b,d,c,e,i){var l,n,w,y,q;e=e?e:c&&c.context?c.context:f.ctxName;l=f.contexts[e];if(a){n=a.indexOf("!");if(n!==-1){w=a.substring(0,n);a=a.substring(n+1,a.length)}else w=l.defPlugin[a];n=l.waiting[a];if(l&&(l.defined[a]||n&&n!==R[a]))return}if(e!==f.ctxName){n=f.contexts[f.ctxName]&&
f.contexts[f.ctxName].loaded;y=true;if(n)for(q in n)if(!(q in r))if(!n[q]){y=false;break}if(y)f.ctxName=e}if(!l){l={contextName:e,config:{waitSeconds:7,baseUrl:f.baseUrl||"./",paths:{},packages:{}},waiting:[],specified:{require:true,exports:true,module:true},loaded:{},scriptCount:0,urlFetched:{},defPlugin:{},defined:{},modifiers:{}};f.plugins.newContext&&f.plugins.newContext(l);l=f.contexts[e]=l}if(c){if(c.baseUrl)if(c.baseUrl.charAt(c.baseUrl.length-1)!=="/")c.baseUrl+="/";y=l.config.paths;n=l.config.packages;
g.mixin(l.config,c,true);if(c.paths){for(q in c.paths)q in r||(y[q]=c.paths[q]);l.config.paths=y}if((y=c.packagePaths)||c.packages){if(y)for(q in y)q in r||k(n,y[q],q);c.packages&&k(n,c.packages);l.config.packages=n}if(c.priority){g(c.priority);l.config.priorityWait=c.priority}if(c.deps||c.callback)g(c.deps||[],c.callback);c.ready&&g.ready(c.ready);if(!b)return}if(b){q=b;b=[];for(c=0;c<q.length;c++)b[c]=g.splitPrefix(q[c],a||i,l)}i=l.waiting.push({name:a,deps:b,callback:d});if(a){l.waiting[a]=i-1;
l.specified[a]=true;if(i=l.modifiers[a]){g(i,e);if(i=i.__deferMods)for(c=0;c<i.length;c++){q=i[c];n=q[q.length-1];if(n===undefined)q[q.length-1]=e;else typeof n==="string"&&i.push(e);require.def.apply(require,q)}}}if(a&&d&&!g.isFunction(d))l.defined[a]=d;w&&t(w,l,{name:"require",args:[a,b,d,l]});f.paused.push([w,a,b,l]);if(a)l.loaded[a]=true};g.mixin=function(a,b,d){for(var c in b)if(!(c in r)&&(!(c in a)||d))a[c]=b[c];return g};g.version="0.14.3";f=g.s={ctxName:"_",contexts:{},paused:[],plugins:{defined:{},
callbacks:{},waiting:{}},skipAsync:{},isBrowser:C,isPageLoaded:!C,readyCalls:[],doc:C?document:null};g.isBrowser=f.isBrowser;if(C){f.head=document.getElementsByTagName("head")[0];if(K=document.getElementsByTagName("base")[0])f.head=K.parentNode}g.plugin=function(a){var b,d,c,e=a.prefix,i=f.plugins.callbacks,l=f.plugins.waiting[e],n;b=f.plugins.defined;c=f.contexts;if(b[e])return g;b[e]=a;n=["newContext","isWaiting","orderDeps"];for(b=0;d=n[b];b++){f.plugins[d]||p(d,d==="isWaiting");i[d].push(a[d])}if(a.newContext)for(d in c)if(!(d in
r)){b=c[d];a.newContext(b)}if(l){for(b=0;c=l[b];b++)a[c.name]&&a[c.name].apply(null,c.args);delete f.plugins.waiting[e]}return g};g.completeLoad=function(a,b){for(var d;J.length;){d=J.shift();if(d[0]===null){d[0]=a;break}else if(d[0]===a)break;else z(d,b)}d&&z(d,b);b.loaded[a]=true;b.scriptCount-=1;j(b)};g.pause=g.resume=function(){};g.checkDeps=function(a,b,d,c){if(a)t(a,c,{name:"checkDeps",args:[b,d,c]});else for(a=0;b=d[a];a++)if(!c.specified[b.fullName]){c.specified[b.fullName]=true;c.startTime=
(new Date).getTime();b.prefix?t(b.prefix,c,{name:"load",args:[b.name,c.contextName]}):g.load(b.name,c.contextName)}};g.modify=function(a,b,d,c,e){var i,l,n=(typeof a==="string"?e:b)||f.ctxName,w=f.contexts[n],y=w.modifiers;if(typeof a==="string"){l=y[a]||(y[a]=[]);if(!l[b]){l.push(b);l[b]=true}w.specified[a]?g.def(b,d,c,e):(l.__deferMods||(l.__deferMods=[])).push([b,d,c,e])}else for(i in a)if(!(i in r)){b=a[i];l=y[i]||(w.modifiers[i]=[]);if(!l[b]){l.push(b);l[b]=true;w.specified[i]&&g([b],n)}}};g.isArray=
function(a){return O.call(a)==="[object Array]"};g.isFunction=A;g.get=function(a,b,d){if(a==="require"||a==="exports"||a==="module")g.onError(new Error("Explicit require of "+a+" is not allowed."));b=b||f.ctxName;var c=f.contexts[b];a=g.normalizeName(a,d,c);d=c.defined[a];d===undefined&&g.onError(new Error("require: module name '"+a+"' has not been loaded yet for context: "+b));return d};g.load=function(a,b){var d=f.contexts[b],c=d.urlFetched,e=d.loaded;f.isDone=false;e[a]||(e[a]=false);if(b!==f.ctxName)v.push(arguments);
else{e=g.nameToUrl(a,null,b);if(!c[e]){d.scriptCount+=1;g.attach(e,b,a);c[e]=true}}};g.jsExtRegExp=/\.js$/;g.normalizeName=function(a,b,d){if(a.charAt(0)==="."){b||g.onError(new Error("Cannot normalize module name: "+a+", no relative module name available."));if(d.config.packages[b])b=[b];else{b=b.split("/");b=b.slice(0,b.length-1)}a=b.concat(a.split("/"));for(s=0;b=a[s];s++)if(b==="."){a.splice(s,1);s-=1}else if(b===".."){a.splice(s-1,2);s-=2}a=a.join("/")}return a};g.splitPrefix=function(a,b,d){var c=
a.indexOf("!"),e=null;if(c!==-1){e=a.substring(0,c);a=a.substring(c+1,a.length)}a=g.normalizeName(a,b,d);return{prefix:e,name:a,fullName:e?e+"!"+a:a}};g.nameToUrl=function(a,b,d,c){var e,i,l,n;n=f.contexts[d];d=n.config;a=g.normalizeName(a,c,n);if(a.indexOf(":")!==-1||a.charAt(0)==="/"||g.jsExtRegExp.test(a))return a+(b?b:"");else if(a.charAt(0)===".")return g.onError(new Error("require.nameToUrl does not handle relative module names (ones that start with '.' or '..')"));else{e=d.paths;i=d.packages;
c=a.split("/");for(n=c.length;n>0;n--){l=c.slice(0,n).join("/");if(e[l]){c.splice(0,n,e[l]);break}else if(l=i[l]){e=l.location+"/"+l.lib;if(a===l.name)e+="/"+l.main;c.splice(0,n,e);break}}a=c.join("/")+(b||".js");return(a.charAt(0)==="/"||a.match(/^\w+:/)?"":d.baseUrl)+a}};g.checkLoaded=function(a){var b=f.contexts[a||f.ctxName],d=b.config.waitSeconds*1E3,c=d&&b.startTime+d<(new Date).getTime(),e,i=b.defined,l=b.modifiers,n="",w=false,y=false,q,B=f.plugins.isWaiting,I=f.plugins.orderDeps;if(!b.isCheckLoaded){if(b.config.priorityWait)if(h(b))j(b);
else return;b.isCheckLoaded=true;d=b.waiting;e=b.loaded;for(q in e)if(!(q in r)){w=true;if(!e[q])if(c)n+=q+" ";else{y=true;break}}if(!w&&!d.length&&(!B||!B(b)))b.isCheckLoaded=false;else{if(c&&n){e=new Error("require.js load timeout for modules: "+n);e.requireType="timeout";e.requireModules=n;g.onError(e)}if(y){b.isCheckLoaded=false;if(C||Q)setTimeout(function(){g.checkLoaded(a)},50)}else{b.waiting=[];b.loaded={};I&&I(b);for(q in l)q in r||i[q]&&g.execModifiers(q,{},d,b);for(e=0;i=d[e];e++)g.exec(i,
{},d,b);b.isCheckLoaded=false;if(b.waiting.length||B&&B(b))g.checkLoaded(a);else if(v.length){e=b.loaded;b=true;for(q in e)if(!(q in r))if(!e[q]){b=false;break}if(b){f.ctxName=v[0][1];q=v;v=[];for(e=0;b=q[e];e++)g.load.apply(g,b)}}else{f.ctxName="_";f.isDone=true;g.callReady&&g.callReady()}}}}};g.exec=function(a,b,d,c){if(a){var e=a.name,i=a.callback;i=a.deps;var l,n,w=c.defined,y,q=[],B,I=false;if(e){if(b[e]||e in w)return w[e];b[e]=true}if(i)for(l=0;n=i[l];l++){n=n.name;if(n==="require")n=x(c,e);
else if(n==="exports"){n=w[e]={};I=true}else if(n==="module"){B=n={id:e,uri:e?g.nameToUrl(e,null,c.contextName):undefined};B.setExports=m(B)}else n=n in w?w[n]:b[n]?undefined:g.exec(d[d[n]],b,d,c);q.push(n)}if((i=a.callback)&&g.isFunction(i)){y=g.execCb(e,i,q);if(e)if(I&&y===undefined&&(!B||!("exports"in B)))y=w[e];else if(B&&"exports"in B)y=w[e]=B.exports;else{e in w&&!I&&g.onError(new Error(e+" has already been defined"));w[e]=y}}g.execModifiers(e,b,d,c);return y}};g.execCb=function(a,b,d){return b.apply(null,
d)};g.execModifiers=function(a,b,d,c){var e=c.modifiers,i=e[a],l,n;if(i){for(n=0;n<i.length;n++){l=i[n];l in d&&g.exec(d[d[l]],b,d,c)}delete e[a]}};g.onScriptLoad=function(a){var b=a.currentTarget||a.srcElement,d;if(a.type==="load"||U.test(b.readyState)){d=b.getAttribute("data-requirecontext");a=b.getAttribute("data-requiremodule");d=f.contexts[d];g.completeLoad(a,d);b.removeEventListener?b.removeEventListener("load",g.onScriptLoad,false):b.detachEvent("onreadystatechange",g.onScriptLoad)}};g.attach=
function(a,b,d,c,e){var i;if(C){c=c||g.onScriptLoad;i=document.createElement("script");i.type=e||"text/javascript";i.charset="utf-8";if(!f.skipAsync[a])i.async=true;i.setAttribute("data-requirecontext",b);i.setAttribute("data-requiremodule",d);if(i.addEventListener)i.addEventListener("load",c,false);else{S=true;i.attachEvent("onreadystatechange",c)}i.src=a;N=i;K?f.head.insertBefore(i,K):f.head.appendChild(i);N=null;return i}else if(Q){c=f.contexts[b];b=c.loaded;b[d]=false;importScripts(a);g.completeLoad(d,
c)}return null};f.baseUrl=F.baseUrl;if(C&&(!f.baseUrl||!f.head)){u=document.getElementsByTagName("script");G=F.baseUrlMatch?F.baseUrlMatch:/(allplugins-|transportD-)?require\.js(\W|$)/i;for(s=u.length-1;s>-1&&(D=u[s]);s--){if(!f.head)f.head=D.parentNode;if(!F.deps)if(H=D.getAttribute("data-main"))F.deps=[H];if((H=D.src)&&!f.baseUrl)if(E=H.match(G)){f.baseUrl=H.substring(0,E.index);break}}}g.pageLoaded=function(){if(!f.isPageLoaded){f.isPageLoaded=true;M&&clearInterval(M);if(P)document.readyState=
"complete";g.callReady()}};g.callReady=function(){var a=f.readyCalls,b,d;if(f.isPageLoaded&&f.isDone&&a.length){f.readyCalls=[];for(b=0;d=a[b];b++)d()}};g.ready=function(a){f.isPageLoaded&&f.isDone?a():f.readyCalls.push(a);return g};if(C){if(document.addEventListener){document.addEventListener("DOMContentLoaded",g.pageLoaded,false);window.addEventListener("load",g.pageLoaded,false);if(!document.readyState){P=true;document.readyState="loading"}}else if(window.attachEvent){window.attachEvent("onload",
g.pageLoaded);if(self===self.top)M=setInterval(function(){try{if(document.body){document.documentElement.doScroll("left");g.pageLoaded()}}catch(a){}},30)}document.readyState==="complete"&&g.pageLoaded()}g(F);typeof setTimeout!=="undefined"&&setTimeout(function(){j(f.contexts[F.context||"_"])},0)})();
(function(){function A(h,j){j=j.nlsWaiting;return j[h]||(j[h]=j[j.push({_name:h})-1])}function t(h,j,p,m){var o,x,r,f,s,v,u="root";x=p.split("-");r=[];f=A(h,m);for(o=x.length;o>-1;o--){s=o?x.slice(0,o).join("-"):"root";if(v=j[s]){if(p===m.config.locale&&!f._match)f._match=s;if(u==="root")u=s;f[s]=s;if(v===true){v=h.split("/");v.splice(-1,0,s);v=v.join("/");if(!m.specified[v]&&!(v in m.loaded)&&!m.defined[v]){m.defPlugin[v]="i18n";r.push(v)}}}}if(u!==p)if(m.defined[u])m.defined[p]=m.defined[u];else f[p]=
u;r.length&&require(r,m.contextName)}var z=/(^.*(^|\/)nls(\/|$))([^\/]*)\/?([^\/]*)/,k={};require.plugin({prefix:"i18n",require:function(h,j,p,m){var o,x=m.defined[h];o=z.exec(h);if(o[5]){h=o[1]+o[5];j=A(h,m);j[o[4]]=o[4];j=m.nls[h];if(!j){m.defPlugin[h]="i18n";require([h],m.contextName);j=m.nls[h]={}}j[o[4]]=p}else{if(j=m.nls[h])require.mixin(j,x);else j=m.nls[h]=x;m.nlsRootLoaded[h]=true;if(o=m.nlsToLoad[h]){delete m.nlsToLoad[h];for(p=0;p<o.length;p++)t(h,j,o[p],m)}t(h,j,m.config.locale,m)}},newContext:function(h){require.mixin(h,
{nlsWaiting:[],nls:{},nlsRootLoaded:{},nlsToLoad:{}});if(!h.config.locale)h.config.locale=typeof navigator==="undefined"?"root":(navigator.language||navigator.userLanguage||"root").toLowerCase()},load:function(h,j){var p=require.s.contexts[j],m;m=z.exec(h);var o=m[4];if(m[5]){h=m[1]+m[5];m=p.nls[h];if(p.nlsRootLoaded[h]&&m)t(h,m,o,p);else{(p.nlsToLoad[h]||(p.nlsToLoad[h]=[])).push(o);p.defPlugin[h]="i18n";require([h],j)}}else if(!p.nlsRootLoaded[h]){p.defPlugin[h]="i18n";require.load(h,j)}},checkDeps:function(){},
isWaiting:function(h){return!!h.nlsWaiting.length},orderDeps:function(h){var j,p,m,o,x,r,f,s,v,u,D,G,H=h.nlsWaiting,E;h.nlsWaiting=[];h.nlsToLoad={};for(j=0;o=H[j];j++){m=o._name;x=h.nls[m];D=null;r=m.split("/");v=r.slice(0,r.length-1).join("/");f=r[r.length-1];for(u in o)if(u!=="_name"&&!(u in k))if(u==="_match")D=o[u];else if(o[u]!==u)(E||(E={}))[u]=o[u];else{s={};r=u.split("-");for(p=r.length;p>0;p--){G=r.slice(0,p).join("-");G!=="root"&&x[G]&&require.mixin(s,x[G])}x.root&&require.mixin(s,x.root);
h.defined[v+"/"+u+"/"+f]=s}h.defined[m]=h.defined[v+"/"+D+"/"+f];if(E)for(u in E)u in k||(h.defined[v+"/"+u+"/"+f]=h.defined[v+"/"+E[u]+"/"+f])}}})})();
(function(){var A=["Msxml2.XMLHTTP","Microsoft.XMLHTTP","Msxml2.XMLHTTP.4.0"],t=/^\s*<\?xml(\s)+version=[\'\"](\d)*.(\d)*[\'\"](\s)*\?>/im,z=/<body[^>]*>\s*([\s\S]+)\s*<\/body>/im;if(!require.textStrip)require.textStrip=function(k){if(k){k=k.replace(t,"");var h=k.match(z);if(h)k=h[1]}else k="";return k};if(!require.getXhr)require.getXhr=function(){var k,h,j;if(typeof XMLHttpRequest!=="undefined")return new XMLHttpRequest;else for(h=0;h<3;h++){j=A[h];try{k=new ActiveXObject(j)}catch(p){}if(k){A=[j];
break}}if(!k)throw new Error("require.getXhr(): XMLHttpRequest not available");return k};if(!require.fetchText)require.fetchText=function(k,h){var j=require.getXhr();j.open("GET",k,true);j.onreadystatechange=function(){j.readyState===4&&h(j.responseText)};j.send(null)};require.plugin({prefix:"text",require:function(){},newContext:function(k){require.mixin(k,{text:{},textWaiting:[]})},load:function(k,h){var j=false,p=null,m,o=k.indexOf("."),x=k.substring(0,o),r=k.substring(o+1,k.length),f=require.s.contexts[h],
s=f.textWaiting;o=r.indexOf("!");if(o!==-1){j=r.substring(o+1,r.length);r=r.substring(0,o);o=j.indexOf("!");if(o!==-1&&j.substring(0,o)==="strip"){p=j.substring(o+1,j.length);j="strip"}else if(j!=="strip"){p=j;j=null}}m=x+"!"+r;o=j?m+"!"+j:m;if(p!==null&&!f.text[m])f.defined[k]=f.text[m]=p;else if(!f.text[m]&&!f.textWaiting[m]&&!f.textWaiting[o]){s[o]||(s[o]=s[s.push({name:k,key:m,fullKey:o,strip:!!j})-1]);h=require.nameToUrl(x,"."+r,h);f.loaded[k]=false;require.fetchText(h,function(v){f.text[m]=
v;f.loaded[k]=true})}},checkDeps:function(){},isWaiting:function(k){return!!k.textWaiting.length},orderDeps:function(k){var h,j,p,m=k.textWaiting;k.textWaiting=[];for(h=0;j=m[h];h++){p=k.text[j.key];k.defined[j.name]=j.strip?require.textStrip(p):p}}})})();
(function(){var A=0;require._jsonp={};require.plugin({prefix:"jsonp",require:function(){},newContext:function(t){require.mixin(t,{jsonpWaiting:[]})},load:function(t,z){var k=t.indexOf("?"),h=t.substring(0,k);k=t.substring(k+1,t.length);var j=require.s.contexts[z],p={name:t},m="f"+A++,o=require.s.head,x=o.ownerDocument.createElement("script");require._jsonp[m]=function(r){p.value=r;j.loaded[t]=true;setTimeout(function(){o.removeChild(x);delete require._jsonp[m]},15)};j.jsonpWaiting.push(p);h=require.nameToUrl(h,
"?",z);h+=(h.indexOf("?")===-1?"?":"")+k.replace("?","require._jsonp."+m);j.loaded[t]=false;x.type="text/javascript";x.charset="utf-8";x.src=h;x.async=true;o.appendChild(x)},checkDeps:function(){},isWaiting:function(t){return!!t.jsonpWaiting.length},orderDeps:function(t){var z,k,h=t.jsonpWaiting;t.jsonpWaiting=[];for(z=0;k=h[z];z++)t.defined[k.name]=k.value}})})();
(function(){function A(k){var h=k.currentTarget||k.srcElement,j,p,m,o;if(k.type==="load"||z.test(h.readyState)){p=h.getAttribute("data-requirecontext");j=h.getAttribute("data-requiremodule");k=require.s.contexts[p];m=k.orderWaiting;o=k.orderCached;o[j]=true;for(j=0;o[m[j]];j++);j>0&&require(m.splice(0,j),p);if(!m.length)k.orderCached={};setTimeout(function(){h.parentNode.removeChild(h)},15)}}var t=window.opera&&Object.prototype.toString.call(window.opera)==="[object Opera]"||"MozAppearance"in document.documentElement.style,
z=/^(complete|loaded)$/;require.plugin({prefix:"order",require:function(){},newContext:function(k){require.mixin(k,{orderWaiting:[],orderCached:{}})},load:function(k,h){var j=require.s.contexts[h],p=require.nameToUrl(k,null,h);require.s.skipAsync[p]=true;if(t)require([k],h);else{j.orderWaiting.push(k);j.loaded[k]=false;require.attach(p,h,k,A,"script/cache")}},checkDeps:function(){},isWaiting:function(k){return!!k.orderWaiting.length},orderDeps:function(){}})})();