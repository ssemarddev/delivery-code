'use strict';
const MANIFEST = 'flutter-app-manifest';
const TEMP = 'flutter-temp-cache';
const CACHE_NAME = 'flutter-app-cache';

const RESOURCES = {"assets/AssetManifest.bin": "23df8f36031396d8e146cd13d1c9ffe7",
"assets/AssetManifest.json": "25e81d4005debda5e08f159f2c7363c9",
"assets/assets/api.json": "28db157c359c3b0d3b38934158935b93",
"assets/assets/front.jpg": "1dbb6c587b6b0a258c31560822337e33",
"assets/assets/image-placeholder.jpg": "771b76fe092f32dfb7654568f1117d49",
"assets/assets/loading.gif": "8db4ac819adce29d013cf39e9620527a",
"assets/assets/loading.png": "e53dcb662d7f9409e2bb4cd09263808b",
"assets/assets/loading_dark.gif": "1548722c835c649f1d449d2903117028",
"assets/assets/loading_dark.png": "936f9c62c947ab0beb6e96425b1ce0a5",
"assets/assets/loading_web.gif": "007ba0bb2d842c3a8a3beb7ba3a4fd20",
"assets/assets/map.png": "f7f82aebbf0add8114b8eceda932f8be",
"assets/assets/marker_1.png": "41b6f41dee9a9ef94cee79d0a20f061e",
"assets/assets/marker_10.png": "32946e1b17145b564960d311f947bf06",
"assets/assets/marker_11.png": "e560f191b9691b206b267b38cf52b547",
"assets/assets/marker_12.png": "2df073f019adc2f48cf6f1a7306c1850",
"assets/assets/marker_13.png": "0723da75d260931eb5cd54d73d4e7e71",
"assets/assets/marker_14.png": "26de371e0153c47d5b272dfbe3b4abb3",
"assets/assets/marker_15.png": "b39dd5fe3247bc709ced43fbed54f09d",
"assets/assets/marker_16.png": "52a605f880396e979a5ef1dc07377e23",
"assets/assets/marker_17.png": "befbd234f9c8471b7e3a3b73a42b396a",
"assets/assets/marker_18.png": "b61a22301b1a0301ca70eedca95f80ba",
"assets/assets/marker_19.png": "23c19db2f1b5f8e3c166033a99120018",
"assets/assets/marker_2.png": "1b0a0bc0c82445a890f0d2361491f44a",
"assets/assets/marker_20.png": "a994b7eb81a24538c77e1a0597574bc0",
"assets/assets/marker_21.png": "5c4b5fe7dea5b634662b0421d9b82518",
"assets/assets/marker_22.png": "86cfba374cc4187e9cfb887eb961adfc",
"assets/assets/marker_23.png": "15bf67e79354cfd4bf9fbd0420ec854b",
"assets/assets/marker_24.png": "8d64bf1ca1505ab6ae5496b89ff52363",
"assets/assets/marker_25.png": "de9b06b13c181b78dc147bdf8af7337c",
"assets/assets/marker_26.png": "16ae851b7993e99fcf3af92285a472f3",
"assets/assets/marker_27.png": "0e17277508023ee9f1c61729a918d48f",
"assets/assets/marker_28.png": "67ee2c1bdb5df1c809d2810b2309c704",
"assets/assets/marker_29.png": "3cec132761f6fe49179d39aaf5086c83",
"assets/assets/marker_3.png": "221f2b353f545cff8e9818383164a30d",
"assets/assets/marker_4.png": "b318d729e49f8d0811957b78fe5319c6",
"assets/assets/marker_5.png": "db0d355b5687041cb96d4ca517bec644",
"assets/assets/marker_6.png": "5bf606b19e12b3d0de8befcfa81597e7",
"assets/assets/marker_7.png": "9929fd5d6c579ef53666fac6747ba0a1",
"assets/assets/marker_8.png": "ca34042425abd4066ff348fd9455b3d6",
"assets/assets/marker_9.png": "2eee56720daeef6687ca484f332f9dd0",
"assets/FontManifest.json": "dc3d03800ccca4601324923c0b1d6d57",
"assets/fonts/MaterialIcons-Regular.otf": "6c7fda98572cfb760664e4b7f539c27c",
"assets/NOTICES": "1f59fe98c0de0c7586d7bd507250df03",
"assets/packages/cupertino_icons/assets/CupertinoIcons.ttf": "57d849d738900cfd590e9adc7e208250",
"assets/packages/localization/test/assets/lang/en_US.json": "18804652fbce3b62aacb6cce6f572f3c",
"assets/packages/localization/test/assets/lang/pt_BR.json": "f999b93065fe17d355d1ac5dcc1ff830",
"assets/packages/localization/test/assets/lang2/en_US.json": "b389499c34b7ee2ec98c62fe49e08fa0",
"assets/packages/localization/test/assets/lang2/pt_BR.json": "08e9b784a138126822761beec7614524",
"assets/packages/toast/assets/toastify.css": "a85675050054f179444bc5ad70ffc635",
"assets/packages/toast/assets/toastify.js": "e7006a0a033d834ef9414d48db3be6fc",
"assets/shaders/ink_sparkle.frag": "f8b80e740d33eb157090be4e995febdf",
"canvaskit/canvaskit.js": "76f7d822f42397160c5dfc69cbc9b2de",
"canvaskit/canvaskit.wasm": "f48eaf57cada79163ec6dec7929486ea",
"canvaskit/chromium/canvaskit.js": "8c8392ce4a4364cbb240aa09b5652e05",
"canvaskit/chromium/canvaskit.wasm": "fc18c3010856029414b70cae1afc5cd9",
"canvaskit/skwasm.js": "1df4d741f441fa1a4d10530ced463ef8",
"canvaskit/skwasm.wasm": "6711032e17bf49924b2b001cef0d3ea3",
"canvaskit/skwasm.worker.js": "19659053a277272607529ef87acf9d8a",
"favicon.png": "5dcef449791fa27946b3d35ad8803796",
"flutter.js": "6b515e434cea20006b3ef1726d2c8894",
"icons/Icon-192.png": "ac9a721a12bbc803b44f645561ecb1e1",
"icons/Icon-512.png": "96e752610906ba2a93c65f8abe1645f1",
"icons/Icon-maskable-192.png": "c457ef57daa1d16f64b27b786ec2ea3c",
"icons/Icon-maskable-512.png": "301a7604d45b3e739efc881eb04896ea",
"index.html": "793ee99e42ec76f9421da2c27f2b8393",
"/": "793ee99e42ec76f9421da2c27f2b8393",
"main.dart.js": "5568b012f636bcefad3ea84a060ad8a5",
"manifest.json": "aec85c705181ff58d8d665ab394ad8fc",
"native.js": "33eeb53b0d0ee54076fdd721f7834629",
"splash/img/dark-1x.gif": "7cf0c4493f1c629d9d0b4106e6c7e80f",
"splash/img/dark-2x.gif": "bc6b2bb55da9b804a933d71bb6e2a193",
"splash/img/dark-3x.gif": "4b1a2c50f27ee08ee391cbcc5d888efc",
"splash/img/dark-4x.gif": "a3fe4a6942d211ded087877db62d23d5",
"splash/img/light-1x.gif": "d1f3e12401150e6aa8b2c45412318117",
"splash/img/light-2x.gif": "094da96dbe20ac0f95aebdeffe3ca00f",
"splash/img/light-3x.gif": "8ccb8b4f149fe1e9a2a5e898a6afcc8a",
"splash/img/light-4x.gif": "2012432d4d3c482a65aa632ca1a9cce4",
"version.json": "40e8533d355c52ea7acc734476976f29"};
// The application shell files that are downloaded before a service worker can
// start.
const CORE = ["main.dart.js",
"index.html",
"assets/AssetManifest.json",
"assets/FontManifest.json"];

// During install, the TEMP cache is populated with the application shell files.
self.addEventListener("install", (event) => {
  self.skipWaiting();
  return event.waitUntil(
    caches.open(TEMP).then((cache) => {
      return cache.addAll(
        CORE.map((value) => new Request(value, {'cache': 'reload'})));
    })
  );
});
// During activate, the cache is populated with the temp files downloaded in
// install. If this service worker is upgrading from one with a saved
// MANIFEST, then use this to retain unchanged resource files.
self.addEventListener("activate", function(event) {
  return event.waitUntil(async function() {
    try {
      var contentCache = await caches.open(CACHE_NAME);
      var tempCache = await caches.open(TEMP);
      var manifestCache = await caches.open(MANIFEST);
      var manifest = await manifestCache.match('manifest');
      // When there is no prior manifest, clear the entire cache.
      if (!manifest) {
        await caches.delete(CACHE_NAME);
        contentCache = await caches.open(CACHE_NAME);
        for (var request of await tempCache.keys()) {
          var response = await tempCache.match(request);
          await contentCache.put(request, response);
        }
        await caches.delete(TEMP);
        // Save the manifest to make future upgrades efficient.
        await manifestCache.put('manifest', new Response(JSON.stringify(RESOURCES)));
        // Claim client to enable caching on first launch
        self.clients.claim();
        return;
      }
      var oldManifest = await manifest.json();
      var origin = self.location.origin;
      for (var request of await contentCache.keys()) {
        var key = request.url.substring(origin.length + 1);
        if (key == "") {
          key = "/";
        }
        // If a resource from the old manifest is not in the new cache, or if
        // the MD5 sum has changed, delete it. Otherwise the resource is left
        // in the cache and can be reused by the new service worker.
        if (!RESOURCES[key] || RESOURCES[key] != oldManifest[key]) {
          await contentCache.delete(request);
        }
      }
      // Populate the cache with the app shell TEMP files, potentially overwriting
      // cache files preserved above.
      for (var request of await tempCache.keys()) {
        var response = await tempCache.match(request);
        await contentCache.put(request, response);
      }
      await caches.delete(TEMP);
      // Save the manifest to make future upgrades efficient.
      await manifestCache.put('manifest', new Response(JSON.stringify(RESOURCES)));
      // Claim client to enable caching on first launch
      self.clients.claim();
      return;
    } catch (err) {
      // On an unhandled exception the state of the cache cannot be guaranteed.
      console.error('Failed to upgrade service worker: ' + err);
      await caches.delete(CACHE_NAME);
      await caches.delete(TEMP);
      await caches.delete(MANIFEST);
    }
  }());
});
// The fetch handler redirects requests for RESOURCE files to the service
// worker cache.
self.addEventListener("fetch", (event) => {
  if (event.request.method !== 'GET') {
    return;
  }
  var origin = self.location.origin;
  var key = event.request.url.substring(origin.length + 1);
  // Redirect URLs to the index.html
  if (key.indexOf('?v=') != -1) {
    key = key.split('?v=')[0];
  }
  if (event.request.url == origin || event.request.url.startsWith(origin + '/#') || key == '') {
    key = '/';
  }
  // If the URL is not the RESOURCE list then return to signal that the
  // browser should take over.
  if (!RESOURCES[key]) {
    return;
  }
  // If the URL is the index.html, perform an online-first request.
  if (key == '/') {
    return onlineFirst(event);
  }
  event.respondWith(caches.open(CACHE_NAME)
    .then((cache) =>  {
      return cache.match(event.request).then((response) => {
        // Either respond with the cached resource, or perform a fetch and
        // lazily populate the cache only if the resource was successfully fetched.
        return response || fetch(event.request).then((response) => {
          if (response && Boolean(response.ok)) {
            cache.put(event.request, response.clone());
          }
          return response;
        });
      })
    })
  );
});
self.addEventListener('message', (event) => {
  // SkipWaiting can be used to immediately activate a waiting service worker.
  // This will also require a page refresh triggered by the main worker.
  if (event.data === 'skipWaiting') {
    self.skipWaiting();
    return;
  }
  if (event.data === 'downloadOffline') {
    downloadOffline();
    return;
  }
});
// Download offline will check the RESOURCES for all files not in the cache
// and populate them.
async function downloadOffline() {
  var resources = [];
  var contentCache = await caches.open(CACHE_NAME);
  var currentContent = {};
  for (var request of await contentCache.keys()) {
    var key = request.url.substring(origin.length + 1);
    if (key == "") {
      key = "/";
    }
    currentContent[key] = true;
  }
  for (var resourceKey of Object.keys(RESOURCES)) {
    if (!currentContent[resourceKey]) {
      resources.push(resourceKey);
    }
  }
  return contentCache.addAll(resources);
}
// Attempt to download the resource online before falling back to
// the offline cache.
function onlineFirst(event) {
  return event.respondWith(
    fetch(event.request).then((response) => {
      return caches.open(CACHE_NAME).then((cache) => {
        cache.put(event.request, response.clone());
        return response;
      });
    }).catch((error) => {
      return caches.open(CACHE_NAME).then((cache) => {
        return cache.match(event.request).then((response) => {
          if (response != null) {
            return response;
          }
          throw error;
        });
      });
    })
  );
}
