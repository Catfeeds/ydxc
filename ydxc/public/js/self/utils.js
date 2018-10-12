var utils = {
    androidInputBugFix: function () {
        // 安卓手机下输入框获取焦点时, 输入法挡住输入框的BUG
        if (this.isAndroid()) {
            window.addEventListener('resize', function () {
                if (document.activeElement.tagName == 'INPUT' || document.activeElement.tagName == 'TEXTAREA') {
                    window.setTimeout(function () {
                        document.activeElement.scrollIntoViewIfNeeded();
                    }, 0);
                }
            });
        }
    },
    isAndroid: function () {
        // 判断是否是安卓
        return /Android/gi.test(navigator.userAgent);
    },
    isIos: function () {
        // 判断是否是苹果
        return /iPad|iPhone/gi.test(navigator.userAgent);
    },
    isPc: function () {
        // 判断是否是PC
        var userAgentInfo = navigator.userAgent;
        var Agents = new Array('Android', 'iPhone', 'SymbianOS', 'Windows Phone', 'iPad', 'iPod');
        var flag = true;
        for (var i = 0; i < Agents.length; i++) {
            if (userAgentInfo.indexOf(Agents[i]) > 0) {
                flag = false;
                break;
            }
        }
        return flag;
    }
};