!function(e){var t={};function n(o){if(t[o])return t[o].exports;var r=t[o]={i:o,l:!1,exports:{}};return e[o].call(r.exports,r,r.exports,n),r.l=!0,r.exports}n.m=e,n.c=t,n.d=function(e,t,o){n.o(e,t)||Object.defineProperty(e,t,{configurable:!1,enumerable:!0,get:o})},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="/",n(n.s=291)}({291:function(e,t,n){"use strict";window.onload=function(){var e=document.getElementById("bars-menu-web"),t=document.querySelector(".header-top__right"),n=document.querySelector(".go-up");e.addEventListener("click",function(e){e.preventDefault(),t.classList.toggle("block")}),n.addEventListener("click",function(e){e.preventDefault();var t=-window.scrollY/(500/15),n=window.setInterval(function(){0!==window.scrollY?window.scrollBy(0,t):window.clearInterval(n)},15)}),window.addEventListener("scroll",function(e){window.scrollY>50?n.classList.add("active-go-up"):n.classList.remove("active-go-up")})}}});
//# sourceMappingURL=animations.js.map