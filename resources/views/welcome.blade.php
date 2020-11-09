<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Audio/Video Example - Record Plugin for Video.js</title>

  <link href="css/video-js.min.css" rel="stylesheet">
  <link href="css/videojs.record.css" rel="stylesheet">

  <script src="js/video.min.js"></script>
  <script src="js/RecordRTC.js"></script>
  <script src="js/adapter.js"></script>

  <script src="js/videojs.record.js"></script>
  {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
  <script src="//code.jquery.com/jquery-1.9.1.js"></script>

  <style>
  /* change player background color */
  #myVideo {
      background-color: #9ab87a;
  }
  </style>
</head>
<body>
<form action="{{route('upload')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" id="video_file" name="audiovideo"/>
    <input type="submit" name="submit" value="Upload" />
</form>

<video id="myVideo" class="video-js vjs-default-skin"></video>

<script>
var player = videojs("myVideo", {
    controls: true,
    width: 320,
    height: 240,
    fluid: false,
    plugins: {
        record: {
            audio: true,
            video: true,
            maxLength: 5,
            debug: true
        }
    }
}, function(){
    // print version information at startup
    var msg = 'Using video.js ' + videojs.VERSION +
        ' with videojs-record ' + videojs.getPluginVersion('record') +
        ' and recordrtc ' + RecordRTC.version;
    videojs.log(msg);
});
// error handling
player.on('deviceError', function() {
    console.log('device error:', player.deviceErrorCode);
});
player.on('error', function(error) {
    console.log('error:', error);
});
// user clicked the record button and started recording
player.on('startRecord', function() {
    console.log('started recording!');
});
// user completed recording and stream is available
player.on('finishRecord', function() {
    // the blob object contains the recorded data that
    // can be downloaded by the user, stored on server etc.
    console.log('finished recording: ', player.recordedData);

    $("#video_file").val(player.recordedData.video);
    var formData = new FormData();
    var token = $("[name='_token']").val();
    formData.append('audiovideo', player.recordedData.video);
    formData.append('_token', token);

    // localStorage['video_1'] = player.recordedData.video;

    // localStorage.setItem('data', JSON.stringify((player.recordedData.video), null, 2));
    
    // Execute the ajax request, in this case we have a very simple PHP script
    // that accepts and save the uploaded "video" file

    // $.ajax({
    //   url: '/upload',   
    //   type: "POST",
    //   processData: false,
    //   contentType: false,
    //   data: formData,
    //   success: function(data){
    //     console.log("Success");
    //     console.log(data);
    //   },
    //     error: function(data) {
            
    //         console.log("Error");
    //         console.log(data);
    //     },
    // });

    // xhr('/upload', formData, function (fName) {
    //     console.log(fName);
    //     // console.log("Video succesfully uploaded !");
    // });

    // // Helper function to send 
    // function xhr(url, data, callback) {
    //     var request = new XMLHttpRequest();
    //     // request.onreadystatechange = function () {
    //     //     if (request.readyState == 4 && request.status == 200) {
    //     //         callback(location.href + request.responseText);
    //     //     }
    //     // };
        
    //     request.onload = function () {
    //     if (xhr.status === 200) {
    //         // File(s) uploaded.
    //         uploadButton.innerHTML = 'Upload';
    //     } else {
    //         alert('An error occurred!');
    //     }
    //     };
    //     request.open('POST', url, true);
    //     request.send(data);
    // }
});
</script>

</body>
</html>