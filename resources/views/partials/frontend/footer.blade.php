<footer class="py-5 bg-dark">
    <div class="container">
        <div class="row">
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
@elseif(Request::is('/articles'))
<script src="{{ asset('js/article.js') }}"></script>
@endif



@stack('scripts')
