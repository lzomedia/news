

<footer class="bg-dark">

    <div class="container">
        <div class="row d-flex justify-content-center">

            <p class="text-center text-white no-margins pt-2">
                <a href="{{ route('website.about') }}" title="about" class="text-white">
                    About
                </a>
                |
                <a href="{{ route('website.terms') }}" title="terms" class="text-white">
                    Terms & Conditions
                </a>
                |
                <a href="{{ route('website.sitemap') }}" title="sitemap" class="text-white">
                    Sitemap
                </a>
                |
                <a href="{{ route('website.feed') }}" title="sitemap" class="text-white">
                    Rss Feed
                </a>
            </p>
            <p class="m-0 text-center text-white pb-2">Copyright &copy; News Reader {{ date('Y') }}</p>
        </div>
    </div>
</footer>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-Z1M69DNZYX"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-Z1M69DNZYX');
</script>
<style>
  .footer{
      padding-top: 1vh;
      display: flex;
      align-items: center;
      margin: 0 0 20px;
      list-style: none;
      justify-content: center;
  }
  .sticky-top { top: 5vh; }
</style>
