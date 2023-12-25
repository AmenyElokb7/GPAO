
                <!-- Left Side Of Navbar -->
                <header id="header" class="fixed-top ">
                    <div class="container d-flex align-items-center">
                        <h1 class="logo me-auto"><a href="index.html">GPAO</a></h1>
                        <nav id="navbar" class="navbar" style="background: transparent">
                            <ul>
                                @guest
                                    @if (Route::has('login'))
                                        <li><a class="nav-link scrollto active" href="{{ url('home') }}#hero">Home</a></li>
                                        <li><a class="nav-link scrollto" href="{{ url('home') }}#about">About</a></li>
                                        <li><a class="nav-link scrollto" href="{{ url('home') }}#services">Services</a></li>
                                        <li><a class="nav-link   scrollto" href="{{ url('home') }}#portfolio">Portfolio</a></li>
                                        <li><a class="nav-link scrollto" href="{{ url('home') }}#team">Team</a></li>
                                        <li><a class="nav-link scrollto" href="{{ url('home') }}#contact">Contact</a></li>
                                        <li><button data-bs-toggle="modal" data-bs-target="#exampleModal" type="button"
                                                class="getstarted scrollto">Get Started</button></li>
                                    @endif
                                @else
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#"
                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" v-pre>
                                            {{ Auth::user()->name }}
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                @endguest

                            </ul>
                            <i class="bi bi-list mobile-nav-toggle"></i>
                        </nav><!-- .navbar -->

                    </div>
                </header><!-- End Header -->
        