<template>
    <div class="kt-footer kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop">
        <div class="kt-footer__copyright">
        2019 &copy;&nbsp;<a href="https://www.guestquest.com/" target="_blank" class="kt-link"> Ivan Kovrlija</a>
        </div>
    </div>
</template>

<script>
(function(w,d,s,g,js,fs){
    g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
    js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
    js.src='https://apis.google.com/js/platform.js';
    fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
}(window,document,'script'));


export default {
    name: 'Footer'
}
</script>

