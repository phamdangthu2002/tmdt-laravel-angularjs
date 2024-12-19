<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons/css/boxicons.min.css" rel="stylesheet">
    <style>
        .footer {
            background-color: #f8f9fa;
            color: #343a40;
            padding: 2rem 0;
            box-shadow: 0 -30px 80px rgba(0, 0, 0, 0.2);

            /* Thêm đổ bóng cho footer */
        }

        .footer .footer-logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: #007bff;
            text-decoration: none;
        }

        .footer .footer-section {
            margin-bottom: 1.5rem;
        }

        .footer .footer-section h5 {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .footer .footer-section a {
            color: #6c757d;
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
            transition: color 0.3s;
        }

        .footer .footer-section a:hover {
            color: #007bff;
        }

        .footer .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            margin: 0 5px;
            background-color: #007bff;
            color: #fff;
            border-radius: 50%;
            transition: background-color 0.3s, transform 0.3s;
        }

        .footer .social-icons a:hover {
            background-color: #0056b3;
            transform: scale(1.1);
        }

        .footer .copy {
            text-align: center;
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 1.5rem;
        }
    </style>
</head>

<body>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 footer-section">
                    <a href="#" class="footer-logo">PhoneShop</a>
                    <p>Your one-stop shop for the latest and greatest smartphones.</p>
                </div>
                <div class="col-md-4 footer-section">
                    <h5>Quick Links</h5>
                    <a href="#">Home</a>
                    <a href="#">Shop</a>
                    <a href="#">About Us</a>
                    <a href="#">Contact</a>
                    <a href="#">FAQs</a>
                </div>
                <div class="col-md-4 footer-section">
                    <h5>Follow Us</h5>
                    <div class="social-icons">
                        <a href="#" class="bx bxl-facebook"></a>
                        <a href="#" class="bx bxl-twitter"></a>
                        <a href="#" class="bx bxl-instagram"></a>
                        <a href="#" class="bx bxl-youtube"></a>
                    </div>
                </div>
            </div>
            <div class="copy">
                &copy; 2024 PhoneShop. All Rights Reserved.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
