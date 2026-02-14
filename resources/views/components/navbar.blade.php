    {{-- Navbar --}}
    <nav class="navbar navbar-default navbar-fixed-top navbar-custom">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                    DASHBOARD <b>PAMERAN</b>
                </a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{ route('dashboard.antrian') }}">Data Pengunjung</a></li>
                    <li><a href="{{ route('dashboard.stand') }}">Info Stand</a></li>
                </ul>
            </div>
        </div>
    </nav>