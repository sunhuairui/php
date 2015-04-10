/**
 * I9RIARENDER - v2.6.5 - 2015-03-20
 * 
 *
 * Copyright (c) 2015 
 * Licensed MIT <>
 */
function mobilecheck() {
    var a = !1;
    return function(b) { (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(b) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(b.substr(0, 4))) && (a = !0)
    } (navigator.userAgent || navigator.vendor || window.opera),
    a
}
function isWeixin() {
    var a = navigator.userAgent.toLowerCase();
    return "micromessenger" == a.match(/MicroMessenger/i) ? !0: !1
}
function countCharacters(a) {
    for (var b = 0, c = 0; c < a.length; c++) {
        var d = a.charCodeAt(c);
        d >= 1 && 126 >= d || d >= 65376 && 65439 >= d ? b++:b += 2
    }
    return b
}

//添加音频
function playVideo(a) {
    if (a) {
        var b = $("#media"),
        c = $("#audio_btn");
        b.attr("src", a),
        c.addClass("video_exist"),
        b.bind("canplay", 
        function() {
            b.get(0).play(),
            c.removeClass("off").addClass("play_yinfu"),
            $("#yinfu").addClass("rotate")
        }),
        c.show().click(function() {
            $(this).hasClass("off") ? ($(this).addClass("play_yinfu").removeClass("off"), $("#yinfu").addClass("rotate"), b.get(0).play()) : ($(this).addClass("off").removeClass("play_yinfu"), $("#yinfu").removeClass("rotate"), b.get(0).pause())
        })
    }
}
function renderPage(a, b, c) {
    a.templateParser("jsonParser").parse({
        def: c[b - 1],
        appendTo: "#page" + b,
        mode: "view"
    });
    var d,
    e,
    f = 1,
    g = $(".z-current").width(),
    h = $(".z-current").height();
    if (imageWidth = $(".m-img").width(), imageHeight = $(".m-img").height(), g / h >= 320 / 486 ? (f = h / 486, d = (g / f - 320) / 2) : (f = g / 320, e = (h / f - 486) / 2), e && $(".edit_area").css({
        marginTop: e
    }), d && $(".edit_area").css({
        marginLeft: d
    }), tplCount == c.length && ($("#eqMobileViewport").attr("content", "width=320, initial-scale=" + f + ", maximum-scale=" + f + ", user-scalable=no"), 320 != clientWidth && clientWidth == document.documentElement.clientWidth || isWeixin() && (navigator.userAgent.indexOf("Android") > -1 || navigator.userAgent.indexOf("Linux") > -1))) {
        var i = 320 / g,
        j = 486 / h,
        k = Math.max(i, j);
        k = k > 1 ? k: 160 * k,
        k = parseInt(k),
        $("#eqMobileViewport").attr("content", "width=320, target-densitydpi=" + k)
    }
}

var tplCount = 0,copied = !1,copyElemDef,originalElemDef,childTouched; 
!function() {
    function a(a) {
        resources.loaded = !0,
        a instanceof Array ? a.forEach(function(a) {
            b(a)
        }) : b(a)
    }
    function b(a) {
        if ("loading" != f[a.url]) {
            if (f[a.url]) return f[a.url];
            if (f[a.url] = !1, "image" == a.type) {
                var b = new Image;
                f[a.url] = "loading",
                b.onload = function() {
                    f[a.url] = b,
                    d() && g.forEach(function(a) {
                        a()
                    })
                },
                b.src = a.url
            } else "js" == a.type && (f[a.url] = "loading", $.getScript(a.url, 
            function() {
                f[a.url] = !0,
                d() && g.forEach(function(a) {
                    a()
                })
            }))
        }
    }
    function c(a) {
        return f[a]
    }
    function d() {
        var a = !0;
        for (var b in f) if (f.hasOwnProperty(b) && (!f[b] || "loading" == f[b])) return ! 1;
        return a
    }
    function e(a) {
        g.push(a)
    }
    var f = {},
    g = [];
    window.resources = {
        load: a,
        get: c,
        onReady: e,
        isReady: d
    }
} (),
function(a) {
    "use strict";
    a.fn.swipeSlide = function(b, c) {
        function d(a, b) {
            a.css({
                "-webkit-transition": "all " + b + "s " + C.transitionType,
                transition: "all " + b + "s " + C.transitionType
            })
        }
        function e(a, b) {
            a.css(C.axisX ? {
                "-webkit-transform": "translate3d(" + b + "px,0,0)",
                transform: "translate3d(" + b + "px,0,0)"
            }: {
                "-webkit-transform": "translate3d(0," + b + "px,0)",
                transform: "translate3d(0," + b + "px,0)"
            })
        }
        function f(a) {
            if (C.lazyLoad) {
                var b = C.ul.find("[data-src]");
                if (b.length > 0) {
                    var c = b.eq(a);
                    c.data("src") && (c.is("img") ? c.attr("src", c.data("src")).data("src", "") : c.css({
                        "background-image": "url(" + c.data("src") + ")"
                    }).data("src", ""))
                }
            }
        }
        function g(a) {
            a.touches || (a.touches = a.originalEvent.touches)
        }
        function h(a) {
            r = a.touches[0].pageX,
            s = a.touches[0].pageY
        }
        function i(a) {
            if (a.preventDefault(), C.autoSwipe && p && clearInterval(p), w = a.touches[0].pageX, x = a.touches[0].pageY, t = w - r, u = x - s, d(C.ul, 0), C.axisX) {
                if (!C.continuousScroll) {
                    if (0 == q && t > 0) return t = 0,
                    o();
                    if (q + 1 >= F && 0 > t) return t = 0,
                    o()
                }
                e(C.ul, -(D * parseInt(q) - t))
            } else {
                if (!C.continuousScroll) {
                    if (0 == q && u > 0) return u = 0,
                    o();
                    if (q + 1 >= F && 0 > u) return u = 0,
                    o()
                }
                e(C.ul, -(E * parseInt(q) - u))
            }
        }
        function j() {
            v = C.axisX ? t: u,
            Math.abs(v) <= y ? k(.3) : v > y ? n() : -y > v && m(),
            o(),
            t = 0,
            u = 0
        }
        function k(a) {
            d(C.ul, a),
            C.axisX ? e(C.ul, -q * D) : e(C.ul, -q * E)
        }
        function l() {
            C.continuousScroll ? q >= F ? (k(.3), q = 0, setTimeout(function() {
                k(0)
            },
            300)) : 0 > q ? (k(.3), q = F - 1, setTimeout(function() {
                k(0)
            },
            300)) : k(.3) : (q >= F ? q = 0: 0 > q && (q = F - 1), k(.3)),
            c(q)
        }
        function m() {
            q++,
            l(),
            C.lazyLoad && f(C.continuousScroll ? q + 2: q + 1)
        }
        function n() {
            if (q--, l(), A && C.lazyLoad) {
                var a = F - 1;
                for (a; F + 1 >= a; a++) f(a);
                return void(A = !1)
            } ! A && C.lazyLoad && f(q)
        }
        function o() {
            C.autoSwipe && (p = setInterval(function() {
                m()
            },
            C.speed))
        }
        var p,
        q = 0,
        r = 0,
        s = 0,
        t = 0,
        u = 0,
        v = 0,
        w = 0,
        x = 0,
        y = 50,
        z = 0,
        A = !0,
        B = a(this),
        C = a.extend({},
        {
            ul: B.children("ul"),
            li: B.children().children("li"),
            continuousScroll: !1,
            autoSwipe: !0,
            speed: 4e3,
            axisX: !0,
            transitionType: "ease",
            lazyLoad: !1,
            clone: !0,
            width: 0,
            length: 0
        },
        b || {}),
        D = C.width || C.li.width(),
        E = C.li.height(),
        F = C.length || C.li.length;
        c = c || 
        function() {},
        function() {
            if (C.continuousScroll && (C.clone && C.ul.prepend(C.li.last().clone()).append(C.li.first().clone()), C.axisX ? (e(C.ul.children().first(), -1 * D), e(C.ul.children().last(), D * F)) : (e(C.ul.children().first(), -1 * E), e(C.ul.children().last(), E * F))), C.lazyLoad) {
                var b = 0;
                for (z = C.continuousScroll ? 3: 2, b; z > b; b++) f(b)
            }
            C.li.each(C.axisX ? 
            function(b) {
                e(a(this), D * b)
            }: function(b) {
                e(a(this), E * b)
            }),
            o(),
            c(q, p),
            B.on("touchstart", 
            function(a) {
                a.stopPropagation(),
                g(a),
                h(a)
            }),
            B.on("touchmove", 
            function(a) {
                a.stopPropagation(),
                g(a),
                i(a)
            }),
            B.on("touchend", 
            function(a) {
                a.stopPropagation(),
                j()
            })
        } ()
    };
} (window.Zepto || window.jQuery),
function(a) {
    //初始化I9RIARENDER.templateParser
    function b(a) {
        function b(a, b, c) {
            return a[b] || (a[b] = c())
        }
        var c = b(a, "I9RIARENDER", Object);
        return b(c, "templateParser", 
        function() {
            var a = {};
            return function(c, d) {
                if ("hasOwnProperty" === c) throw new Error("hasOwnProperty is not a valid name");
                return d && a.hasOwnProperty(c) && (a[c] = null),
                b(a, c, d)
            }
        })
    }
    b(a);
} (window, document),
function(a) {
    function b(a, b, c, d) {
        var e = {},
        f = a / b,
        g = c / d;
        return f > g ? (e.width = c, e.height = c / f) : (e.height = d, e.width = d * f),
        e
    }
    var c = a.templateParser("jsonParser", 
    function() {
        function a(a) {
            return function(b, c) {
                a[b] = c
            }
        }
        function b(a, b) {
            var c = i[("" + a.type).charAt(0)](a);
            if (c) {
                var d = $('<li comp-drag comp-rotate class="comp-resize comp-rotate inside" id="inside_' + c.id + '" num="' + a.num + '" ctype="' + a.type + '"></li>');
                3 != ("" + a.type).charAt(0) && 1 != ("" + a.type).charAt(0) && d.attr("comp-resize", ""),
                "p" == ("" + a.type).charAt(0) && d.removeAttr("comp-rotate"),
                1 == ("" + a.type).charAt(0) && d.removeAttr("comp-drag"),
                2 == ("" + a.type).charAt(0) && d.addClass("wsite-text"),
                4 == ("" + a.type).charAt(0) && (a.properties.imgStyle && $(c).css(a.properties.imgStyle), d.addClass("wsite-image")),
                5 == ("" + a.type).charAt(0) && d.addClass("wsite-input"),
                6 == ("" + a.type).charAt(0) && d.addClass("wsite-button"),
                8 == ("" + a.type).charAt(0) && d.addClass("wsite-button"),
                "v" == ("" + a.type).charAt(0) && d.addClass("wsite-video"),
                d.mouseenter(function() {
                    $(this).addClass("inside-hover")
                }),
                d.mouseleave(function() {
                    $(this).removeClass("inside-hover")
                });
                var e = $('<div class="element-box">').append($('<div class="element-box-contents">').append(c));
                return d.append(e),
                5 != ("" + a.type).charAt(0) && 6 != ("" + a.type).charAt(0) || "edit" != b || $(c).before($('<div class="element" style="position: absolute; height: 100%; width: 100%;">')),
                a.css && (d.css({
                    width: 320 - parseInt(a.css.left)
                }), d.css({
                    width: a.css.width,
                    height: a.css.height,
                    left: a.css.left,
                    top: a.css.top,
                    zIndex: a.css.zIndex,
                    bottom: a.css.bottom,
                    transform: a.css.transform
                }), e.css(a.css).css({
                    width: "100%",
                    height: "100%",
                    transform: "none"
                }), e.children(".element-box-contents").css({
                    width: "100%",
                    height: "100%"
                }), 4 != ("" + a.type).charAt(0) && "p" != ("" + a.type).charAt(0) && $(c).css({
                    width: a.css.width,
                    height: a.css.height
                })),
                d
            }
        }
        function c(a) {
            for (var b = 0; b < a.length - 1; b++) for (var c = b + 1; c < a.length; c++) if (parseInt(a[b].css.zIndex, 10) > parseInt(a[c].css.zIndex, 10)) {
                var d = a[b];
                a[b] = a[c],
                a[c] = d
            }
            for (var e = 0; e < a.length; e++) a[e].css.zIndex = e + 1 + "";
            return a
        }
        function d(a, d, e) {
            d = d.find(".edit_area").css({
                overflow: "hidden"
            });
            var f,
            g = a.elements;
            if (g) for (g = c(g), f = 0; f < g.length; f++) if (3 == g[f].type) {
                var h = i[("" + g[f].type).charAt(0)](g[f]);
                "edit" == e && j[("" + g[f].type).charAt(0)] && j[("" + g[f].type).charAt(0)](h, g[f])
            } else {
                var m = b(g[f], e);
                if (!m) continue;
                d.append(m);
                for (var n = 0; n < l.length; n++) l[n](m, g[f], e);
                k[("" + g[f].type).charAt(0)] && k[("" + g[f].type).charAt(0)](m, g[f]),
                "edit" == e && j[("" + g[f].type).charAt(0)] && j[("" + g[f].type).charAt(0)](m, g[f])
            }
        }
        function e() {
            return j
        }
        function f() {
            return i
        }
        function g(a) {
            l.push(a)
        }
        function h() {
            return l
        }
        var i = {},
        j = {},
        k = {},
        l = [],
        m = containerWidth = 320,
        n = containerHeight = 486,
        o = 1,
        p = 1,
        q = {
            getComponents: f,
            getEventHandlers: e,
            addComponent: a(i),
            bindEditEvent: a(j),
            bindAfterRenderEvent: a(k),
            addInterceptor: g,
            getInterceptors: h,
            wrapComp: b,
            mode: "view",
            parse: function(a) {
                var b = $('<div class="edit_wrapper"><ul id="edit_area' + a.def.id + '" comp-droppable paste-element class="edit_area weebly-content-area weebly-area-active"></div>'),
                c = this.mode = a.mode;
                this.def = a.def,
                "view" == c && tplCount++;
                var e = $(a.appendTo);
                return containerWidth = e.width(),
                containerHeight = e.height(),
                o = m / containerWidth,
                p = n / containerHeight,
                d(a.def, b.appendTo($(a.appendTo)), c)
            }
        };
        return q
    });
    //添加页面中元素,css3动画
    c.addInterceptor(function(a, b) {
        function d(a, b, d) {
            a.css("animation", b + " " + d.duration + "s ease " + d.delay + "s " + (d.countNum ? d.countNum: "")),
            "view" == c.mode ? (d.count && a.css("animation-iteration-count", "infinite"), a.css("animation-fill-mode", "both")) : (a.css("animation-iteration-count", "1"), a.css("animation-fill-mode", "backwards")),
            d.linear && a.css("animation-timing-function", "linear")
        }
        if (b.properties && b.properties.anim) {
            var e = b.properties.anim,
            f = $(".element-box", a),
            g = "";
            0 === e.type && (g = "fadeIn"),
            1 === e.type && (0 === e.direction && (g = "fadeInLeft"), 1 === e.direction && (g = "fadeInDown"), 2 === e.direction && (g = "fadeInRight"), 3 === e.direction && (g = "fadeInUp")),
            6 === e.type && (g = "wobble"),
            5 === e.type && (g = "rubberBand"),
            7 === e.type && (g = "rotateIn"),
            8 === e.type && (g = "flip"),
            9 === e.type && (g = "swing"),
            2 === e.type && (0 === e.direction && (g = "bounceInLeft"), 1 === e.direction && (g = "bounceInDown"), 2 === e.direction && (g = "bounceInRight"), 3 === e.direction && (g = "bounceInUp")),
            3 === e.type && (g = "bounceIn"),
            4 === e.type && (g = "zoomIn"),
            10 === e.type && (g = "fadeOut"),
            11 === e.type && (g = "flipOutY"),
            12 === e.type && (g = "rollIn"),
            13 === e.type && (g = "lightSpeedIn"),
            b.properties.anim.trigger ? a.click(function() {
                d(f, g, b.properties.anim)
            }) : d(f, g, b.properties.anim)
        }
    }),
    //处理 类型为html文本
    c.addComponent("2", 
    function(a) {
        var b = document.createElement("div");
        return b.id = a.id,
        b.setAttribute("ctype", a.type),
        b.setAttribute("class", "element comp_paragraph editable-text"),
        a.content && (b.innerHTML = a.html ? a.html.replace('[TEXT]', a.content) : a.content),
        b.style.cursor = "default",
        b
    }),
    //处理 页面背景
    c.addComponent("3", 
    function(a) {
        var b = $("#nr .edit_area")[0];
        return "view" == c.mode && (b = document.getElementById("edit_area" + c.def.id)),
        b = $(b).parent()[0],
        a.properties.bgColor && (b.style.backgroundColor = a.properties.bgColor),
        a.properties.imgSrc && (b.style.backgroundImage = "url(" + a.properties.imgSrc + ")", b.style.backgroundOrigin = "element content-box", b.style.backgroundSize = "cover", b.style.backgroundPosition = "50% 50%"),
        b
    }),
    //处理 页面图片
    c.addComponent("4", 
    function(a) {
        var b = document.createElement("img");
        return b.id = a.id,
        b.setAttribute("ctype", a.type),
        b.setAttribute("class", "element comp_image editable-image"),
        b.src = a.properties.src,
        b
    }),
    c.addComponent("p", 
    function(a) {
        if (a.properties && a.properties.children) {
            var c = 320,
            d = 160,
            e = a.css.width || c,
            f = a.css.height || d,
            g = $('<div id="' + a.id + '" class="slide element" ctype="' + a.type + '"></div>'),
            h = $("<ul>").appendTo(g),
            i = $('<div class="dot">').appendTo(g);
            for (var j in a.properties.children) {
                var k = b(a.properties.children[j].width, a.properties.children[j].height, e, f),
                l = $('<img data-src="' + PREFIX_FILE_HOST + a.properties.children[j].src + '" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC">');
                l.css({
                    width: k.width,
                    height: k.height
                });
                var m = $("<li>").css({
                    lineHeight: f + "px"
                });
                m.append(l),
                h.append(m),
                i.append($("<span>"))
            }
            return INTERVAL_OBJ[a.id] && (clearInterval(INTERVAL_OBJ[a.id]), delete INTERVAL_OBJ[a.id]),
            g.attr("length", a.properties.children.length).attr("autoscroll", a.properties.autoPlay).attr("interval", a.properties.interval),
            g.swipeSlide({
                autoSwipe: a.properties.autoPlay,
                continuousScroll: !0,
                speed: a.properties.interval,
                transitionType: "cubic-bezier(0.22, 0.69, 0.72, 0.88)",
                lazyLoad: !0,
                width: e
            },
            function(b, c) {
                i.children().eq(b).addClass("cur").siblings().removeClass("cur"),
                c && (INTERVAL_OBJ[a.id] = c)
            }),
            g.get(0)
        }
    });
} (window.I9RIARENDER);
var I9RIAPAGE = function() {
    function a(a) {
        n = !0;
        for (var d, f = 0, g = e._pageData.length; g > f; f++) a == e._pageData[f].id && (d = e._pageData[f].num);
        d || (d = a);
        var h = $(e.$currentPage).find(".m-img").attr("id").charAt(4),
        i = $(e.$currentPage).siblings(".main-page").find("#page" + d);
        i && (e.$activePage = $(i).parent(".main-page").get(0), h > d ? b() : d > h && c())
    }
    function b() {
        var a = 0;
        f();
        var b = setInterval(function() {
            a += 2,
            "0" == e._scrollMode || "1" == e._scrollMode || "2" == e._scrollMode ? s = a: ("3" == e._scrollMode || "4" == e._scrollMode || "5" == e._scrollMode) && (r = a),
            g(),
            a >= 21 && (clearInterval(b), h())
        },
        1)
    }
    function c() {
        k = !1;
        var a = 0;
        f();
        var b = setInterval(function() {
            a -= 2,
            "0" == e._scrollMode || "1" == e._scrollMode || "2" == e._scrollMode ? s = a: ("3" == e._scrollMode || "4" == e._scrollMode || "5" == e._scrollMode) && (r = a),
            g(),
            -21 >= a && (clearInterval(b), h())
        },
        1)
    }
    function d() {
        k = !0
    }
    var e,f,g,h,i,j,k,l = $(window),m = !0,n = !1,o = mobilecheck(),p = 0,q = 0,r = 0,s = 0,t = !1,u = !1,v = !0,
    w = function(a, b, c, d) {
        function k(a, b, c) {
            for (var d = ["", "webkit", "moz"], e = 0, f = d.length; f > e; e++) {
                var g = c instanceof Array ? c[e] : c,
                h = d[e] + b;
                a[h] = g
            }
        }
        function w() {
            return $(e.$currentPage).find(".page_effect.lock").get(0) ? !1: !0
        }
        function x() {
            if (u) if (k(e.$currentPage.style, "Transform", "scale(1)"), "0" == b || "1" == b || "2" == b || "6" == b) {
                var a = s > 0 ? "": "-";
                k(e.$activePage.style, "Transform", "translateY(" + a + "100%)")
            } else {
                var a = r > 0 ? "": "-";
                k(e.$activePage.style, "Transform", "translateX(" + a + "100%)")
            }
            setTimeout(function() {
                e.$activePage.classList.remove("z-active"),
                e.$activePage.classList.remove("z-move"),
                e._isDisableFlipPage = !1
            },
            500)
        }
        function y() {
            if (Math.abs(s) > Math.abs(r) && w()) if (s > 0) {
                if (e._isDisableFlipPrevPage) return;
                u || v ? (u = !1, v = !1, e.$activePage && (e.$activePage.classList.remove("z-active"), e.$activePage.classList.remove("z-move")), n ? m = !0: e.$currentPage.previousElementSibling && e.$currentPage.previousElementSibling.classList.contains("main-page") ? e.$activePage = e.$currentPage.previousElementSibling: (e.$activePage = e._$pages.last().get(0), m = !0), e.$activePage && e.$activePage.classList.contains("main-page") ? (e.$activePage.classList.add("z-active"), e.$activePage.classList.add("z-move"), e.$activePage.style.webkitTransition = "none", e.$activePage.style.webkitTransform = "translateY(-" + window.innerHeight + "px)", e.$activePage.style.mozTransition = "none", e.$activePage.style.mozTransform = "translateY(-" + window.innerHeight + "px)", e.$activePage.style.transition = "none", e.$activePage.style.transform = "translateY(-" + window.innerHeight + "px)", $(e.$activePage).trigger("active"), e.$currentPage.style.webkitTransformOrigin = "bottom center", e.$currentPage.style.mozTransformOrigin = "bottom center", e.$currentPage.style.transformOrigin = "bottom center") : (e.$currentPage.style.webkitTransform = "translateY(0px) scale(1)", e.$currentPage.style.mozTransform = "translateY(0px) scale(1)", e.$currentPage.style.transform = "translateY(0px) scale(1)", e.$activePage = null)) : (e.$activePage.style.webkitTransform = "translateY(-" + (window.innerHeight - s) + "px)", e.$activePage.style.mozTransform = "translateY(-" + (window.innerHeight - s) + "px)", e.$activePage.style.transform = "translateY(-" + (window.innerHeight - s) + "px)", "1" == e._scrollMode && (e.$currentPage.style.webkitTransform = "scale(" + (window.innerHeight / (window.innerHeight + s)).toFixed(3) + ")", e.$currentPage.style.mozTransform = "scale(" + (window.innerHeight / (window.innerHeight + s)).toFixed(3) + ")", e.$currentPage.style.transform = "scale(" + (window.innerHeight / (window.innerHeight + s)).toFixed(3) + ")"))
            } else if (0 > s) {
                if (e._isDisableFlipNextPage) return; ! u || v ? (u = !0, v = !1, e.$activePage && (e.$activePage.classList.remove("z-active"), e.$activePage.classList.remove("z-move")), n ? m = !0: e.$currentPage.nextElementSibling && e.$currentPage.nextElementSibling.classList.contains("main-page") ? e.$activePage = e.$currentPage.nextElementSibling: (e.$activePage = e._$pages.first().get(0), m = !0), e.$activePage && e.$activePage.classList.contains("main-page") ? (e.$activePage.classList.add("z-active"), e.$activePage.classList.add("z-move"), e.$activePage.style.webkitTransition = "none", e.$activePage.style.webkitTransform = "translateY(" + window.innerHeight + "px)", e.$activePage.style.mozTransition = "none", e.$activePage.style.mozTransform = "translateY(" + window.innerHeight + "px)", e.$activePage.style.transition = "none", e.$activePage.style.transform = "translateY(" + window.innerHeight + "px)", $(e.$activePage).trigger("active"), e.$currentPage.style.webkitTransformOrigin = "top center", e.$currentPage.style.mozTransformOrigin = "top center", e.$currentPage.style.transformOrigin = "top center") : (e.$currentPage.style.webkitTransform = "translateY(0px) scale(1)", e.$currentPage.style.mozTransform = "translateY(0px) scale(1)", e.$currentPage.style.transform = "translateY(0px) scale(1)", e.$activePage = null)) : (e.$activePage.style.webkitTransform = "translateY(" + (window.innerHeight + s) + "px)", e.$activePage.style.mozTransform = "translateY(" + (window.innerHeight + s) + "px)", e.$activePage.style.transform = "translateY(" + (window.innerHeight + s) + "px)", "1" == e._scrollMode && (e.$currentPage.style.webkitTransform = "scale(" + ((window.innerHeight + s) / window.innerHeight).toFixed(3) + ")", e.$currentPage.style.mozTransform = "scale(" + ((window.innerHeight + s) / window.innerHeight).toFixed(3) + ")", e.$currentPage.style.transform = "scale(" + ((window.innerHeight + s) / window.innerHeight).toFixed(3) + ")"))
            }
        }
        function z() {
            childTouched = !1,
            Math.abs(s) > Math.abs(r) && Math.abs(s) > 20 ? ("1" == e._scrollMode ? (e.$currentPage.style.webkitTransform = "scale(0.2)", e.$activePage.style.webkitTransform = "translateY(0px)", e.$currentPage.style.mozTransform = "scale(0.2)", e.$activePage.style.mozTransform = "translateY(0px)", e.$currentPage.style.transform = "scale(0.2)", e.$activePage.style.transform = "translateY(0px)") : (e.$currentPage.style.webkitTransform = "scale(1)", e.$activePage.style.webkitTransform = "translateY(0px)", e.$currentPage.style.mozTransform = "scale(1)", e.$activePage.style.mozTransform = "translateY(0px)", e.$currentPage.style.transform = "scale(1)", e.$activePage.style.transform = "translateY(0px)"), w() || $("#audio_btn").css("opacity", 0), setTimeout(function() {
                $(e.$activePage).removeClass("z-active z-move").addClass("z-current"),
                $(e.$currentPage).removeClass("z-current z-move"),
                e._isDisableFlipPage = !1,
                e.$currentPage = $(e.$activePage).trigger("current"),
                $(e.$currentPage).trigger("hide")
            },
            500)) : (e._isDisableFlipPage = !1, x())
        }
        function A() {
            if (Math.abs(r) > Math.abs(s) && w()) if (r > 0) {
                if (e._isDisableFlipPrevPage) return;
                u || v ? (u = !1, v = !1, e.$activePage && (e.$activePage.classList.remove("z-active"), e.$activePage.classList.remove("z-move")), n ? m = !0: e.$currentPage.previousElementSibling && e.$currentPage.previousElementSibling.classList.contains("main-page") ? e.$activePage = e.$currentPage.previousElementSibling: (e.$activePage = e._$pages.last().get(0), m = !0), e.$activePage && e.$activePage.classList.contains("main-page") ? (e.$activePage.classList.add("z-active"), e.$activePage.classList.add("z-move"), e.$activePage.style.webkitTransition = "none", e.$activePage.style.webkitTransform = "translateX(-" + window.innerWidth + "px)", e.$activePage.style.mozTransition = "none", e.$activePage.style.mozTransform = "translateX(-" + window.innerWidth + "px)", e.$activePage.style.transition = "none", e.$activePage.style.transform = "translateX(-" + window.innerWidth + "px)", $(e.$activePage).trigger("active"), e.$currentPage.style.webkitTransformOrigin = "center right", e.$currentPage.style.mozTransformOrigin = "center right", e.$currentPage.style.transformOrigin = "center right") : (e.$currentPage.style.webkitTransform = "translateX(0px) scale(1)", e.$currentPage.style.mozTransform = "translateX(0px) scale(1)", e.$currentPage.style.transform = "translateX(0px) scale(1)", e.$activePage = null)) : (e.$activePage.style.webkitTransform = "translateX(-" + (window.innerWidth - r) + "px)", e.$activePage.style.mozTransform = "translateX(-" + (window.innerWidth - r) + "px)", e.$activePage.style.transform = "translateX(-" + (window.innerWidth - r) + "px)", "3" == e._scrollMode && (e.$currentPage.style.webkitTransform = "scale(" + (window.innerWidth / (window.innerWidth + r)).toFixed(3) + ")", e.$currentPage.style.mozTransform = "scale(" + (window.innerWidth / (window.innerWidth + r)).toFixed(3) + ")", e.$currentPage.style.transform = "scale(" + (window.innerWidth / (window.innerWidth + r)).toFixed(3) + ")"))
            } else if (0 > r) {
                if (e._isDisableFlipNextPage) return; ! u || v ? (u = !0, v = !1, e.$activePage && (e.$activePage.classList.remove("z-active"), e.$activePage.classList.remove("z-move")), n ? m = !0: e.$currentPage.nextElementSibling && e.$currentPage.nextElementSibling.classList.contains("main-page") ? e.$activePage = e.$currentPage.nextElementSibling: (e.$activePage = e._$pages.first().get(0), m = !0), e.$activePage && e.$activePage.classList.contains("main-page") ? (e.$activePage.classList.add("z-active"), e.$activePage.classList.add("z-move"), e.$activePage.style.webkitTransition = "none", e.$activePage.style.webkitTransform = "translateX(" + window.innerWidth + "px)", e.$activePage.style.mozTransition = "none", e.$activePage.style.mozTransform = "translateX(" + window.innerWidth + "px)", e.$activePage.style.transition = "none", e.$activePage.style.transform = "translateX(" + window.innerWidth + "px)", $(e.$activePage).trigger("active"), e.$currentPage.style.webkitTransformOrigin = "center left", e.$currentPage.style.mozTransformOrigin = "center left", e.$currentPage.style.transformOrigin = "center left") : (e.$currentPage.style.webkitTransform = "translateX(0px) scale(1)", e.$currentPage.style.mozTransform = "translateX(0px) scale(1)", e.$currentPage.style.transform = "translateX(0px) scale(1)", e.$activePage = null)) : (e.$activePage.style.webkitTransform = "translateX(" + (window.innerWidth + r) + "px)", e.$activePage.style.mozTransform = "translateX(" + (window.innerWidth + r) + "px)", e.$activePage.style.transform = "translateX(" + (window.innerWidth + r) + "px)", "3" == e._scrollMode && (e.$currentPage.style.webkitTransform = "scale(" + ((window.innerWidth + r) / window.innerWidth).toFixed(3) + ")", e.$currentPage.style.mozTransform = "scale(" + ((window.innerWidth + r) / window.innerWidth).toFixed(3) + ")", e.$currentPage.style.transform = "scale(" + ((window.innerWidth + r) / window.innerWidth).toFixed(3) + ")"))
            }
        }
        function B() {
            childTouched = !1,
            Math.abs(r) > Math.abs(s) && Math.abs(r) > 20 ? ("3" == e._scrollMode ? (e.$currentPage.style.webkitTransform = "scale(0.2)", e.$activePage.style.webkitTransform = "translateX(0px)", e.$currentPage.style.mozTransform = "scale(0.2)", e.$activePage.style.mozTransform = "translateX(0px)", e.$currentPage.style.transform = "scale(0.2)", e.$activePage.style.transform = "translateX(0px)") : (e.$currentPage.style.webkitTransform = "scale(1)", e.$activePage.style.webkitTransform = "translateX(0px)", e.$currentPage.style.mozTransform = "scale(1)", e.$activePage.style.mozTransform = "translateX(0px)", e.$currentPage.style.transform = "scale(1)", e.$activePage.style.transform = "translateX(0px)"), w() || $("#audio_btn").css("opacity", 0), setTimeout(function() {
                $(e.$activePage).removeClass("z-active z-move").addClass("z-current"),
                $(e.$currentPage).removeClass("z-current z-move"),
                e._isDisableFlipPage = !1,
                e.$currentPage = $(e.$activePage).trigger("current"),
                $(e.$currentPage).trigger("hide")
            },
            500)) : (e._isDisableFlipPage = !1, x())
        }
        function C() {
            if (Math.abs(r) > Math.abs(s) && w()) if (r > 0) {
                if (e._isDisableFlipPrevPage) return;
                u || v ? (u = !1, v = !1, e.$activePage && (e.$activePage.classList.remove("z-active"), e.$activePage.classList.remove("z-move")), n ? m = !0: e.$currentPage.previousElementSibling && e.$currentPage.previousElementSibling.classList.contains("main-page") ? e.$activePage = e.$currentPage.previousElementSibling: (e.$activePage = e._$pages.last().get(0), m = !0), e.$activePage && e.$activePage.classList.contains("main-page") ? (e.$activePage.classList.add("z-active"), e.$activePage.classList.add("z-move"), e.$activePage.style.webkitTransition = "none", e.$activePage.style.webkitTransform = "translateX(-" + i + "px)", e.$activePage.style.mozTransition = "none", e.$activePage.style.mozTransform = "translateX(-" + i + "px)", e.$activePage.style.transition = "none", e.$activePage.style.transform = "translateX(-" + i + "px)", $(e.$activePage).trigger("active")) : (e.$currentPage.style.webkitTransform = "translateX(0px) scale(1)", e.$currentPage.style.mozTransform = "translateX(0px) scale(1)", e.$currentPage.style.transform = "translateX(0px) scale(1)", e.$activePage = null)) : (e.$activePage.style.webkitTransform = "translateX(-" + (i - r) + "px)", e.$activePage.style.mozTransform = "translateX(-" + (i - r) + "px)", e.$activePage.style.transform = "translateX(-" + (i - r) + "px)", e.$currentPage.style.webkitTransform = "translateX(" + r + "px)", e.$currentPage.style.mozTransform = "translateX(" + r + "px)", e.$currentPage.style.transform = "translateX(" + r + "px)")
            } else if (0 > r) {
                if (e._isDisableFlipNextPage) return; ! u || v ? (u = !0, v = !1, e.$activePage && (e.$activePage.classList.remove("z-active"), e.$activePage.classList.remove("z-move")), n ? m = !0: e.$currentPage.nextElementSibling && e.$currentPage.nextElementSibling.classList.contains("main-page") ? e.$activePage = e.$currentPage.nextElementSibling: (e.$activePage = e._$pages.first().get(0), m = !0), e.$activePage && e.$activePage.classList.contains("main-page") ? (e.$activePage.classList.add("z-active"), e.$activePage.classList.add("z-move"), e.$activePage.style.webkitTransition = "none", e.$activePage.style.webkitTransform = "translateX(-" + i + "px)", e.$activePage.style.mozTransition = "none", e.$activePage.style.mozTransform = "translateX(-" + i + "px)", e.$activePage.style.transition = "none", e.$activePage.style.transform = "translateX(-" + i + "px)", $(e.$activePage).trigger("active")) : (e.$currentPage.style.webkitTransform = "translateX(0px) scale(1)", e.$currentPage.style.mozTransform = "translateX(0px) scale(1)", e.$currentPage.style.transform = "translateX(0px) scale(1)", e.$activePage = null)) : (e.$activePage.style.webkitTransform = "translateX(" + (i + r) + "px)", e.$activePage.style.mozTransform = "translateX(" + (i + r) + "px)", e.$activePage.style.transform = "translateX(" + (i + r) + "px)", e.$currentPage.style.webkitTransform = "translateX(" + r + "px)", e.$currentPage.style.mozTransform = "translateX(" + r + "px)", e.$currentPage.style.transform = "translateX(" + r + "px)")
            }
        }
        function D() {
            childTouched = !1,
            Math.abs(r) > Math.abs(s) && Math.abs(r) > 20 ? (r > 0 ? (e.$currentPage.style.webkitTransform = "translateX(" + i + "px)", e.$currentPage.style.mozTransform = "translateX(" + i + "px)", e.$currentPage.style.transform = "translateX(" + i + "px)") : (e.$currentPage.style.webkitTransform = "translateX(-" + i + "px)", e.$currentPage.style.mozTransform = "translateX(-" + i + "px)", e.$currentPage.style.transform = "translateX(-" + i + "px)"), e.$activePage.style.webkitTransform = "translateX(0px)", e.$activePage.style.mozTransform = "translateX(0px)", e.$activePage.style.transform = "translateX(0px)", w() || $("#audio_btn").css("opacity", 0), setTimeout(function() {
                $(e.$activePage).removeClass("z-active z-move").addClass("z-current"),
                $(e.$currentPage).removeClass("z-current z-move"),
                e._isDisableFlipPage = !1,
                e.$currentPage = $(e.$activePage).trigger("current"),
                $(e.$currentPage).trigger("hide")
            },
            500)) : (e._isDisableFlipPage = !1, x())
        }
        function E() {
            if (Math.abs(s) > Math.abs(r) && w()) if (s > 0) {
                if (e._isDisableFlipNextPage) return; ! u || v ? (u = !0, v = !1, e.$activePage && $(e.$activePage).removeClass("z-move z-active"), n ? m = !0: e.$currentPage.nextElementSibling && e.$currentPage.nextElementSibling.classList.contains("main-page") ? e.$activePage = e.$currentPage.nextElementSibling: (e.$activePage = e._$pages.first().get(0), m = !0)) : m = !0,
                e.$activePage && e.$activePage.classList.contains("main-page") && (k(e._$app.get(0).style, "perspective", "1000"), k(e._$app.get(0).style, "TransformStyle", "preserve-3d"), $(e.$activePage).addClass("z-active z-move").trigger("active"), k(e.$currentPage.style, "Transform", "translateZ(" + $(".nr").height() / 2 + "px)"), k(e.$activePage.style, "Transform", "rotateX(-90deg) translateZ(-" + $(".nr").height() / 2 + "px)"))
            } else if (0 > s) {
                if (e._isDisableFlipNextPage) return; (!u || v) && (u = !0, v = !1, e.$activePage && $(e.$activePage).removeClass("z-move z-active"), n ? m = !0: e.$currentPage.nextElementSibling && e.$currentPage.nextElementSibling.classList.contains("main-page") ? e.$activePage = e.$currentPage.nextElementSibling: (e.$activePage = e._$pages.first().get(0), 
                m = !0), e.$activePage && e.$activePage.classList.contains("main-page") ? (e._$app.get(0).style.webkitPerspective = "10000px", e._$app.get(0).style.perspective = "10000px", k(e._$app.get(0).style, "TransformStyle", "preserve-3d"), $(e.$activePage).addClass("z-active z-move").trigger("active")) : (k(e.$currentPage.style, "Transform", "translateX(0px) scale(1)"), e.$activePage = null))
            }
        }
        function F() {
            Math.abs(s) > Math.abs(r) && Math.abs(s) > 20 ? (s > 0 ? (e._$app.get(0).style.webkitTransform = "rotateX(89deg)", e._$app.get(0).style.transform = "rotateX(89deg)") : (e._$app.get(0).style.webkitPerspective = "10000px", e._$app.get(0).style.perspective = "10000px", k(e._$app.get(0).style, "TransformStyle", "preserve-3d"), e._$app.get(0).style.webkitTransform = "rotateY(-89deg)", e._$app.get(0).style.transform = "rotateY(-89deg)"), w() || $("#audio_btn").css("opacity", 0), setTimeout(function() {
                $(e.$activePage).removeClass("z-active z-move").addClass("z-current"),
                $(e.$currentPage).removeClass("z-current z-move"),
                e._isDisableFlipPage = !1,
                e.$currentPage = $(e.$activePage).trigger("current"),
                $(e.$currentPage).trigger("hide")
            },
            500)) : (e._isDisableFlipPage = !1, x())
        }
        this._$app = a,
        this._$pages = this._$app.find(".main-page"),
        this.$currentPage = this._$pages.eq(0),
        this.$activePage = null,
        this._isFirstShowPage = !0,
        this._isInitComplete = !1,
        this._isDisableFlipPage = !1,
        this._isDisableFlipPrevPage = !1,
        this._isDisableFlipNextPage = !1,
        this._scrollMode = b,
        this._pageData = c,
        this.pageData = d,
        b = b,
        e = this,
        i = o || window.top != window.self ? window.innerWidth: $(".nr").width(),
        j = o || window.top != window.self ? window.innerHeight: $(".nr").height(),
        function() {
            l.on("scroll.elasticity", 
            function(a) {
                a.preventDefault()
            }).on("touchmove.elasticity", 
            function(a) {
                a.preventDefault()
            }),
            l.delegate("img", "mousemove", 
            function(a) {
                a.preventDefault()
            })
        } (),
        e._$app.on("mousedown touchstart", 
        function(a) {
            return childTouched ? !1: void f(a)
        }).on("mousemove touchmove", 
        function(a) {
            g(a)
        }).on("mouseup touchend mouseleave", 
        function(a) {
            return childTouched ? !1: void h(a)
        }),
        f = function(a) {
            o && a && (a = event),e._isDisableFlipPage || (e.$currentPage = e._$pages.filter(".z-current").get(0), n || (e.$activePage = null), e.$currentPage && w() && (t = !0, u = !1, v = !0, r = 0, s = 0, a && "mousedown" == a.type ? (p = a.pageX, q = a.pageY) : a && "touchstart" == a.type && (p = a.touches[0].pageX, q = a.touches[0].pageY), e.$currentPage.classList.add("z-move"), k(e.$currentPage.style, "Transition", "none")))
        },
        g = function(a) {
            o && a && (a = event),
            t && e._$pages.length > 1 && (a && "mousemove" == a.type ? (r = a.pageX - p, s = a.pageY - q) : a && "touchmove" == a.type && (r = a.touches[0].pageX - p, s = a.touches[0].pageY - q), "0" == b || "2" == b || "1" == b ? y() : "4" == b || "3" == b ? A() : "5" == b ? C() : "6" == b && E())
        },
        h = function() {
            t && w() && (t = !1, e.$activePage ? (e._isDisableFlipPage = !0, e.$currentPage.style.webkitTransition = "-webkit-transform .4s linear", e.$activePage.style.webkitTransition = "-webkit-transform .4s linear", e.$currentPage.style.mozTransition = "-moz-transform .4s linear", e.$activePage.style.mozTransition = "-moz-transform .4s linear", e.$currentPage.style.transition = "transform .4s linear", e.$activePage.style.transition = "transform .4s linear", "0" == b || "2" == b || "1" == b ? z() : "4" == b || "3" == b ? B() : "5" == b ? D() : "6" == b && F()) : e.$currentPage.classList.remove("z-move")),
            n = !1
        }
    };
    return {
        pageScroll: a,
        nextPage: c,
        prePage: b,
        app: w,
        setEndCount: d
    }
}();
!function($) {

    // 判断如果为pc 则添加pc段样式
    function addElmentsForPc(a) {
        var b = document.getElementsByTagName("head")[0],
        c = document.createElement("link");
        c.href = "/Public/iwatch/styles/pcviewer.css",
        c.rel = "stylesheet",
        b.appendChild(c),
        window != window.top ? $("body").css("background-image", "none") : $(".p-index").wrap('<div class = "phone_panel ' + window.projectType + '"></div>'); //$('<div class = "ctrl_panel"></div>').appendTo($(".phone_panel")), $('<a id = "pre_page" type = "button" class = "pre_btn btn" onclick = "I9RIAPAGE.prePage()">上一页</a>').prependTo($(".ctrl_panel")), $('<a id = "next_page" type = "button" class = "next_btn btn" onclick = "I9RIAPAGE.nextPage()">下一页</a>').appendTo($(".ctrl_panel"));
    }

    function setWeixinShareData(a){
         var href = window.location.href, base = href, last = href.lastIndexOf("/");
        if (last != -1) base = base.substr(0, last);
        var path = a.imgUrl;
        if (path[0] != "/") path = "/" + path;

        window.shareData = {
            'title' : a.name,
            'desc' : a.desc,
            'imgUrl' : base + path + '?v='+(new Date()).getTime()
        };
    }

    // 后台获取json数据
    function getRequestUrl(sceneId) {
       return '/index.php?s=/Home/Pagetemplate/combinePagesData/token/'+sceneId+'.html';
    }

    // 解析json数据
    function parseJson(a) {
        document.title = a.obj.name,
        $("#metaDescription").attr("content", a.obj.name + ", " + a.obj.desc),
        isWeixin() && setWeixinShareData(a.obj),
        $(".scene_title").html(a.obj.name),
        pageMode = a.obj.pageMode;
        var b = [];

        return a.obj.property && (a.obj.property = JSON.parse(a.obj.property)),b = a.list,b.length <= 0 ? (alert("此场景不存在!"), void(window.location.href = "http://bee.9ria.com")) : (appendLastPage(a, b))
    }



    //
    function parsePage(a, b) {
        for (var c = [], d = !1, e = b.obj.bgAudio ? b.obj.audiourl : false, f = 1; f <= a.length; f++){
            if (
                $('<section class="main-page" ><div class="m-img" id="page' + f + '"></div></section>').appendTo(".nr"), //添加每一页的dom容器
                a.length > 1 && (0 == pageMode || 1 == pageMode || 2 == pageMode ? $('<section class="u-arrow-bottom"><img src="/Public/iwatch/images/btn01_arrow.png" /></section>').appendTo("#page" + f) : (3 == pageMode || 4 == pageMode || 5 == pageMode) && $('<section class="u-arrow-right"><img src="/Public/iwatch/images/btn01_arrow_right.png" /></section>').appendTo("#page" + f)), //pageMode 0 1 2 插入向上的箭头，3 4 5 插入像左的箭头
                1 == f && ($(".loading").hide(), $(".main-page").eq(0).addClass("z-current")), // 第一页设置为显示
                a[f - 1].properties && !$.isEmptyObject(a[f - 1].properties) ? a[f - 1].properties.image || a[f - 1].properties.scratch ? scriptLoaded.scratch ? addScratchEffect(a, f) : !
                function(b) {
                    $.getScript(CLIENT_CDN + "/Public/iwatch/scripts/scratch_effect.js", function() {
                        scriptLoaded.scratch = !0, addScratchEffect(e, a, b)
                    })
                }(f) : a[f - 1].properties.finger ? (c.push({
                    num: f,
                    finger: a[f - 1].properties.finger
                }), d || (d = !0, $.getScript("/Public/iwatch/scripts/lock_effect.js", function() {
                    test(e, a, c, $(".m-img").width(), $(".m-img").height())
                }))) : a[f - 1].properties.fallingObject ? scriptLoaded.fallingObject ? fallingObject(a, f) : !
                function(b) {
                    $.getScript(CLIENT_CDN + "/Public/iwatch/scripts/falling_object.js", function() {
                        scriptLoaded.fallingObject = !0, fallingObject(a, b), 1 == b && playVideo(e)
                    })
                }(f) : a[f - 1].properties.effect ? !
                function(b) {
                    resources.load(window.eqx[a[b - 1].properties.effect.name].config.resources), resources.onReady(function() {
                        window[a[b - 1].properties.effect.name].doEffect(e, b, a, renderPage)
                    })
                }(f) : renderPage(I9RIARENDER, f, a) : 
                (renderPage(I9RIARENDER, f, a), 1 == f && playVideo(e)),
                f == a.length
            ) {
                I9RIAPAGE.app($(".nr"), b.obj.pageMode, a, b);
            }
        } 
    }

    // 如果判断为企业/广告用户，则发请求获取模板 加载最后一页 现在去掉相关逻辑
    function appendLastPage(a, b) {
        if(window.projectType == "publish"){
        }else if(window.projectType == 'editor'){
            $(document).bind("pagetemplate.play",function(evt, pageid){
                $("section.main-page").remove();
                parsePage([b[pageid - 1]], a);
            });
        }else{

        }
    }

    function getTemplateData(){
        $.ajax({
            type: "GET",
            url: requestUrl,
            xhrFields: {
                withCredentials: !0
            },
            crossDomain: !0
        }).done(function(a) {
            if(!a.code){
                parseJson(a.data);
            }
        });
    }


    var url,preview,mobileview,pageMode,ad = 0,customLastPage = !1,scriptLoaded = {};

    if(/[http|https]:\/\/.*\/play\//.test(window.location.href)){
        url =  window.location.href.split("/play/")[1];
        window.projectType = 'publish';
    }else if(window.location.href.split("/templates/")[1]){
        url = window.location.href.split("/templates/")[1];
        window.projectType = 'demo';
    }else if(window.location.href.split('/editor/appid/')[1]){
        url = window.location.href.split('/editor/appid/')[1].split(".html")[0]
        window.projectType = 'editor';
    }else if(window.location.href.split('/editScene/appid/')[1]){
        url = window.location.href.split('/editScene/appid/')[1].split(".html")[0]
        window.projectType = 'editScene';
    }else{

    }

    url = /[http|https]:\/\/.*\/play\//.test(window.location.href) ? window.location.href.split("/play/")[1] : (window.location.href.split("/templates/")[1] ? window.location.href.split("/templates/")[1] : window.location.href.split('/appid/')[1].split(".html")[0]);
    var sceneId = url.split("#")[0].split("&")[0].split("?")[0].split("/")[0],param = url.split(sceneId)[1];
    param.indexOf("preview=preview") > 0 && (preview = !0),param.indexOf("mobileview=mobileview") > 0 && (mobileview = !0),mobilecheck() || addElmentsForPc(sceneId);
    var requestUrl = getRequestUrl(sceneId);
    jQuery.support.cors = !0,
    
    getTemplateData();

    $(document).bind("pagetemplate.getdata",function(evt, callback){
        getTemplateData();
    })

    var imgUrl,descContent,shareTitle
}(jQuery);

$(".main").show();