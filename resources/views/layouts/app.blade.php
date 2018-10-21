<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta property="og:url" content="https://coinware.co">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Coinware Airdrop">
    <meta property="og:description" content="Coinware Exchange Website: https://coinware.co">
    <meta property="og:image" content="{{asset('/public/img/logo-icon.png')}}">

    <title>Coinware - Airdrop</title>
    <link href="{{asset('/public/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('/public/css/core.min.css')}}" rel="stylesheet">
    <link href="{{asset('/public/css/thesaas.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
    <link rel="icon" href="{{asset('/public/img/favicon.png')}}">
    <style>
      .gradient-header {
        background: #DE6262;
        /* fallback for old browsers */
        background: -webkit-linear-gradient(to right, #FFB88C, #DE6262);
        /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #FFB88C, #DE6262);
        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
      }

      .text-theme {
        color: #fff !important;
      }
      i.fa.fa-check-circle {
          margin-left: 45%;
          font-size: 80px;
          color: #00a99d;
      }
   
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/4.11.0/d3.js"></script>
    <script src="https://sdk.accountkit.com/en_US/sdk.js"></script>
    @yield('headerjs')
  </head>
  <body class="thesaas-sections-split">
    <!-- Topbar -->
    <nav class="topbar topbar-expand-md topbar-sticky">
      <div class="container">
        <div class="topbar-left">
          <button class="topbar-toggler">☰</button>
          <a class="topbar-brand" href="https://lalaworld.io/">
            <img class="logo-default" src="{{asset('/public/img/logo.png')}}">
            <img class="logo-inverse" src="{{asset('/public/img/logo.png')}}">
          </a>
        </div>
        <div class="topbar-right">
          <nav class="topbar topbar-expand-md">
            <div class="container">
              <div class="topbar-left">
                <button class="topbar-toggler">☰</button>
                <a class="topbar-brand" href="https://lalaworld.io/">
                  <img class="logo-default" src="{{asset('/public/img/logo.png')}}">
                  <img class="logo-inverse" src="{{asset('/public/img/logo.png')}}">
                </a>
              </div>
              <div class="topbar-right">
                <ul class="topbar-nav nav">
                  <li class="nav-item">
                    <a class="nav-link" href="https://coinware.co/" target="_blank">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="https://coinware.co/whitepaper.pdf" target="_blank">Whitepaper</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="http://coinware.co" target="_blank">Crowdsale</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#" data-scrollto="token-profile">Token Profile</a>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
        </div>
      </div>
    </nav>
    @yield('content')
    <section id="footer" class="footer-section">
      <div class="container footer-width">
        <hr class="footer white" width="100%">
        <div class="container text-center footer-width footer-bottom">
          <p>
          <img class="footer-logo" src="{{asset('/public/img/logo-icon.png')}}">
          </p>
        </div>
      </div>
    </section>
    <script src="{{asset('/public/js/core.min.js')}}"></script>
    <script src="{{asset('/public/js/thesaas.min.js')}}"></script>
    <script src="{{asset('/public/js/script.js')}}"></script>
    <script src="{{asset('/public/js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('/public/js/notify.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
    @yield('footerjs')
  </body>
</html>
