<!doctype html>
<html lang="en">
  @include('layouts.head')
  <body class="bg-gray-100 flex items-center justify-center min-h-screen p-6">
    <input type="hidden" name="webrtc-url" id="webrtc-url" value="http://localhost:8083/stream/6a058e52-b72d-4edd-9b8e-73faa1580e01/channel/0/webrtc">
    <div class="w-full max-w-4xl">
      <div class="w-full aspect-w-16 aspect-h-9 border-2 border-blue-500 shadow-lg rounded-lg overflow-hidden mb-6">
        <video id="webrtc-video" autoplay muted playsinline control class="w-full h-full bg-black"></video>
      </div>
      @include('anpr.index')
    </div>
  
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        function startPlay(videoEl, url) {
          const webrtc = new RTCPeerConnection({
            iceServers: [{
              urls: ['stun:stun.l.google.com:19302']
            }],
            sdpSemantics: 'unified-plan'
          });

          webrtc.ontrack = function (event) {
            console.log(event.streams.length + ' track is delivered');
            videoEl.srcObject = event.streams[0];
            videoEl.play();
          };

          webrtc.addTransceiver('video', { direction: 'sendrecv' });

          webrtc.onnegotiationneeded = async function handleNegotiationNeeded() {
            const offer = await webrtc.createOffer();
            await webrtc.setLocalDescription(offer);

            fetch(url, {
              method: 'POST',
              body: new URLSearchParams({ data: btoa(webrtc.localDescription.sdp) })
            })
              .then(response => response.text())
              .then(data => {
                try {
                  webrtc.setRemoteDescription(
                    new RTCSessionDescription({ type: 'answer', sdp: atob(data) })
                  );
                } catch (e) {
                  console.warn(e);
                }
              });
          };

          const webrtcSendChannel = webrtc.createDataChannel('rtsptowebSendChannel');
          webrtcSendChannel.onopen = (event) => {
            console.log(`${webrtcSendChannel.label} has opened`);
            webrtcSendChannel.send('ping');
          };
          webrtcSendChannel.onclose = (_event) => {
            console.log(`${webrtcSendChannel.label} has closed`);
            startPlay(videoEl, url);
          };
          webrtcSendChannel.onmessage = event => console.log(event.data);
        }

        const videoEl = document.querySelector('#webrtc-video');
        const webrtcUrl = document.querySelector('#webrtc-url').value;

        startPlay(videoEl, webrtcUrl);
      });
    </script>

  </body>
</html>
