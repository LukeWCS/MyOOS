!function(e){var t={};function n(i){if(t[i])return t[i].exports;var r=t[i]={i:i,l:!1,exports:{}};return e[i].call(r.exports,r,r.exports,n),r.l=!0,r.exports}n.m=e,n.c=t,n.d=function(e,t,i){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:i})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var i=Object.create(null);if(n.r(i),Object.defineProperty(i,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)n.d(i,r,function(t){return e[t]}.bind(null,r));return i},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=331)}({331:function(e,t){!function(e,t,n){var i,r,l,a,o,s,c=/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,63}$/i,u=/^(https?|ftp):\/\/[A-Z0-9.-]+\.[A-Z]{2,63}[^ "]*$/i,p={},d={},h="ontouchend"in document;function f(){return s||i.dom.getParent(i.selection.getNode(),"a[href]")}window.wpLink={timeToTriggerRiver:150,minRiverAJAXDuration:200,riverBottomThreshold:5,keySensitivity:100,lastSearch:"",textarea:"",modalOpen:!1,init:function(){p.wrap=e("#wp-link-wrap"),p.dialog=e("#wp-link"),p.backdrop=e("#wp-link-backdrop"),p.submit=e("#wp-link-submit"),p.close=e("#wp-link-close");var n=e('<div class="link-nofollow"><label><span> </span> <input type="checkbox" id="wp-link-nofollow"> '+t.relCheckbox+"</label></div>"),i=e('<div class="wp-link-title-field"> <label><span>'+t.linkTitle+'</span> <input id="wp-link-title" type="text"></label></div>');n.insertAfter("#wp-link .link-target"),i.insertAfter("#wp-link .wp-link-text-field"),e("#wp-link .query-results").css("top","260px"),p.text=e("#wp-link-text"),p.url=e("#wp-link-url"),p.nonce=e("#_ajax_linking_nonce"),p.openInNewTab=e("#wp-link-target"),p.search=e("#wp-link-search"),p.nofollow=e("#wp-link-nofollow"),p.title=e("#wp-link-title"),d.search=new l(e("#search-results")),d.recent=new l(e("#most-recent-results")),d.elements=p.dialog.find(".query-results"),p.queryNotice=e("#query-notice-message"),p.queryNoticeTextDefault=p.queryNotice.find(".query-notice-default"),p.queryNoticeTextHint=p.queryNotice.find(".query-notice-hint"),p.dialog.keydown(wpLink.keydown),p.dialog.keyup(wpLink.keyup),p.submit.click(function(e){e.preventDefault(),wpLink.update()}),p.close.add(p.backdrop).add("#wp-link-cancel button").click(function(e){e.preventDefault(),wpLink.close()}),d.elements.on("river-select",wpLink.updateFields),p.search.on("focus.wplink",function(){p.queryNoticeTextDefault.hide(),p.queryNoticeTextHint.removeClass("screen-reader-text").show()}).on("blur.wplink",function(){p.queryNoticeTextDefault.show(),p.queryNoticeTextHint.addClass("screen-reader-text").hide()}),p.search.on("keyup input",function(){window.clearTimeout(r),r=window.setTimeout(function(){wpLink.searchInternalLinks()},500)}),p.url.on("paste",function(){setTimeout(wpLink.correctURL,0)}),p.url.on("blur",wpLink.correctURL)},correctURL:function(){var t=e.trim(p.url.val());t&&o!==t&&!/^(?:[a-z]+:|#|\?|\.|\/)/.test(t)&&(p.url.val("http://"+t),o=t)},open:function(t,n,r,l){var a,o=e(document.body);o.addClass("modal-open"),wpLink.modalOpen=!0,s=l,wpLink.range=null,t&&(window.wpActiveEditor=t),window.wpActiveEditor&&(this.textarea=e("#"+window.wpActiveEditor).get(0),void 0!==window.tinymce&&(o.append(p.backdrop,p.wrap),a=window.tinymce.get(window.wpActiveEditor),i=a&&!a.isHidden()?a:null),!wpLink.isMCE()&&document.selection&&(this.textarea.focus(),this.range=document.selection.createRange()),p.wrap.show(),p.backdrop.show(),wpLink.refresh(n,r),e(document).trigger("wplink-open",p.wrap))},isMCE:function(){return i&&!i.isHidden()},refresh:function(e,t){d.search.refresh(),d.recent.refresh(),wpLink.isMCE()?wpLink.mceRefresh(e,t):(p.wrap.hasClass("has-text-field")||p.wrap.addClass("has-text-field"),document.selection?document.selection.createRange().text:void 0!==this.textarea.selectionStart&&this.textarea.selectionStart!==this.textarea.selectionEnd&&(t=this.textarea.value.substring(this.textarea.selectionStart,this.textarea.selectionEnd)||t||""),p.text.val(t),wpLink.setDefaultValues()),h?p.url.focus().blur():window.setTimeout(function(){p.url[0].select(),p.url.focus()}),d.recent.ul.children().length||d.recent.ajax(),o=p.url.val().replace(/^http:\/\//,"")},hasSelectedText:function(e){var t,n,r,l=i.selection.getContent();if(/</.test(l)&&(!/^<a [^>]+>[^<]+<\/a>$/.test(l)||-1===l.indexOf("href=")))return!1;if(e){if(0===(n=e.childNodes).length)return!1;for(r=n.length-1;r>=0;r--)if(3!=(t=n[r]).nodeType&&!window.tinymce.dom.BookmarkManager.isBookmarkNode(t))return!1}return!0},mceRefresh:function(n,r){var l,a,o=f(),s=this.hasSelectedText(o);o?(l=o.textContent||o.innerText,a=i.dom.getAttrib(o,"href"),e.trim(l)||(l=r||""),n&&(u.test(n)||c.test(n))&&(a=n),"_wp_link_placeholder"!==a?(p.url.val(a),p.openInNewTab.prop("checked","_blank"===i.dom.getAttrib(o,"target")),p.nofollow.prop("checked","nofollow"===i.dom.getAttrib(o,"rel")),p.title.val(i.dom.getAttrib(o,"title")),p.submit.val(t.update)):this.setDefaultValues(l),p.search.val(n&&n!==a?n:""),window.setTimeout(function(){wpLink.searchInternalLinks()})):(l=i.selection.getContent({format:"text"})||r||"",this.setDefaultValues(l)),s?(p.text.val(l),p.wrap.addClass("has-text-field")):(p.text.val(""),p.wrap.removeClass("has-text-field"))},close:function(t){e(document.body).removeClass("modal-open"),wpLink.modalOpen=!1,"noReset"!==t&&(wpLink.isMCE()?(i.plugins.wplink&&i.plugins.wplink.close(),i.focus()):(wpLink.textarea.focus(),wpLink.range&&(wpLink.range.moveToBookmark(wpLink.range.getBookmark()),wpLink.range.select()))),p.backdrop.hide(),p.wrap.hide(),p.title.val(""),o=!1,e(document).trigger("wplink-close",p.wrap)},getAttrs:function(){wpLink.correctURL();var t={href:e.trim(p.url.val()),target:p.openInNewTab.prop("checked")?"_blank":null,rel:p.nofollow.prop("checked")?"nofollow":""};return e.trim(p.title.val())&&(t.title=e.trim(p.title.val())),t},buildHtml:function(e){var t='<a href="'+e.href+'"';return e.target&&(t+=' target="'+e.target+'"'),e.rel&&(t+=' rel="'+e.rel+'"'),e.title&&(t+=' title="'+e.title+'"'),t+">"},update:function(){wpLink.isMCE()?wpLink.mceUpdate():wpLink.htmlUpdate()},htmlUpdate:function(){var i,r,l,a,o,s,c,u=wpLink.textarea;if(u){i=wpLink.getAttrs(),r=p.text.val();var d=document.createElement("a");d.href=i.href,"javascript:"!==d.protocol&&"data:"!==d.protocol||(i.href=""),i.href&&(l=wpLink.buildHtml(i),document.selection&&wpLink.range?(u.focus(),wpLink.range.text=l+(r||wpLink.range.text)+"</a>",wpLink.range.moveToBookmark(wpLink.range.getBookmark()),wpLink.range.select(),wpLink.range=null):void 0!==u.selectionStart&&(o=u.selectionEnd,s=(a=u.selectionStart)+(l=l+(c=r||u.value.substring(a,o))+"</a>").length,a!==o||c||(s-=4),u.value=u.value.substring(0,a)+l+u.value.substring(o,u.value.length),u.selectionStart=u.selectionEnd=s),wpLink.close(),u.focus(),e(u).trigger("change"),n.a11y.speak(t.linkInserted))}},mceUpdate:function(){var r,l,a,o,s=wpLink.getAttrs(),c=document.createElement("a");if(c.href=s.href,"javascript:"!==c.protocol&&"data:"!==c.protocol||(s.href=""),!s.href)return i.execCommand("unlink"),void wpLink.close();r=i.$(f()),i.undoManager.transact(function(){r.length||(i.execCommand("mceInsertLink",!1,{href:"_wp_link_placeholder","data-wp-temp-link":1}),r=i.$('a[data-wp-temp-link="1"]').removeAttr("data-wp-temp-link"),a=e.trim(r.text())),r.length?(p.wrap.hasClass("has-text-field")&&((l=p.text.val())?r.text(l):a||r.text(s.href)),s["data-wplink-edit"]=null,s["data-mce-href"]=null,s.hasOwnProperty("rel")&&!s.rel&&(s.rel=null),r.attr(s)):i.execCommand("unlink")}),wpLink.close("noReset"),i.focus(),r.length&&((o=r.parent("#_mce_caret")).length&&o.before(r.removeAttr("data-mce-bogus")),i.selection.select(r[0]),i.selection.collapse(),i.plugins.wplink&&i.plugins.wplink.checkLink(r[0])),i.nodeChanged(),p.title.val(""),n.a11y.speak(t.linkInserted)},updateFields:function(e,t){p.url.val(t.children(".item-permalink").val())},getUrlFromSelection:function(t){return t||(this.isMCE()?t=i.selection.getContent({format:"text"}):document.selection&&wpLink.range?t=wpLink.range.text:void 0!==this.textarea.selectionStart&&(t=this.textarea.value.substring(this.textarea.selectionStart,this.textarea.selectionEnd))),(t=e.trim(t))&&c.test(t)?"mailto:"+t:t&&u.test(t)?t.replace(/&amp;|&#0?38;/gi,"&"):""},setDefaultValues:function(e){p.url.val(this.getUrlFromSelection(e)),p.search.val(""),wpLink.searchInternalLinks(),p.submit.val(t.save)},searchInternalLinks:function(){var e,t=p.search.val()||"";if(t.length>2){if(d.recent.hide(),d.search.show(),wpLink.lastSearch===t)return;wpLink.lastSearch=t,e=p.search.parent().find(".spinner").addClass("is-active"),d.search.change(t),d.search.ajax(function(){e.removeClass("is-active")})}else d.search.hide(),d.recent.show()},next:function(){d.search.next(),d.recent.next()},prev:function(){d.search.prev(),d.recent.prev()},keydown:function(e){var t,n;27===e.keyCode?(wpLink.close(),e.stopImmediatePropagation()):9===e.keyCode&&("wp-link-submit"!==(n=e.target.id)||e.shiftKey?"wp-link-close"===n&&e.shiftKey&&(p.submit.focus(),e.preventDefault()):(p.close.focus(),e.preventDefault())),e.shiftKey||38!==e.keyCode&&40!==e.keyCode||(!document.activeElement||"link-title-field"!==document.activeElement.id&&"url-field"!==document.activeElement.id)&&(t=38===e.keyCode?"prev":"next",clearInterval(wpLink.keyInterval),wpLink[t](),wpLink.keyInterval=setInterval(wpLink[t],wpLink.keySensitivity),e.preventDefault())},keyup:function(e){38!==e.keyCode&&40!==e.keyCode||(clearInterval(wpLink.keyInterval),e.preventDefault())},delayedCallback:function(e,t){var n,i,r,l;return t?(setTimeout(function(){if(i)return e.apply(l,r);n=!0},t),function(){if(n)return e.apply(this,arguments);r=arguments,l=this,i=!0}):e}},e.extend((l=function(t,n){var i=this;this.element=t,this.ul=t.children("ul"),this.contentHeight=t.children("#link-selector-height"),this.waiting=t.find(".river-waiting"),this.change(n),this.refresh(),e("#wp-link .query-results, #wp-link #link-selector").scroll(function(){i.maybeLoad()}),t.on("click","li",function(t){i.select(e(this),t)})}).prototype,{refresh:function(){this.deselect(),this.visible=this.element.is(":visible")},show:function(){this.visible||(this.deselect(),this.element.show(),this.visible=!0)},hide:function(){this.element.hide(),this.visible=!1},select:function(e,t){var n,i,r,l;e.hasClass("unselectable")||e===this.selected||(this.deselect(),this.selected=e.addClass("selected"),n=e.outerHeight(),i=this.element.height(),r=e.position().top,l=this.element.scrollTop(),0>r?this.element.scrollTop(l+r):r+n>i&&this.element.scrollTop(l+r-i+n),this.element.trigger("river-select",[e,t,this]))},deselect:function(){this.selected&&this.selected.removeClass("selected"),this.selected=!1},prev:function(){var e;this.visible&&this.selected&&(e=this.selected.prev("li")).length&&this.select(e)},next:function(){if(this.visible){var t=this.selected?this.selected.next("li"):e("li:not(.unselectable):first",this.element);t.length&&this.select(t)}},ajax:function(e){var t=this,n=1==this.query.page?0:wpLink.minRiverAJAXDuration,i=wpLink.delayedCallback(function(n,i){t.process(n,i),e&&e(n,i)},n);this.query.ajax(i)},change:function(e){this.query&&this._search===e||(this._search=e,this.query=new a(e),this.element.scrollTop(0))},process:function(n,i){var r="",l=!0,a="",o=1===i.page;n?e.each(n,function(){a=l?"alternate":"",r+=(a+=this.title?"":" no-title")?'<li class="'+a+'">':"<li>",r+='<input type="hidden" class="item-permalink" value="'+this.permalink+'" />',r+='<span class="item-title">',r+=this.title?this.title:t.noTitle,r+='</span><span class="item-info">'+this.info+"</span></li>",l=!l}):o&&(r+='<li class="unselectable no-matches-found"><span class="item-title"><em>'+t.noMatchesFound+"</em></span></li>"),this.ul[o?"html":"append"](r)},maybeLoad:function(){var e=this,t=this.element,n=t.scrollTop()+t.height();this.query.ready()&&n>=this.contentHeight.height()-wpLink.riverBottomThreshold&&setTimeout(function(){var n=t.scrollTop(),i=n+t.height();e.query.ready()&&i>=e.contentHeight.height()-wpLink.riverBottomThreshold&&(e.waiting.addClass("is-active"),t.scrollTop(n+e.waiting.outerHeight()),e.ajax(function(){e.waiting.removeClass("is-active")}))},wpLink.timeToTriggerRiver)}}),e.extend((a=function(e){this.page=1,this.allLoaded=!1,this.querying=!1,this.search=e}).prototype,{ready:function(){return!(this.querying||this.allLoaded)},ajax:function(t){var n=this,i={action:"wp-link-ajax",page:this.page,_ajax_linking_nonce:p.nonce.val()};this.search&&(i.search=this.search),this.querying=!0,e.post(window.ajaxurl,i,function(e){n.page++,n.querying=!1,n.allLoaded=!e,t(e,i)},"json")}}),e(document).ready(wpLink.init)}(jQuery,window.wpLinkL10n,window.wp)}});