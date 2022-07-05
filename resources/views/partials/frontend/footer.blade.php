

<footer class=" bg-dark fixed-bottom">

    <div class="container">
        <div class="row d-flex justify-content-center">

            <p class="text-center text-white no-margins">
                <a href="{{ route('website.about') }}" class="text-white">
                    About
                </a>
                |
                <a href="{{ route('website.terms') }}" class="text-white">
                    Terms & Conditions
                </a>
                |
                <a href="{{ route('website.demo') }}" class="text-white">
                    Demo
                </a>
            </p>
            <p class="m-0 text-center text-white">Copyright &copy; News Reader {{ date('Y') }}</p>
        </div>
    </div>
</footer>
<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>


<!-- Switch the vue apps !-->

@if(Request::is('/'))
<script src="{{ asset('js/home.js') }}"></script>
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

@elseif(Request::has('/articles'))
<script src="{{ asset('js/article.js') }}"></script>
@endif



@stack('scripts')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<!-- Include the Quill library -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<!-- Initialize Quill editor -->
<script>
    var quill = new Quill('#editor', {
        theme: 'snow'
    });
</script>
<style>
  .footer{
      display: flex;
      align-items: center;
      margin: 0 0 20px;
      padding: 0;
      list-style: none;
      justify-content: center;
  }
</style>
