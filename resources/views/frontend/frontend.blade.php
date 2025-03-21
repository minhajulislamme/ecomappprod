<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Ever Store</title>

    <!-- Initialize Data Layer -->
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', '{{ $gtm_id }}');
    </script>

    <!-- Google Tag Manager -->
    @if ($gtm_id)
        <script>
            (function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s),
                    dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', '{{ $gtm_id }}');
        </script>
    @endif
    <!-- End Google Tag Manager -->

    <!-- rimix icon cdn  -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />

    <!-- Add Swiper CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- CSS -->
    @vite(['resources/css/frontend/app.css', 'resources/js/frontend/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Facebook Meta Pixel Code -->
    @if ($pixel_id)
        <script>
            ! function(f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function() {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $pixel_id }}');
            fbq('track', 'PageView');
        </script>
        <noscript>
            <img height="1" width="1" style="display:none"
                src="https://www.facebook.com/tr?id={{ $pixel_id }}&ev=PageView&noscript=1" />
        </noscript>
    @endif
    <!-- End Facebook Meta Pixel Code -->
</head>

<body class="bg-gray-100 font-jost">
    <!-- Google Tag Manager (noscript) -->
    @if ($gtm_id)
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtm_id }}" height="0" width="0"
                style="display:none;visibility:hidden"></iframe>
        </noscript>
    @endif
    <!-- End Google Tag Manager (noscript) -->

    <!-- top bar start  -->
    @include('frontend.body.topbar')
    <!-- Mobile/Tablet View -->
    @include('frontend.body.mobiletopbar')
    <!-- top bar end  -->

    <!-- Navbar start  -->
    @include('frontend.body.navbar')
    <!-- Navbar end  -->

    <!-- Mobile Bottom Navigation -->
    @include('frontend.body.mobilebottomnav')
    <!-- Mobile Category Menu -->
    @include('frontend.body.mobilecategorymenu')

    <!-- Main Content -->

    @yield('content')
    <!-- show more product  end  -->
    <!-- Scroll to top button -->
    <a href="#" id="scrollToTop"
        class="fixed bottom-20 right-4 lg:bottom-8 lg:right-8 bg-orange-500 text-white w-10 h-10 rounded-full shadow-lg flex items-center justify-center transform scale-0 transition-all duration-300 hover:bg-orange-600 z-50">
        <i class="ri-arrow-up-line text-xl"></i>
    </a>

    <!-- delivery trust secure payment start -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Free Delivery -->
            <div
                class="flex items-center space-x-6 p-6 rounded-lg  transition-all duration-300 group border-2 border-dashed border-orange-200">
                <div
                    class="w-16 h-16 rounded-full bg-orange-100 text-orange-500 flex items-center justify-center group-hover:bg-orange-500 group-hover:text-white transition-all duration-300">
                    <i class="ri-truck-line text-3xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">Free Delivery</h3>
                    <p class="text-gray-500 text-sm">Free shipping on all orders over $200</p>
                </div>
            </div>

            <!-- Money Back Guarantee -->
            <div
                class="flex items-center space-x-6 p-6 rounded-lg  transition-all duration-300 group border-2 border-dashed border-orange-200">
                <div
                    class="w-16 h-16 rounded-full bg-orange-100 text-orange-500 flex items-center justify-center group-hover:bg-orange-500 group-hover:text-white transition-all duration-300">
                    <i class="ri-money-dollar-circle-line text-3xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">Money Back Guarantee</h3>
                    <p class="text-gray-500 text-sm">100% money back guarantee</p>
                </div>
            </div>

            <!-- Secure Payment -->
            <div
                class="flex items-center space-x-6 p-6 rounded-lg  transition-all duration-300 group border-2 border-dashed border-orange-200">
                <div
                    class="w-16 h-16 rounded-full bg-orange-100 text-orange-500 flex items-center justify-center group-hover:bg-orange-500 group-hover:text-white transition-all duration-300">
                    <i class="ri-shield-check-line text-3xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">Secure Payment</h3>
                    <p class="text-gray-500 text-sm">All payments are secured</p>
                </div>
            </div>
        </div>
    </div>
    <!-- delivery trust secure payment end -->

    <!-- Floating Action Buttons -->
    <div class="fixed left-4 bottom-20 lg:bottom-8 z-50">
        <!-- Main Chat Button -->
        <a href="#" onclick="toggleFloatingButtons()"
            class="relative flex items-center justify-center w-10 h-10 bg-orange-500 text-white rounded-full shadow-lg hover:bg-orange-600 transform hover:-translate-y-1 transition-all duration-300 group">
            <i class="ri-message-3-line text-xl"></i>
            <span
                class="absolute left-full ml-2 bg-orange-500 text-white text-sm py-1 px-2 rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none">
                Live Chat
            </span>
        </a>

        <!-- Hidden Buttons Container -->
        <div id="hiddenButtons"
            class="absolute bottom-16 left-0 flex flex-col gap-3 scale-0 opacity-0 transition-all duration-300 origin-bottom-left">
            <!-- massenger  -->
            <a href="https://m.me/username" target="_blank" class="flex items-center group">
                <div
                    class="flex items-center justify-center w-10 h-10 bg-blue-500 text-white rounded-full shadow-lg hover:bg-blue-600 transform hover:-translate-y-1 transition-all duration-300">
                    <i class="ri-messenger-line text-2xl"></i>
                </div>
                <span
                    class="bg-orange-500 text-white text-sm py-1 px-2 rounded ml-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">Messenger</span>
            </a>
            <!-- WhatsApp -->
            <a href="https://wa.me/1234567890" target="_blank" class="flex items-center group">
                <div
                    class="flex items-center justify-center w-10 h-10 bg-green-500 text-white rounded-full shadow-lg hover:bg-green-600 transform hover:-translate-y-1 transition-all duration-300">
                    <i class="ri-whatsapp-line text-2xl"></i>
                </div>
                <span
                    class="bg-orange-500 text-white text-sm py-1 px-2 rounded ml-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">WhatsApp</span>
            </a>

            <!-- Call -->
            <a href="tel:+1234567890" class="flex items-center group">
                <div
                    class="flex items-center justify-center w-10 h-10 bg-blue-500 text-white rounded-full shadow-lg hover:bg-blue-600 transform hover:-translate-y-1 transition-all duration-300">
                    <i class="ri-phone-line text-2xl"></i>
                </div>
                <span
                    class="bg-orange-500 text-white text-sm py-1 px-2 rounded ml-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">Call
                    Us</span>
            </a>
        </div>
    </div>


    <!-- Cart Sidebar -->
    @include('frontend.body.cartsidebar')

    <!-- Wishlist Sidebar -->
    @include('frontend.body.wishlistsidebar')

    <!-- Footer Section -->
    @include('frontend.body.footer')

    <!-- Add padding to body to prevent content from being hidden behind fixed bottom nav -->


    <!-- JS -->
    {{-- <script src="src/js/app.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src={{ asset('js/frontend/image_vaild.js') }}></script>
    <script src={{ asset('js/frontend/custom.js') }}></script>
    <script>
        @if (Session::has('message'))
            Swal.fire({
                text: "{{ Session::get('message') }}",
                icon: "{{ Session::get('alert-type', 'success') }}",
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'colored-toast'
                }
            });
        @endif
    </script>
    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;

                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;

                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;

                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif
    </script>

    <!-- GTM Data Layer Helper -->
    <script>
        // Helper function to safely push to data layer
        function pushToDataLayer(data) {
            window.dataLayer = window.dataLayer || [];
            // Clear previous ecommerce object
            dataLayer.push({
                ecommerce: null
            });
            // Push new data
            dataLayer.push(data);
        }

        // Helper function for ecommerce events
        function pushEcommerceEvent(eventName, ecommerceData) {
            pushToDataLayer({
                event: eventName,
                ecommerce: ecommerceData
            });
        }
    </script>

    @yield('scripts')
</body>

</html>
