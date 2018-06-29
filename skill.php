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

/**
 * @param $URL 请求链接
 * @param null $data 数据 array() string
 * @param string $type 请求类型 POST GET PUT DELETE
 * @param string $headers 头部信息
 * @param string $data_type 返回数据类型 默认为json
 * @return mixed
 */
function curl_request($url, $data = null, $type = 'POST', $headers = "", $data_type = 'json'){
  $ch = curl_init();
  //判断ssl连接方式
  if(stripos($url, 'https://') !== false) {
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSLVERSION, 1);
  }
  $connttime = 300; //连接等待时间500毫秒
  $timeout = 15000;//超时时间15秒
  $querystring = "";
  if (is_array($data)) {
    foreach ($data as $key => $val) {
      if (is_array($val)) {
        foreach ($val as $val2) {
          $querystring .= urlencode($key).'='.urlencode($val2).'&';
        }
      } else {
        $querystring .= urlencode($key).'='.urlencode($val).'&';
      }
    }
    $querystring = substr($querystring, 0, -1); // Eliminate unnecessary &
  } else {
    $querystring = $data;
  }
  curl_setopt ($ch, CURLOPT_URL, $url); //发贴地址
  // 设置HEADER头部信息
  // if($headers!=""){
  //  curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
  // }else {
  //  curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Content-type: text/json'));
  // }
  curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);//反馈信息
  curl_setopt ($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1); //http 1.1版本

  curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT_MS, $connttime);//连接等待时间
  curl_setopt ($ch, CURLOPT_TIMEOUT_MS, $timeout);//超时时间
  switch ($type) {
    case "GET" : curl_setopt($ch, CURLOPT_HTTPGET, true);
      break;
    case "POST": curl_setopt($ch, CURLOPT_POST,true);
      curl_setopt($ch, CURLOPT_POSTFIELDS,$querystring);
      break;
    case "PUT" : curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "PUT");
      curl_setopt($ch, CURLOPT_POSTFIELDS,$querystring);
      break;
    case "DELETE": curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
      curl_setopt($ch, CURLOPT_POSTFIELDS,$querystring);
      break;
  }
  $output = curl_exec($ch);
  $status = curl_getinfo($ch);
  curl_close($ch);
  if (isset($status['http_code']) && $status['http_code'] == 200) {
    return $output;
  } else {
    Log::error($output);
    return $output;
  }
}
