<!DOCTYPE html><html><head>
  <!--
    If you are serving your web app in a path other than the root, change the
    href value below to reflect the base path you are serving from.

    The path provided below has to start and end with a slash "/" in order for
    it to work correctly.

    For more details:
    * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/base

    This is a placeholder for base href that will be replaced by the value of
    the `--base-href` argument provided to `flutter build`.
  -->
  <base href="/">

  <meta charset="UTF-8">
  <meta content="IE=Edge" http-equiv="X-UA-Compatible">
  <meta name="description" content="Aplicación para manejo de pedidos">

  <!-- iOS meta tags & icons -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="apple-mobile-web-app-title" content="delivery">
  <link rel="apple-touch-icon" href="icons/Icon-192.png">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="favicon.png">

  <!-- TODO: Add your Google Maps API key here -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAohL1VFcI7Vs4g3fRTj7eOCE1XuuHmTdY"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

  <title>Distribuidora del Sur</title>
  <link rel="manifest" href="manifest.json">
  <script>
    // The value below is injected by flutter build, do not touch.
    var serviceWorkerVersion = "865499064";
  </script>
  <!-- This script adds the flutter initialization JS code -->
  <script src="flutter.js" defer=""></script>
  
  
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
  
  
  <style id="splash-screen-style">
    html {
      height: 100%
    }

    body {
      margin: 0;
      min-height: 100%;
      background-color: #ffffff;
          background-size: 100% 100%;
    }

    .center {
      margin: 0;
      position: absolute;
      top: 50%;
      left: 50%;
      -ms-transform: translate(-50%, -50%);
      transform: translate(-50%, -50%);
    }

    .contain {
      display:block;
      width:100%; height:100%;
      object-fit: contain;
    }

    .stretch {
      display:block;
      width:100%; height:100%;
    }

    .cover {
      display:block;
      width:100%; height:100%;
      object-fit: cover;
    }

    .bottom {
      position: absolute;
      bottom: 0;
      left: 50%;
      -ms-transform: translate(-50%, 0);
      transform: translate(-50%, 0);
    }

    .bottomLeft {
      position: absolute;
      bottom: 0;
      left: 0;
    }

    .bottomRight {
      position: absolute;
      bottom: 0;
      right: 0;
    }

    @media (prefers-color-scheme: dark) {
      body {
        background-color: #272727;
          }
    }
  </style>
  <script id="splash-screen-script">
    function removeSplashFromWeb() {
      document.getElementById("splash")?.remove();
      document.getElementById("splash-branding")?.remove();
      document.body.style.background = "transparent";
    }
  </script>
</head>
<body>
  <picture id="splash">
      <source srcset="splash/img/light-1x.gif 1x, splash/img/light-2x.gif 2x, splash/img/light-3x.gif 3x, splash/img/light-4x.gif 4x" media="(prefers-color-scheme: light)">
      <source srcset="splash/img/dark-1x.gif 1x, splash/img/dark-2x.gif 2x, splash/img/dark-3x.gif 3x, splash/img/dark-4x.gif 4x" media="(prefers-color-scheme: dark)">
      <img class="center" aria-hidden="true" src="splash/img/light-1x.gif" alt="">
  </picture>
  
  
  <script>
    window.addEventListener('load', function(ev) {
      // Download main.dart.js
      _flutter.loader.loadEntrypoint({
        serviceWorker: {
          serviceWorkerVersion: serviceWorkerVersion,
        },
        onEntrypointLoaded: function(engineInitializer) {
          engineInitializer.initializeEngine().then(function(appRunner) {
            appRunner.runApp();
          });
        }
      });
    });
  </script>


</body></html>