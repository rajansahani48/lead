{{-- Left Side Navbar --}}
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                @if (auth()->user()->role == 'admin')
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <div class="sb-nav-link-icon"><i class="fa fa-user" aria-hidden="true"></i></div>
                        @php
                            if (auth()->check()) {
                                echo auth()->user()->name;
                            }
                        @endphp
                    </a>
                    <a class="nav-link" href="{{ route('dashboardchart') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <a class="nav-link" href="{{ route('telecaller.index') }}">
                        <div class="sb-nav-link-icon"><i class="fa fa-phone" aria-hidden="true"></i></div>
                        Telecaller
                    </a>
                    <a class="nav-link" href="{{ route('campaign.index') }}">
                        <div class="sb-nav-link-icon"><i class='fas fa-bullhorn' style='font-size:17px'></i></div>
                        Campaign
                    </a>
                @elseif (auth()->user()->role == 'telecaller')
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <div class="sb-nav-link-icon"><i class="fa fa-user" aria-hidden="true"></i></div>
                        @php
                            if (auth()->check()) {
                                echo auth()->user()->name;
                            }
                        @endphp
                    </a>
                    <a class="nav-link" href="{{ route('showlead') }}">
                        <div class="sb-nav-link-icon"><i class="fa fa-phone" aria-hidden="true"></i></div>
                        Leads
                    </a>
                    <a class="nav-link" href="/wallet">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-wallet"></i></div>
                        Wallet
                    </a>
                @endif
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            @php
                if (auth()->check()) {
                    echo auth()->user()->name;
                }
            @endphp
        </div>
    </nav>
</div>
