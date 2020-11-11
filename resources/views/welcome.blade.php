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
    @csrf

    <video id="myVideo" class="video-js vjs-default-skin"></video>

    <script>
        // start_recording();

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
            console.log('finished recording: ', player.recordedData.name);

            var formData = new FormData();
            var token = $("[name='_token']").val();
            formData.append('audiovideo', player.recordedData);
            formData.append('_token', token);

            $.ajax({
            url: '/upload',   
            type: "POST",
            processData: false,
            contentType: false,
            data: formData,
            success: function(data){
                console.log("Success");
                console.log(data);
            },
                error: function(data) {
                    
                    console.log("Error");
                    console.log(data);
                },
            });

        });

        // function start_recording(){
        //     player.startRecord();
        //     console.log("Starting");
        // }
    </script>

</body>
</html>