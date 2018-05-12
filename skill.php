<?php
#实现vue 的滚动加载数据
loadMore: function () {
    var wrapper = document.querySelector('.modal-dialog-body');
    var container = document.querySelector('.fan-out-body');
    $('.modal-dialog-body').scroll(function(){
      var scrollTop = wrapper.scrollTop;
      if (scrollTop + wrapper.clientHeight >= container.clientHeight) {
        if (material.scrollDisable) {
          console.log('lai');
          material.scrollDisable = false;
          var params = {},
              filter = {page: material.fansPage+1, rows: material.fansRows};
          // 触发加载数据
          material.$http.get("{:url('home/app/fans', ['id' => $Think.get.id])}", {params: filter}).then(function(res) {
            material.fansPage = res.body.page;
            res.body.fans.forEach(loadfans => {
              material.fans.push(loadfans);
            });
            material.scrollDisable = true;
          });
        }
      }
   });
},
