<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Lab</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #f5f5f5;
        }

        .content {
            flex: 1;
            padding: 40px 20px;
            text-align: center;
            color: #666;
        }

        footer {
            background: linear-gradient(135deg, #1b2963ff 0%, #202740ff 100%);
            color: white;
            padding: 50px 20px 20px;
            margin-top: auto;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 40px;
            margin-bottom: 30px;
        }

        .footer-section h3 {
            font-size: 1.3em;
            margin-bottom: 20px;
            font-weight: 600;
            position: relative;
            display: inline-block;
        }

        .footer-section h3::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 50px;
            height: 3px;
            background: rgba(174, 220, 251, 0.8);
            border-radius: 2px;
        }

        .contact-info {
            list-style: none;
        }

        .contact-info li {
            margin-bottom: 15px;
            display: flex;
            align-items: start;
            line-height: 1.6;
        }

        .contact-info i {
            margin-right: 12px;
            font-size: 1.1em;
            margin-top: 3px;
            opacity: 0.9;
        }

        .social-links {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .social-links a {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            font-size: 1.3em;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .social-links a:hover {
            background: rgba(79, 111, 235, 0.3);
            transform: translateY(-5px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding-top: 25px;
            text-align: center;
            font-size: 0.95em;
            opacity: 0.9;
        }

        .footer-bottom p {
            margin: 5px 0;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3>Contact Us</h3>
                <ul class="contact-info">
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Jl. Soekarno Hatta Malang</span>
                    </li>
                    <li>
                        <i class="fas fa-phone"></i>
                        <span>+62 12 3456 7890</span>
                    </li>
                    <li>
                        <i class="fas fa-envelope"></i>
                        <span>laboratoriumBA@polinema.ac.id</span>
                    </li>
                    <li>
                        <i class="fas fa-clock"></i>
                        <span>Senin - Jumat: 08.00 - 17.00 WIB</span>
                    </li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Tentang Lab</h3>
                <ul class="contact-info">
                    <li>
                        <i class="fas fa-flask"></i>
                        <span>Home</span>
                    </li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Social Media</h3>
                <div class="social-links">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 Laboratorium Bussines Analyst | POLITEKNIK NEGERI MALANG</p>
        </div>
    </footer>
</body>
</html>