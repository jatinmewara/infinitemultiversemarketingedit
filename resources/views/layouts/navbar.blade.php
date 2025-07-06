<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Marketing</title>
    <link href="img/logo1.svg" rel="icon">
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <nav class="sidebar-nav">
            <ul>
                <li class="nav-item active">
                    <a href="#" class="nav-link">
                        <i class="fas fa-home"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-bullhorn"></i>
                        <span class="nav-text">Blogs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-user"></i>
                        <span class="nav-text">User</span>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-cog"></i>
                        <span class="nav-text">Product Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-chart-line"></i>
                        <span class="nav-text">Sales Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-university"></i>
                        <span class="nav-text">Banking Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-wallet"></i>
                        <span class="nav-text">Cash Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-industry"></i>
                        <span class="nav-text">Manufacturing</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-palette"></i>
                        <span class="nav-text">Menu Design</span>
                        <i class="fas fa-chevron-right nav-arrow"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-calendar"></i>
                        <span class="nav-text">Calendar</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-user"></i>
                        <span class="nav-text">User</span>
                        <i class="fas fa-chevron-right nav-arrow"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-envelope"></i>
                        <span class="nav-text">Email</span>
                        <i class="fas fa-chevron-right nav-arrow"></i>
                    </a>
                </li> -->
            </ul>
        </nav>
    </aside>
    <!-- Header/Navbar -->
    <header class="navbar">
        <div class="navbar-left">
            <div class="navbar-logo">
                <img class="navicon" src="img/logo1.svg">
            </div>
        </div>

        <div class="navbar-right">
            <div class="user-profile">
                <img src="/placeholder.svg?height=40&width=40" alt="Barry Tech" class="user-avatar">
                <div class="user-info">
                    <span class="user-name">Jatin Mewara</span>
                    <span class="user-role">Admin</span>
                </div>
            </div>
        </div>
    </header>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Sidebar toggle functionality
            const sidebar = document.getElementById("sidebar")
            const sidebarToggle = document.getElementById("sidebarToggle")
            const menuToggle = document.getElementById("menuToggle")

            // Handle both sidebar toggle buttons
            if (sidebarToggle) {
                sidebarToggle.addEventListener("click", () => {
                    sidebar.classList.toggle("collapsed")
                })
            }

            if (menuToggle) {
                menuToggle.addEventListener("click", () => {
                    sidebar.classList.toggle("collapsed")
                })
            }

            // Mobile sidebar toggle
            function handleMobileMenu() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.add("mobile")
                    sidebarToggle.addEventListener("click", () => {
                        sidebar.classList.toggle("open")
                    })
                } else {
                    sidebar.classList.remove("mobile", "open")
                }
            }

            // Chart functionality using Canvas
            const canvas = document.getElementById("areaChart")
            const ctx = canvas.getContext("2d")

            function drawChart() {
                const width = (canvas.width = canvas.offsetWidth)
                const height = (canvas.height = canvas.offsetHeight)

                // Clear canvas
                ctx.clearRect(0, 0, width, height)

                // Sample data points for the area chart
                const dataPoints = [
                    { x: 0, y: 0.7 },
                    { x: 0.1, y: 0.5 },
                    { x: 0.2, y: 0.6 },
                    { x: 0.3, y: 0.4 },
                    { x: 0.4, y: 0.8 },
                    { x: 0.5, y: 0.3 },
                    { x: 0.6, y: 0.9 },
                    { x: 0.7, y: 0.6 },
                    { x: 0.8, y: 0.8 },
                    { x: 0.9, y: 0.4 },
                    { x: 1, y: 0.7 },
                ]

                // Create gradient
                const gradient = ctx.createLinearGradient(0, 0, 0, height)
                gradient.addColorStop(0, "rgba(34, 197, 94, 0.3)")
                gradient.addColorStop(1, "rgba(34, 197, 94, 0.05)")

                // Draw area
                ctx.beginPath()
                ctx.moveTo(0, height)

                dataPoints.forEach((point, index) => {
                    const x = point.x * width
                    const y = height - point.y * height * 0.8 - height * 0.1

                    if (index === 0) {
                        ctx.lineTo(x, y)
                    } else {
                        ctx.lineTo(x, y)
                    }
                })

                ctx.lineTo(width, height)
                ctx.closePath()
                ctx.fillStyle = gradient
                ctx.fill()

                // Draw line
                ctx.beginPath()
                dataPoints.forEach((point, index) => {
                    const x = point.x * width
                    const y = height - point.y * height * 0.8 - height * 0.1

                    if (index === 0) {
                        ctx.moveTo(x, y)
                    } else {
                        ctx.lineTo(x, y)
                    }
                })

                ctx.strokeStyle = "#22c55e"
                ctx.lineWidth = 2
                ctx.stroke()

                // Draw month labels
                ctx.fillStyle = "#8b92b2"
                ctx.font = '12px -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif'
                ctx.textAlign = "center"

                const months = ["Aug", "Sep", "Oct"]
                months.forEach((month, index) => {
                    const x = (index / (months.length - 1)) * width
                    ctx.fillText(month, x, height - 10)
                })

                // Draw Y-axis labels
                ctx.textAlign = "right"
                const yLabels = ["0", "20", "40", "60", "80"]
                yLabels.forEach((label, index) => {
                    const y = height - (index / (yLabels.length - 1)) * (height - 40) - 20
                    ctx.fillText(label, width - 10, y)
                })
            }

            // Initialize chart
            drawChart()

            // Redraw chart on window resize
            window.addEventListener("resize", () => {
                handleMobileMenu()
                setTimeout(drawChart, 100)
            })

            // Initialize mobile menu handling
            handleMobileMenu()

            // Animate progress bars on load
            setTimeout(() => {
                const progressBars = document.querySelectorAll(".progress-fill")
                progressBars.forEach((bar) => {
                    const width = bar.style.width
                    bar.style.width = "0%"
                    setTimeout(() => {
                        bar.style.width = width
                    }, 100)
                })
            }, 500)

            // Add click handlers for navigation items
            const navLinks = document.querySelectorAll(".nav-link")
            navLinks.forEach((link) => {
                link.addEventListener("click", function (e) {
                    e.preventDefault()

                    // Remove active class from all items
                    document.querySelectorAll(".nav-item").forEach((item) => {
                        item.classList.remove("active")
                    })

                    // Add active class to clicked item
                    this.parentElement.classList.add("active")
                })
            })
        })

    </script>
</body>

</html>