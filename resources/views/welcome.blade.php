<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="img/logo1.svg" rel="icon">
    <title>Digitall Marketing</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        background: linear-gradient(to right, #0f0c29, #302b63, #24243e);
        font-family: 'Quantico', sans-serif;
        overflow: hidden;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        perspective: 1000px;
    }

    #particles-js {
        position: absolute;
        width: 100%;
        height: 100%;
        z-index: -1;
    }

    .login-container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25),
            0 10px 10px rgba(0, 0, 0, 0.22);
        width: 400px;
        max-width: 100%;
        padding: 40px;
        text-align: center;
    }

    h1 {
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
    }

    .social-container {
        margin: 20px 0;
    }

    .social-container a {
        border: 1px solid #DDDDDD;
        border-radius: 50%;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        margin: 0 5px;
        height: 40px;
        width: 40px;
        color: #333;
    }

    input {
        background-color: #eee;
        border: none;
        padding: 12px 15px;
        margin: 8px 0;
        width: 100%;
        border-radius: 5px;
    }

    button {
        border-radius: 20px;
        border: 1px solid #FF4B2B;
        background-color: #FF4B2B;
        color: #FFFFFF;
        font-size: 12px;
        font-weight: bold;
        padding: 12px 45px;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: transform 80ms ease-in;
        margin-top: 15px;
        cursor: pointer;
    }

    a {
        color: #333;
        font-size: 14px;
        text-decoration: none;
        margin: 15px 0;
        display: block;
    }

    .signup-link {
        margin-top: 30px;
        color: #FF4B2B;
        font-weight: bold;
    }

    .logo {
        font-size: 24px;
        font-weight: bold;
        color: #FF4B2B;
        margin-bottom: 20px;
        display: block;
    }
</style>

<body>
    <div id="particles-js"></div>
    <div class="login-container">
        <span class="logo">Infinite Multiverse Marketing</span>
        <h1>Sign In</h1>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <x-text-input id="email" type="email" name="email" :value="old('email')" placeholder="Email" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />

            <!-- Password -->
            <x-text-input id="password" type="password" name="password" placeholder="Password" required
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />

            <!-- Forgot Password -->
            <!-- @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif -->

            <button type="submit">{{ __('Sign In') }}</button>
        </form>

        <a href="{{ route('register') }}" class="signup-link">Don't have an account? Sign Up</a>
    </div>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize particle.js
            particlesJS('particles-js', {
                "particles": {
                    "number": {
                        "value": 80,
                        "density": {
                            "enable": true,
                            "value_area": 800
                        }
                    },
                    "color": {
                        "value": "#64f5ff"
                    },
                    "shape": {
                        "type": "circle",
                        "stroke": {
                            "width": 0,
                            "color": "#000000"
                        },
                        "polygon": {
                            "nb_sides": 5
                        }
                    },
                    "opacity": {
                        "value": 0.5,
                        "random": true,
                        "anim": {
                            "enable": true,
                            "speed": 1,
                            "opacity_min": 0.1,
                            "sync": false
                        }
                    },
                    "size": {
                        "value": 3,
                        "random": true,
                        "anim": {
                            "enable": true,
                            "speed": 2,
                            "size_min": 0.1,
                            "sync": false
                        }
                    },
                    "line_linked": {
                        "enable": true,
                        "distance": 150,
                        "color": "#6441ff",
                        "opacity": 0.4,
                        "width": 1
                    },
                    "move": {
                        "enable": true,
                        "speed": 2,
                        "direction": "none",
                        "random": true,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": false,
                        "attract": {
                            "enable": true,
                            "rotateX": 600,
                            "rotateY": 1200
                        }
                    }
                },
                "interactivity": {
                    "detect_on": "canvas",
                    "events": {
                        "onhover": {
                            "enable": true,
                            "mode": "grab"
                        },
                        "onclick": {
                            "enable": true,
                            "mode": "push"
                        },
                        "resize": true
                    },
                    "modes": {
                        "grab": {
                            "distance": 140,
                            "line_linked": {
                                "opacity": 1
                            }
                        },
                        "bubble": {
                            "distance": 400,
                            "size": 40,
                            "duration": 2,
                            "opacity": 8,
                            "speed": 3
                        },
                        "repulse": {
                            "distance": 200,
                            "duration": 0.4
                        },
                        "push": {
                            "particles_nb": 4
                        },
                        "remove": {
                            "particles_nb": 2
                        }
                    }
                },
                "retina_detect": true
            });

            // DOM elements
            const signUpButton = document.getElementById('signUp');
            const signInButton = document.getElementById('signIn');
            const container = document.getElementById('container');
            const loginForm = document.getElementById('loginForm');
            const signupForm = document.getElementById('signupForm');
            const modal = document.getElementById('welcomeModal');
            const closeModal = document.querySelector('.close');
            const welcomeMessage = document.getElementById('welcomeMessage');
            const characterMessage = document.getElementById('characterMessage');
            const characterImage = document.getElementById('characterImage');
            const exploreBtn = document.getElementById('exploreBtn');

            // Character data with better images
            const characterData = {
                ironman: {
                    name: "Iron Man",
                    image: "https://i.imgur.com/Ru3HXUq.png",
                    quote: "Genius, billionaire, playboy, philanthropist."
                },
                captainamerica: {
                    name: "Captain America",
                    image: "https://i.imgur.com/9BkI9Qj.png",
                    quote: "I can do this all day."
                },
                thor: {
                    name: "Thor",
                    image: "https://i.imgur.com/3Gkh9XG.png",
                    quote: "Bring me Thanos!"
                },
                hulk: {
                    name: "Hulk",
                    image: "https://i.imgur.com/rZQqQYj.png",
                    quote: "Hulk smash!"
                },
                blackwidow: {
                    name: "Black Widow",
                    image: "https://i.imgur.com/6Z7DZ9Y.png",
                    quote: "I'm always picking up after you boys."
                },
                hawkeye: {
                    name: "Hawkeye",
                    image: "https://i.imgur.com/9QVqZJ0.png",
                    quote: "The city is flying and we're fighting an army of robots."
                },
                spiderman: {
                    name: "Spider-Man",
                    image: "https://i.imgur.com/1uHcDnR.png",
                    quote: "With great power comes great responsibility."
                },
                doctorstrange: {
                    name: "Doctor Strange",
                    image: "https://i.imgur.com/9QVqZJ0.png",
                    quote: "We're in the endgame now."
                },
                blackpanther: {
                    name: "Black Panther",
                    image: "https://i.imgur.com/3Gkh9XG.png",
                    quote: "Wakanda forever!"
                },
                captainmarvel: {
                    name: "Captain Marvel",
                    image: "https://i.imgur.com/rZQqQYj.png",
                    quote: "Higher, further, faster baby."
                },
                scarletwitch: {
                    name: "Scarlet Witch",
                    image: "https://i.imgur.com/6Z7DZ9Y.png",
                    quote: "You took everything from me."
                },
                vision: {
                    name: "Vision",
                    image: "https://i.imgur.com/9QVqZJ0.png",
                    quote: "A thing isn't beautiful because it lasts."
                },
                starlord: {
                    name: "Star-Lord",
                    image: "https://i.imgur.com/1uHcDnR.png",
                    quote: "I'm Star-Lord, man."
                },
                gamora: {
                    name: "Gamora",
                    image: "https://i.imgur.com/9QVqZJ0.png",
                    quote: "I'm going to die surrounded by the biggest idiots in the galaxy."
                },
                thanos: {
                    name: "Thanos",
                    image: "https://i.imgur.com/3Gkh9XG.png",
                    quote: "I am inevitable."
                },
                loki: {
                    name: "Loki",
                    image: "https://i.imgur.com/rZQqQYj.png",
                    quote: "I am Loki of Asgard, and I am burdened with glorious purpose."
                }
            };

            // Toggle between sign in and sign up
            signUpButton.addEventListener('click', () => {
                container.classList.add('right-panel-active');
                // Add animation effect
                container.style.transform = 'translateY(-20px) rotateX(5deg) rotateY(5deg)';
                setTimeout(() => {
                    container.style.transform = 'translateY(0) rotateX(0deg) rotateY(0deg)';
                }, 300);
            });

            signInButton.addEventListener('click', () => {
                container.classList.remove('right-panel-active');
                // Add animation effect
                container.style.transform = 'translateY(-20px) rotateX(-5deg) rotateY(-5deg)';
                setTimeout(() => {
                    container.style.transform = 'translateY(0) rotateX(0deg) rotateY(0deg)';
                }, 300);
            });

            // Handle login form submission
            loginForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const email = document.getElementById('loginEmail').value;
                const password = document.getElementById('loginPassword').value;

                // Simulate loading
                const submitBtn = e.target.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Entering Multiverse...';

                setTimeout(() => {
                    submitBtn.innerHTML = originalText;

                    // Show welcome message
                    welcomeMessage.textContent = `Welcome back, ${email.split('@')[0]}!`;
                    characterMessage.textContent = 'You have successfully re-entered the Infinite Multiverse Marketing platform.';
                    characterImage.style.backgroundImage = 'url("https://i.imgur.com/Ru3HXUq.png")';
                    exploreBtn.style.display = 'block';
                    modal.style.display = 'block';

                    // Add cosmic effect to modal
                    const modalContent = document.querySelector('.modal-content');
                    modalContent.style.animation = 'none';
                    void modalContent.offsetWidth; // Trigger reflow
                    modalContent.style.animation = 'modalFadeIn 0.5s ease-out';
                }, 1500);
            });

            // Handle signup form submission
            signupForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const name = document.getElementById('signupName').value;
                const email = document.getElementById('signupEmail').value;
                const password = document.getElementById('signupPassword').value;
                const character = document.getElementById('favCharacter').value;

                // Simulate loading
                const submitBtn = e.target.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Opening Portal...';

                setTimeout(() => {
                    submitBtn.innerHTML = originalText;

                    if (!character) {
                        alert('Please select your Multiverse Guide!');
                        return;
                    }

                    const selectedCharacter = characterData[character];

                    // Show welcome message with character info
                    welcomeMessage.textContent = `Welcome to the Multiverse, ${name}!`;
                    characterMessage.textContent = `Your guide is ${selectedCharacter.name}. "${selectedCharacter.quote}"`;
                    characterImage.style.backgroundImage = `url(${selectedCharacter.image})`;
                    exploreBtn.style.display = 'block';
                    modal.style.display = 'block';

                    // Add cosmic effect to modal
                    const modalContent = document.querySelector('.modal-content');
                    modalContent.style.animation = 'none';
                    void modalContent.offsetWidth; // Trigger reflow
                    modalContent.style.animation = 'modalFadeIn 0.5s ease-out';

                    // Reset form and switch to login
                    signupForm.reset();
                    container.classList.remove('right-panel-active');
                }, 1500);
            });

            // Close modal
            closeModal.addEventListener('click', function () {
                modal.style.display = 'none';
            });

            // Explore button
            exploreBtn.addEventListener('click', function () {
                // Add portal animation before redirecting
                modal.style.animation = 'none';
                void modal.offsetWidth;
                modal.style.animation = 'modalFadeIn 0.5s reverse';

                setTimeout(() => {
                    modal.style.display = 'none';
                    // In a real app, you would redirect to the dashboard
                    alert('Welcome to your Multiverse Dashboard! (This would redirect in a real app)');
                }, 500);
            });

            // Close modal when clicking outside
            window.addEventListener('click', function (event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });

            // Add floating animation to container
            setInterval(() => {
                const float = Math.sin(Date.now() / 1000) * 5;
                container.style.transform = `translateY(${float}px) rotateX(${float / 10}deg) rotateY(${float / 10}deg)`;
            }, 50);
        });
    </script>
</body>

</html>